<?php

namespace XF\Mvc\Reply;

use function is_array, is_object, is_string;

class Error extends AbstractReply
{
	/**
	 * @var array<string|\Stringable>
	 */
	protected $errors = [];

	/**
	 * @param string|\Stringable|array<string|\Stringable> $errors
	 * @param int                                          $responseCode
	 */
	public function __construct($errors, $responseCode = 200)
	{
		$this->setErrors($errors, false);
		$this->setResponseCode($responseCode);
	}

	/**
	 * @return array<string|\Stringable>
	 */
	public function getErrors()
	{
		return $this->errors;
	}

	/**
	 * @param string|\Stringable|array<string|\Stringable> $errors
	 * @param bool                                         $append
	 */
	public function setErrors($errors, $append = true)
	{
		if (!is_array($errors))
		{
			$errors = [$errors];
		}

		foreach ($errors AS $error)
		{
			$this->validateErrorValue($error);
		}

		if ($append)
		{
			$this->errors = array_merge($this->errors, $errors);
		}
		else
		{
			$this->errors = $errors;
		}
	}

	/**
	 * @param string|\Stringable $error
	 */
	public function addError($error)
	{
		$this->validateErrorValue($error);
		$this->errors[] = $error;
	}

	protected function validateErrorValue($error): void
	{
		if (is_string($error))
		{
			return;
		}

		if (is_object($error) && method_exists($error, '__toString'))
		{
			return;
		}

		throw new \InvalidArgumentException(
			'The error value must be a string or an object which can be cast to a string'
		);
	}

}