<?php

namespace XF\Payment;

use XF\Entity\PaymentProfile;
use XF\Entity\PurchaseRequest;
use XF\Mvc\Controller;
use XF\Purchasable\Purchase;

use function array_key_exists, in_array, intval, is_string, strlen, strval;

class Stripe extends AbstractProvider
{
	// Force a specific Stripe version so we can better control
	// when we are ready for potential code breaking changes.

	protected $stripeVersion = '2019-08-14';

	protected $customerCache = [];

	public function getTitle()
	{
		return 'Stripe';
	}

	public function renderConfig(PaymentProfile $profile)
	{
		$data = [
			'profile' => $profile,
			'events' => $this->getActionableEvents()
		];
		return \XF::app()->templater()->renderTemplate('admin:payment_profile_' . $this->providerId, $data);
	}

	public function verifyConfig(array &$options, &$errors = [])
	{
		if (\XF::config('enableLivePayments'))
		{
			$keyName = 'live_secret_key';
		}
		else
		{
			$keyName = 'test_secret_key';
		}

		$secretKey = $options[$keyName];

		if ($secretKey)
		{
			try
			{
				\Stripe\Stripe::setAppInfo(
					'XenForo',
					\XF::$version,
					''
				);
				\Stripe\Stripe::setApiKey($secretKey);
				\Stripe\Stripe::setApiVersion($this->stripeVersion);

				$stripeAccount = \Stripe\Account::retrieve();
			}
			catch (\Exception $e)
			{
				$errors[] = \XF::phrase('cannot_verify_that_your_key_x_is_valid', ['keyName' => $keyName]);
				return false;
			}

			$options['stripe_country'] = $stripeAccount->country;
		}

		$statementDescriptor = $options['statement_descriptor'];
		if (strlen($statementDescriptor))
		{
			$statementDescriptor = $this->sanitizeStatementDescriptor($statementDescriptor);

			if (strlen($statementDescriptor) < 5 || strlen($statementDescriptor) > 22)
			{
				$errors[] = \XF::phrase('valid_statement_descriptor_must_be_correct_length_and_format');
				return false;
			}

			$options['statement_descriptor'] = $statementDescriptor;
		}
		else
		{
			// Validate that we can get a statement descriptor from the title
			$defaultStatementDescription = $this->getStatementDescriptor();

			if (strlen($defaultStatementDescription) < 5 || strlen($defaultStatementDescription) > 22)
			{
				$errors[] = \XF::phrase('stripe_custom_statement_descriptor_required');
				return false;
			}
		}

		return true;
	}

	protected function getStripeKey(PaymentProfile $paymentProfile, $type = 'secret')
	{
		if (\XF::config('enableLivePayments'))
		{
			$key = $paymentProfile->options['live_' . $type . '_key'];
		}
		else
		{
			$key = $paymentProfile->options['test_' . $type . '_key'];
		}

		return $key;
	}

	protected function setupStripe(PaymentProfile $paymentProfile)
	{
		\Stripe\Stripe::setAppInfo(
			'XenForo',
			\XF::$version,
			'https://xenforo.com/contact'
		);
		\Stripe\Stripe::setApiKey($this->getStripeKey($paymentProfile));
		\Stripe\Stripe::setApiVersion($this->stripeVersion);
	}

	protected function getChargeMetadata(PurchaseRequest $purchaseRequest)
	{
		return [
			'request_key' => $purchaseRequest->request_key
		] + $this->getCustomerMetadata($purchaseRequest);
	}

	protected function getCustomerMetadata(PurchaseRequest $purchaseRequest)
	{
		/** @var \XF\Validator\Email $validator */
		$validator = \XF::app()->validator('Email');

		$email = null;

		if ($purchaseRequest->User)
		{
			$email = $validator->coerceValue($purchaseRequest->User->email);
			if (!$email || !$validator->isValid($email))
			{
				$email = null;
			}
		}

		if (!$email)
		{
			$email = 'invalid@example.com';
		}

		return [
			'user_id' => $purchaseRequest->user_id,
			'username' => $purchaseRequest->User
				? $purchaseRequest->User->username
				: \XF::phrase('guest'),
			'email' => $email
		];
	}

	protected function getTransactionMetadata(Purchase $purchase)
	{
		return [
			'purchasable_type_id' => $purchase->purchasableTypeId,
			'purchasable_id' => $purchase->purchasableId,
			'currency' => $purchase->currency,
			'cost' => $purchase->cost,
			'length_amount' => $purchase->lengthAmount,
			'length_unit' => $purchase->lengthUnit
		];
	}

