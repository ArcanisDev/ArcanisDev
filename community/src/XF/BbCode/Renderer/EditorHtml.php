<?php

namespace XF\BbCode\Renderer;

use function count, intval, is_array, strlen;

class EditorHtml extends Html
{
	protected $undisplayableTags = [
		'code',
		'icode',
		'html',
		'php',
		'media',
		'plain',
		'spoiler',
		'ispoiler',
		'user',
	];

	protected $blockTagsOpenRegex = '(?:<p|<div|<blockquote|<ul|<ol|<table|<h\\d|<hr)(?=[\s>]|$)';
	protected $blockTagsCloseRegex = '</p>|</div>|</blockquote>|</ul>|</ol>|</table>|</h\\d>|</hr>';

	public function addDefaultTags()
	{
		parent::addDefaultTags();

		$this->modifyTag('b', ['replace' => ['<strong>', '</strong>']]);
		$this->addTag('i', ['replace' => ['<em>', '</em>']]);
		$this->addTag('u', ['replace' => ['<u>', '</u>']]);
		$this->addTag('s', ['replace' => ['<s>', '</s>']]);

		$this->modifyTag('url', ['trimAfter' => 0]);

		foreach ($this->undisplayableTags AS $tag)
		{
			$this->modifyTag($tag, [
				'replace' => null,
				'callback' => null,
				'trimAfter' => 0,
				'stopBreakConversion' => false
			]);
		}
	}

	public function getCustomTagConfig(array $tag)
	{
		// custom tags are displayed
		return [
			'replace' => null,
			'callback' => null
		];
	}

	public function getDefaultOptions()
	{
		$options = parent::getDefaultOptions();
		$options['noProxy'] = true;
		$options['inList'] = false;
		$options['lightbox'] = false;

		return $options;
	}

	public function filterFinalOutput($output)
	{
		$debug = false;

		$btOpen = $this->blockTagsOpenRegex;
		$btClose = $this->blockTagsCloseRegex;

		$debugNl = ($debug ? "\n" : '');

		if ($debug) { echo '<hr /><b>Original:</b><br />'. nl2br(htmlspecialchars($output)); }

		$output = $this->cleanUpInlineListWrapping($output);

		$output = preg_replace('#\s*<break-start />(?>\s*)(?!' . $btOpen . '|' . $btClose . '|<break-start|$)#i', $debugNl . "<p>", $output);
		$output = preg_replace('#\s*<break-start />#i', '', $output);
		$output = preg_replace('#(' . $btClose . ')\s*<break />#i', "\\1", $output);
		$output = preg_replace('#<break />\s*(' . $btOpen . '|' . $btClose . ')#i', "</p>" . ($debug ? "\n" : '') . "\\1", $output);
		$output = preg_replace('#<break />\r?\n( )#i', "</p>" . $debugNl . "<p>&nbsp;", $output);
		$output = preg_replace('#<break />\s*#i', "</p>" . $debugNl . "<p>", $output);

		if ($debug) { echo '<hr /><b>Post-break:</b><br />'. nl2br(htmlspecialchars($output)); }

		$output = trim($output);
		if (!preg_match('#^(' . $btOpen . ')#i', $output))
		{
			$output = '<p>' . $output;
		}
		if (!preg_match('#(' . $btClose . ')$#i', $output))
		{
			$output .= '</p>';
		}
		else if (preg_match('#(</blockquote>|</table>|</ol>|</ul>)$#i', $output))
		{
			$output .= $debugNl . '<p></p>';
		}

		$output = preg_replace_callback('#(<p[^>]*>)(.*)(</p>)#siU',
			[$this, 'replaceEmptyContent'], $output
		);
		$output = str_replace('<empty-content />', '', $output); // just in case

		$output = $this->fixListStyles($output);

		if ($debug) { echo '<hr /><b>Final:</b><br />'. nl2br(htmlspecialchars($output)); }

		return $output;
	}

	protected function cleanUpInlineListWrapping($text)
	{
		do
		{
			$originalText = $text;

			$text = preg_replace_callback(
				'#<(span|strong|em|u|s)([^>]*)><break-start />\s*<(ul|ol)(\s[^>]*)?>(.*)</\\3>\s*<break-start />\s*</\\1>#siU',
				function (array $match)
				{
					$inlineTag = $match[1];
					$inlineAttrs = $match[2];
					$listTag = $match[3];
					$listAttrs = $match[4];
					$listContents = $match[5];

					$listContents = preg_replace_callback(
						'#(<li[^>]*>)(.*)(</li>)#siU',
						function (array $elementMatch) use ($inlineTag, $inlineAttrs)
						{
							$elementContents = "<$inlineTag$inlineAttrs>$elementMatch[2]</$inlineTag>";

							return $elementMatch[1] . $elementContents . $elementMatch[3];
						},
						$listContents
					);

					return "<break-start /><$listTag$listAttrs>$listContents</$listTag><break-start />";
				},
				$text
			);
		}
		while ($originalText != $text);

		return $text;
	}

