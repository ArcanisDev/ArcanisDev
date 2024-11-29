!function($, window, document, _undefined)
{
	"use strict";

	$.FE = FroalaEditor;

	XF.isEditorEnabled = function()
	{
		return XF.LocalStorage.get('editorDisabled') ? false : true;
	};
	XF.setIsEditorEnabled = function(enabled)
	{
		if (enabled)
		{
			XF.LocalStorage.remove('editorDisabled');
		}
		else
		{
			XF.LocalStorage.set('editorDisabled', '1', true);
		}
	};

	XF.Editor = XF.Element.newHandler({
		options: {
			maxHeight: .70,
			minHeight: 250, // default set in Templater->formEditor() $controlOptions['data-min-height']
			buttonsRemove: '',
			attachmentTarget: true,
			deferred: false,
			attachmentUploader: '.js-attachmentUpload',
			attachmentContextInput: 'attachment_hash_combined'
		},

		edMinHeight: 63, // Froala seems to force height to a minimum of 63

		$form: null,
		buttonManager: null,
		ed: null,
		mentioner: null,
		emojiCompleter: null,
		uploadUrl: null,

		init: function()
		{
			if (!this.$target.is('textarea'))
			{
				console.error('Editor can only be initialized on a textarea');
				return;
			}

			// make sure the min height cannot be below the minimum
			this.options.minHeight = Math.max(this.edMinHeight, this.options.minHeight);

			this.$target.trigger('editor:start', [this]);

			this.$form = this.$target.closest('form');
			if (!this.$form.length)
			{
				this.$form = null;
			}

			if (this.options.attachmentTarget)
			{
				var $attachManager = this.$target.closest('[data-xf-init~=attachment-manager]'),
					$uploader = $attachManager.find(this.options.attachmentUploader);
				this.uploadUrl = $uploader.attr('href');
			}

			if (!this.options.deferred)
			{
				this.startInit();
			}
		},

		startInit: function(callbacks)
		{
			var t = this,
				cbBefore = callbacks && callbacks.beforeInit,
				cbAfter = callbacks && callbacks.afterInit;

			this.$target.css('visibility', '');

			this.ed = new FroalaEditor(this.$target[0], this.getEditorConfig(), function()
			{
				var ed = t.ed;

				if (cbBefore)
				{
					cbBefore(t, ed);
				}

				t.editorInit();

				if (cbAfter)
				{
					cbAfter(t, ed);
				}
			});
		},

		reInit: function(callbacks)
		{
			if (this.ed)
			{
				this.ed.destroy();

				this.startInit(callbacks);
			}
		},

		getEditorConfig: function()
		{
			var fontSize = ['9', '10', '12', '15', '18', '22', '26'];
			var fontFamily = {
				"arial": 'Arial',
				"'book antiqua'": 'Book Antiqua',
				"'courier new'": 'Courier New',
				"georgia": 'Georgia',
				'tahoma': 'Tahoma',
				"'times new roman'": 'Times New Roman',
				"'trebuchet ms'": 'Trebuchet MS',
				"verdana": 'Verdana'
			};

			var heightLimits = this.getHeightLimits();

			var iconsTemplate = 'font_awesome_5'; // solid
			if (XF.config.fontAwesomeWeight !== 's')
			{
				iconsTemplate += XF.config.fontAwesomeWeight;
			}

			var config = {
				attribution: false,
				direction: FroalaEditor.LANGUAGE.xf.direction,
				editorClass: 'bbWrapper', // since this is a BB code editor, we want our output to normalize like BB code
				fileUpload: false,
				fileMaxSize: 4 * 1024 * 1024 * 1024, // 4G
				fileUploadParam: 'upload',
				fileUploadURL: false,
				fontFamily: fontFamily,
				fontSize: fontSize,
				heightMin: heightLimits[0],
				heightMax: heightLimits[1],
				htmlAllowedTags: ['a', 'audio', 'b', 'bdi', 'bdo', 'blockquote', 'br', 'cite', 'code', 'dfn', 'div', 'em', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hr', 'i', 'img', 'li', 'mark', 'ol', 'p', 'pre', 's', 'small', 'span', 'strike', 'strong', 'sub', 'sup', 'table', 'tbody', 'td', 'tfoot', 'th', 'thead', 'time', 'tr', 'u', 'ul', 'var', 'video', 'wbr'],
				key: 'ZOD3gA8B10A6C5A2G3C-8TMIBDIa1NTMNZFFPFZc1d1Ib2a1E1fA4A3G3F3F2B6C4C4C3G3==',
				htmlAllowComments: false,
				iconsTemplate: iconsTemplate,
				imageUpload: false,
				imageCORSProxy: null,
				imageDefaultDisplay: 'inline',
				imageDefaultWidth: 0,
				imageEditButtons: ['imageAlign', 'imageSize', 'imageAlt', '|', 'imageReplace', 'imageRemove', '|', 'imageLink', 'linkOpen', 'linkEdit', 'linkRemove'],
				imageManagerLoadURL: false,
				imageMaxSize: 4 * 1024 * 1024 * 1024, // 4G
				imagePaste: false,
				imageResize: true,
				imageUploadParam: 'upload',
				imageUploadRemoteUrls: false,
				imageUploadURL: false,
				language: 'xf',
				linkAlwaysBlank: true,
				linkEditButtons: ['linkOpen', 'linkEdit', 'linkRemove'],
				linkInsertButtons: ['linkBack'],
				listAdvancedTypes: false,
				paragraphFormat: {
					N: 'Normal',
					H2: 'Heading 1',
					H3: 'Heading 2',
					H4: 'Heading 3'
				},
				placeholderText: '',
				tableResizer: false,
				tableEditButtons: ['tableHeader', 'tableRemove', '|', 'tableRows', 'tableColumns'],
				toolbarSticky: false,
				toolbarStickyOffset: 36,
				tableInsertHelper: false,
				videoAllowedTypes: ['mp4', 'quicktime', 'ogg', 'webm'],
				videoAllowedProviders: [],
				videoDefaultAlign: 'center', // when inline, this means not floated
				videoDefaultDisplay: 'inline',
				videoDefaultWidth: 500,
				videoEditButtons: ['videoReplace', 'videoRemove', '|', 'videoAlign', 'videoSize'],
				videoInsertButtons: ['videoBack', '|', 'videoUpload'],
				videoMaxSize: 4 * 1024 * 1024 * 1024, // 4G
				videoMove: true,
				videoUpload: false,
				videoUploadParam: 'upload',
				videoUploadURL: false,
				zIndex: XF.getElEffectiveZIndex(this.$target) + 1,
				xfBbCodeAttachmentContextInput: this.options.attachmentContextInput
			};

			// FA5 overrides
			FroalaEditor.DefineIcon('insertVideo', { FA5NAME: 'video-plus' });

			if (this.uploadUrl)
			{
				var uploadParams = {
					_xfToken: XF.config.csrf,
					_xfResponseType: 'json',
					_xfWithData: 1
				};

				config.fileUpload = true;
				config.fileUploadParams = uploadParams;
				config.fileUploadURL = this.uploadUrl;

				config.imageUpload = true;
				config.imageUploadParams = uploadParams;
				config.imageUploadURL = this.uploadUrl;
				config.imagePaste = true;

				config.videoUpload = true;
				config.videoUploadParams = uploadParams;
				config.videoUploadURL = this.uploadUrl;
			}
			else
			{
				config.imageInsertButtons = ['imageByURL'];
			}

			var buttons = this.getButtonConfig();

			config = $.extend({}, config, buttons);

			this.$target.trigger('editor:config', [config, this]);

			return config;
		},

		getButtonConfig: function()
		{
			try
			{
				var editorToolbars = $.parseJSON($('.js-editorToolbars').first().html()) || {};
			}
			catch (e)
			{
				console.error("Editor buttons data not valid: ", e);
				return;
			}

			var editorDropdownButtons = {};

			try
			{
				var editorDropdowns = $.parseJSON($('.js-editorDropdowns').first().html()) || {};
				for (var d in editorDropdowns)
				{
					if (editorDropdowns.hasOwnProperty(d) && editorDropdowns[d].buttons)
					{
						editorDropdownButtons[d] = editorDropdowns[d].buttons;
					}
				}
			}
			catch (e)
			{
				console.error("Editor dropdowns data not valid: ", e);
			}

			var buttonManager = new XF.EditorButtons(this, editorToolbars, editorDropdownButtons);
			this.buttonManager = buttonManager;

			if (!XF.isElementWithinDraftForm(this.$target))
			{
				buttonManager.addRemovedButton('xfDraft');
			}

			var attachmentManager = this.getAttachmentManager();
			if (!attachmentManager || !attachmentManager.supportsVideoAudioUploads)
			{
				buttonManager.addRemovedButton('insertVideo');
			}

			if (this.options.buttonsRemove)
			{
				buttonManager.addRemovedButtons(this.options.buttonsRemove.split(','));
			}

			var eventData = {
				buttonManager: buttonManager
			};

			// note: this is a new event, meaning the original event (editor:buttons)
			// no longer triggers. this should avoid any major issues with BC breaks
			// and most functionality can probably now be replicated with the
			// new editor button manager. note the eventData object has changed too.
			this.$target.trigger('editor:toolbar-buttons', [eventData, this]);

			return buttonManager.getToolbars();
		},

		editorInit: function()
		{
			var t = this,
				ed = this.ed;

			this.watchEditorHeight();

			if (this.$form)
			{
				this.$form.on('ajax-submit:before draft:beforesync', function()
				{
					XF.EditorHelpers.sync(ed);
				});

				this.$form.on('draft:complete', function(e, data)
				{
					var $draftButton,
						$indicator;

					if (ed.$tb.length && data.draft.saved === true)
					{
						$draftButton = ed.$tb.find('.fr-command.fr-btn[data-cmd=xfDraft]');
						if ($draftButton.length)
						{
							$indicator = $draftButton.find('.editorDraftIndicator');
							if (!$indicator.length)
							{
								$indicator = $('<b class="editorDraftIndicator" />').appendTo($draftButton);
							}

							setTimeout(function() { $indicator.addClass('is-active'); }, 50);
							setTimeout(function() { $indicator.removeClass('is-active'); }, 2500);
						}
					}
				});

				// detect image/video uploads from within Froala and potentially block submission if they're still happening
				this.$form.on('ajax-submit:before', function(e, data)
				{
					var $uploads = ed.$el.find('.fr-uploading');

					if ($uploads.length > 0 && !confirm(XF.phrase('files_being_uploaded_are_you_sure')))
					{
						data.preventSubmit = true;
					}
				});

				ed.events.on('keydown', function(e)
				{
					if (e.key == 'Enter' && (XF.isMac() ? e.metaKey : e.ctrlKey))
					{
						e.preventDefault();
						t.$form.submit();
						return false;
					}
				}, true);

				if (XF.isElementWithinDraftForm(this.$form))
				{
					var $edEl = $(ed.$el[0]);
					XF.Element.applyHandler($edEl, 'draft-trigger');
				}
			}

			// make images be inline automatically
			ed.events.on('image.inserted', function($img)
			{
				$img.removeClass('fr-dib').addClass('fr-dii');
			});

			ed.events.on('image.loaded', function($img)
			{
				t.replaceBase64ImageWithUpload($img);
			});

			ed.events.on('image.beforePasteUpload', function(img)
			{
				var placeholderSrc = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
				if (img.src == placeholderSrc)
				{
					return false;
				}
			});

			var isPlainPaste = false;

			ed.events.on('cut copy', function(e)
			{
				var range = ed.selection.ranges(0);
				if (!range || !range.commonAncestorContainer)
				{
					return;
				}

				var container = range.commonAncestorContainer;

				if (container.nodeType == Node.TEXT_NODE)
				{
					if (
						range.startOffset == 0
						&& range.endOffset == container.length
						&& container.parentNode != ed.$el[0]
					)
					{
						// if a complete bit of text is selected, try to select up the chain
						// as far as is equivalent
						container = container.parentNode;
						while (
							container.parentNode != ed.$el[0]
							&& !container.previousSibling
							&& !container.nextSibling
						)
						{
							container = container.parentNode;
						}
						range.selectNode(container);
					}
					else
					{
						container = container.parentNode;
					}
				}

				var $ps = $(container).find('p');
				$ps.attr('data-xf-p', '1');

				setTimeout(function()
				{
					$ps.removeAttr('data-xf-p');
				}, 0);
			});

			ed.events.on('paste.before', function(e)
			{
				isPlainPaste = false;

				if (e && e.clipboardData && e.clipboardData.getData)
				{
					var types = '',
						clipboard_types = e.clipboardData.types;

					if (ed.helpers.isArray(clipboard_types))
					{
						for (var i = 0 ; i < clipboard_types.length; i++)
						{
							types += clipboard_types[i] + ';';
						}
					}
					else
					{
						types = clipboard_types;
					}

					if (
						/text\/plain/.test(types) && !ed.browser.mozilla
						&& !/text\/html/.test(types)
						&& (!/text\/rtf/.test(types) || !ed.browser.safari)
					)
					{
						isPlainPaste = true;
					}
				}
			});

			ed.events.on('paste.beforeCleanup', function(content)
			{
				if (isPlainPaste)
				{
					content = content
						.replace(/\t/g, '    ')
						.replace(/  /g, '&nbsp; ')
						.replace(/  /g, '&nbsp; ')
						.replace(/> /g, '>&nbsp;');
				}

				// by the time the clean up happens, these line breaks have been stripped
				content = content.replace(/(<pre[^>]*>)([\s\S]+?)(<\/pre>)/g, function(match, open, inner, close)
				{
					inner = inner.replace(/\r?\n/g, '<br>');

					return open + inner + close;
				});

				// P tags that have their top and bottom margins set to 0 act like our single line break versions,
				// so tag them as such
				content = content.replace(
					/<p([^>]+)margin-top:\s*0[a-z]*;\s*margin-bottom:\s*0[a-z]*;([^>]*)>([\s\S]*?)<\/p>/g,
					function(match, prefix, suffix, content)
					{
						return '<p' + prefix + suffix + ' data-xf-p="1">' + content + '</p>';
					}
				);

				content = content.replace(/<div(?=\s|>)/g, function(match)
				{
					return match + ' data-xf-p="1"';
				});

				// sometimes URLs are auto-linked when pasting using some browsers. because this interferes with unfurling
				// (an already linked URL cannot be unfurled) attempt to detect and extract the links to paste as text.
				// there are multiple variants depending on browser and OS.

				var match;

				// variant 1: mostly *nix (including Apple)
				match = content.match(/^(?:<meta[^>]*>)?<a href=(?:'|")([^'"]*)\/?(?:'|")>\1<\/a>$/);
				if (match)
				{
					content = $.trim(match[1]);
				}

				// variant 2: mostly Windows
				match = content.match(/<!--StartFragment--><a href=(?:'|")([^'"]*)\/?(?:'|")>[^<]+<\/a><!--EndFragment-->/);
				if (match)
				{
					content = $.trim(match[1]);
				}

				content = XF.adjustHtmlForRte(content);

				var nodes = $.parseHTML(content),
					removeAttributesFromNodeList = function(nodes)
					{
						var node, attrs, i, a;

						for (i = 0; i < nodes.length; i++)
						{
							node = nodes[i];
							if (node instanceof Element)
							{
								if (node.hasAttributes())
								{
									attrs = node.attributes;

									for (a = attrs.length - 1; a >= 0; a--)
									{
										var attr = attrs[a];
										if (attr.name.toLowerCase().substr(0, 2) == 'on'
											|| attr.name.toLowerCase() == 'style'
										)
										{
											node.removeAttribute(attr.name);
										}
									}
								}

								removeAttributesFromNodeList(node.children);
							}
						}
					};

				removeAttributesFromNodeList(nodes);

				content = $('<div />').html(nodes).html();

				return $.trim(content);
			});

			ed.events.on('paste.afterCleanup', function(content)
			{
				return t.normalizePaste(content);
			});

			ed.events.on('paste.after', function()
			{
				// keep the cursor visible if possible
				var range = ed.selection.ranges(0);
				if (!range || !range.getBoundingClientRect)
				{
					return;
				}

				var rect = range.getBoundingClientRect(),
					elRect = ed.$wp[0].getBoundingClientRect();

				if (
					rect.top < 0
					|| rect.left < 0
					|| rect.bottom > $(window).height()
					|| rect.right > $(window).width()
					|| rect.bottom > elRect.bottom
				)
				{
					setTimeout(function()
					{
						t.scrollToCursor();
					}, 100);
				}

				XF.EditorHelpers.normalizeBrForEditor(ed.$el);
			});

			var mentionerOpts = {
				url: XF.getAutoCompleteUrl()
			};
			this.mentioner = new XF.AutoCompleter(
				$(ed.$el), mentionerOpts, ed
			);

			if (XF.config.shortcodeToEmoji)
			{
				var emojiOpts = {
					url: XF.canonicalizeUrl('index.php?misc/find-emoji'),
					at: ':',
					keepAt: false,
					insertMode: 'html',
					displayTemplate: '<div class="contentRow">' +
						'<div class="contentRow-figure contentRow-figure--emoji">{{{icon}}}</div>' +
						'<div class="contentRow-main contentRow-main--close">{{{text}}}' +
						'<div class="contentRow-minor contentRow-minor--smaller">{{{desc}}}</div></div>' +
						'</div>',
					beforeInsert: function(value, el)
					{
						XF.logRecentEmojiUsage($(el).find('img.smilie').data('shortname'));

						return value;
					}
				};
				this.emojiCompleter = new XF.AutoCompleter(
					$(ed.$el), emojiOpts, ed
				);
			}

			this.setupUploads();

			if (!XF.isEditorEnabled())
			{
				var $bbCodeInput = this.$target.next('input[data-bb-code]');
				if ($bbCodeInput.length)
				{
					ed.bbCode.toBbCode($bbCodeInput.val(), true);
				}
				else
				{
					ed.bbCode.toBbCode(null, true);
				}
			}

			XF.EditorHelpers.setupBlurSelectionWatcher(ed);

			this.$target.on('control:enabled', function()
			{
				ed.edit.on();
			});
			this.$target.on('control:disabled', function()
			{
				ed.edit.off();
			});

			var self = this;
			this.$target.on('control:enabled', function()
			{
				ed.edit.on();
				if (ed.bbCode && ed.bbCode.isBbCodeView())
				{
					var $button = ed.$tb.find('.fr-command[data-cmd=xfBbCode]');
					$button.removeClass('fr-disabled');
				}
				else
				{
					ed.toolbar.enable();
				}
			});
			this.$target.on('control:disabled', function()
			{
				ed.edit.off();
				ed.toolbar.disable();
				ed.$tb.find(' > .fr-command').addClass('fr-disabled');
			});

			this.$target.trigger('editor:init', [ed, this]);

			XF.layoutChange();
		},

		focus: function()
		{
			XF.EditorHelpers.focus(this.ed);
		},

		blur: function()
		{
			XF.EditorHelpers.blur(this.ed);
		},

		normalizePaste: function(content)
		{
			// FF has a tendency of maintaining whitespace from the content which gives odd pasting results
			content = content.replace(/(<(ul|li|p|div)>)\s+/ig, '$1');
			content = content.replace(/\s+(<\/(ul|li|p|div)>)/ig, '$1');

			// some pastes from Chrome insert this span unexpectedly which causes extra bullet points
			content = content
				.replace(/<span>&nbsp;<\/span>/ig, ' ')
				.replace(/(<\/li>)\s+(<li)/ig, '$1$2');

			var ed = this.ed,
				frag = $.parseHTML(content),
				$fragWrapper = $('<div />').html(frag);

			$fragWrapper.find('table').each(function(i, table)
			{
				var $table = $(table).width('100%');
				$table.wrap('<div class="bbTable"></div>');

				$table.find('[colspan], [rowspan]').removeAttr('colspan rowspan');

				var maxColumns = 0;
				$table.find('> tbody > tr').each(function()
				{
					var columnCount = $(this).find('> td, > th').length;
					maxColumns = Math.max(maxColumns, columnCount);
				}).each(function()
				{
					var $cells = $(this).find('> td, > th'),
						columnCount = $cells.length;
					if (columnCount < maxColumns)
					{
						var tag = '<td />';
						if (columnCount && $cells[0].tagName === 'TH')
						{
							tag = '<th />';
						}

						for (var i = columnCount; columnCount < maxColumns; columnCount++)
						{
							$(this).append(tag);
						}
					}
				});
			});

			$fragWrapper.find('code, del, ins, sub, sup').replaceWith(function() { return this.innerHTML; });

			// We expose H2 - H4 primarily. If we find an H1, consider that to be the biggest heading and
			// shift the others down 1. Otherwise, leave as is.
			var hasH1 = false;
			$fragWrapper.find('h1').replaceWith(function()
			{
				hasH1 = true;
				return $('<h2>').append($(this).contents());
			});

			var hMap = {
				'H2': hasH1 ? 'H3' : 'H2',
				'H3': hasH1 ? 'H4' : 'H3',
				'H4': 'H4',
				'H5': 'H4',
				'H6': 'H4'
			};
			$fragWrapper.find('h2, h3, h4, h5, h6').replaceWith(function()
			{
				return $('<' + hMap[this.tagName] + '>').append($(this).contents());
			});

			$fragWrapper.find('pre').replaceWith(function()
			{
				var inner = this.innerHTML;

				inner = inner
					.replace(/\r?\n/g, '<br>')
					.replace(/\t/g, '    ')
					.replace(/  /g, '&nbsp; ')
					.replace(/  /g, '&nbsp; ')
					.replace(/> /g, '>&nbsp;')
					.replace(/<br> /g, '<br>&nbsp;');

				return inner + '<br>';
			});

			if (!ed.opts.imagePaste)
			{
				// If image pasting is disabled in Froala, it will remove all pasted images, even if they
				// will be just links. Allow linked images to remain in this case.
				$fragWrapper.find('img[data-fr-image-pasted]').each(function()
				{
					var $this = $(this),
						src = $this.attr('src');
					if (src.match(/https?:\/\//i))
					{
						$this.removeAttr('data-fr-image-pasted');
					}
				});
			}

			// first we try to move any br tags up to the root if they're only within inline tags...
			$fragWrapper.find('br').each(function(i, br)
			{
				var $parents = $(br).parents().not($fragWrapper);
				if (!$parents.length)
				{
					// at the root of the paste already
					return;
				}

				if ($parents.filter(function(j, el) { return ed.node.isBlock(el); }).length)
				{
					// if we have a block parent, we can't move this
					return;
				}

				var $shiftTarget = $([]),
					shiftIsEl = false,
					$clone,
					ref = br,
					$topParent = $parents.last();

				do
				{
					while (ref.nextSibling)
					{
						$clone = $(ref.nextSibling).clone();
						if (shiftIsEl)
						{
							$shiftTarget.append($clone);
						}
						else
						{
							$shiftTarget = $shiftTarget.add($clone);
						}

						$(ref.nextSibling).remove();
					}
					ref = ref.parentNode;
					if (!ref || $fragWrapper.is(ref))
					{
						break;
					}

					$clone = $(ref).clone().empty();
					$clone.html($shiftTarget);
					$shiftTarget = $clone;
					shiftIsEl = true;
				}
				while (ref.parentNode && !$fragWrapper.is(ref.parentNode));
				// note: this is intentionally checking the ref.parentNode, even though ref has already been moved up.
				// we want to stop when the last tag we cloned is at the root

				$(br).remove();

				$topParent.after($shiftTarget);
				$topParent.after('<br />');
			});

			// Look for root p tags to add extra line breaks since we treat a p as a single break.
			// Try to detect an internal paste and don't add it there
			var copiedText = '',
				pastedText = $fragWrapper[0].textContent.replace(/\s/g, '');

			try
			{
				copiedText = (ed.win.localStorage.getItem('fr-copied-text') || '').replace(/\s/g, '');
			}
			catch (e) {}

			if (copiedText !== pastedText)
			{
				$fragWrapper.find('> p:not([data-xf-p])').each(function()
				{
					if (this.nextSibling)
					{
						$(this).after('<p />');
					}
				});
			}

			$fragWrapper.find('p').removeAttr('data-xf-p');

			frag = $fragWrapper.contents();

			// ...now we split the root level by br tags into p tags. (Make sure we do this after the p doubling
			// since br is a single break
			var node,
				$output = $('<div />'),
				$wrapTarget = null;

			for (var i = 0; i < frag.length; i++)
			{
				node = frag[i];

				if (node.nodeType == Node.ELEMENT_NODE && ed.node.isBlock(node))
				{
					$output.append(node);
					$wrapTarget = null;
				}
				else if (node.nodeType == Node.ELEMENT_NODE && node.tagName == 'BR')
				{
					if (!$wrapTarget)
					{
						// this would generally be two <br> tags in a row
						$output.append('<p />');
					}

					$wrapTarget = null;
				}
				else // text or some other type of element
				{
					if (!$wrapTarget)
					{
						$wrapTarget = $('<p />');
						$output.append($wrapTarget);
					}

					$wrapTarget.append(node);
				}
			}

			var $children = $output.children();
			if ($children.length == 1 && $children.is('p, div'))
			{
				$output = $children;
			}

			return XF.EditorHelpers.normalizeBrForEditor($output.html());
		},

		watchEditorHeight: function()
		{
			var ed = this.ed,
				self = this;

			$(window).onPassive('resize', function()
			{
				var heightLimits = self.getHeightLimits();
				ed.opts.heightMin = heightLimits[0];
				ed.opts.heightMax = heightLimits[1];
				ed.size.refresh();
				XF.layoutChange();
			});
			ed.events.on('focus', function()
			{
				self.scrollToCursorAfterPendingResize();
			});

			//var getHeight = function() { return ed.$el.height(); },
			var getHeight = function() { return ed.$wp.height(); },
				height = getHeight(),
				layoutChangeIfNeeded = function()
				{
					var newHeight = getHeight();
					if (height != newHeight)
					{
						height = newHeight;
						XF.layoutChange();
					}
				};

			ed.events.on('keyup', layoutChangeIfNeeded);
			ed.events.on('commands.after', layoutChangeIfNeeded);
			ed.events.on('html.set', layoutChangeIfNeeded);
			ed.events.on('init', layoutChangeIfNeeded);
			ed.events.on('initialized', layoutChangeIfNeeded);
		},

		getHeightLimits: function()
		{
			var maxHeightOption = this.options.maxHeight,
				minHeightOption = this.options.minHeight,
				maxHeight = null,
				minHeight = null;

			if (this.$target.closest('.overlay').length)
			{
				maxHeightOption = 0.1; // don't grow the editor at all if we are in an overlay
			}

			if (maxHeightOption)
			{
				var viewHeight = $(window).height(),
					height;

				// we can't reliably detect when the keyboard displays, so we need to act like it's always displayed
				if (/(iPad|iPhone|iPod)/g.test(navigator.userAgent))
				{
					viewHeight -= 250;
				}

				if (maxHeightOption > 0)
				{
					if (maxHeightOption <= 1) // example: 0.8 = 80%
					{
						height = viewHeight * maxHeightOption;
					}
					else
					{
						height = maxHeightOption; // example 250 = 250px
					}
				}
				else // example: -100 = window height - 100 px
				{
					height = viewHeight + maxHeightOption;
				}

				maxHeight = Math.floor(height);
				maxHeight = Math.max(maxHeight, 150);
			}

			if (minHeightOption && maxHeight)
			{
				minHeight = Math.min(minHeightOption, maxHeight);
				if (minHeight == maxHeight)
				{
					minHeight -= 1; // prevents an unnecessary scrollbar
				}
			}

			return [minHeight, maxHeight];
		},

		setupUploads: function()
		{
			var t = this,
				ed = this.ed;

			ed.events.on('file.uploaded', function(response)
			{
				this.popups.hide('file.insert');
				this.events.focus();
				return t.handleUploadSuccess(response);
			});

			ed.events.on('file.error', function(details, response)
			{
				this.popups.hide('file.insert');
				t.handleUploadError(details, response);
				this.events.focus();
				return false;
			});

			if (!this.uploadUrl)
			{
				ed.events.on('image.beforeUpload', function()
				{
					return false; // prevent uploading
				});
				ed.events.on('file.beforeUpload', function()
				{
					return false; // prevent uploading
				});
				ed.events.on('video.beforeUpload', function()
				{
					return false; // prevent uploading
				});
			}

			ed.events.on('image.error', function(details, response)
			{
				if (!response)
				{
					return; // not an uploaded image
				}

				this.popups.hide('image.insert');
				t.handleUploadError(details, response);
				return false;
			});

			ed.events.on('video.error', function(details, response)
			{
				if (!response)
				{
					return; // not an uploaded image
				}

				this.popups.hide('video.insert');
				t.handleUploadError(details, response);
				return false;
			});

			ed.events.on('image.uploaded', function(response)
			{
				var onError = function()
				{
					ed.image.remove();
					ed.popups.hide('image.insert');
					ed.events.focus();
					return false;
				};

				var onSuccess = function()
				{
					return true;
				};

				return t.handleUploadSuccess(response, onError, onSuccess);
			});

			ed.events.on('video.uploaded', function(response)
			{
				var onError = function()
				{
					ed.video.remove();
					ed.popups.hide('video.insert');
					ed.events.focus();
					return false;
				};

				var onSuccess = function()
				{
					return true;
				};

				return t.handleUploadSuccess(response, onError, onSuccess);
			});

			var videoImageInsert = function($el, response)
			{
				if (!response)
				{
					return;
				}

				try
				{
					var json = $.parseJSON(response);
				}
				catch (e)
				{
					return;
				}

				if ($el.hasClass('fr-video'))
				{
					var $video = $el.find('video');

					$video
						.attr('data-xf-init', 'video-init')
						.attr('style', '')
						.empty();

					$el = $video;
				}

				if (json.attachment)
				{
					// clean up the data attributes that were added from our JSON response
					var id = json.attachment.attachment_id,
						attrs = $el[0].attributes,
						re = /^data-(?!xf-init)/;
					for (var i = attrs.length - 1; i >= 0; i--)
					{
						if (re.test(attrs[i].nodeName))
						{
							$el.removeAttr(attrs[i].nodeName);
						}
					}

					$el.attr('data-attachment', "full:" + id);
				}
			};

			ed.events.on('image.inserted video.inserted', videoImageInsert);
			ed.events.on('image.replaced video.replaced', videoImageInsert);

			ed.events.on('image.loaded', function($img)
			{
				// try to prevent automatic editing of an image once inserted

				if (!ed.popups.isVisible('image.edit'))
				{
					// ... but not if we're not in the edit mode
					return;
				}

				var $editorImage = ed.image.get();
				if (!$editorImage || $editorImage[0] != $img[0])
				{
					// ... and only if it's for this image
					return;
				}

				ed.image.exitEdit(true);

				var range = ed.selection.ranges(0);
				range.setStartAfter($img[0]);
				range.collapse(true);

				var selection = ed.selection.get();
				selection.removeAllRanges();
				selection.addRange(range);

				ed.events.focus();
				t.scrollToCursor();
			});

			ed.events.on('video.loaded', function($video)
			{
				// try to prevent automatic editing of a video once inserted

				if (!ed.popups.isVisible('video.edit'))
				{
					// ... but not if we're not in the edit mode
					return;
				}

				var $editorVideo = ed.video.get();
				if (!$editorVideo || $editorVideo[0] != $video[0])
				{
					// ... and only if it's for this video
					return;
				}

				ed.events.trigger('video.hideResizer');
				ed.popups.hide('video.edit');

				var range = ed.selection.ranges(0);
				range.setStartAfter($video[0]);
				range.collapse(true);

				var selection = ed.selection.get();
				selection.removeAllRanges();
				selection.addRange(range);

				ed.events.focus();
				t.scrollToCursor();
			});

			ed.events.on('popups.show.image.edit', function()
			{
				var $editorImage = ed.image.get();

				if (!$editorImage.length || !$editorImage.hasClass('smilie'))
				{
					return;
				}

				ed.image.exitEdit(true);
				ed.selection.save();

				setTimeout(function()
				{
					ed.selection.restore();
				}, 0);
			});
		},

		handleUploadSuccess: function(response, onError, onSuccess)
		{
			try
			{
				var json = $.parseJSON(response);
			}
			catch (e)
			{
				json = {
					status: 'error',
					errors: [XF.phrase('oops_we_ran_into_some_problems')]
				}
			}

			if (json.status && json.status == 'error')
			{
				XF.alert(json.errors[0]);
				return onError ? onError(json) : false;
			}

			var attachmentManager = this.getAttachmentManager();
			if (attachmentManager && json.attachment)
			{
				attachmentManager.insertUploadedRow(json.attachment);
				return onSuccess ? onSuccess(json, attachmentManager) : false;
			}

			return false;
		},

		handleUploadError: function(details, response)
		{
			var json;

			try
			{
				json = $.parseJSON(response);
			}
			catch (e)
			{
				json = null;
			}

			if (!json || !json.errors)
			{
				json = {
					status: 'error',
					errors: [XF.phrase('oops_we_ran_into_some_problems')]
				};
			}

			XF.alert(json.errors[0]);
		},

		getAttachmentManager: function()
		{
			var $match = this.$target.closest('[data-xf-init~=attachment-manager]');
			if ($match && $match.length)
			{
				return XF.Element.getHandler($match, 'attachment-manager');
			}

			return null;
		},

		isBbCodeView: function()
		{
			if (this.ed.bbCode && this.ed.bbCode.isBbCodeView)
			{
				return this.ed.bbCode.isBbCodeView();
			}
			else
			{
				return false;
			}
		},

		insertContent: function(html, text)
		{
			var ed = this.ed;

			if (this.isBbCodeView())
			{
				if (typeof text !== 'undefined')
				{
					ed.bbCode.insertBbCode(text);
				}
			}
			else
			{
				this.focus();
				ed.undo.saveStep();
				ed.html.insert(html);
				ed.undo.saveStep();
				XF.Element.initialize(ed.$el);

				XF.EditorHelpers.normalizeAfterInsert(ed);
			}

			this.scrollToCursor();
			this.scrollToCursorAfterPendingResize();
		},

		replaceContent: function(html, text)
		{
			var ed = this.ed;

			if (this.isBbCodeView())
			{
				if (typeof text !== 'undefined')
				{
					ed.bbCode.replaceBbCode(text);
				}
			}
			else
			{
				ed.html.set(html);
			}
		},

		scrollToCursor: function()
		{
			var ed = this.ed;

			if (this.isBbCodeView())
			{
				ed.bbCode.getTextArea().autofocus();
				ed.$box[0].scrollIntoView(true);
			}
			else
			{
				this.focus();

				var $edBox = ed.$box,
					$edWrapper = ed.$wp,
					selEl = ed.selection.endElement(),
					selBottom = selEl.getBoundingClientRect().bottom,
					selVisible = true,
					winHeight = XF.windowHeight();

				if (XF.browser.ios)
				{
					// assume the keyboard takes up approximately this much space
					winHeight -= 250;
				}

				if (selBottom < 0 || selBottom >= winHeight)
				{
					// outside the window
					selVisible = false;
				}
				if ($edWrapper && selVisible)
				{
					var wrapperRect = $edWrapper[0].getBoundingClientRect();

					if (selBottom > wrapperRect.bottom || selBottom < wrapperRect.top)
					{
						// inside the window, but need to scroll the wrapper
						selVisible = false;
					}
				}

				if (!selVisible)
				{
					var boxPos = $edBox[0].getBoundingClientRect();
					if (boxPos.top < 0 || boxPos.bottom >= winHeight)
					{
						if (!XF.browser.ios)
						{
							// don't add in iOS because it shouldn't apply to small screens but this doesn't trigger
							// in iOS as expected
							$edBox.addClass('is-scrolling-to');
						}
						$edBox[0].scrollIntoView(true);
						$edBox.removeClass('is-scrolling-to');
					}

					if ($edWrapper)
					{
						var info = ed.position.getBoundingRect().top;

						// attempt to put this in the middle of the screen.
						// 50px offset to compensate for sticky form footer.
						// note this doesn't seem to work in iOS at all likely due to webkit limitations.
						if (info > $edWrapper.offset().top - ed.helpers.scrollTop() + $edWrapper.height() - 50) {
							$edWrapper.scrollTop(info + $edWrapper.scrollTop() - ($edWrapper.height() + $edWrapper.offset().top) + ed.helpers.scrollTop() + (winHeight / 2));
						}
					}
					else
					{
						selEl.scrollIntoView();
					}
				}
			}
		},

		scrollToCursorAfterPendingResize: function(forceTrigger)
		{
			// This is to ensure that we keep the cursor visible after the onscreen keyboard appears
			// by trying to determine when this happens and scroll to it.
			var self = this,
				ed = this.ed,
				scrollTimer,
				onResize = function()
				{
					$(window).off('resize', onResize);
					$(window).on('scroll', scrollWatcher);

					if (scrollTimer)
					{
						clearTimeout(scrollTimer);
					}
					scrollTimer = setTimeout(scrollTo, 500);
				},
				scrollWatcher = function()
				{
					if (scrollTimer)
					{
						clearTimeout(scrollTimer);
					}
					scrollTimer = setTimeout(scrollTo, 100);
				},
				scrollTo = function()
				{
					$(window).off('scroll', scrollWatcher);

					if (ed.core.hasFocus())
					{
						self.scrollToCursor();
					}
				};

			$(window).on('resize', onResize);
			setTimeout(function()
			{
				$(window).off('resize', onResize);
			}, 2000);

			if (forceTrigger)
			{
				scrollTimer = setTimeout(scrollTo, 1000);
			}
		},

		base64ToBytes: function(base64String, sliceSize)
		{
			sliceSize = sliceSize || 512;

			var byteCharacters = atob(base64String);
			var byteArrays = [];

			for (var offset = 0; offset < byteCharacters.length; offset += sliceSize)
			{
				var slice = byteCharacters.slice(offset, offset + sliceSize);

				var byteNumbers = new Array(slice.length);
				for (var i = 0; i < slice.length; i++)
				{
					byteNumbers[i] = slice.charCodeAt(i);
				}

				var byteArray = new Uint8Array(byteNumbers);

				byteArrays.push(byteArray);
			}

			return byteArrays;
		},

		editorSupportsUploads: function()
		{
			return (this.ed.opts.imageInsertButtons.indexOf('imageUpload') !== -1);
		},

		imageMatchesBase64Encoding: function($img)
		{
			var src = $img.attr('src');
			return src.match(/^data:(image\/([a-z0-9]+));base64,(.*)$/);
		},

		replaceBase64ImageWithUpload: function($img)
		{
			if ($img.hasClass('smilie'))
			{
				// it's one of our smilies or emojis so skip it
				return;
			}

			var match, contentType, extension, base64String;

			match = this.imageMatchesBase64Encoding($img);

			if (match)
			{
				contentType = match[1];
				extension = match[2];
				base64String = match[3];

				if (this.ed.opts.imageAllowedTypes.indexOf(extension) === -1)
				{
					$img[0].remove();
					return;
				}

				if (this.editorSupportsUploads())
				{
					var file = new Blob(this.base64ToBytes(base64String), {
						type: contentType
					});

					// skip very small data URIs
					if (file.size > 1024)
					{
						this.ed.image.upload([ file ]);
					}
				}
				else
				{
					$img[0].remove();
				}
			}
		},

		isInitialized: function()
		{
			return this.ed ? true : false;
		}
	});

	XF.EditorButtons = XF.create({
		xfEd: null,
		buttonClasses: null,

		toolbars: {},
		dropdowns: {},
		removeButtons: null,

		recalculateNeeded: true,

		__construct: function(xfEd, toolbars, dropdowns)
		{
			this.xfEd = xfEd;

			// initialize this as empty for each editor instance
			this.removeButtons = [];

			if (toolbars)
			{
				this.toolbars = toolbars;
			}
			if (dropdowns)
			{
				this.dropdowns = dropdowns;
			}
		},

		addToolbar: function(name, buttons)
		{
			this.toolbars[name] = buttons;
			this.recalculateNeeded = true;
		},

		adjustToolbar: function(name, callback)
		{
			var buttons = this.toolbars[name];
			if (buttons)
			{
				this.toolbars[name] = callback(buttons, name, this);
				this.recalculateNeeded = true;
				return true;
			}
			else
			{
				return false;
			}
		},

		adjustToolbars: function(callback)
		{
			for (var k in this.toolbars)
			{
				if (this.toolbars.hasOwnProperty(k))
				{
					this.adjustToolbar(k, callback);
				}
			}
		},

		getToolbar: function(name)
		{
			var toolbars = this.getToolbars();
			return toolbars[name];
		},

		getToolbars: function()
		{
			this.recalculateIfNeeded();

			if (XF.EditorHelpers.isPreviewAvailable(this.xfEd.$target))
			{
				for (var toolbarSize in this.toolbars)
				{
					if (this.toolbars.hasOwnProperty(toolbarSize))
					{
						this.toolbars[toolbarSize].preview = {buttons: ['xfPreview'], align: 'right'};
					}
				}
			}

			return this.toolbars;
		},

		addDropdown: function(name, buttons)
		{
			this.dropdowns[name] = buttons;
			this.recalculateNeeded = true;
		},

		adjustDropdown: function(name, callback)
		{
			var buttons = this.dropdowns[name];
			if (buttons)
			{
				this.dropdowns[name] = callback(buttons, name, this);
				this.recalculateNeeded = true;
				return true;
			}
			else
			{
				return false;
			}
		},

		adjustDropdowns: function(callback)
		{
			for (var k in this.dropdowns)
			{
				if (this.dropdowns.hasOwnProperty(k))
				{
					this.adjustDropdown(k, callback);
				}
			}
		},

		getDropdown: function(name)
		{
			var dropdowns = this.getDropdowns();
			return dropdowns[name];
		},

		getDropdowns: function()
		{
			this.recalculateIfNeeded();

			return this.dropdowns;
		},

		addRemovedButton: function(name)
		{
			this.removeButtons.push(name);
			this.recalculateNeeded = true;
		},

		addRemovedButtons: function(buttons)
		{
			for (var i = 0; i < buttons.length; i++)
			{
				this.removeButtons.push(buttons[i]);
			}
			this.recalculateNeeded = true;
		},

		recalculateIfNeeded: function()
		{
			if (this.recalculateNeeded)
			{
				this.recalculate();
			}
		},

		recalculate: function()
		{
			var removeList = this.removeButtons,
				remove,
				buttonClasses = this.getButtonClasses(),
				toolbarKey,
				dropdownKey,
				group,
				i;

			function removeFromButtons(buttons, removeName)
			{
				if (!buttons.filter)
				{
					return [];
				}

				if (typeof removeName == 'string' && buttonClasses[removeName])
				{
					removeName = buttonClasses[removeName];
				}

				if (typeof removeName == 'string')
				{
					removeName = removeName.split('|');
				}

				return buttons.filter(function(button)
				{
					return !(removeName.indexOf(button) >= 0);
				});
			}

			// remove disallowed buttons
			for (i = 0; i < removeList.length; i++)
			{
				remove = removeList[i];

				for (toolbarKey in this.toolbars)
				{
					if (this.toolbars.hasOwnProperty(toolbarKey))
					{
						for (group in this.toolbars[toolbarKey])
						{
							if (this.toolbars[toolbarKey].hasOwnProperty(group))
							{
								this.toolbars[toolbarKey][group]['buttons'] = removeFromButtons(this.toolbars[toolbarKey][group]['buttons'], remove);
							}
						}
					}
				}
				for (dropdownKey in this.dropdowns)
				{
					if (this.dropdowns.hasOwnProperty(dropdownKey))
					{
						this.dropdowns[dropdownKey] = removeFromButtons(this.dropdowns[dropdownKey], remove);
					}
				}
			}

			// remove empty dropdowns
			for (dropdownKey in this.dropdowns)
			{
				if (this.dropdowns.hasOwnProperty(dropdownKey) && !this.dropdowns[dropdownKey].length)
				{
					for (toolbarKey in this.toolbars)
					{
						if (this.toolbars.hasOwnProperty(toolbarKey))
						{
							for (group in this.toolbars[toolbarKey])
							{
								if (this.toolbars[toolbarKey].hasOwnProperty(group))
								{
									this.toolbars[toolbarKey][group]['buttons'] = removeFromButtons(this.toolbars[toolbarKey][group]['buttons'], dropdownKey);
								}
							}
						}
					}
				}
			}

			this.recalculateNeeded = false;
		},

		getButtonClasses: function()
		{
			if (!this.buttonClasses)
			{
				this.buttonClasses = {
					_basic: ['bold', 'italic', 'underline', 'strikeThrough'],
					_extended: ['textColor', 'fontFamily', 'fontSize', 'xfInlineCode', 'paragraphFormat'],
					_link: ['insertLink'],
					_align: ['align', 'alignLeft', 'alignCenter', 'alignRight', 'alignJustify'],
					_list: ['formatOL', 'formatUL', 'outdent', 'indent'],
					_indent: ['outdent', 'indent'],
					_smilies: ['xfSmilie'],
					_image: ['insertImage', 'xfInsertGif'],
					_media: ['insertVideo', 'xfMedia'],
					_block: ['xfQuote', 'xfCode', 'xfSpoiler', 'xfInlineSpoiler', 'insertTable', 'insertHR']
				};
			}

			return this.buttonClasses;
		}
	});

	XF.EditorHelpers = {
		// note: these will generally be overridden from the option
		toolbarSizes: {
			SM: 420,
			MD: 550,
			LG: 800
		},

		setupBlurSelectionWatcher: function(ed)
		{
			var $el = ed.$el,
				trackSelection = false,
				trackKey = 'xf-ed-blur-sel',
				range;

			$(document).on('mousedown keydown', function(e)
			{
				if (!trackSelection)
				{
					// editor isn't known to be focused
					return;
				}
				if (ed.$el[0] == e.target || $.contains(ed.$el[0], e.target))
				{
					// event triggering is the editor or within it, so should maintain selection
					return;
				}
				if (!ed.selection.inEditor())
				{
					// the current selection isn't in the editor, so nothing to save
					return;
				}

				range = ed.selection.ranges(0);
			});

			ed.events.on('blur', function()
			{
				ed.$box.removeClass('is-focused');

				if (range)
				{
					$el.data(trackKey, range);
				}
				else
				{
					$el.removeData(trackKey);
				}

				trackSelection = false;
				range = null;
			}, true);
			ed.events.on('focus', function()
			{
				ed.$box.addClass('is-focused');
				trackSelection = true;
				range = null;

				setTimeout(function()
				{
					$el.removeData(trackKey);
				}, 0);
			});
			ed.events.on('commands.before', function(cmd)
			{
				var cmdConfig = FroalaEditor.COMMANDS[cmd];
				if (cmdConfig && (typeof cmdConfig.focus == 'undefined' || cmdConfig.focus))
				{
					XF.EditorHelpers.restoreMaintainedSelection(ed);
					// focus will happen in the command
				}
			});
		},

		restoreMaintainedSelection: function(ed)
		{
			var $el = ed.$el,
				blurSelection = $el.data('xf-ed-blur-sel');

			if (!ed.selection.inEditor())
			{
				if (blurSelection)
				{
					ed.markers.remove();
					ed.markers.place(blurSelection, true, 0);
					ed.markers.place(blurSelection, false, 0);
					ed.selection.restore();
				}
				else
				{
					ed.selection.setAtEnd(ed.el);
					ed.selection.restore();
				}
			}
		},

		focus: function(ed)
		{
			XF.EditorHelpers.restoreMaintainedSelection(ed);
			ed.$tb.addClass('is-focused');
			ed.events.focus();
		},

		blur: function(ed)
		{
			ed.$el[0].blur();
			ed.$tb.removeClass('is-focused');
			ed.selection.clear();
		},

		sync: function(ed)
		{
			ed.$oel.val(ed.html.get());
		},

		wrapSelectionText: function(ed, before, after, save, inline)
		{
			if (save)
			{
				ed.selection.save();
			}
			ed.undo.saveStep();

			var $wrapper = $('<div></div>'),
				$markers = ed.$el.find('.fr-marker'),
				html = null,
				selectedHtml;

			if (!ed.selection.isCollapsed())
			{
				// markers may be touched by getSelected
				$wrapper.append($markers.last().get(0));

				selectedHtml = XF.EditorHelpers.bypassBrowserShims(ed, function()
				{
					return ed.html.getSelected();
				});

				if (/<p>/i.test(selectedHtml))
				{
					// avoid injecting additional new-lines when selected spans new-lines
					if (inline)
					{
						var $frag = $('<div />').html(selectedHtml);
						var $p = $frag.children('p');
						$p.first().prepend(XF.htmlspecialchars(before));
						$p.last().append($wrapper.children());
						$p.last().append(XF.htmlspecialchars(after));

						// special case that an entire single line has been selected, and instead select the contents of that line
						if ($p.length === 1 && $frag.contents().length === 1)
						{
							html = $p.html();
						}
						else
						{
							html = $frag.html();
						}
					}
					else
					{
						selectedHtml = selectedHtml + $wrapper.html();
						inline = true;
					}
				}
				else
				{
					selectedHtml = selectedHtml + $wrapper.html();
				}
			}
			else
			{
				$wrapper.append($markers.first().get(0));
				$wrapper.append($markers.last().get(0));
				selectedHtml = $wrapper.html();
			}

			if (html === null)
			{
				html = XF.htmlspecialchars(before)
					+ selectedHtml
					+ XF.htmlspecialchars(after);
			}

			if (!inline)
			{
				html = '<p>' + html + '</p>';
			}

			ed.html.insert(html);

			ed.selection.restore();
			ed.placeholder.hide();
			ed.undo.saveStep();
			XF.EditorHelpers.normalizeAfterInsert(ed);
		},

		insertCode: function(ed, type, code)
		{
			var tag, lang, output;

			switch (type.toLowerCase())
			{
				case '': tag = 'CODE'; lang = ''; break;
				default: tag = 'CODE'; lang = type.toLowerCase(); break;
			}

			code = code.replace(/&/g, '&amp;').replace(/</g, '&lt;')
				.replace(/>/g, '&gt;').replace(/"/g, '&quot;')
				.replace(/\t/g, '    ')
				.replace(/\n /g, '\n&nbsp;')
				.replace(/  /g, '&nbsp; ')
				.replace(/  /g, ' &nbsp;') // need to do this twice to catch a situation where there are an odd number of spaces
				.replace(/\n/g, '</p><p>');

			output = '[' + tag + (lang ? '=' + lang : '') + ']' + code + '[/' + tag + ']';
			if (output.match(/<\/p>/i))
			{
				output = '<p>' + output + '</p>';
				output = output.replace(/<p><\/p>/g, '<p><br></p>');
			}

			ed.undo.saveStep();
			ed.html.insert(output);
			ed.undo.saveStep();

			XF.EditorHelpers.normalizeAfterInsert(ed);
		},

		insertSpoiler: function(ed, title)
		{
			var open;
			if (title)
			{
				open = '[SPOILER="' + title + '"]';
			}
			else
			{
				open = '[SPOILER]';
			}

			XF.EditorHelpers.wrapSelectionText(ed, open, '[/SPOILER]', true);
		},

		normalizeBrForEditor: function (content)
		{
			var asString = typeof content === 'string',
				$fragWrapper;

			if (asString)
			{
				$fragWrapper = $('<div />').html(content);
			}
			else
			{
				$fragWrapper = content;
			}

			var checkNodeMatch = function ($node, elementType)
			{
				var node = $node.get(0);

				return ($node.is(elementType)
					&& node.className === ''
					&& !node.hasAttribute('id')
					&& !node.hasAttribute('style'));
			};

			// Workaround editor behaviour that a <br> should not be the first or last child of a <p> tag
			// <p><br>...</p>; editor can delete too many lines
			// <p>...<br></p>; editor can delete too few lines

			$fragWrapper.children('p').each(function ()
			{
				if (this.childNodes.length !== 1)
				{
					return;
				}

				var $firstChild = $(this.childNodes[0]);

				if (checkNodeMatch($firstChild, 'span'))
				{
					$(this).html($firstChild.html());
				}
			});

			$fragWrapper.children('p').each(function()
			{
				if (this.childNodes.length <= 1)
				{
					return;
				}

				var $firstChild = $(this.childNodes[0]);

				if (checkNodeMatch($firstChild, 'br'))
				{
					$(this).before($('<p>').append($firstChild));
				}
			});

			$fragWrapper.children('p').each(function()
			{
				if (this.childNodes.length <= 1)
				{
					return;
				}

				var $lastChild = $(this.childNodes[this.childNodes.length - 1]);

				if (checkNodeMatch($lastChild, 'br'))
				{
					$lastChild.remove();
				}
			});

			return asString ? $fragWrapper.html() : $fragWrapper;
		},

		normalizeAfterInsert: function(ed)
		{
			var selected = ed.html.getSelected();

			if (/<br>\s*<\/p>/.test(selected))
			{
				XF.EditorHelpers.normalizeBrForEditor(ed.$el);
				// remove the last undo step and replace it with the corrected html version
				ed.undo_index--;
				ed.undo_stack.pop();
				ed.undo.saveStep();
			}
		},

		isPreviewAvailable: function($textarea)
		{
			if (!$textarea.data('preview-url') && !$textarea.closest('form').data('preview-url'))
			{
				return false;
			}

			if ($textarea.data('preview') === false)
			{
				return false;
			}

			return true;
		},

		dialogs: {},

		loadDialog: function (ed, dialog)
		{
			var dialogs = XF.EditorHelpers.dialogs;
			if (dialogs[dialog])
			{
				dialogs[dialog].show(ed);
			}
			else
			{
				console.error("Unknown dialog '" + dialog + "'");
			}
		},

		bypassBrowserShims: function (ed, callback, browsers = [ 'mozilla' ])
		{
			var oldValues = {};

			for (var browser of browsers)
			{
				oldValues[browser] = ed.browser[browser];
				ed.browser[browser] = 0;
			}

			try
			{
				return callback();
			}
			finally
			{
				for (var browserKey in oldValues)
				{
					if (oldValues.hasOwnProperty(browserKey))
					{
						ed.browser[browserKey] = oldValues[browserKey];
					}
				}
			}
		}
	};

	XF.EditorDialog = XF.create({
		ed: null,
		overlay: null,
		dialog: null,
		cache: true,

		__construct: function(dialog)
		{
			this.dialog = dialog;
		},

		show: function(ed)
		{
			this.ed = ed;

			ed.selection.save();

			XF.loadOverlay(XF.canonicalizeUrl('index.php?editor/dialog&dialog=' + this.dialog), {
				beforeShow: XF.proxy(this, 'beforeShow'),
				afterShow: XF.proxy(this, 'afterShow'),
				init: XF.proxy(this, 'init'),
				cache: this.cache
			});
		},

		init: function(overlay)
		{
			var self = this;

			overlay.on('overlay:hidden', function()
			{
				if (self.ed)
				{
					self.ed.markers.remove();
				}
			});

			this._init(overlay);
		},

		_init: function(overlay) {},

		beforeShow: function(overlay)
		{
			this.overlay = overlay;

			this._beforeShow(overlay);
		},

		_beforeShow: function(overlay) {},

		afterShow: function(overlay)
		{
			this._afterShow(overlay);

			overlay.$overlay.find('textarea, input').first().focus();
		},

		_afterShow: function(overlay) {}
	});

	XF.EditorDialogMedia = XF.extend(XF.EditorDialog, {
		_beforeShow: function(overlay)
		{
			$('#editor_media_url').val('');
		},

		_init: function(overlay)
		{
			$('#editor_media_form').submit(XF.proxy(this, 'submit'));
		},

		submit: function(e)
		{
			e.preventDefault();

			var ed = this.ed,
				overlay = this.overlay;

			XF.ajax('POST',
				XF.canonicalizeUrl('index.php?editor/media'),
				{ url: $('#editor_media_url').val() },
				function (data)
				{
					if (data.matchBbCode)
					{
						ed.selection.restore();
						ed.undo.saveStep();
						ed.html.insert(XF.htmlspecialchars(data.matchBbCode));
						ed.undo.saveStep();
						XF.EditorHelpers.normalizeAfterInsert(ed);
						overlay.hide();
					}
					else if (data.noMatch)
					{
						XF.alert(data.noMatch);
					}
					else
					{
						ed.selection.restore();
						overlay.hide();
					}
				}
			);
		}
	});

	XF.EditorDialogSpoiler = XF.extend(XF.EditorDialog, {
		_beforeShow: function(overlay)
		{
			$('#editor_spoiler_title').val('');
		},

		_init: function(overlay)
		{
			$('#editor_spoiler_form').submit(XF.proxy(this, 'submit'));
		},

		submit: function(e)
		{
			e.preventDefault();

			var ed = this.ed,
				overlay = this.overlay;

			ed.selection.restore();
			XF.EditorHelpers.insertSpoiler(ed, $('#editor_spoiler_title').val());

			overlay.hide();
		}
	});

	XF.EditorDialogCode = XF.extend(XF.EditorDialog, {
		_beforeShow: function(overlay)
		{
			this.ed.$el.blur();
		},

		_afterShow: function(overlay)
		{
			var $container = overlay.$container,
				$codeMirror = $container.find('.CodeMirror'),
				ed = this.ed,
				instance;

			$container.find('[data-xf-init~="code-editor-switcher-container"]').trigger('code-editor:reinit');

			if ($codeMirror.length)
			{
				instance = $codeMirror[0].CodeMirror;
			}

			var selectedText;

			if (ed.selection.isCollapsed())
			{
				selectedText = '';
			}
			else
			{
				var selected = ed.html.getSelected()
					.replace(/&nbsp;/gmi, ' ')
					.replace(/\u200B/g, '')
					.replace(/(<\/(p|div|pre|blockquote|h[1-6]|tr|th|ul|ol|li)>)\s*/gi, '$1\n')
					.replace(/<(li|p)><br><\/\1>\s*/gi, '\n')
					.replace(/<br>\s*/gi, '\n');

				selectedText = $('<div>').html($.parseHTML(selected)).text().trim();
			}

			// weird FF behavior where inserting code wouldn't replace the current selection without this
			ed.selection.save();

			if (instance)
			{
				instance.getDoc().setValue(selectedText);
				instance.focus();
			}
			else
			{
				$container.find('.js-codeEditor').val(selectedText).focus();
			}
		},

		_init: function(overlay)
		{
			$('#editor_code_form').submit(XF.proxy(this, 'submit'));
		},

		submit: function(e)
		{
			e.preventDefault();

			var ed = this.ed,
				overlay = this.overlay;

			var $codeMirror = overlay.$container.find('.CodeMirror');
			if ($codeMirror.length)
			{
				var codeMirror = $codeMirror[0].CodeMirror,
					doc = codeMirror.getDoc();

				codeMirror.save();
				doc.setValue('');

				codeMirror.setOption('mode', '');
			}

			var $type = $('#editor_code_type'),
				$code = $('#editor_code_code');

			ed.selection.restore();
			XF.EditorHelpers.insertCode(ed, $type.val(), $code.val());

			overlay.hide();

			$code.val('');
			$type.val('');
		}
	});

	XF.editorStart = {
		started: false,
		custom: [],

		startAll: function()
		{
			if (!XF.editorStart.started)
			{
				XF.editorStart.setupLanguage();
				XF.editorStart.registerOverrides();
				XF.editorStart.registerToolbarSizes();
				XF.editorStart.registerCommands();
				XF.editorStart.registerCustomCommands();
				XF.editorStart.registerEditorDropdowns();
				XF.editorStart.registerDialogs();

				$(document).trigger('editor:first-start');

				XF.editorStart.started = true;
			}
		},

		setupLanguage: function()
		{
			var dir = $('html').attr('dir'),
				lang;

			try
			{
				lang = $.parseJSON($('.js-editorLanguage').first().html()) || {};
			}
			catch (e)
			{
				console.error(e);
				lang = {};
			}

			FroalaEditor.LANGUAGE['xf'] = {
				translation: lang,
				direction: dir ? dir.toLowerCase() : 'ltr'
			};
		},

		registerOverrides: function()
		{
			var originalHelpers = FroalaEditor.MODULES.helpers;

			FroalaEditor.MODULES.helpers = function(ed)
			{
				var helpers = originalHelpers.apply(this, arguments),
					sanitizeURL = helpers.sanitizeURL;

				helpers.sanitizeURL = function(url)
				{
					var res = sanitizeURL(url);
					return res
						.replace(/["]/g, '%22')
						.replace(/[']/g, '%27');
				};

				helpers.screenSize = function()
				{
					function sizeHelper(width, sizeName)
					{
						ed.$box.data('size', sizeName);
						return FroalaEditor[FroalaEditor.hasOwnProperty(sizeName) ? sizeName : 'LG'];
					}

					try
					{
						var width = ed.$box.width(),
							toolbarSizes = XF.EditorHelpers.toolbarSizes;

						// if the editor isn't visible, we won't get a width, so loop up to find
						// the first thing we can get a width from
						if (width <= 0)
						{
							var ref = ed.$box[0];
							while (ref = ref.parentNode)
							{
								width = ref.clientWidth;
								if (width > 0)
								{
									var css = window.getComputedStyle(ref);
									width -= parseInt(css.paddingLeft, 10) + parseInt(css.paddingRight, 10);
									if (width > 0)
									{
										break;
									}
								}
							}
						}

						if (width < toolbarSizes.SM)
						{
							return sizeHelper(width, 'XS');
						}

						if (width < toolbarSizes.MD)
						{
							return sizeHelper(width, 'SM');
						}

						if (width < toolbarSizes.LG)
						{
							return sizeHelper(width, 'MD');
						}

						if (width < toolbarSizes.LG + 50)
						{
							return sizeHelper(width, 'LG')
						}

						return sizeHelper(width, 'XL');
					}
					catch (ex)
					{
						// if in doubt...
						return sizeHelper(width, 'XS');
					}
				};

				return helpers;
			};
		},

		registerToolbarSizes: function()
		{
			try
			{
				var editorToolbarSizes = $.parseJSON($('.js-editorToolbarSizes').first().html()) || {};
			}
			catch (e)
			{
				console.error("Toolbar sizes data not valid: ", e);
				return;
			}

			XF.EditorHelpers.toolbarSizes = editorToolbarSizes;
		},

		commands:
		{
			xfQuote: ['quote-right', {
				title: 'Quote',
				icon: 'xfQuote',
				undo: true,
				focus: true,
				callback: function()
				{
					var editor = this;

					// gets information about the path back to the editor root, including the first
					// quote found
					function getNodePathInfo(node)
					{
						var original = node,
							quote = null;

						if (node.tagName == 'BLOCKQUOTE')
						{
							quote = node;
						}

						while (node.parentNode && node.parentNode !== editor.el)
						{
							node = node.parentNode;

							if (!quote && node.tagName == 'BLOCKQUOTE')
							{
								quote = node;
							}
						}

						return {
							original: original,
							quote: quote,
							root: node
						};
					}

					editor.selection.save();
					editor.html.wrap(true, true, true, true);
					editor.selection.restore();

					var blocks = editor.selection.blocks(),
						blocksInfo = [],
						createQuote = true,
						b,
						info;

					// if the temp div is selected, just assume it's the first block that we want
					if (blocks.length == 1 && $(blocks[0]).is('.fr-temp-div'))
					{
						blocks = [$(editor.el).find('p').get(0)];
					}

					for (b = 0; b < blocks.length; b++)
					{
						info = getNodePathInfo(blocks[b]);
						if (info.quote)
						{
							createQuote = false;
						}

						blocksInfo.push(info);
					}

					editor.selection.save();

					if (createQuote)
					{
						var $quote = $(document.createElement('blockquote'));
						$quote.insertBefore(blocksInfo[0].root);

						for (b = 0; b < blocksInfo.length; b++)
						{
							$quote.append(blocksInfo[b].root);
						}
					}
					else
					{
						var quote;

						for (b = 0; b < blocksInfo.length; b++)
						{
							quote = blocksInfo[b].quote;
							if (quote)
							{
								$(quote).replaceWith(quote.innerHTML);
							}
						}
					}

					editor.html.unwrap();
					editor.selection.restore();
				}
			}],

			xfCode: ['code', {
				title: 'Code',
				icon: 'xfCode',
				undo: true,
				focus: true,
				callback: function()
				{
					XF.EditorHelpers.loadDialog(this, 'code');
				}
			}],

			xfInlineCode: ['terminal', {
				title: 'Inline Code',
				icon: 'xfInlineCode',
				undo: true,
				focus: true,
				callback: function()
				{
					XF.EditorHelpers.wrapSelectionText(this, '[ICODE]', '[/ICODE]', true, true);
				}
			}],

			xfMedia: ['photo-video', {
				title: 'Media',
				icon: 'xfMedia',
				undo: true,
				focus: true,
				callback: function()
				{
					XF.EditorHelpers.loadDialog(this, 'media');
				}
			}],

			xfSpoiler: ['eye-slash', {
				title: 'Spoiler',
				icon: 'xfSpoiler',
				undo: true,
				focus: true,
				callback: function()
				{
					XF.EditorHelpers.loadDialog(this, 'spoiler');
				}
			}],

			xfInlineSpoiler: ['mask', {
				title: 'Inline Spoiler',
				icon: 'xfInlineSpoiler',
				undo: true,
				focus: true,
				callback: function()
				{
					XF.EditorHelpers.wrapSelectionText(this, '[ISPOILER]', '[/ISPOILER]', true, true);
				}
			}],

			xfSmilie: ['smile', {
				title: 'Smilies',
				icon: 'xfSmilie',
				undo: false,
				focus: false,
				refreshOnCallback: false,
				callback: function()
				{
					var t = this;

					setTimeout(function()
					{
						t.xfSmilie.showMenu();
					}, 0);
				}
			}],

			xfInsertGif: ['xfInsertGif', {
				title: 'Insert GIF',
				icon: 'xfInsertGif',
				undo: false,
				focus: false,
				refreshOnCallback: false,
				callback: function()
				{
					var t = this;

					setTimeout(function()
					{
						t.xfInsertGif.showMenu();
					}, 0);
				}
			}],

			xfDraft: ['save', {
				type: 'dropdown',
				title: 'Drafts',
				focus: true,
				undo: false,
				options: {
					xfDraftSave: 'Save Draft',
					xfDraftDelete: 'Delete Draft'
				},
				html: function()
				{
					var options = {
						xfDraftSave: 'Save Draft',
						xfDraftDelete: 'Delete Draft'
					};

					var o = '<ul class="fr-dropdown-list">'

					for (var key in options)
					{
						o += '<li><a class="fr-command" data-cmd="xfDraft" data-param1="' + key + '">' + this.language.translate(options[key]) + '</a></li>';
					}

					o += '</ul>';

					return o;
				},
				callback: function(cmd, val)
				{
					// note: wrapped in $() so it is one of *our* jQuery objects
					var $form = $(this.$el.closest('form'));
					if (!$form.length)
					{
						console.error('No parent form to find draft handler');
						return;
					}

					var draftHandler = XF.Element.getHandler($form, 'draft');
					if (!draftHandler)
					{
						console.error('No draft handler on parent form');
						return;
					}

					if (val == 'xfDraftSave')
					{
						draftHandler.triggerSave();
					}
					else if (val == 'xfDraftDelete')
					{
						draftHandler.triggerDelete();
					}
				}
			}],

			xfBbCode: ['brackets', {
				title: 'Toggle BB Code',
				icon: 'xfBbCode',
				undo: false,
				focus: false,
				forcedRefresh: true,
				callback: function()
				{
					this.bbCode.toggle();
				}
			}],

			xfPreview: ['file-search', {
				title: 'Preview',
				icon: 'xfPreview',
				undo: false,
				focus: false,
				forcedRefresh: true,
				callback: function()
				{
					this.contentPreview.toggle();
				}
			}]
		},

		registerCommands: function()
		{
			var t = this,
				cmd;

			FroalaEditor.PLUGINS.xfInsertGif = function(editor)
			{
				var initialized = false,
					loaded = false,
					$menu,
					$menuScroll,
					scrollTop = 0;

				function showMenu()
				{
					selectionSave();

					XF.EditorHelpers.blur(editor);

					var $btn = $(editor.$tb.find('.fr-command[data-cmd="xfInsertGif"]')).first();

					if (!initialized)
					{
						initialized = true;

						var menuHtml = $.trim($('.js-xfEditorMenu').first().html());

						$menu = $($.parseHTML(Mustache.render(menuHtml, { href: XF.canonicalizeUrl('index.php?editor/insert-gif') })));
						$menu.addClass('menu--gif');
						$menu.insertAfter($btn);

						$btn.data('xf-click', 'menu');

						var handler = XF.Event.getElementHandler($btn, 'menu', 'click');

						$menu.on('menu:complete', function()
						{
							$menuScroll = $menu.find('.menu-scroller');

							if (!loaded)
							{
								loaded = true;

								initMenuContents();

								var $gifSearch = $menu.find('.js-gifSearch');
								$gifSearch.on('input', performSearch);

								$menu.find('.js-gifCloser').on('click', function()
								{
									XF.EditorHelpers.focus(editor);
								});

								editor.events.on('commands.mousedown', function($el)
								{
									if ($el.data('cmd') != 'xfInsertGif')
									{
										handler.close();
									}
								});

								$menu.on('menu:closed', function()
								{
									scrollTop = $menuScroll.scrollTop();
								});
							}

							$menuScroll.scrollTop(scrollTop);

							if (!window.IntersectionObserver)
							{
								loadVisibleImages($menuScroll);
							}
						});

						$menu.on('menu:closed', function()
						{
							setTimeout(function()
							{
								editor.markers.remove();
							}, 50);
						});
					}

					var clickHandlers = $btn.data('xfClickHandlers');
					if (clickHandlers && clickHandlers.menu)
					{
						clickHandlers.menu.toggle();
					}
				}

				function initMenuContents()
				{
					if (window.IntersectionObserver)
					{
						var gifObserver = new IntersectionObserver(onGifIntersection, {
							root: $menuScroll[0],
							rootMargin: '0px 0px 100px 0px'
						});
						$menuScroll.find('.js-gif img:not(.js-observed)').each(function()
						{
							$(this).addClass('js-observed');
							gifObserver.observe(this);
						});

						var loadingObserver = new IntersectionObserver(onLoadingIntersection, {
							root: $menuScroll[0],
							rootMargin: '0px 0px 50px 0px'
						})
						$menuScroll.find('.js-gifLoadMore').each(function()
						{
							loadingObserver.observe(this);
						});
					}
					else
					{
						$menuScroll.onPassive('scroll', loadVisibleImages);
					}

					$menuScroll.find('.js-gif').on('click', insertGif);
				}

				function insertGif(e)
				{
					var $target = $(e.currentTarget),
						$img = $target.find('img'),
						$container = $img.parent();

					if ($container.hasClass('is-loading'))
					{
						return;
					}

					$container.addClass('is-loading');

					var	image = $img.data('insert'),
						$image = $('<img />')
							.attr('src', image)
							.attr('class', 'fr-fic fr-dii fr-draggable')
							.attr('alt', $img.attr('alt'));

					var insert = function()
					{
						selectionRestore();
						XF.EditorHelpers.focus(editor);
						editor.undo.saveStep();
						editor.html.insert($image.prop('outerHTML'));
						editor.undo.saveStep();
						selectionSave();
						XF.EditorHelpers.blur(editor);
						XF.EditorHelpers.normalizeAfterInsert(editor);

						if ($menu)
						{
							$menu.find('.js-gifCloser').click();
						}

						$container.removeClass('is-loading');
					};

					if (!$image.prop('complete'))
					{
						$image.on('load', insert);
					}
					else
					{
						insert();
					}
				}

				function onGifIntersection(changes, observer)
				{
					var entry, $target;

					for (var i = 0; i < changes.length; i++)
					{
						entry = changes[i];
						$target = $(entry.target);
						if (entry.isIntersecting)
						{
							lazyLoadGif($target);
						}
						else
						{
							lazyUnloadGif($target);
						}
					}
				}

				function onLoadingIntersection(changes, observer)
				{
					var entry, $target;

					for (var i = 0; i < changes.length; i++)
					{
						entry = changes[i];
						if (!entry.isIntersecting)
						{
							continue;
						}

						$target = $(entry.target);
						loadMore($target);
						observer.unobserve(entry.target);
					}
				}

				function loadVisibleImages($rowOrEvent)
				{
					var $row = $rowOrEvent;

					if ($rowOrEvent instanceof Event)
					{
						$row = $($rowOrEvent.currentTarget);
					}

					if (!$row.is(':visible'))
					{
						return;
					}

					var visibleRect = $row[0].getBoundingClientRect(),
						visibleBottom = visibleRect.bottom + 100; // 100px offset for visible detection
					$row.children().each(function()
					{
						var $child = $(this),
							childRect = this.getBoundingClientRect();

						if (childRect.bottom < visibleRect.top)
						{
							// area is above what's visible
							return;
						}
						if (childRect.top > visibleBottom)
						{
							// area is below what's visible, so assume everything else is
							return false;
						}

						// otherwise we're visible, so look for smilies here
						$child.find('.js-gif img').each(function()
						{
							var $toLoad = $(this),
								smilieRect = this.getBoundingClientRect();

							if (smilieRect.top <= visibleBottom)
							{
								// gif is before the end of the visible area, so load
								lazyLoadGif($toLoad);
							}
						});
					});
				}

				function loadMore($target)
				{
					if ($target.data('loading'))
					{
						return;
					}

					$target.data('loading', true);

					XF.ajax('GET', $target.data('href'), function(data)
					{
						if (!data.html)
						{
							// TODO: should remove the loading element as likely indicates no more GIFs
							return;
						}

						XF.setupHtmlInsert(data.html, function($html)
						{
							var $insert;

							if ($html.is('.js-gifContainer'))
							{
								$insert = $($html.html());
							}
							else
							{
								$insert = $($html.find('.js-gifContainer').html());
							}

							$insert.insertAfter($target);
							$target.remove();

							initMenuContents();
						});
					});
				}

				function lazyLoadGif($toLoad)
				{
					if ($toLoad.data('loaded'))
					{
						return;
					}

					var dataSrc = $toLoad.attr('data-src'),
						src = $toLoad.attr('src');

					$toLoad.attr('src', dataSrc);
					$toLoad.attr('data-src', src);
					$toLoad.data('loaded', true);
				}

				function lazyUnloadGif($toLoad)
				{
					if (!$toLoad.data('loaded'))
					{
						return;
					}

					var dataSrc = $toLoad.attr('data-src'),
						src = $toLoad.attr('src');

					$toLoad.attr('src', dataSrc);
					$toLoad.attr('data-src', src);
					$toLoad.data('loaded', false);
				}

				var timer;

				function performSearch()
				{
					var $input = $(this),
						$fullList = $menu.find('.js-gifFullRow'),
						$searchResults = $menu.find('.js-gifSearchRow');

					clearTimeout(timer);

					timer = setTimeout(function()
					{
						var value = $input.val();

						if (!value || value.length < 2)
						{
							$searchResults.hide();
							$fullList.show();
							loadVisibleImages($fullList);
							return;
						}

						var url = XF.canonicalizeUrl('index.php?editor/insert-gif/search');
						XF.ajax('GET', url, {'q': value}, function(data)
						{
							if (!data.html)
							{
								return;
							}

							XF.setupHtmlInsert(data.html, function($html)
							{
								$fullList.hide();
								$searchResults.html($html);
								$searchResults.show();
								$menuScroll.scrollTop(0);

								initMenuContents();
							});
						});
					}, 300);
				}

				function selectionSave()
				{
					editor.selection.save();
				}

				function selectionRestore()
				{
					editor.selection.restore();
				}

				return {
					showMenu: showMenu
				}
			};

			FroalaEditor.PLUGINS.xfSmilie = function(editor)
			{
				var initialized = false,
					loaded = false,
					$menu,
					$menuScroll,
					scrollTop = 0,
					flashTimeout,
					logTimeout;

				function showMenu()
				{
					selectionSave();

					XF.EditorHelpers.blur(editor);

					var $btn = $(editor.$tb.find('.fr-command[data-cmd="xfSmilie"]')).first();

					if (!initialized)
					{
						initialized = true;

						var menuHtml = $.trim($('.js-xfEditorMenu').first().html());

						$menu = $($.parseHTML(Mustache.render(menuHtml, { href: XF.canonicalizeUrl('index.php?editor/smilies-emoji') })));
						$menu.addClass('menu--emoji');
						$menu.insertAfter($btn);

						$btn.data('xf-click', 'menu');

						var handler = XF.Event.getElementHandler($btn, 'menu', 'click');

						$menu.on('menu:complete', function()
						{
							$menuScroll = $menu.find('.menu-scroller');

							if (!loaded)
							{
								loaded = true;

								if (window.IntersectionObserver)
								{
									var observer = new IntersectionObserver(onEmojiIntersection, {
										root: $menuScroll[0],
										rootMargin: '0px 0px 100px 0px'
									});
									$menuScroll.find('span.smilie--lazyLoad').each(function()
									{
										observer.observe(this);
									});
								}
								else
								{
									$menuScroll.onPassive('scroll', loadVisibleImages);
								}

								$menuScroll.find('.js-emoji').on('click', insertEmoji);

								var $emojiSearch = $menu.find('.js-emojiSearch');
								$emojiSearch.on('input', performSearch);

								$menu.find('.js-emojiCloser').on('click', function()
								{
									XF.EditorHelpers.focus(editor);
								});

								$(document).on('recent-emoji:logged', updateRecentEmoji);

								editor.events.on('commands.mousedown', function($el)
								{
									if ($el.data('cmd') != 'xfSmilie')
									{
										handler.close();
									}
								});

								$menu.on('menu:closed', function()
								{
									scrollTop = $menuScroll.scrollTop();
								});
							}

							$menuScroll.scrollTop(scrollTop);

							if (!window.IntersectionObserver)
							{
								loadVisibleImages($menuScroll);
							}
						});

						$menu.on('menu:closed', function()
						{
							setTimeout(function()
							{
								editor.markers.remove();
							}, 50);
						});
					}

					var clickHandlers = $btn.data('xfClickHandlers');
					if (clickHandlers && clickHandlers.menu)
					{
						clickHandlers.menu.toggle();
					}
				}

				function insertEmoji(e)
				{
					var $target = $(e.currentTarget),
						html = $target.html(),
						$html = $(html);

					if ($html.hasClass('smilie--lazyLoad'))
					{
						return;
					}

					XF.EditorHelpers.bypassBrowserShims(editor, function()
					{
						selectionRestore();
						XF.EditorHelpers.focus(editor);
						editor.undo.saveStep();
						editor.html.insert(html);
						editor.undo.saveStep();
						selectionSave();
						XF.EditorHelpers.blur(editor);
						XF.EditorHelpers.normalizeAfterInsert(editor);
					});

					if ($menu)
					{
						var $insertRow = $menu.find('.js-emojiInsertedRow');
						$insertRow.find('.js-emojiInsert').html(html);
						$insertRow.addClassTransitioned('is-active');

						clearTimeout(flashTimeout);
						flashTimeout = setTimeout(function()
						{
							$insertRow.removeClassTransitioned('is-active');
						}, 1500);
					}

					clearTimeout(logTimeout);
					logTimeout = setTimeout(function()
					{
						// delay the logging of the recent emoji usage in order to
						// avoid a situation whereby the emojis do not flip position
						// if you are attempting to insert the same emoji repeatedly.
						// a delay here also prevents the emoji menu from closing.
						XF.logRecentEmojiUsage($target.data('shortname'));
					}, 1500);
				}

				function onEmojiIntersection(changes, observer)
				{
					var entry, $target;

					for (var i = 0; i < changes.length; i++)
					{
						entry = changes[i];
						if (!entry.isIntersecting)
						{
							continue;
						}

						$target = $(entry.target);
						lazyLoadEmoji($target);
						observer.unobserve(entry.target);
					}
				}

				function loadVisibleImages($rowOrEvent, assumeVisible)
				{
					var $row = $rowOrEvent;

					if ($rowOrEvent instanceof Event)
					{
						$row = $($rowOrEvent.currentTarget);
					}

					if (!assumeVisible && !$row.is(':visible'))
					{
						return;
					}

					var visibleRect = $row[0].getBoundingClientRect(),
						visibleBottom = visibleRect.bottom + 100; // 100px offset for visible detection
					$row.children().each(function()
					{
						var $child = $(this),
							childRect = this.getBoundingClientRect();

						if (childRect.bottom < visibleRect.top)
						{
							// area is above what's visible
							return;
						}
						if (childRect.top > visibleBottom)
						{
							// area is below what's visible, so assume everything else is
							return false;
						}

						// otherwise we're visible, so look for smilies here
						$child.find('span.smilie--lazyLoad').each(function()
						{
							var $toLoad = $(this),
								smilieRect = this.getBoundingClientRect();

							if (smilieRect.top <= visibleBottom)
							{
								// smilie is before the end of the visible area, so load
								lazyLoadEmoji($toLoad);
							}
						});
					});
				}

				function lazyLoadEmoji($toLoad)
				{
					var $image = $('<img />').attr({
						'class': $toLoad.attr('class').replace(/(\s|^)smilie--lazyLoad(\s|$)/, ' '),
						alt: $toLoad.attr('data-alt'),
						title: $toLoad.attr('title'),
						src: $toLoad.attr('data-src'),
						'data-shortname': $toLoad.attr('data-shortname')
					});

					var replace = function()
					{
						var f = function()
						{
							$toLoad.replaceWith($image);
						};

						if (window.requestAnimationFrame)
						{
							window.requestAnimationFrame(f);
						}
						else
						{
							f();
						}
					};

					if (!$image.prop('complete'))
					{
						$image.on('load', replace);
					}
					else
					{
						replace();
					}
				}

				var timer;

				function performSearch()
				{
					var $input = $(this),
						$fullList = $menu.find('.js-emojiFullList'),
						$searchResults = $menu.find('.js-emojiSearchResults');

					clearTimeout(timer);

					timer = setTimeout(function()
					{
						var value = $input.val();

						if (!value || value.length < 2)
						{
							$searchResults.hide();
							$fullList.show();
							loadVisibleImages($fullList);
							return;
						}

						var url = XF.canonicalizeUrl('index.php?editor/smilies-emoji/search');
						XF.ajax('GET', url, {'q': value}, function(data)
						{
							if (!data.html)
							{
								return;
							}

							XF.setupHtmlInsert(data.html, function($html)
							{
								$html.find('.js-emoji').on('click', insertEmoji);

								$fullList.hide();
								$searchResults.replaceWith($html);
							});
						});
					}, 300);
				}

				function updateRecentEmoji()
				{
					var recent = XF.getRecentEmojiUsage(),
						$recentHeader = $menuScroll.find('.js-recentHeader'),
						$recentBlock = $menuScroll.find('.js-recentBlock'),
						$recentList = $recentBlock.find('.js-recentList'),
						$emojiLists = $menuScroll.find('.js-emojiList');

					if (!recent)
					{
						return;
					}

					var $newList = $recentList.clone(),
						newListArr = [];

					$newList.empty();

					for (var i in recent)
					{
						var shortname = recent[i],
							$emoji;

						$emojiLists.each(function()
						{
							var $list = $(this),
								$original = $list.find('.js-emoji[data-shortname="' + shortname + '"]').closest('li');

							$emoji = $original.clone();

							if ($emoji.length)
							{
								$emoji.find('.js-emoji').on('click', insertEmoji);
								newListArr.push($emoji);
								return false;
							}
						});
					}

					for (i in newListArr)
					{
						var $li = newListArr[i];
						$li.appendTo($newList);
					}

					$recentList.replaceWith($newList);

					if ($recentBlock.hasClass('is-hidden'))
					{
						$recentBlock.hide();
						$recentBlock.removeClass('is-hidden');
						$recentHeader.removeClass('is-hidden');
						$recentBlock.xfFadeDown(XF.config.speed.fast);
					}

					loadVisibleImages($newList, true);
				}

				function selectionSave()
				{
					editor.selection.save();
				}

				function selectionRestore()
				{
					editor.selection.restore();
				}

				return {
					showMenu: showMenu
				}
			};

			$.extend(FroalaEditor.DEFAULTS, {
				xfBbCodeAttachmentContextInput: 'attachment_hash_combined'
			});
			FroalaEditor.PLUGINS.bbCode = function(ed)
			{
				var _isBbCodeView = false;

				function getButton()
				{
					return ed.$tb.find('.fr-command[data-cmd=xfBbCode]');
				}

				function getBbCodeBox()
				{
					var $oel = ed.$oel;

					var $bbCodeBox = $oel.data('xfBbCodeBox');
					if (!$bbCodeBox)
					{
						var borderAdjust = parseInt(ed.$wp.css('border-bottom-width'), 10)
							+ parseInt(ed.$wp.css('border-top-width'), 10);

						$bbCodeBox = $('<textarea class="input" style="display: none" />');
						$bbCodeBox.attr('aria-label', XF.htmlspecialchars(XF.phrase('rich_text_box')));
						$bbCodeBox.css({
							minHeight: ed.opts.heightMin ? (ed.opts.heightMin + borderAdjust) + 'px' : null,
							maxHeight: ed.opts.heightMax ? ed.opts.heightMax + 'px' : null,
							height: ed.opts.height ? (ed.opts.height + borderAdjust) + 'px' : null,
							padding: ed.$el.css('padding')
						});
						$bbCodeBox.attr('name', $oel.data('original-name'));
						$oel.data('xfBbCodeBox', $bbCodeBox);
						ed.$wp.after($bbCodeBox[0]);

						$bbCodeBox.on('focus blur', function(e)
						{
							switch (e.type)
							{
								case 'focus':
									ed.$box.addClass('is-focused');
									break;

								case 'blur':
									ed.$box.removeClass('is-focused');
									break;
							}
						});

						XF.Element.applyHandler($bbCodeBox, 'textarea-handler');
						XF.Element.applyHandler($bbCodeBox, 'user-mentioner');
						XF.Element.applyHandler($bbCodeBox, 'emoji-completer');

						if (XF.isElementWithinDraftForm($bbCodeBox))
						{
							XF.Element.applyHandler($bbCodeBox, 'draft-trigger');
						}
					}

					return $bbCodeBox;
				}

				function btnsToDisable($button)
				{
					return ed.$tb.find('> .fr-btn-grp .fr-command, > .fr-more-toolbar .fr-command')
						.not($button)
						.not('[data-cmd^="more"]')
						.not('[data-cmd=xfPreview]');
				}

				function toBbCode(bbCode, skipFocus)
				{
					var $bbCodeBox = getBbCodeBox();

					var apply = function(bbCode, skipFocus)
					{
						_isBbCodeView = true;

						var $button;

						ed.undo.saveStep();
						ed.$el.blur();

						$button = getButton();

						btnsToDisable($button).addClass('fr-disabled');
						$button.addClass('fr-active');

						ed.$wp.css('display', 'none');
						ed.$oel.attr('disabled', 'disabled'); // Froala jQuery doesn't implement prop

						$bbCodeBox.val(bbCode)
							.css('display', '')
							.prop('disabled', false)
							.trigger('autosize');

						if (!skipFocus)
						{
							$bbCodeBox.autofocus();
						}

						XF.setIsEditorEnabled(false);
					};

					if (typeof bbCode == 'string')
					{
						apply(bbCode, skipFocus);
					}
					else
					{
						XF.ajax('POST',
							XF.canonicalizeUrl('index.php?editor/to-bb-code'),
							{ html: ed.html.get() },
							function (data) { apply(data.bbCode, skipFocus); }
						);
					}
				}

				function toHtml(html)
				{
					var $bbCodeBox = getBbCodeBox();

					var apply = function(html)
					{
						_isBbCodeView = false;

						var $button = getButton();

						btnsToDisable($button).removeClass('fr-disabled');
						$button.removeClass('fr-active');

						ed.$oel.removeAttr('disabled');
						ed.html.set(html);
						$bbCodeBox.css('display', 'none').prop('disabled', true);
						ed.$wp.css('display', '');
						ed.events.focus();
						ed.undo.saveStep();
						ed.size.refresh();

						XF.setIsEditorEnabled(true);
						XF.layoutChange();
					};

					if (typeof html == 'string')
					{
						apply(html);
					}
					else
					{
						var params = { bb_code: $bbCodeBox.val() };

						var $form = ed.$el.closest('form');
						if ($form.length)
						{
							if ($form[0][ed.opts.xfBbCodeAttachmentContextInput])
							{
								params.attachment_hash_combined = $($form[0][ed.opts.xfBbCodeAttachmentContextInput]).val();
							}
						}

						XF.ajax('POST',
							XF.canonicalizeUrl('index.php?editor/to-html'),
							params,
							function (data) { apply(data.editorHtml); }
						);
					}
				}

				function toggle()
				{
					if (_isBbCodeView)
					{
						toHtml();
					}
					else
					{
						toBbCode();
					}
				}

				function isBbCodeView()
				{
					return _isBbCodeView;
				}

				function getToggleableButtons()
				{
					return btnsToDisable(getButton());
				}

				function insertBbCode(bbCode)
				{
					if (!_isBbCodeView)
					{
						return;
					}

					var $bbCodeBox = getBbCodeBox();
					XF.insertIntoTextBox($bbCodeBox, bbCode);
				}

				function replaceBbCode(bbCode)
				{
					if (!_isBbCodeView)
					{
						return;
					}

					var $bbCodeBox = getBbCodeBox();
					XF.replaceIntoTextBox($bbCodeBox, bbCode);
				}

				function getTextArea()
				{
					return (_isBbCodeView ? getBbCodeBox() : null);
				}

				function _init()
				{
					ed.events.on('buttons.refresh', function()
					{
						return !_isBbCodeView;
					});
				}

				return {
					_init: _init,
					getBbCodeBox: getBbCodeBox,
					toBbCode: toBbCode,
					isBbCodeView: isBbCodeView,
					getTextArea: getTextArea,
					insertBbCode: insertBbCode,
					replaceBbCode: replaceBbCode,
					toHtml: toHtml,
					toggle: toggle,
					getToggleableButtons: getToggleableButtons
				};
			};

			FroalaEditor.PLUGINS.contentPreview = function(ed) {
				var _isPreview = false;

				function getButton()
				{
					return ed.$tb.find('.fr-command[data-cmd=xfPreview]');
				}

				function getPreviewBox()
				{
					var $outerEl = ed.$oel;

					var $previewBox = $outerEl.data('xfPreviewBox');
					if (!$previewBox)
					{
						var css = $(ed.$el[0]).css(['padding-top', 'padding-right', 'padding-bottom', 'padding-left']);
						css.minHeight = ed.opts.heightMin ? ed.opts.heightMin + 'px' : null;

						$previewBox = $('<div class="xfPreview" style="display:none" />');
						$previewBox.css(css);
						$outerEl.data('xfPreviewBox', $previewBox);

						ed.$wp.after($previewBox[0]);
					}

					return $previewBox;
				}

				function btnsToDisable($button)
				{
					return ed.$tb.find('> .fr-btn-grp .fr-command')
						.not($button);
				}

				function toPreview(previewHtml)
				{
					var $previewBox = getPreviewBox();

					var apply = function($previewHtml)
					{
						_isPreview = true;

						var $button;

						ed.undo.saveStep();
						ed.$el.blur();

						// closes any active more toolbar
						ed.$tb.find('.fr-command.fr-open[data-cmd^="more"]').each(function()
						{
							ed.commands.exec($(this).attr('data-cmd'));
						});

						$button = getButton();

						btnsToDisable($button).addClass('fr-disabled fr-invisible');
						$button.addClass('fr-active');

						// switch tabs
						ed.$tb.find('.fr-btn-grp')
							.addClass('rte-tab--inactive')
							.filter('.rte-tab--preview').removeClass('rte-tab--inactive');

						// switch classes on outer box
						ed.$box.addClass('is-preview');

						if (ed.bbCode.isBbCodeView())
						{
							var $box = ed.bbCode.getBbCodeBox();
							$box.css('display', 'none');
						}
						else
						{
							ed.$wp.css('display', 'none');
						}

						$previewBox
							.html($previewHtml.find('.bbWrapper'))
							.css('display', '');
					};

					if (typeof previewHtml == 'string')
					{
						apply($($.parseHTML(previewHtml)));
					}
					else
					{
						// this is to force syncing the contents back to the textarea
						ed.events.trigger('form.submit');

						var $form = ed.$oel.closest('form'),
							href = ed.$oel.data('preview-url') ? ed.$oel.data('preview-url') : $form.data('preview-url'),
							formData = XF.getDefaultFormData($form);

						XF.ajax('POST',
							XF.canonicalizeUrl(href),
							formData,
							function (data)
							{
								XF.setupHtmlInsert(data.html, function($html)
								{
									XF.activate($html);
									apply($html);
								});
							}
						);
					}
				}

				function toHtml(skipFocus)
				{
					var $previewBox = getPreviewBox(),
						$button = getButton(),
						isBbCodeView = ed.bbCode.isBbCodeView();

					_isPreview = false;

					// reset the buttons to the state that thre preview expects...
					btnsToDisable($button).removeClass('fr-disabled fr-invisible');
					$button.removeClass('fr-active');

					if (isBbCodeView)
					{
						// ... then restore the BB code view state if needed
						ed.bbCode.getToggleableButtons().addClass('fr-disabled');
					}

					// switch tabs
					ed.$tb.find('.fr-btn-grp')
						.removeClass('rte-tab--inactive')
						.filter('.rte-tab--preview').addClass('rte-tab--inactive');

					ed.$oel.removeAttr('disabled');
					$previewBox.css('display', 'none');

					// switch classes on outer box
					ed.$box.removeClass('is-preview');

					if (isBbCodeView)
					{
						var $box = ed.bbCode.getBbCodeBox();
						$box.css('display', '');
					}
					else
					{
						ed.$wp.css('display', '');
					}

					if (!skipFocus)
					{
						ed.events.focus();
					}

					XF.layoutChange();
				}

				function toggle()
				{
					var $oel = $(ed.$oel);

					if (!XF.EditorHelpers.isPreviewAvailable($oel))
					{
						return;
					}

					if (_isPreview)
					{
						toHtml();
					}
					else
					{
						XF.EditorHelpers.sync(ed);

						var testValue;

						if (ed.bbCode && ed.bbCode.isBbCodeView())
						{
							testValue = ed.bbCode.getBbCodeBox().val();
						}
						else
						{
							testValue = $oel.val();
						}

						if (!testValue)
						{
							return;
						}

						toPreview();
					}
				}

				function isPreview()
				{
					return _isPreview;
				}

				function _init()
				{
					ed.events.on('buttons.refresh', function()
					{
						return !_isPreview;
					});

					setupPreviewTabs();
					ed.events.on('codeView.toggle', function()
					{
						setupPreviewTabs();
					});

					// turn the whole of the toolbar into a tab-switcher
					ed.$tb.on('click', function(e)
					{
						if (_isPreview)
						{
							if (!$(e.target).closest('.rte-tab--preview').length)
							{
								toggle();
							}
						}
					});

					$(ed.$tb.closest('form')).on('preview:hide', function()
					{
						toHtml(true);
					});
				}

				function setupPreviewTabs()
				{
					var $grps = ed.$tb.find('.fr-btn-grp');

					if (XF.EditorHelpers.isPreviewAvailable($(ed.$oel)))
					{
						$grps.slice($grps.length - 1).addClass('rte-tab--inactive rte-tab--preview');
						$grps.slice($grps.length - 2, $grps.length - 1).addClass('rte-tab--beforePreview');
					}
					else
					{
						$grps.slice($grps.length - 1).addClass('rte-tab--beforePreview');
					}

				}

				return {
					_init: _init,
					toPreview: toPreview,
					isPreview: isPreview,
					toHtml: toHtml,
					toggle: toggle
				};
			}

			for (cmd in this.commands)
			{
				if (this.commands.hasOwnProperty(cmd))
				{
					FroalaEditor.DefineIcon(cmd, { NAME: this.commands[cmd][0]});
					FroalaEditor.RegisterCommand(cmd, this.commands[cmd][1]);
				}
			}
		},

		registerCustomCommands: function()
		{
			var custom;

			try
			{
				custom = $.parseJSON($('.js-editorCustom').first().html()) || {};
			}
			catch (e)
			{
				console.error(e);
				custom = {};
			}

			for (var tag in custom)
			{
				if (!custom.hasOwnProperty(tag))
				{
					continue;
				}

				(function(tag, def)
				{
					// make sure this matches with the disabler in XF\Service\User\SignatureEdit
					var name = 'xfCustom_' + tag,
						tagUpper = tag.toUpperCase(),
						template = {},
						faMatch;

					if (def.type == 'fa')
					{
						faMatch = def.value.match(/^fa([slrb]) fa-(.+)$/);
						if (faMatch)
						{
							template = {
								FA5NAME: faMatch[2],
								template: 'font_awesome_5' + (faMatch[1] === 's' ? '' : faMatch[1])
							};

						}
						else
						{
							template = { NAME: def.value };
						}
					}
					else if (def.type == 'svg')
					{
						template = {
							template: 'svg',
							PATH: def.value
						}
					}
					else if (def.type == 'image')
					{
						template = {
							template: 'image',
							SRC: '"' + XF.canonicalizeUrl(def.value) + '"',
							ALT: '"' + def.title + '"'
						};
					}

					var config = {
						title: def.title,
						icon: name,
						undo: true,
						focus: true,
						callback: function()
						{
							XF.EditorHelpers.wrapSelectionText(
								this,
								def.option == 'yes' ? '[' + tagUpper + '=]' : '[' + tagUpper + ']',
								'[/' + tagUpper + ']',
								true
							);
						}
					};

					FroalaEditor.DefineIcon(name, template);
					FroalaEditor.RegisterCommand(name, config);

					XF.editorStart.custom.push(name);
				})(tag, custom[tag]);
			}

			// Now let's override a few icons
			FroalaEditor.DefineIcon('xfInsertGif', { template: 'svg', PATH: 'M11.5 9H13v6h-1.5zM9 9H6c-.6 0-1 .5-1 1v4c0 .5.4 1 1 1h3c.6 0 1-.5 1-1v-2H8.5v1.5h-2v-3H10V10c0-.5-.4-1-1-1zm10 1.5V9h-4.5v6H16v-2h2v-1.5h-2v-1z' });
			FroalaEditor.DefineIcon('textColor', {NAME: 'palette'}); // normally 'tint'
			FroalaEditor.DefineIcon('fontFamily', {NAME: 'font'}); // normally 'text'
			FroalaEditor.DefineIcon('fontSize', {NAME: 'text-size'}); // normally 'text-height'
		},

		registerEditorDropdowns: function()
		{
			var editorDropdowns;

			try
			{
				editorDropdowns = $.parseJSON($('.js-editorDropdowns').first().html()) || {};
			}
			catch (e)
			{
				console.error("Editor dropdowns data not valid: ", e);
				editorDropdowns = {};
			}

			for (var cmd in editorDropdowns)
			{
				if (!editorDropdowns.hasOwnProperty(cmd))
				{
					continue;
				}

				(function(cmd, button)
				{
					// removes the fa- prefix which we use internally
					button.icon = button.icon.substr(3);

					FroalaEditor.DefineIcon(cmd, { NAME: button.icon});
					FroalaEditor.RegisterCommand(cmd, {
						type: 'dropdown',
						title: button.title,
						icon: cmd,
						undo: false,
						focus: false,
						html: function()
						{
							var o = '<ul class="fr-dropdown-list">',
								options = button.buttons,
								c, info;

							var editor = XF.getEditorInContainer($(this.$oel));
							if (editor && editor.buttonManager)
							{
								// respect any removals if possible
								options = editor.buttonManager.getDropdown(cmd);
							}

							for (var i in options)
							{
								c = options[i];
								info = FroalaEditor.COMMANDS[c];
								if (info)
								{
									o += '<li><a class="fr-command" data-cmd="' + c + '">' + this.icon.create(info.icon || c) + '&nbsp;&nbsp;' + this.language.translate(info.title) + '</a></li>';
								}
							}
							o += '</ul>';

							return o;
						}
					});
				})(cmd, editorDropdowns[cmd]);
			}
		},

		registerDialogs: function()
		{
			XF.EditorHelpers.dialogs.media = new XF.EditorDialogMedia('media');
			XF.EditorHelpers.dialogs.spoiler = new XF.EditorDialogSpoiler('spoiler');
			XF.EditorHelpers.dialogs.code = new XF.EditorDialogCode('code');
		}
	};

	$(document).one('editor:start', XF.editorStart.startAll);

	XF.EditorPlaceholderClick = XF.Event.newHandler({
		eventNameSpace: 'XFEditorPlaceholderClick',
		options: {},

		edInitialized: false,

		init: function()
		{
		},

		click: function(e)
		{
			var $target = this.$target,
				t = this;

			$target.find('.editorPlaceholder-editor').removeClass('is-hidden');
			$target.find('.editorPlaceholder-placeholder').addClass('is-hidden');

			var editor = XF.getEditorInContainer($target);
			if (editor instanceof XF.Editor)
			{
				if (this.edInitialized)
				{
					return;
				}

				editor.startInit({
					beforeInit: function()
					{
						t.edInitialized = true;
					},
					afterInit: function(xfEd, froalaEd)
					{
						// initialized with a click so focus
						froalaEd.events.focus(true);

						if (XF.isIOS())
						{
							xfEd.scrollToCursor();
							xfEd.scrollToCursorAfterPendingResize();
						}

						if (froalaEd.opts.tooltips)
						{
							setTimeout(function()
							{
								// hide any tooltips that appeared as a result of the editor loading
								// as clicks in the placeholder may place the cursor over a button
								// and trigger a tooltip.
								froalaEd.tooltip.hide();
							}, 30);
						}
					}
				});
			}
			else
			{
				displayEditor();
				if (editor instanceof $)
				{
					editor.focus();
				}
			}
		}
	});

	XF.Event.register('click', 'editor-placeholder', 'XF.EditorPlaceholderClick');

	XF.Element.register('editor', 'XF.Editor');
}
(jQuery, window, document);