	protected function getCustomStatementDescriptor(PaymentProfile $paymentProfile): string
	{
		if (
			array_key_exists('statement_descriptor', $paymentProfile->options)
			&& strlen($paymentProfile->options['statement_descriptor']) > 0
		)
		{
			// note: already sanitized on save
			$statementDescriptor = $paymentProfile->options['statement_descriptor'];
		}
		else
		{
			$statementDescriptor = $this->getStatementDescriptor();
		}

		return $statementDescriptor;
	}

	protected function getStatementDescriptor()
	{
		return $this->sanitizeStatementDescriptor(\XF::app()->options()->boardTitle);
	}

	protected function sanitizeStatementDescriptor(string $descriptor): string
	{
		$cleanDescriptor = str_replace(['\\', "'", '"', '*', '<', '>'], '', $descriptor);
		$cleanDescriptor = utf8_romanize(utf8_deaccent($cleanDescriptor));

		$originalString = $cleanDescriptor;

		// Attempt to transliterate remaining UTF-8 characters to their ASCII equivalents
		$cleanDescriptor = @iconv('UTF-8', 'ASCII//TRANSLIT', $cleanDescriptor);
		if (!$cleanDescriptor)
		{
			// iconv failed so forget about it
			$cleanDescriptor = $originalString;
		}

		$cleanDescriptor = preg_replace('/[^a-zA-Z0-9_ -.]/', '', $cleanDescriptor);

		return \XF::app()->stringFormatter()->wholeWordTrim(
			$cleanDescriptor, 22, 0, ''
		);
	}

	protected function getPaymentParams(PurchaseRequest $purchaseRequest, Purchase $purchase)
	{
		$paymentProfile = $purchase->paymentProfile;
		$publishableKey = $this->getStripeKey($paymentProfile, 'publishable');

		return [
			'purchaseRequest' => $purchaseRequest,
			'paymentProfile' => $paymentProfile,
			'purchaser' => $purchase->purchaser,
			'purchase' => $purchase,
			'purchasableTypeId' => $purchase->purchasableTypeId,
			'purchasableId' => $purchase->purchasableId,
			'publishableKey' => $publishableKey,
			'cost' => $this->getStripeFormattedCost(
				$purchaseRequest,
				$purchase
			)
		];
	}

	public function initiatePayment(Controller $controller, PurchaseRequest $purchaseRequest, Purchase $purchase)
	{
		$viewParams = $this->getInitiatePaymentParams($controller, $purchaseRequest, $purchase);

		return $controller->view('XF:Purchase\StripeInitiate', 'payment_initiate_stripe', $viewParams);
	}

	public function getInitiatePaymentParams(Controller $controller, PurchaseRequest $purchaseRequest, Purchase $purchase)
	{
		$viewParams = $this->getPaymentParams($purchaseRequest, $purchase);

		$sessionPaymentInfo = [
			'purchaseRequestId' => $purchaseRequest->purchase_request_id
		];

		if ($purchase->recurring)
		{
			$product = $this->createStripeProduct($purchase->paymentProfile, $purchase, $error);
			if (!$product)
			{
				$errorPhrase = \XF::phrase('error_occurred_while_creating_stripe_product:');
				throw $controller->exception($controller->error("$errorPhrase $error"));
			}

			$plan = $this->createStripePlan($product, $purchase->paymentProfile, $purchase, $error);
			if (!$plan)
			{
				$errorPhrase = \XF::phrase('error_occurred_while_creating_stripe_plan:');
				throw $controller->exception($controller->error("$errorPhrase $error"));
			}

			$customer = $this->getStripeCustomer($purchaseRequest, $purchase->paymentProfile, $purchase, $error);
			if (!$customer)
			{
				$errorPhrase = \XF::phrase('error_occurred_while_creating_stripe_customer:');
				throw $controller->exception($controller->error("$errorPhrase $error"));
			}

			$sessionPaymentInfo['customerId'] = $customer->id;
			$sessionPaymentInfo['planId'] = $plan->id;
		}
		else
		{
			$paymentIntent = $this->createPaymentIntent($purchaseRequest, $purchase, $error);
			if (!$paymentIntent)
			{
				throw $controller->exception($controller->error($error));
			}

			$purchaseRequest->fastUpdate('provider_metadata', $paymentIntent->id);

			$viewParams['paymentIntent'] = $paymentIntent;

			$sessionPaymentInfo['paymentIntentId'] = $paymentIntent->id;
		}

		$controller->session()->stripePaymentInfo = $sessionPaymentInfo;

		return $viewParams;
	}

