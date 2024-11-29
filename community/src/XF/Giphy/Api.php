<?php

namespace XF\Giphy;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

use function is_array;

class Api
{
	/**
	 * @var \GuzzleHttp\Client
	 */
	protected $client;

	protected $baseApiUrl = 'https://api.giphy.com/v1/';

	protected $apiKey;

	protected $config = [
		'random_id' => null,
		'rating' => 'g',
		'lang' => 'en'
	];

	public function __construct(string $apiKey, array $config = [])
	{
		$this->apiKey = $apiKey;

		$this->config = array_replace($this->config, $config);

		$this->client = \XF::app()->http()->createClient([
			'base_uri' => $this->baseApiUrl,
			'http_errors' => false
         ]);
	}

	public function getTrending(int $offset, int $limit, string &$error = null)
	{
		$config = $this->config;

		$result = $this->request('gifs/trending', [
			'random_id' => $config['random_id'],
			'rating' => $config['rating'],
			'limit' => $limit,
			'offset' => $offset
		], $error);

		if ($error)
		{
			return [];
		}

		$images = $this->prepareImageResults($result);
		return $images;
	}

	public function getSearchResults(string $q, int $offset, int $limit, string &$error = null)
	{
		$config = $this->config;

		$result = $this->request('gifs/search', [
			'q' => $q,
			'random_id' => $config['random_id'],
			'rating' => $config['rating'],
			'limit' => $limit,
			'offset' => $offset
		], $error);

		if ($error)
		{
			return [];
		}

		$images = $this->prepareImageResults($result);
		return $images;
	}

	public function request(string $path, array $params = [], string &$error = null, string $method = 'get'): array
	{
		$params = ['api_key' => $this->apiKey] + $params;
		$path .= '?' . http_build_query($params);

		$request = new Request($method, $path);

		try
		{
			$response = $this->client->send($request);
			$body = $response->getBody();

			if ($body)
			{
				$contents = @json_decode($body->getContents(), true);
				$result = is_array($contents) ? $contents : [];

				if ($response->getStatusCode() !== 200)
				{
					$error = 'GIPHY API error: ' . ($result['message'] ?? \XF::phrase('unexpected_error_occurred'));
					\XF::logError($error);
				}
			}
			else
			{
				$result = [];
				$error = 'GIPHY API error: ' . \XF::phrase('unexpected_error_occurred');
				\XF::logError($error);
			}
		}
		catch (RequestException $e)
		{
			\XF::logException($e, false, 'GIPHY connection error: ');
			$result = [];

			$error = $e->getMessage();
		}

		return $result;
	}

	protected function prepareImageResults($result): array
	{
		$images = [];

		if (is_array($result))
		{
			foreach ($result['data'] AS $data)
			{
				$fixedHeight = $data['images']['fixed_height']['url']; // always available
				$fixedHeightStill = $data['images']['fixed_height_still']['url']; // always available

				$fixedHeightSmall = $data['images']['fixed_height_small']['url'] ?? $fixedHeight;
				$fixedHeightSmallStill = $data['images']['fixed_height_small_still']['url'] ?? $fixedHeightStill;

				$images[$data['id']] = [
					'title' => $data['title'],
					'insert' => $this->normalizeImageUrl($fixedHeight),
					'src' => $this->normalizeImageUrl($fixedHeightSmall),
					'thumb' => $this->normalizeImageUrl($fixedHeightSmallStill),
				];
			}
		}

		return $images;
	}

	protected function normalizeImageUrl($url)
	{
		$parts = parse_url($url);
		return sprintf(
			'%s://%s%s',
			$parts['scheme'],
			$parts['host'],
			$parts['path']
		);
	}
}