	protected function replaceEmptyContent(array $match)
	{
		$emptyParaText = ''; // was  <br /> -- Froala seems to handle this for us and removing this fixes some minor issues

		if (strlen(trim($match[2])) == 0)
		{
			// paragraph is actually empty
			$output = $emptyParaText;
		}
		else
		{
			$test = strip_tags($match[2], '<empty-content><img><br><hr>');
			if (trim($test) == '<empty-content />')
			{
				$output = str_replace('<empty-content />', $emptyParaText, $match[2]);
			}
			else
			{
				// we had a break
				$output = str_replace('<empty-content />', '', $match[2]);
			}
		}

		return $match[1] . $output . $match[3];
	}

	protected function fixListStyles($output)
	{
		$fix = function(array $match)
		{
			$pAttrs = $match[1];
			$listTag = $match[2];
			$listAttrs = $match[3];
			$listContent = $match[4];

			if (!$listAttrs)
			{
				$listAttrs = $pAttrs;
			}
			else
			{
				// TODO: this is not actually correct as it doesn't merge style attributes, but it's likely to be uncommon
				$listAttrs = $listAttrs . ' ' . $pAttrs;
			}

			return "<{$listTag}{$listAttrs}>{$listContent}</{$listTag}>";
		};

		do
		{
			$original = $output;
			$output = preg_replace_callback(
				'#<p([^>]*)>\s*<(ul|ol)([^>]*)>(.*)</\\2>\s*</p>#siU',
				$fix,
				$output
			);
		}
		while ($original != $output);

		return $output;
	}

	public function filterString($string, array $options)
	{
		if (!empty($options['treatAsStructuredText']))
		{
			$string = $this->formatter->convertStructuredTextLinkToBbCode($string);
			$string = $this->formatter->convertStructuredTextMentionsToBbCode($string);
		}

		if (empty($options['stopSmilies']))
		{
			$string = $this->formatter->replaceSmiliesHtml($string);
			$string = $this->formatter->getEmojiFormatter()->formatEmojiToImage($string);
		}
		else
		{
			$string = htmlspecialchars($string);
		}

		$string = str_replace("\t", '    ', $string);

		// doing this twice handles situations with 3 spaces
		$string = str_replace('  ', '&nbsp; ', $string);
		$string = str_replace('  ', '&nbsp; ', $string);

		if (empty($options['stopLineBreakConversion']))
		{
			if (!empty($options['inList']) || !empty($options['inTable']))
			{
				$string = nl2br($string);
			}
			else
			{
				$string = preg_replace('/\r\n|\n|\r/', "<break />\n", $string);
			}
		}

		return $string;
	}

	public function renderTagUrl(array $children, $option, array $tag, array $options)
	{
		$options['shortenUrl'] = false;

		if (is_array($option)
			&& !empty($option['unfurl'])
		)
		{
			// we're inside a URL tag already
			// don't treat what's inside it was structured text
			// otherwise unfurled URLs will be wrapped in a further URL
			$options['treatAsStructuredText'] = false;
			return $this->renderUnparsedTag($tag, $options);
		}

		return parent::renderTagUrl($children, $option, $tag, $options);
	}

	protected function getRenderedLink($text, $url, array $options)
	{
		return $this->wrapHtml(
			'<a href="' . htmlspecialchars($url) . '" target="_blank">',
			$text,
			'</a>'
		);
	}

	protected function getDefaultImageDisplayOptions(array $renderOptions = []): array
	{
		return [
			'leftAlignClass' => 'fr-fil',
			'rightAlignClass' => 'fr-fir',
			'allowIntrinsicDimensions' => false
		];
	}

	protected function getRenderedImg($imageUrl, $validUrl, array $params = [])
	{
		$alt = $params['alt'] ?? '';
		$styleAttr = $params['styleAttr'] ?? '';
		$class = 'fr-fic fr-dii fr-draggable ' . ($params['alignClass'] ?? '');

		return '<img src="' . htmlspecialchars($validUrl) . '"'
			. ' alt="' . htmlspecialchars($alt) . '"'
			. ' class="' . htmlspecialchars($class) . '"'
			. ' style="' . htmlspecialchars($styleAttr) . '" />';
	}