	public function processPayment(Controller $controller, PurchaseRequest $purchaseRequest, PaymentProfile $paymentProfile, Purchase $purchase)
	{
		if (!$purchase->recurring)
		{
			// payment already made via JS for non-recurring
			return null;
		}

		// we need to make sure that the previously stored details relate to this request
		$sessionPaymentInfo = $controller->session()->stripePaymentInfo;
		if (!$sessionPaymentInfo || $sessionPaymentInfo['purchaseRequestId'] !== $purchaseRequest->purchase_request_id)
		{
			throw $controller->exception(
				$controller->error(\XF::phrase('unexpected_error_occurred'))
			);
		}

		// the stripe JS sets this up
		$paymentMethodId = $controller->filter('payment_method_id', 'str');
		if (!$paymentMethodId)
		{
			throw $controller->exception(
				$controller->error(\XF::phrase('unexpected_error_occurred'))
			);
		}

		$this->setupStripe($paymentProfile);

		// attach the payment method to this customer
		try
		{
			$paymentMethod = \Stripe\PaymentMethod::retrieve($paymentMethodId);
			$paymentMethod->attach(['customer' => $sessionPaymentInfo['customerId']]);
		}
		catch (\Stripe\Exception\ExceptionInterface $e)
		{
			$error = $e->getMessage();
			$errorPhrase = \XF::phrase('error_occurred_while_creating_stripe_subscription:');
			throw $controller->exception($controller->error("$errorPhrase $error"));
		}

		if (!empty($sessionPaymentInfo['subscriptionId']))
		{
			// we've already created the subscription, so this represents the case where we are going
			// through 3D secure or if the payment method fails
			$subscriptionId = $sessionPaymentInfo['subscriptionId'];

			try
			{
				/** @var \Stripe\Subscription $subscription */
				$subscription = \Stripe\Subscription::retrieve([
					'id' => $subscriptionId,
					'expand' => ['latest_invoice.payment_intent']
				]);
			}
			catch (\Stripe\Exception\ExceptionInterface $e)
			{
				$error = $e->getMessage();
				$errorPhrase = \XF::phrase('error_occurred_while_creating_stripe_subscription:');
				throw $controller->exception($controller->error("$errorPhrase $error"));
			}
		}
		else
		{
			// This is the first attempt to create/charge the subscription. Stripe will auto-charge
			// the subscription and we'll handle this via a webhook.

			try
			{
				/** @var \Stripe\Subscription $subscription */
				$subscription = \Stripe\Subscription::create([
					'customer' => $sessionPaymentInfo['customerId'],
					'default_payment_method' => $paymentMethodId,
					'items' => [
						['plan' => $sessionPaymentInfo['planId']]
					],
					'metadata' => $this->getTransactionMetadata($purchase),
					'expand' => ['latest_invoice.payment_intent']
				]);
			}
			catch (\Stripe\Exception\ExceptionInterface $e)
			{
				$error = $e->getMessage();
				$errorPhrase = \XF::phrase('error_occurred_while_creating_stripe_subscription:');
				throw $controller->exception($controller->error("$errorPhrase $error"));
			}

			$subscriptionId = $subscription->id;

			$purchaseRequest->fastUpdate('provider_metadata', $subscriptionId);
		}

		$latestInvoice = $subscription->latest_invoice;
		$latestInvoiceId = $latestInvoice->id;
		$paymentStatus = $latestInvoice->payment_intent->status;
		$piSecret = $latestInvoice->payment_intent->client_secret;

		if ($paymentStatus !== 'succeeded')
		{
			// payment hasn't succeeded to log extra details into the session and trigger an error for the user
			$sessionPaymentInfo['subscriptionId'] = $subscriptionId;
			$sessionPaymentInfo['latestInvoiceId'] = $latestInvoiceId;
			$controller->session()->stripePaymentInfo = $sessionPaymentInfo;

			$reply = $controller->view();
			$reply->setJsonParams([
				'paymentFailed' => true,
				'paymentStatus' => $subscription->latest_invoice->payment_intent->status,
				'piSecret' => $piSecret
			]);
			return $reply;
		}

		// payment success, we don't need the session details and can redirect
		unset($controller->session()->stripePaymentInfo);

		return null;
	}

