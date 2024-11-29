<?php

namespace XF\BbCode\Renderer;

use function intval;

class ApiHtml extends Html
{
	public function getDefaultOptions()
	{
		$options = parent::getDefaultOptions();
		$options['lightbox'] = false;
		$options['stopSmilies'] = 1;
		$options['allowUnfurl'] = false;
		$options['noProxy'] = true;

		return $options;
	}

	public function filterFinalOutput($output)
	{
		return trim($output);
	}

	public function renderTagAttach(array $children, $option, array $tag, array $options)
	{
		$id = intval($this->renderSubTreePlain($children));
		if (!$id)
		{
			return '';
		}

		$fullUrl = \XF::app()->router('public')->buildLink('canonical:attachments', ['attachment_id' => $id]);

		if (empty($options['attachments'][$id]))
		{
			$phrase = \XF::phrase('view_attachment_x', ['name' => $id]);
			return '<a href="' . htmlspecialchars($fullUrl) . '">' . $phrase . '</a>';
		}

		/** @var \XF\Entity\Attachment $attachment */
		$attachment = $options['attachments'][$id];

		$canView = !empty($options['viewAttachments']);
		$isFull = $this->isFullAttachView($option);

		$displayAttrs = $this->processImageDisplayModifiers(
			$option,
			$this->getDefaultImageDisplayOptions($options)
		);

		$alt = ($displayAttrs['alt'] ?? '') ?: $attachment->filename;

		if ($attachment->is_video && $canView)
		{
			$videoUrl = \XF::canonicalizeUrl($attachment->direct_url);
			return '<video controls><source src="' . htmlspecialchars($videoUrl) . '" /></video>';
		}
		else if ($attachment->is_audio && $canView)
		{
			$audioUrl = \XF::canonicalizeUrl($attachment->direct_url);
			return '<audio controls><source src="' . htmlspecialchars($audioUrl) . '" /></audio>';
		}
		else if ($canView && $isFull && $attachment->Data->width)
		{
			return '<img src="' . htmlspecialchars($fullUrl) . '" alt="' . htmlspecialchars($alt) . '" />';
		}
		else if ($attachment->has_thumbnail)
		{
			$thumbnailUrl = $attachment->thumbnail_url_full;

			return '<a href="' . htmlspecialchars($fullUrl) . '">'
				. '<img src="' . htmlspecialchars($thumbnailUrl) . '" alt="' . htmlspecialchars($alt) . '" />'
				. '</a>';
		}
		else
		{
			$phrase = \XF::phrase('view_attachment_x', ['name' => $attachment->filename]);
			return '<a href="' . htmlspecialchars($fullUrl) . '">' . $phrase . '</a>';
		}
	}

	protected function getRenderedCode($content, $language, array $config = [])
	{
		return $this->wrapHtml(
			'<pre class="xfBb-code" data-lang="' . htmlspecialchars($language) . '">',
			$content,
			'</pre>'
		);
	}

	public function renderTagInlineCode(array $children, $option, array $tag, array $options)
	{
		$content = $this->renderSubTree($children, $options);

		return $this->wrapHtml('<code class="xfBb-icode">', $content, '</code>');
	}

	protected function getRenderedImg($imageUrl, $validUrl, array $params = [])
	{
		$alt = $params['alt'] ?? '';

		return '<img src="' . htmlspecialchars($imageUrl) . '" alt="' . htmlspecialchars($alt) . '" />';
	}

	protected function getRenderedQuote($content, $name, array $source, array $attributes)
	{
		return $this->wrapHtml(
			'<blockquote class="xfBb-quote" data-name="' . htmlspecialchars($name) . '">',
			$content,
			'</blockquote>'
		);
	}

	protected function getRenderedSpoiler($content, $title = null)
	{
		return $this->wrapHtml(
			'<div>',
			\XF::phrase('spoiler_content_hidden'),
			'</div>'
		);
	}

	protected function getRenderedInlineSpoiler($content)
	{
		return $this->wrapHtml(
			'<span>',
			\XF::phrase('spoiler_content_hidden'),
			'</span>'
		);
	}

	protected function getRenderedUser($content, int $userId)
	{
		$link = \XF::app()->router('public')->buildLink('canonical:members', ['user_id' => $userId]);

		return $this->wrapHtml(
			'<a href="' . htmlspecialchars($link) . '">',
			$content,
			'</a>'
		);
	}

	protected function renderFinalTableHtml($tableHtml, $tagOption, $extraContent)
	{
		return "<div class='xfBb-table'>\n<table style='width: 100%'>$tableHtml</table>\n$extraContent</div>";
	}
}