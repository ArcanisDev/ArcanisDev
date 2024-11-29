<?php

namespace XF\Pub\View\Error;


class EmbeddedImageRequest extends \XF\Mvc\View
{
	public function renderRaw()
	{
		$response = $this->response;

		$response->contentType('image/png', '')
			->setDownloadFileName('invalid_image_request.png', true);

		$response->header('X-XF-Error', 'unexpected_embedded_image_request');

		return $response->responseFile(\XF::getRootDirectory() . '/styles/default/xenforo/missing-image.png');
	}
}