	protected function getStripeProductAndPlanId(Purchase $purchase)
	{
		return $purchase->purchasableTypeId . '_' . md5(
			$purchase->currency . $purchase->cost . $purchase->lengthAmount . $purchase->lengthUnit
		);
	}

	protected function getStripeCustomer(PurchaseRequest $purchaseRequest, PaymentProfile $paymentProfile, Purchase $purchase, &$error = null)
	{
		$this->setupStripe($paymentProfile);
		$metadata = $this->getCustomerMetadata($purchaseRequest);

		$cacheId = "$paymentProfile->payment_profile_id-$metadata[email]";
		if (isset($this->customerCache[$cacheId]))
		{
			return $this->customerCache[$cacheId];
		}

		$customer = null;

		try
		{
			$customers = \Stripe\Customer::all([
				'limit' => 1,
				'email' => $metadata['email']
			]);

			/** @var \Stripe\Customer $customer */
			$customer = reset($customers->data);
		}
		catch (\Stripe\Exception\ExceptionInterface $e) {}

		if (!$customer)
		{
			try
			{
				/** @var \Stripe\Customer $customer */
				$customer = \Stripe\Customer::create([
					'description' => $metadata['username'],
					'email' => $metadata['email'],
					'metadata' => $this->getCustomerMetadata($purchaseRequest)
				]);
			}
			catch (\Stripe\Exception\ExceptionInterface $e)
			{
				// failed to create
				$error = $e->getMessage();
				return false;
			}
		}

		$this->customerCache[$cacheId] = $customer;

		return $customer;
	}

	protected function getStripeFormattedCost(PurchaseRequest $purchaseRequest, Purchase $purchase)
	{
		return $this->prepareCost($purchase->cost, $purchase->currency);
	}

	protected function createPaymentIntent(PurchaseRequest $purchaseRequest, Purchase $purchase, &$error = null)
	{
		$paymentProfile = $purchase->paymentProfile;
		$this->setupStripe($paymentProfile);

		$customer = $this->getStripeCustomer(
			$purchaseRequest,
			$paymentProfile,
			$purchase,
			$error
		);
		if (!$customer)
		{
			return false;
		}

		try
		{
			// note: this object must be updated if the amount changes
			$paymentIntent = \Stripe\PaymentIntent::create([
				'amount' => $this->getStripeFormattedCost(
					$purchaseRequest, $purchase
				),
				'currency' => $purchase->currency,
				'customer' => $customer->id,
				'description' => $purchase->title,
				'receipt_email' => $purchaseRequest->User
					? $purchaseRequest->User->email
					: null,
				'statement_descriptor' => $this->getCustomStatementDescriptor($paymentProfile),
				'metadata' => $this->getChargeMetadata($purchaseRequest),
				'setup_future_usage' => $purchase->recurring ? 'off_session' : null
			]);
		}
		catch (\Stripe\Exception\ExceptionInterface $e)
		{
			// failed to create
			$error = $e->getMessage();
			return false;
		}

		return $paymentIntent;
	}

	protected function createStripeProduct(PaymentProfile $paymentProfile, Purchase $purchase, &$error = null)
	{
		$this->setupStripe($paymentProfile);
		$productId = $this->getStripeProductAndPlanId($purchase);

		try
		{
			/** @var \Stripe\Product $product */
			$product = \Stripe\Product::retrieve($productId);
		}
		catch (\Stripe\Exception\ExceptionInterface $e)
		{
			// likely means no existing product, so lets create it
			try
			{
				/** @var \Stripe\Product $product */
				$product = \Stripe\Product::create([
					'id' => $productId,
					'name' => $purchase->purchasableTitle,
					'type' => 'service',
					'metadata' => $this->getTransactionMetadata($purchase),
					'statement_descriptor' => $this->getCustomStatementDescriptor($paymentProfile)
				]);
			}
			catch (\Stripe\Exception\ExceptionInterface $e)
			{
				// failed to retrieve, failed to create
				$error = $e->getMessage();
				return false;
			}
		}

		return $product;
	}