	public function renderTagAttach(array $children, $option, array $tag, array $options)
	{
		$id = intval($this->renderSubTreePlain($children));
		if (!$id)
		{
			return '';
		}

		// TODO: get the extra attributes for this - align, width etc.
		$full = $this->isFullAttachView($option);
		$type = $full ? 'full' : 'thumb';

		$bbCode = '[ATTACH' . ($full ? '=full' : '') . ']' . $id . '[/ATTACH]';

		if (empty($options['attachments'][$id]))
		{
			return $bbCode;
		}

		/** @var \XF\Entity\Attachment $attachment */
		$attachment = $options['attachments'][$id];

		$url = htmlspecialchars($attachment->direct_url);
		$align = $this->hasAlignOption($option);

		if ($attachment->is_video)
		{
			switch ($align)
			{
				case 'R': $alignClass = 'fr-fvr'; break;
				case 'L': $alignClass = 'fr-fvl'; break;
				default: $alignClass = '';
			}

			return '<span contenteditable="false" draggable="true"'
				. ' class="fr-video fr-dvi fr-draggable fr-deletable ' . $alignClass . '">'
				. '<video data-xf-init="video-init" data-attachment="full:' . $id . '"'
				. ' src="' . $url . '" controls></video></span>';
		}
		else if ($attachment->is_audio)
		{
			switch ($align)
			{
				case 'R': $alignClass = 'fr-fvr'; break;
				case 'L': $alignClass = 'fr-fvl'; break;
				default: $alignClass = '';
			}

			return '<span contenteditable="false" draggable="true"'
				. ' class="fr-audio fr-dvi fr-draggable fr-deletable ' . $alignClass . '">'
				. '<audio data-attachment="full:' . $id . '" src="' . $url . '" controls></audio></span>';
		}
		else if ($attachment->has_thumbnail)
		{
			if ($type == 'thumb')
			{
				$url = $attachment->thumbnail_url;
			}

			switch ($align)
			{
				case 'R': $alignClass = 'fr-fir'; break;
				case 'L': $alignClass = 'fr-fil'; break;
				default: $alignClass = '';
			}

			$displayAttrs = $this->processImageDisplayModifiers(
				$option,
				$this->getDefaultImageDisplayOptions($options)
			);

			$styleAttr = htmlspecialchars($displayAttrs['style'] ?? '');

			$alt = $displayAttrs['alt'] ?? '';
			$alt = htmlspecialchars($alt ?: ($attachment ? $attachment->filename : ''));

			$url = htmlspecialchars($url);

			return "<img src=\"{$url}\" data-attachment=\"{$type}:{$id}\" alt=\"{$alt}\" class=\"{$alignClass}\" style=\"{$styleAttr}\" />";
		}
		else
		{
			return $bbCode;
		}
	}

	public function renderTagAlign(array $children, $option, array $tag, array $options)
	{
		$output = $this->renderSubTree($children, $options);

		switch (strtolower($tag['tag']))
		{
			case 'left':
			case 'center':
			case 'right':
			case 'justify':
				$wrapped = $this->wrapHtml('<p style="text-align: ' . $tag['tag'] . '">', $output, '</p>');
				return "{$wrapped}<break-start />\n";

			default:
				return $this->wrapHtml('<p>', $output, '</p>') . "<break-start />\n";
		}
	}

	public function renderTagList(array $children, $option, array $tag, array $options)
	{
		$wasInList = !empty($options['inList']);
		$options['inList'] = true;

		$output = parent::renderTagList($children, $option, $tag, $options);
		$output = preg_replace('#\s*<break-start />\s*#i', "\n", $output);
		if (!$wasInList)
		{
			$output = "<break-start />\n$output<break-start />\n";
		}

		return $output;
	}

	public function renderTagIndent(array $children, $option, array $tag, array $options)
	{
		$output = $this->renderSubTree($children, $options);

		$amount = $option ? intval($option) : 1;
		$amount = max(1, min($amount, 5));

		$side = \XF::language()->isRtl() ? 'right' : 'left';
		$css = 'margin-' . $side . ': ' . ($amount * 20) . 'px';

		$wrapped = $this->wrapHtml(
			'<p style="' . $css . '">',
			$output,
			'</p>'
		);
		return "{$wrapped}<break-start />\n";
	}

