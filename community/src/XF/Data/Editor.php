<?php

namespace XF\Data;

class Editor
{
	public function getStandardButtons(): array
	{
		return [
			'clearFormatting' => [
				'fa' => 'fa-eraser',
				'title' => \XF::phrase('remove_formatting')
			],
			'bold' => [
				'fa' => 'fa-bold',
				'title' => \XF::phrase('weight_bold')
			],
			'italic' => [
				'fa' => 'fa-italic',
				'title' => \XF::phrase('italic')
			],
			'underline' => [
				'fa' => 'fa-underline',
				'title' => \XF::phrase('underline')
			],
			'strikeThrough' => [
				'fa' => 'fa-strikethrough',
				'title' => \XF::phrase('strike_through')
			],
			'textColor' => [
				'fa' => 'fa-palette',
				'title' => \XF::phrase('text_color')
			],
			'fontFamily' => [
				'fa' => 'fa-font',
				'title' => \XF::phrase('font_family'),
				'type' => 'dropdown'
			],
			'fontSize' => [
				'fa' => 'fa-text-size',
				'title' => \XF::phrase('font_size'),
				'type' => 'dropdown'
			],
			'insertLink' => [
				'fa' => 'fa-link',
				'title' => \XF::phrase('insert_link')
			],
			'insertImage' => [
				'fa' => 'fa-image',
				'title' => \XF::phrase('insert_image')
			],
			'xfInsertGif' => [
				'svg' => 'M11.5 9H13v6h-1.5zM9 9H6c-.6 0-1 .5-1 1v4c0 .5.4 1 1 1h3c.6 0 1-.5 1-1v-2H8.5v1.5h-2v-3H10V10c0-.5-.4-1-1-1zm10 1.5V9h-4.5v6H16v-2h2v-1.5h-2v-1z',
				'title' => \XF::phrase('insert_gif')
			],
			'insertVideo' => [
				'fa' => 'fa-video-plus',
				'title' => \XF::phrase('insert_video')
			],
			'xfSmilie' => [
				'fa' => 'fa-smile',
				'title' => \XF::phrase('smilies')
			],
			'xfMedia' => [
				'fa' => 'fa-photo-video',
				'title' => \XF::phrase('media')
			],
			'xfQuote' => [
				'fa' => 'fa-quote-right',
				'title' => \XF::phrase('quote')
			],
			'xfSpoiler' => [
				'fa' => 'fa-eye-slash',
				'title' => \XF::phrase('spoiler')
			],
			'xfInlineSpoiler' => [
				'fa' => 'fa-mask',
				'title' => \XF::phrase('inline_spoiler')
			],
			'xfCode' => [
				'fa' => 'fa-code',
				'title' => \XF::phrase('code')
			],
			'xfInlineCode' => [
				'fa' => 'fa-terminal',
				'title' => \XF::phrase('inline_code')
			],
			'align' => [
				'fa' => 'fa-align-left',
				'title' => \XF::phrase('alignment'),
				'type' => 'dropdown'
			],
			'formatOL' => [
				'fa' => 'fa-list-ol',
				'title' => \XF::phrase('ordered_list')
			],
			'formatUL' => [
				'fa' => 'fa-list-ul',
				'title' => \XF::phrase('unordered_list')
			],
			'indent' => [
				'fa' => 'fa-indent',
				'title' => \XF::phrase('indent')
			],
			'outdent' => [
				'fa' => 'fa-outdent',
				'title' => \XF::phrase('outdent')
			],
			'insertTable' => [
				'fa' => 'fa-table',
				'title' => \XF::phrase('insert_table')
			],
			'insertHR' => [
				'fa' => 'fa-horizontal-rule',
				'title' => \XF::phrase('insert_horizontal_line')
			],
			'undo' => [
				'fa' => 'fa-undo',
				'title' => \XF::phrase('undo')
			],
			'redo' => [
				'fa' => 'fa-redo',
				'title' => \XF::phrase('redo')
			],
			'xfDraft' => [
				'fa' => 'fa-save',
				'title' => \XF::phrase('drafts'),
				'type' => 'dropdown'
			],
			'xfBbCode' => [
				'fa' => 'fa-brackets',
				'title' => \XF::phrase('toggle_bb_code')
			],
			'alignLeft' => [
				'fa' => 'fa-align-left',
				'title' => \XF::phrase('align_left')
			],
			'alignCenter' => [
				'fa' => 'fa-align-center',
				'title' => \XF::phrase('align_center')
			],
			'alignRight' => [
				'fa' => 'fa-align-right',
				'title' => \XF::phrase('align_right')
			],
			'alignJustify' => [
				'fa' => 'fa-align-justify',
				'title' => \XF::phrase('justify_text')
			],
			'paragraphFormat' => [
				'fa' => 'fa-paragraph',
				'title' => \XF::phrase('paragraph_format'),
				'type' => 'dropdown'
			],
		];
	}

	public function getCombinedButtonData($customBbCodes = [], $dropdowns = []): array
	{
		$buttons = $this->getStandardButtons();
		$buttons = array_merge($buttons, $this->getButtonsFromCustomBbCodes($customBbCodes));

		\XF::fire('editor_button_data', [&$buttons, $this]);

		$dropdownButtons = $this->getButtonsFromDropdowns($dropdowns);
		if ($dropdownButtons)
		{
			$buttons['-hr'] = false;
			$buttons = array_merge($buttons, $dropdownButtons);
		}

		/*// vertical separator // TODO: not until separators are properly implemented
		$buttons['|'] = [
			'text' => '|',
			'title' => \XF::phrase('vertical_separator'),
			'type' => 'separator'
		];*/

		return $buttons;
	}

	public function getButtonsFromCustomBbCodes($bbCodes): array
	{
		$buttons = [];

		foreach ($bbCodes AS $bbCodeId => $bbCode)
		{
			$key = 'xfCustom_' . $bbCodeId;
			$buttons[$key] = [
				'title' => $bbCode->title
			];

			switch ($bbCode->editor_icon_type)
			{
				case 'fa':
					$buttons[$key]['fa'] = (substr($bbCode->editor_icon_value, 0, 2) == 'fa' ? '' : 'fa-') . $bbCode->editor_icon_value;
					break;

				case 'image':
					$buttons[$key]['image'] = $bbCode->editor_icon_value;
					break;

				case '':
					$buttons[$key]['text'] = $bbCode->editor_icon_value;
					break;

			}
		}

		return $buttons;
	}

	public function getButtonsFromDropdowns($dropdowns): array
	{
		$buttons = [];

		foreach ($dropdowns AS $cmd => $dropdown)
		{
			$buttons[$cmd] = [
				'fa' => $dropdown->icon,
				'title' => $dropdown->title,
				'type' => 'editable_dropdown'
			];
		}

		return $buttons;
	}
}