	protected function createStripePlan(\Stripe\Product $product, PaymentProfile $paymentProfile, Purchase $purchase, &$error = null)
	{
		$this->setupStripe($paymentProfile);
		$planId = $this->getStripeProductAndPlanId($purchase);
		$expectedAmount = $this->prepareCost($purchase->cost, $purchase->currency);

		$findOrCreatePlan = function($planId, $expectedAmount, &$error) use ($purchase, $product)
		{
			try
			{
				$plan = \Stripe\Plan::retrieve($planId);
			}
			catch (\Stripe\Exception\ExceptionInterface $e)
			{
				// likely means no existing plan, so lets create it
				try
				{
					$plan = \Stripe\Plan::create([
						'id' => $planId,
						'currency' => $purchase->currency,
						'amount' => $expectedAmount,
						'billing_scheme' => 'per_unit',
						'interval' => $purchase->lengthUnit,
						'interval_count' => $purchase->lengthAmount,
						'product' => $product->id,
						'metadata' => $this->getTransactionMetadata($purchase)
					]);
				}
				catch (\Stripe\Exception\ExceptionInterface $e)
				{
					// failed to retrieve, failed to create
					$error = $e->getMessage();
					return false;
				}
			}

			/** @var \Stripe\Plan $plan */
			return $plan;
		};

		$plan = $findOrCreatePlan($planId, $expectedAmount, $error);
		if (!$plan)
		{
			// got an error when creating the plan so don't try anything
			return false;
		}

		if ($plan->amount !== $expectedAmount)
		{
			// base plan is likely triggering the off-by-one cost bug so we need to make a new one
			$planId .= '_' . $expectedAmount;

			$plan = $findOrCreatePlan($planId, $expectedAmount, $error);
			if (!$plan)
			{
				return false;
			}
		}

		return $plan;
	}

	public function renderCancellationTemplate(PurchaseRequest $purchaseRequest)
	{
		return $this->renderCancellationDefault($purchaseRequest);
	}

	public function processCancellation(Controller $controller, PurchaseRequest $purchaseRequest, PaymentProfile $paymentProfile)
	{
		if (!$purchaseRequest->provider_metadata || strpos($purchaseRequest->provider_metadata, 'sub_') !== 0)
		{
			$logFinder = \XF::finder('XF:PaymentProviderLog')
				->where('purchase_request_key', $purchaseRequest->request_key)
				->where('provider_id', $this->providerId)
				->order('log_date', 'desc');

			$logs = $logFinder->fetch();

			$subscriberId = null;
			foreach ($logs AS $log)
			{
				if ($log->subscriber_id && strpos($log->subscriber_id, 'sub_') === 0)
				{
					$subscriberId = $log->subscriber_id;
					break;
				}
			}

			if (!$subscriberId)
			{
				return $controller->error(\XF::phrase('could_not_find_subscriber_id_for_this_purchase_request'));
			}
		}
		else
		{
			$subscriberId = $purchaseRequest->provider_metadata;
		}

		$this->setupStripe($paymentProfile);

		try
		{
			/** @var \Stripe\Subscription $subscription */
			$subscription = \Stripe\Subscription::retrieve($subscriberId);
			$cancelledSubscription = $subscription->cancel();

			if ($cancelledSubscription->status != 'canceled')
			{
				throw $controller->exception($controller->error(
					\XF::phrase('this_subscription_cannot_be_cancelled_maybe_already_cancelled')
				));
			}
		}
		catch (\Stripe\Exception\ExceptionInterface $e)
		{
			throw $controller->exception($controller->error(
				\XF::phrase('this_subscription_cannot_be_cancelled_maybe_already_cancelled')
			));
		}

		return $controller->redirect(
			$controller->getDynamicRedirect(),
			\XF::phrase('stripe_subscription_cancelled_successfully')
		);
	}