	public function renderTagHeading(array $children, $option, array $tag, array $options)
	{
		$align = null;
		$output = null;

		if (count($children) == 1 && is_array($children[0]))
		{
			$alignTag = $children[0];

			switch ($alignTag['tag'])
			{
				case 'left':
				case 'center':
				case 'right':
				case 'justify':
					$align = $alignTag['tag'];
					$output = $this->renderSubTree($alignTag['children'], $options);
			}
		}

		if ($align === null)
		{
			$output = $this->renderSubTree($children, $options);
		}

		$type = $option ? intval($option) : 0;
		$tag = $this->getHeadingTagMap($type);
		if ($tag == 'div')
		{
			$tag = 'p';
		}

		if ($align)
		{
			$styleAttr = ' style="text-align: ' . $align . '"';
		}
		else
		{
			$styleAttr = '';
		}

		$wrapped = $this->wrapHtml("<{$tag}{$styleAttr}>", $output, "</$tag>");
		return "<break-start />{$wrapped}<break-start />\n";
	}

	public function renderTagHr(array $children, $option, array $tag, array $options)
	{
		$output = trim($this->renderSubTree($children, $options));

		return "<break-start /><hr /><break-start />\n{$output}";
	}

	public function renderTagQuote(array $children, $option, array $tag, array $options)
	{
		if (!$children)
		{
			return '';
		}

		$quoteParams = $this->parseQuoteTagParams($option, $options);

		$quoteAttributeParts = [];
		if ($quoteParams['name'])
		{
			$quoteAttributeParts[] = 'data-quote="' . htmlspecialchars($quoteParams['name']) . '"';
		}
		if ($quoteParams['source'])
		{
			$source = $quoteParams['source'];
			$quoteAttributeParts[] = 'data-source="' . htmlspecialchars("$source[type]: $source[id]") . '"';
			unset($quoteParams['attributes'][$source['type']]); // will double output otherwise
		}
		if ($quoteParams['attributes'])
		{
			$attributes = $quoteParams['attributes'];
			$parts = [];
			foreach ($attributes AS $k => $v)
			{
				$parts[] = "$k: $v";
			}
			$quoteAttributeParts[] = 'data-attributes="' . htmlspecialchars(implode(', ', $parts)) . '"';
		}

		$quoteAttributes = $quoteAttributeParts ? ' ' . implode(' ', $quoteAttributeParts) : '';

		$this->trimChildrenList($children);
		$output = trim($this->renderSubTree($children, $options));

		if (!preg_match('#^(' . $this->blockTagsOpenRegex . ')#si', $output))
		{
			$output = '<p>' . $output;
		}
		if (!preg_match('#(' . $this->blockTagsCloseRegex . '|<break />|<break-start />)$#si', $output))
		{
			$output .= '</p>';
		}
		$output = preg_replace('#\s*<break-start />$#si', '', $output);

		return "<blockquote{$quoteAttributes}>{$output}</blockquote><break-start />\n";
	}

	public function renderTagTable(array $children, $option, array $tag, array $options)
	{
		$wasInTable = !empty($options['inTable']);
		$options['inTable'] = true;

		$output = parent::renderTagTable($children, $option, $tag, $options);
		$output = preg_replace('#\s*<break-start />\s*#i', "\n", $output);
		if (!$wasInTable)
		{
			$output = "<break-start />\n$output<break-start />\n";
		}

		return $output;
	}

	protected function renderFinalTableHtml($tableHtml, $tagOption, $extraContent)
	{
		$output = "<table style='width: 100%'>$tableHtml</table>";

		if (strlen($extraContent))
		{
			$output .= "<p>$extraContent</p>";
		}

		return $output;
	}

	public function wrapHtml($open, $inner, $close, $option = null)
	{
		$btOpen = $this->blockTagsOpenRegex;
		$btClose = $this->blockTagsCloseRegex;

		$inner = preg_replace('#(<break />\s*)(?=<break />|$)#i', '\\1<empty-content />', $inner);

		$callback = function ($m) use ($close, $open) { return $close . $m[0] . $open; };

		if (preg_match('#^(' . $btOpen . ')#i', $open))
		{
			$inner = preg_replace_callback(
				'#<break-start />(?>\s*)(?!' . $btOpen . '|' . $btClose . '|$)#i',
				$callback,
				$inner
			);
			$inner = preg_replace_callback(
				'#<break />(?>\s*)(?!' . $btOpen . ')#i',
				$callback,
				$inner
			);
		}
		else
		{
			if (preg_match('#^<break />#i', $inner))
			{
				$inner = '<empty-content />' . $inner;
			}
			$inner = preg_replace_callback('#<break />\s*((' . $btOpen . ')[^>]*>)?#i', $callback, $inner);
		}

		return $open . $inner . $close;
	}
}