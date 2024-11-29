<?php

namespace XF\Admin\View\Log\ImageProxy;

class Image extends \XF\Mvc\View
{
	public function renderRaw()
	{
		/** @var \XF\Entity\ImageProxy $image */
		$image = $this->params['image'];
		/** @var \XF\Entity\ImageProxy $image */
		$placeHolderImage = $this->params['placeHolderImage'];

		$proxyController = \XF::app()->proxy()->controller();
		$proxyController->applyImageResponseHeaders($this->response, $image, null);

		if ($image->isPlaceholder())
		{
			return $this->response->responseFile($image->getPlaceholderPath());
		}
		else
		{
			try
			{
				$resource = \XF::fs()->readStream($image->getAbstractedImagePath());
				return $this->response->responseStream($resource, $image->file_size);
			}
			catch (\League\Flysystem\FileNotFoundException $e)
			{
				// the file was pruned mid-request
				return $this->response->responseFile($placeHolderImage->getPlaceholderPath());
			}
		}
	}
}