	public function setupCallback(\XF\Http\Request $request)
	{
		$state = new CallbackState();

		$inputRaw = $request->getInputRaw();
		$state->inputRaw = $inputRaw;
		$state->signature = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? null;

		$input = @json_decode($inputRaw, true);
		$filtered = \XF::app()->inputFilterer()->filterArray($input ?: [], [
			'data' => 'array',
			'id' => 'str',
			'type' => 'str'
		]);

		$event = $filtered['data'];

		$state->transactionId = $filtered['id'];
		$state->eventType = $filtered['type'];
		$state->event = $event['object'] ?? [];

		if (isset($state->event['metadata']['request_key']))
		{
			$state->requestKey = $state->event['metadata']['request_key'];
		}
		else if (isset($state->event['subscription'])
			&& is_string($state->event['subscription'])
			&& strpos($state->event['subscription'], 'sub_') === 0
		)
		{
			$this->setPurchaseRequestFromSubscriptionId(
				$state->event['subscription'],
				$state
			);
		}
		else if (isset($state->event['object']) && ($state->event['object'] == 'review' || $state->event['object'] == 'dispute'))
		{
			// reviews/disputes don't have a metadata object, but set the payment intent or charge id
			if (!empty($state->event['payment_intent']))
			{
				$providerMetadata = $state->event['payment_intent'];
			}
			else if (!empty($state->event['charge']))
			{
				$providerMetadata = $state->event['charge'];
			}
			else
			{
				return $state;
			}

			$purchaseRequest = \XF::em()->findOne('XF:PurchaseRequest', ['provider_metadata' => $providerMetadata]);
			$state->purchaseRequest = $purchaseRequest; // sets request key too
		}
		else if (isset($state->event['object']) && $state->event['object'] == 'charge')
		{
			// generally for legacy one off payments where the charge object metadata doesn't contain the request key
			$chargeId = $state->event['id'];

			$purchaseRequest = \XF::em()->findOne('XF:PurchaseRequest', ['provider_metadata' => $chargeId]);

			if (!$purchaseRequest && !empty($state->event['invoice']) && $state->eventType === 'charge.refunded')
			{
				// ...or a subscription being refunded/terminated early.
				// Note that with the current code, we only want to check this for refunds as otherwise
				// this will pick up for charge.succeeded and potentially process an upgrade twice.
				$finder = \XF::finder('XF:PaymentProfile')->where('provider_id', 'stripe');
				foreach ($finder->fetch() AS $profile)
				{
					$this->setupStripe($profile);

					try
					{
						$invoice = \Stripe\Invoice::retrieve($state->event['invoice']);
						if ($invoice && $invoice->subscription)
						{
							$this->setPurchaseRequestFromSubscriptionId(
								$invoice->subscription,
								$state
							);
							break;
						}
					}
					catch (\Stripe\Exception\ExceptionInterface $e)
					{
						// just continue on
					}
				}
			}
			else
			{
				$state->purchaseRequest = $purchaseRequest; // sets request key too
			}
		}

		return $state;
	}

	protected function setPurchaseRequestFromSubscriptionId(
		string $subscriptionId,
		CallbackState $state
	): bool
	{
		$state->subscriberId = $subscriptionId;

		$purchaseRequest = \XF::em()->findOne(
			'XF:PurchaseRequest',
			['provider_metadata' => $subscriptionId]
		);

		if ($purchaseRequest)
		{
			$state->purchaseRequest = $purchaseRequest; // sets requestKey too
			return true;
		}

		$logFinder = \XF::finder('XF:PaymentProviderLog')
			->where('subscriber_id', $subscriptionId)
			->where('provider_id', $this->providerId)
			->order('log_date', 'desc');

		foreach ($logFinder->fetch() AS $log)
		{
			if ($log->purchase_request_key)
			{
				$state->requestKey = $log->purchase_request_key; // sets purchaseRequest too
				return true;
			}
		}

		return false;
	}

	protected function validateExpectedValues(CallbackState $state)
	{
		return ($state->getPurchaseRequest() && $state->getPaymentProfile());
	}

	protected function verifyWebhookSignature(CallbackState $state)
	{
		$paymentProfile = $state->getPaymentProfile();

		if (empty($paymentProfile->options['signing_secret']))
		{
			return true; // not enabled so pass
		}

		if (empty($state->signature))
		{
			return false; // enabled but signature missing so fail
		}

		$secret = $paymentProfile->options['signing_secret'];
		$payload = $state->inputRaw;
		$signature = $state->signature;

		try
		{
			$this->setupStripe($paymentProfile);
			$verifiedEvent = \Stripe\Webhook::constructEvent($payload, $signature, $secret);
		}
		catch (\Stripe\Exception\UnexpectedValueException $e)
		{
			return false;
		}
		catch (\Stripe\Exception\SignatureVerificationException $e)
		{
			return false;
		}

		return $verifiedEvent;
	}

	protected function getActionableEvents()
	{
		// charge.dispute.created doesn't automatically indicate a loss of funds
		// charge.dispute.funds_withdrawn is the indicator for that, so we will ignore creation.
		return [
			'charge.dispute.funds_withdrawn',
			'charge.dispute.funds_reinstated',
			'charge.refunded',
			'charge.succeeded',
			'invoice.payment_succeeded',
			'review.closed'
		];
	}

	protected function isEventSkippable(CallbackState $state)
	{
		$eventType = $state->eventType;

		if (!in_array($eventType, $this->getActionableEvents()))
		{
			return true;
		}

		if ($eventType === 'invoice.payment_succeeded' && (array_key_exists('charge', $state->event) && $state->event['charge'] === null))
		{
			// no charge associated so we already charged in a separate transaction
			// this is likely the initial invoice payment so we can skip this.
			return true;
		}

		return false;
	}

	public function validateCallback(CallbackState $state)
	{
		if ($this->isEventSkippable($state))
		{
			// Stripe sends a lot of webhooks, we shouldn't log them.
			// They are viewable verbosely in the Stripe Dashboard.
			$state->httpCode = 200;
			return false;
		}

		if (!$this->validateExpectedValues($state))
		{
			if (
				!empty($state->eventType)
				&& $state->eventType === 'charge.succeeded'
				&& !empty($state->event['invoice'])
			)
			{
				// if there's an invoice, that would indicate a recurring subscription and we generally
				// listen for the invoice payment event
				$state->httpCode = 200;
				return false;
			}

			$state->logType = 'error';
			$state->logMessage = 'Event data received from Stripe does not contain the expected values.';
			if (!$state->requestKey)
			{
				$state->httpCode = 200; // Not likely to recover from this error so send a successful response.
			}
			return false;
		}

		if (!$this->verifyWebhookSignature($state))
		{
			$state->logType = 'error';
			$state->logMessage = 'Webhook received from Stripe could not be verified as being valid.';
			$state->httpCode = 400;

			return false;
		}

		return true;
	}

	public function validateCost(CallbackState $state)
	{
		$purchaseRequest = $state->getPurchaseRequest();

		$currency = $purchaseRequest->cost_currency;
		$cost = $this->prepareCost($purchaseRequest->cost_amount, $currency);

		$amountPaid = null;
		$balanceChange = 0;

		switch ($state->eventType)
		{
			case 'charge.succeeded':
				$amountPaid = $state->event['amount'];
				break;
			case 'invoice.payment_succeeded':
				$amountPaid = $state->event['amount_paid'];

				if (isset($state->event['ending_balance']) && isset($state->event['starting_balance']))
				{
					$balanceChange = $state->event['starting_balance'] - $state->event['ending_balance'];
				}
				break;
		}

		if ($amountPaid !== null)
		{
			$costValidated = (
				$amountPaid === $cost
				&& strtoupper($state->event['currency']) === $currency
			);

			if (!$costValidated && $balanceChange)
			{
				// manipulating subscription dates in Stripe can lead to customer balances rather than a charge
				// so account for the balance change adjusting the amount paid
				$costValidated = (
					$amountPaid === ($cost + $balanceChange)
					&& strtoupper($state->event['currency']) === $currency
				);
			}

			if (!$costValidated && $state->eventType == 'invoice.payment_succeeded')
			{
				// due to previous approach in prepareCost, the cost could have gone through
				// to Stripe with a 1 cent (or equivalent) lower value than expected, so allow that,
				// provided Stripe is telling us that they've paid what's due
				$costValidated = (
					$amountPaid === ($cost - 1)
					&& $state->event['amount_due'] === $amountPaid
					&& strtoupper($state->event['currency']) === $currency
				);
			}

			if (!$costValidated)
			{
				$state->logType = 'error';
				$state->logMessage = 'Invalid cost amount';
				return false;
			}

			return true;
		}

		return true;
	}

	public function getPaymentResult(CallbackState $state)
	{
		switch ($state->eventType)
		{
			case 'charge.succeeded':
				if ($state->event['outcome']['type'] == 'authorized')
				{
					$state->paymentResult = CallbackState::PAYMENT_RECEIVED;
				}
				else
				{
					$state->logType = 'info';
					$state->logMessage = 'Charge succeeded but not authorized, it may require review in the Stripe Dashboard.';
				}

				// sleep for 5 seconds to offset an insanely fast webhook
				// being processed before the user is redirected
				// TODO: consider a different (better) approach
				usleep(5 * 1000000);

				$purchaseRequest = $state->purchaseRequest;

				if ($purchaseRequest
					&& $purchaseRequest->provider_metadata
					&& strpos($purchaseRequest->provider_metadata, 'sub_') === 0
					&& !empty($state->event['payment_method'])
				)
				{
					$this->setupStripe($state->paymentProfile);

					try
					{
						/** @var \Stripe\Subscription $subscription */
						$subscription = \Stripe\Subscription::retrieve(
							$purchaseRequest->provider_metadata
						);

						/** @var \Stripe\PaymentMethod $paymentMethod */
						$paymentMethod = \Stripe\PaymentMethod::retrieve(
							$state->event['payment_method']
						);

						\Stripe\Subscription::update($subscription->id, [
							'default_payment_method' => $paymentMethod->id
						]);
					}
					catch (\Stripe\Exception\ExceptionInterface $e) {}
				}

				break;

			case 'invoice.payment_succeeded':
				$state->paymentResult = CallbackState::PAYMENT_RECEIVED;
				break;

			case 'review.closed':
				if ($state->event['reason'] == 'approved')
				{
					$state->paymentResult = CallbackState::PAYMENT_RECEIVED;
				}
				else
				{
					$state->logType = 'info';
					$state->logMessage = 'Previous payment review now closed, but not approved.';
				}
				break;

			case 'charge.refunded':
			case 'charge.dispute.funds_withdrawn':
				$state->paymentResult = CallbackState::PAYMENT_REVERSED;
				break;

			case 'charge.dispute.funds_reinstated':
				$state->paymentResult = CallbackState::PAYMENT_REINSTATED;
				break;
		}
	}

	public function prepareLogData(CallbackState $state)
	{
		$state->logDetails = $state->event;
		$state->logDetails['eventType'] = $state->eventType;
	}

	protected $supportedCurrencies = [
		'AED', 'AFN', 'ALL', 'AMD', 'AOA',
		'ARS', 'AUD', 'AWG', 'AZN', 'BAM',
		'BBD', 'BDT', 'BGN', 'BIF', 'BMD',
		'BND', 'BOB', 'BRL', 'BWP', 'BZD',
		'CAD', 'CDF', 'CHF', 'CLP', 'CNY',
		'COP', 'CRC', 'CVE', 'CZK', 'DJF',
		'DKK', 'DOP', 'DZD', 'EGP', 'ETB',
		'EUR', 'GBP', 'GEL', 'GNF', 'GTQ',
		'GYD', 'HKD', 'HNL', 'HRK', 'HUF',
		'IDR', 'ILS', 'INR', 'ISK', 'JMD',
		'JPY', 'KES', 'KHR', 'KMF', 'KRW',
		'KZT', 'LBP', 'LKR', 'LRD', 'MAD',
		'MDL', 'MGA', 'MKD', 'MOP', 'MUR',
		'MXN', 'MYR', 'MZN', 'NAD', 'NGN',
		'NIO', 'NOK', 'NPR', 'NZD', 'PAB',
		'PEN', 'PHP', 'PKR', 'PLN', 'PYG',
		'QAR', 'RON', 'RSD', 'RUB', 'RWF',
		'SAR', 'SEK', 'SGD', 'SOS', 'STD',
		'THB', 'TOP', 'TRY', 'TTD', 'TWD',
		'TZS', 'UAH', 'UGX', 'USD', 'UYU',
		'UZS', 'VND', 'XAF', 'XOF', 'ZAR'
	];

	/**
	 * List of zero-decimal currencies as defined by Stripe's documentation. If we're dealing with one of these,
	 * this is already the smallest currency unit, and can be passed as-is. Otherwise convert it.
	 *
	 * @var array
	 */
	protected $zeroDecimalCurrencies = [
		'BIF', 'CLP', 'DJF', 'GNF', 'JPY',
		'KMF', 'KRW', 'MGA', 'PYG', 'RWF',
		'VND', 'VUV', 'XAF', 'XOF', 'XPF'
	];

	/**
	 * Given a cost and a currency, this will return the cost as an integer converted to the smallest currency unit.
	 *
	 * @param $cost
	 * @param $currency
	 *
	 * @return int
	 */
	protected function prepareCost($cost, $currency)
	{
		if (!in_array($currency, $this->zeroDecimalCurrencies))
		{
			$cost *= 100;
		}
		return intval(strval($cost));
	}

	public function verifyCurrency(PaymentProfile $paymentProfile, $currencyCode)
	{
		return (in_array($currencyCode, $this->supportedCurrencies));
	}

	/**
	 * @return string[]
	 */
	public function getCookieThirdParties(): array
	{
		return ['stripe'];
	}
}
