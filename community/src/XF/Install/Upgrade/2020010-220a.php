<?php

namespace XF\Install\Upgrade;

use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;

class Version2020010 extends AbstractUpgrade
{
	public function getVersionName()
	{
		return '2.2.0 Alpha';
	}

	public function step1()
	{
		$this->createTable('xf_activity_summary_definition', function (Create $table)
		{
			$table->addColumn('definition_id', 'varbinary', 50);
			$table->addColumn('definition_class', 'varchar', 100);
			$table->addColumn('addon_id', 'varbinary', 50)->setDefault('');
			$table->addPrimaryKey('definition_id');
		});

		$this->createTable('xf_activity_summary_section', function (Create $table)
		{
			$table->addColumn('section_id', 'int')->autoIncrement();
			$table->addColumn('definition_id', 'varbinary', 50);
			$table->addColumn('display_order', 'int')->setDefault(0);
			$table->addColumn('show_value', 'tinyint', 3)->setDefault(1);
			$table->addColumn('options', 'blob');
			$table->addColumn('active', 'tinyint', 3)->setDefault(1);
		});

		$this->createTable('xf_api_login_token', function (Create $table)
		{
			$table->addColumn('login_token_id', 'int')->autoIncrement();
			$table->addColumn('login_token', 'varbinary', 32);
			$table->addColumn('user_id', 'int');
			$table->addColumn('expiry_date', 'int');
			$table->addColumn('limit_ip', 'varbinary', 16)->nullable();
			$table->addPrimaryKey('login_token_id');
			$table->addUniqueKey('login_token');
			$table->addKey('expiry_date');
		});

		$this->createTable('xf_content_vote', function (Create $table)
		{
			$table->addColumn('vote_id', 'int')->autoIncrement();
			$table->addColumn('content_type', 'varbinary', 25);
			$table->addColumn('content_id', 'int');
			$table->addColumn('vote_user_id', 'int');
			$table->addColumn('content_user_id', 'int');
			$table->addColumn('is_content_user_counted', 'tinyint', 3)->setDefault(1);
			$table->addColumn('score', 'int')->unsigned(false);
			$table->addColumn('vote_date', 'int');
			$table->addUniqueKey(['content_type', 'content_id', 'vote_user_id'], 'content_type_id_user');
			$table->addKey('vote_user_id');
			$table->addKey('content_user_id');
		});

		$this->createTable('xf_forum_type', function(Create $table)
		{
			$table->addColumn('forum_type_id', 'varbinary', 50);
			$table->addColumn('handler_class', 'varchar', 100);
			$table->addColumn('addon_id', 'varbinary', 50)->setDefault('');
			$table->addPrimaryKey('forum_type_id');
		});

		$this->createTable('xf_pre_reg_action', function (Create $table)
		{
			$table->addColumn('action_id', 'int')->autoIncrement();
			$table->addColumn('guest_key', 'varbinary', 75)->nullable();
			$table->addColumn('user_id', 'int')->nullable();
			$table->addColumn('content_id', 'int');
			$table->addColumn('ip_address', 'varbinary', 16)->setDefault('');
			$table->addColumn('last_update', 'int');
			$table->addColumn('action_class', 'varchar', 100);
			$table->addColumn('action_data', 'mediumblob');
			$table->addUniqueKey('guest_key');
			$table->addUniqueKey('user_id');
			$table->addKey('last_update');
		});

		$this->createTable('xf_search_forum', function (Create $table)
		{
			$table->addColumn('node_id', 'int');
			$table->addColumn('search_criteria', 'mediumblob');
			$table->addColumn('sort_order', 'varchar', 25)->setDefault('last_post_date');
			$table->addColumn('sort_direction', 'varchar', 5)->setDefault('desc');
			$table->addColumn('max_results', 'smallint', 5)->setDefault(200);
			$table->addColumn('cache_ttl', 'int')->setDefault(10);
			$table->addColumn('discussion_count', 'int')->setDefault(0);
			$table->addColumn('message_count', 'int')->setDefault(0);
			$table->addColumn('last_post_id', 'int')->setDefault(0);
			$table->addColumn('last_post_date', 'int')->setDefault(0);
			$table->addColumn('last_post_user_id', 'int')->setDefault(0);
			$table->addColumn('last_post_username', 'varchar', 50)->setDefault('');
			$table->addColumn('last_thread_id', 'int')->setDefault(0);
			$table->addColumn('last_thread_title', 'varchar', 150)->setDefault('');
			$table->addColumn('last_thread_prefix_id', 'int')->setDefault(0);
			$table->addPrimaryKey('node_id');
		});

		$this->createTable('xf_search_forum_cache', function (Create $table)
		{
			$table->addColumn('node_id', 'int');
			$table->addColumn('results', 'mediumblob');
			$table->addColumn('cache_date', 'int');
			$table->addPrimaryKey('node_id');
		});

		$this->createTable('xf_search_forum_cache_user', function (Create $table)
		{
			$table->addColumn('node_id', 'int');
			$table->addColumn('user_id', 'int');
			$table->addColumn('results', 'mediumblob');
			$table->addColumn('cache_date', 'int');
			$table->addPrimaryKey(['node_id', 'user_id']);
		});

		$this->createTable('xf_thread_question', function (Create $table)
		{
			$table->addColumn('thread_id', 'int');
			$table->addColumn('solution_post_id', 'int')->setDefault(0);
			$table->addColumn('solution_user_id', 'int')->setDefault(0);
			$table->addPrimaryKey('thread_id');
		});

		$this->createTable('xf_thread_type', function(Create $table)
		{
			$table->addColumn('thread_type_id', 'varbinary', 50);
			$table->addColumn('handler_class', 'varchar', 100);
			$table->addColumn('addon_id', 'varbinary', 50)->setDefault('');
			$table->addPrimaryKey('thread_type_id');
		});

		$this->createTable('xf_username_change', function (Create $table)
		{
			$table->addColumn('change_id', 'int')->autoIncrement();
			$table->addColumn('user_id', 'int');
			$table->addColumn('old_username', 'varchar', 50);
			$table->addColumn('new_username', 'varchar', 50);
			$table->addColumn('change_reason', 'varchar', 200)->setDefault('');
			$table->addColumn('change_state', 'enum')->values(['moderated', 'approved', 'rejected'])->setDefault('approved');
			$table->addColumn('change_user_id', 'int');
			$table->addColumn('change_date', 'int');
			$table->addColumn('moderator_user_id', 'int')->setDefault(0);
			$table->addColumn('reject_reason', 'varchar', 200)->setDefault('');
			$table->addColumn('visible', 'tinyint')->setDefault(1);
			$table->addKey('change_date');
			$table->addKey(['old_username', 'change_state', 'change_date'], 'old_username_state_date');
			$table->addKey(['new_username', 'change_state'], 'new_username_state');
			$table->addKey(['user_id', 'change_state', 'change_date'], 'user_id_state_date');
		});
	}

	public function step2()
	{
		$this->alterTable('xf_admin', function (Alter $table)
		{
			$table->addColumn('advanced', 'tinyint', 3)->setDefault(0)->after('admin_language_id');
		});

		$this->alterTable('xf_forum', function (Alter $table)
		{
			$table->addColumn('allow_index', 'enum')->values(['allow', 'deny', 'criteria'])->setDefault('allow')->after('find_new');
			$table->addColumn('index_criteria', 'blob')->after('allow_index');
			$table->addColumn('forum_type_id', 'varbinary', 50)->setDefault('discussion');
			$table->addColumn('type_config', 'mediumblob');
		});

		$this->alterTable('xf_language', function (Alter $table)
		{
			$table->addColumn('user_selectable', 'bool')->setDefault(1);
		});

		$this->alterTable('xf_member_stat', function (Alter $table)
		{
			$table->addColumn('visibility_class', 'varchar', 100)->setDefault('')->after('callback_method');
			$table->addColumn('visibility_method', 'varchar', 75)->setDefault('')->after('visibility_class');
		});

		$this->alterTable('xf_upgrade_check', function (Alter $table)
		{
			$table->addColumn('installable_add_ons', 'blob')->nullable()->after('invalid_add_ons');
		});
	}

	public function step3()
	{
		$this->alterTable('xf_option', function (Alter $table)
		{
			$table->addColumn('advanced', 'tinyint', 3)
				->setDefault(0)
				->after('validation_method');
		});

		$this->alterTable('xf_option_group', function (Alter $table)
		{
			$table->addColumn('advanced', 'tinyint', 3)
				->setDefault(0)
				->after('debug_only');
		});

		$this->alterTable('xf_style', function (Alter $table)
		{
			$table->addColumn('assets', 'mediumblob')->after('properties');
			$table->addColumn('effective_assets', 'mediumblob')->after('assets');
		});

		$this->alterTable('xf_thread_field', function (Alter $table)
		{
			$table->addColumn('wrapper_template', 'text')->after('display_template');
		});

		$this->alterTable('xf_user_field', function (Alter $table)
		{
			$table->addColumn('wrapper_template', 'text')->after('display_template');
		});
	}

	public function step4()
	{
		$this->alterTable('xf_attachment_data', function (Alter $table)
		{
			$table->changeColumn('file_size', 'bigint');
		});
	}

	public function step5()
	{
		$this->alterTable('xf_attachment', function(Alter $table)
		{
			$table->addKey('data_id');
		});
	}

	public function step6()
	{
		$this->alterTable('xf_conversation_master', function (Alter $table)
		{
			$table->addKey('last_message_user_id');
		});
	}

	public function step7()
	{
		$this->alterTable('xf_conversation_user', function (Alter $table)
		{
			$table->addKey('last_message_user_id');
		});
	}

	public function step8()
	{
		$this->alterTable('xf_image_proxy', function (Alter $table)
		{
			$table->changeColumn('file_size', 'bigint');
		});
	}

	public function step9()
	{
		$this->alterTable('xf_moderator_log', function (Alter $table)
		{
			$table->addKey('content_user_id');
		});
	}

	public function step10()
	{
		$this->alterTable('xf_post', function (Alter $table)
		{
			$table->addColumn('type_data', 'mediumblob')->after('position');
			$table->addColumn('vote_score', 'int')->unsigned(false);
			$table->addColumn('vote_count', 'int')->setDefault(0);
			$table->addKey(
				['thread_id', ['vote_score', 'descending' => true], 'post_date'],
				'thread_id_score_date'
			);
		});
	}

	public function step11()
	{
		$this->alterTable('xf_reaction_content', function (Alter $table)
		{
			$table->addKey(['content_user_id', 'is_counted', 'reaction_id', 'reaction_date']);
			$table->addKey('reaction_user_id');
		});
	}

	public function step12()
	{
		$this->alterTable('xf_report', function (Alter $table)
		{
			$table->addKey('last_modified_user_id');
		});
	}

	public function step13()
	{
		$this->alterTable('xf_thread', function (Alter $table)
		{
			$table->addColumn('vote_score', 'int')->unsigned(false);
			$table->addColumn('vote_count', 'int')->setDefault(0);
			$table->addColumn('type_data', 'mediumblob');
			$table->addKey(['node_id', 'sticky', 'discussion_state', 'vote_score'], 'node_id_sticky_state_vote_score');
			$table->addKey('last_post_user_id');
		});
	}

	public function step14()
	{
		$this->alterTable('xf_user', function (Alter $table)
		{
			$table->addColumn('username_date', 'int')->setDefault(0)->after('username');
			$table->addColumn('username_date_visible', 'int')->setDefault(0)->after('username_date');
			$table->addColumn('security_lock', 'enum')->values(['', 'change', 'reset'])->setDefault('')->after('user_state');
			$table->addColumn('vote_score', 'int')->unsigned(false)->setDefault(0);
			$table->addColumn('last_summary_email_date', 'int')->nullable()->after('last_activity');
			$table->addColumn('question_solution_count', 'int')->setDefault(0)->after('message_count');
			$table->addColumn('alerts_unviewed', 'smallint', 5)->setDefault(0)->after('trophy_points');

			$table->addKey('vote_score');
			$table->addKey('last_summary_email_date');
			$table->addKey('permission_combination_id');
			$table->addKey('question_solution_count');
		});
	}

	public function step15()
	{
		$this->alterTable('xf_user_alert', function (Alter $table)
		{
			$table->addColumn('read_date', 'int')->setDefault(0)->after('view_date');
			$table->addColumn('auto_read', 'tinyint')->setDefault(1)->after('read_date');

			// index is superseded
			$table->dropIndexes('contentType_contentId');

			// for basic content type lookups
			$table->addKey(['content_type', 'content_id', 'user_id']);

			// primarily for looking up active alerts for a user from a set of content -- content_id will generally
			// be a multiple element list, so further columns aren't particularly helpful
			$table->addKey(['alerted_user_id', 'content_type', 'content_id']);

			// for unviewed calculations
			$table->addKey(['alerted_user_id', 'view_date']);

			// for unread calculations
			$table->addKey(['alerted_user_id', 'read_date']);
		});
	}

	public function step16()
	{
		$this->alterTable('xf_user_profile', function (Alter $table)
		{
			$table->addColumn('banner_date', 'int')->setDefault(0)->after('avatar_crop_y');
			$table->addColumn('banner_position_y', 'tinyint')->nullable()->after('banner_date');
		});
	}

	public function step17()
	{
		$this->alterTable('xf_profile_post_comment', function (Alter $table)
		{
			$table->addColumn('attach_count', 'smallint', 5)->setDefault(0)->after('message_state');
		});
	}

	// Convert username changes to the new log
	public function step18($position, array $stepData)
	{
		$perPage = 1000;
		$db = $this->db();

		if (!isset($stepData['max']))
		{
			$stepData['max'] = $db->fetchOne("SELECT MAX(content_id) FROM xf_change_log WHERE content_type = 'user' AND field = 'username'");
		}

		$userIds = $db->fetchAllColumn($db->limit("
			SELECT DISTINCT(content_id)
			FROM xf_change_log
			WHERE content_id > ? AND content_type = 'user' AND field = 'username' 
			ORDER BY content_id
		", $perPage), $position);

		if (!$userIds)
		{
			return true;
		}

		$em = $this->app->em();
		$db->beginTransaction();

		$next = 0;
		foreach ($userIds AS $userId)
		{
			$next = $userId;

			$changes = $db->fetchAll("
				SELECT 
					content_id AS user_id,
					old_value AS old_username,
					new_value AS new_username,
					'approved' AS change_state,
					edit_user_id AS change_user_id,
					edit_date AS change_date,
					0 AS moderator_user_id,
					'' AS reject_reason,
					0 AS visible
				FROM xf_change_log
				WHERE content_id = ? AND content_type = 'user' AND field = 'username'
				ORDER BY change_date
			", $userId);

			if (!$changes)
			{
				continue;
			}

			$inserts = [];

			foreach ($changes AS $change)
			{
				// we don't have any unique constraints but this ensures dupes aren't introduced
				// in the event that this upgrade step is somehow run multiple times
				$exists = $em->findOne('XF:UsernameChange', $change);

				if ($exists)
				{
					continue;
				}

				$inserts[] = $change;
			}

			if ($inserts)
			{
				$db->insertBulk('xf_username_change', $inserts);

				$dates = array_column($inserts, 'change_date');
				$db->update('xf_user', ['username_date' => end($dates)], 'user_id = ?', $userId);
			}
		}

		$db->commit();

		return [
			$next,
			"$next / $stepData[max]",
			$stepData
		];
	}

	public function step19()
	{
		$this->executeUpgradeQuery("
			UPDATE xf_user_privacy
			SET allow_post_profile = 'members'
			WHERE allow_post_profile = 'everyone'
		");

		$this->executeUpgradeQuery("
			UPDATE xf_user_privacy
			SET allow_send_personal_conversation = 'members'
			WHERE allow_send_personal_conversation = 'everyone'
		");
	}

	public function step20()
	{
		// note this is intentionally separate from other alters as the updates are needed first
		$this->alterTable('xf_user_privacy', function (Alter $table)
		{
			$table->changeColumn('allow_post_profile')
				->removeValues('everyone')
				->setDefault('members');

			$table->changeColumn('allow_send_personal_conversation')
				->removeValues('everyone')
				->setDefault('members');
		});
	}

	public function step21()
	{
		// if opted-in to admin emails also opt-in to activity summary
		// emails but in a paused state (0) to avoid excessive emails
		$this->executeUpgradeQuery("
			UPDATE xf_user AS u
			INNER JOIN xf_user_option AS uo ON
				(u.user_id = uo.user_id)
			SET u.last_summary_email_date = 0
			WHERE uo.receive_admin_email = 1
		");
	}

	public function step22()
	{
		if (!$this->columnExists('xf_forum', 'allow_poll'))
		{
			return;
		}

		$this->executeUpgradeQuery("
			UPDATE xf_forum
			SET type_config = IF(allow_poll = 1,
			    '{\"allowed_thread_types\":[\"poll\"]}',
			    '{\"allowed_thread_types\":[]}'
			)
		");

		$this->alterTable('xf_forum', function(Alter $table)
		{
			$table->dropColumns('allow_poll');
		});
	}

	public function step23()
	{
		$this->db()->update(
			'xf_thread',
			['discussion_type' => 'discussion'],
			"discussion_type = ''"
		);
	}

	protected function getEditorButtonDefault(): array
	{
		return [
			'toolbarButtons' => [
				'moreText' => [
					'buttons' => [
						'clearFormatting',
						'bold',
						'italic',
						'fontSize',
						'textColor',
						'fontFamily',
						'strikeThrough',
						'underline',
						'xfInlineCode',
						'xfInlineSpoiler',
					],
					'buttonsVisible' => '5',
					'align' => 'left',
					'icon' => 'fa-ellipsis-v',
				],
				'moreParagraph' => [
					'buttons' => [
						'xfList',
						'align',
						'paragraphFormat',
					],
					'buttonsVisible' => '3',
					'align' => 'left',
					'icon' => 'fa-ellipsis-v',
				],
				'moreRich' => [
					'buttons' => [
						'insertLink',
						'insertImage',
						'xfSmilie',
						'xfMedia',
						'xfQuote',
						'insertTable',
						'insertHR',
						'insertVideo',
						'xfSpoiler',
						'xfCode',
					],
					'buttonsVisible' => '6',
					'align' => 'left',
					'icon' => 'fa-ellipsis-v',
				],
				'moreMisc' => [
					'buttons' => [
						'undo',
						'redo',
						'xfBbCode',
						'xfDraft',
					],
					'buttonsVisible' => '4',
					'align' => 'right',
					'icon' => '',
				],
			],
			'toolbarButtonsMD' => [
				'moreText' => [
					'buttons' => [
						'bold',
						'italic',
						'fontSize',
						'textColor',
						'fontFamily',
						'strikeThrough',
						'underline',
						'xfInlineCode',
						'xfInlineSpoiler',
					],
					'buttonsVisible' => '3',
					'align' => 'left',
					'icon' => 'fa-ellipsis-v',
				],
				'moreParagraph' => [
					'buttons' => [
						'xfList',
						'align',
						'paragraphFormat',
					],
					'buttonsVisible' => '3',
					'align' => 'left',
					'icon' => 'fa-ellipsis-v',
				],
				'moreRich' => [
					'buttons' => [
						'insertLink',
						'insertImage',
						'xfSmilie',
						'insertVideo',
						'xfMedia',
						'xfQuote',
						'insertTable',
						'insertHR',
						'xfSpoiler',
						'xfCode',
					],
					'buttonsVisible' => '2',
					'align' => 'left',
					'icon' => 'fa-ellipsis-v',
				],
				'moreMisc' => [
					'buttons' => [
						'undo',
						'redo',
						'clearFormatting',
						'xfBbCode',
						'xfDraft',
					],
					'buttonsVisible' => '1',
					'align' => 'right',
					'icon' => '',
				],
			],
			'toolbarButtonsSM' => [
				'moreText' => [
					'buttons' => [
						'bold',
						'italic',
						'fontSize',
						'textColor',
						'fontFamily',
						'strikeThrough',
						'underline',
						'xfInlineCode',
						'xfInlineSpoiler',
					],
					'buttonsVisible' => '2',
					'align' => 'left',
					'icon' => 'fa-ellipsis-v',
				],
				'moreParagraph' => [
					'buttons' => [
						'xfList',
						'align',
						'paragraphFormat'
					],
					'buttonsVisible' => '1',
					'align' => 'left',
					'icon' => 'fa-ellipsis-v',
				],
				'moreRich' => [
					'buttons' => [
						'insertLink',
						'insertImage',
						'xfSmilie',
						'xfQuote',
						'insertVideo',
						'xfMedia',
						'insertTable',
						'insertHR',
						'xfSpoiler',
						'xfCode',
					],
					'buttonsVisible' => '3',
					'align' => 'left',
					'icon' => 'fa-ellipsis-v',
				],
				'moreMisc' => [
					'buttons' => [
						'undo',
						'redo',
						'xfBbCode',
						'clearFormatting',
						'xfDraft',
					],
					'buttonsVisible' => '1',
					'align' => 'right',
					'icon' => '',
				],
			],
			'toolbarButtonsXS' => [
				'moreText' => [
					'buttons' => [
						'bold',
						'italic',
						'fontSize',
						'textColor',
						'fontFamily',
						'xfList',
						'align',
						'paragraphFormat',
						'strikeThrough',
						'underline',
						'xfInlineSpoiler',
						'xfInlineCode',
					],
					'buttonsVisible' => '2',
					'align' => 'left',
					'icon' => 'fa-ellipsis-v',
				],
				'moreParagraph' => [
					'buttons' => [],
					'buttonsVisible' => '0',
					'align' => 'left',
					'icon' => 'fa-ellipsis-v',
				],
				'moreRich' => [
					'buttons' => [
						'insertLink',
						'insertImage',
						'xfSmilie',
						'xfQuote',
						'insertVideo',
						'xfMedia',
						'insertTable',
						'insertHR',
						'xfSpoiler',
						'xfCode',
					],
					'buttonsVisible' => '2',
					'align' => 'left',
					'icon' => 'fa-ellipsis-v',
				],
				'moreMisc' => [
					'buttons' => [
						'undo',
						'redo',
						'xfBbCode',
						'clearFormatting',
						'xfDraft',
					],
					'buttonsVisible' => '1',
					'align' => 'right',
					'icon' => '',
				],
			],
		];
	}

	public function step24()
	{
		$db = $this->db();

		$newToolbars = $this->getEditorButtonDefault();
		$customInsertGroup = 'moreRich';

		$standardButtons = [
			"-hs",
			"-vs",
			"align",
			"bold",
			"clearFormatting",
			"color",
			"fontFamily",
			"fontSize",
			"formatOL",
			"formatUL",
			"indent",
			"insertImage",
			"insertLink",
			"insertTable",
			"insertVideo",
			"italic",
			"outdent",
			"redo",
			"strikeThrough",
			"textColor", // probably won't be there -- this is Froala 3
			"underline",
			"undo",
			"xfBbCode",
			"xfCode",
			"xfDraft",
			"xfInlineCode",
			"xfInlineSpoiler",
			"xfList",
			"xfMedia",
			"xfQuote",
			"xfSmilie",
			"xfSpoiler",
		];

		$dropdowns = json_decode($db->fetchOne("
			SELECT option_value
			FROM xf_option
			WHERE option_id = 'editorDropdownConfig'
		"), true);

		$existingToolbarConfig = json_decode($db->fetchOne("
			SELECT option_value
			FROM xf_option
			WHERE option_id = 'editorToolbarConfig'
		"), true);

		if (isset($existingToolbarConfig['toolbarButtons']['moreRich']))
		{
			// already been converted
			return;
		}

		$db->beginTransaction();

		foreach ($dropdowns AS $dropdownId => &$dropdown)
		{
			if ($dropdownId === 'xfList')
			{
				// we want to keep this by default
				continue;
			}

			$buttonsChanged = false;

			foreach ($dropdown['buttons'] AS $i => $button)
			{
				if (in_array($button, $standardButtons))
				{
					unset($dropdown['buttons'][$i]);
					$buttonsChanged = true;
				}
			}

			if (!$dropdown['buttons'])
			{
				// Dropdown is empty, so remove or disable. Consider it to be a "standard" button and it won't
				// be moved into the new layout.
				$standardButtons[] = $dropdownId;

				switch ($dropdownId)
				{
					case 'xfInsert':
						// these are default dropdowns from before so just get rid of them
						$db->delete('xf_editor_dropdown', 'cmd = ?', $dropdownId);
						$db->delete('xf_phrase', 'title = ? AND language_id = 0', "editor_dropdown.{$dropdownId}");
						break;

					default:
						// these are custom dropdowns so disable them
						$db->update('xf_editor_dropdown', ['active' => 0], 'cmd = ? ', $dropdownId);
				}

				unset($dropdowns[$dropdownId]);
			}
			else if ($buttonsChanged)
			{
				// we still have buttons but they're different, so update the dropdown
				$db->update(
					'xf_editor_dropdown',
					['buttons' => json_encode($dropdown['buttons'])],
					'cmd = ?',
					$dropdownId
				);
			}
		}

		foreach ($existingToolbarConfig AS $toolbarType => $buttons)
		{
			foreach ($buttons AS $button)
			{
				if (!in_array($button, $standardButtons))
				{
					$newToolbars[$toolbarType][$customInsertGroup]['buttons'][] = $button;
				}
			}
		}

		$db->update(
			'xf_option',
			['option_value' => json_encode($dropdowns)],
			"option_id = 'editorDropdownConfig'"
		);
		$db->update(
			'xf_option',
			['option_value' => json_encode($newToolbars)],
			"option_id = 'editorToolbarConfig'"
		);

		$db->commit();
	}

	public function step25()
	{
		$this->executeUpgradeQuery("
			UPDATE xf_user_alert
			SET read_date = view_date
		");
	}

	public function step26()
	{
		$this->executeUpgradeQuery("
			UPDATE xf_user
			SET alerts_unviewed = alerts_unread
		");
	}

	public function step27()
	{
		$this->addThreadPrefixDescHelpPhrases();

		$this->db()->query("
			INSERT IGNORE INTO xf_phrase
				(language_id, title, phrase_text, global_cache, addon_id)
			VALUES
				(0, 'activity_summary_section.1', '', 0, ''),
				(0, 'activity_summary_section.2', '', 0, '')
		");

		$this->db()->query("
			INSERT IGNORE INTO `xf_activity_summary_section` 
			    (`section_id`, `definition_id`, `display_order`, `options`)
			VALUES
				(1, 'latest_threads',   100,    '[]'),
				(2, 'latest_posts',     200,    '[]')
		");

		$this->db()->insert(
			'xf_node_type',
			[
				'node_type_id' => 'SearchForum',
				'entity_identifier' => 'XF:SearchForum',
				'permission_group_id' => 'searchForum',
				'admin_route' => 'search-forums',
				'public_route' => 'search-forums',
				'handler_class' => 'XF:SearchForum'
			],
			true
		);

		$this->db()->emptyTable('xf_mail_queue');
	}

	public function addThreadPrefixDescHelpPhrases()
	{
		$inserts = [];
		$prefixIds = $this->db()->fetchAllColumn("SELECT prefix_id FROM `xf_thread_prefix`");
		$contentType = 'thread';

		foreach ($prefixIds AS $prefixId)
		{
			$inserts[] = sprintf("(0, '%s_prefix_%s.%d', '')", $contentType, 'desc', $prefixId);
			$inserts[] = sprintf("(0, '%s_prefix_%s.%d', '')", $contentType, 'help', $prefixId);
		}

		if ($inserts)
		{
			$this->executeUpgradeQuery("
				INSERT IGNORE INTO xf_phrase
				    (language_id, title, phrase_text)
				VALUES
					" . implode(",\n", $inserts)
			);
		}
	}

	public function step28()
	{
		// don't trigger rebuilds here as it's possible the code will fail -- it's triggered by the core cache rebuild
		$this->insertForumType('article', 'XF:Article', 'XF', false);
		$this->insertForumType('discussion', 'XF:Discussion', 'XF', false);
		$this->insertForumType('question', 'XF:Question', 'XF', false);
		$this->insertForumType('suggestion', 'XF:Suggestion', 'XF', false);

		$this->insertThreadType('article', 'XF:Article', 'XF', false);
		$this->insertThreadType('discussion', 'XF:Discussion', 'XF', false);
		$this->insertThreadType('poll', 'XF:Poll', 'XF', false);
		$this->insertThreadType('question', 'XF:Question', 'XF', false);
		$this->insertThreadType('redirect', 'XF:Redirect', 'XF', false);
		$this->insertThreadType('suggestion', 'XF:Suggestion', 'XF', false);
	}

	public function step29()
	{
		$this->applyGlobalPermission('profileBanner', 'allowed', 'avatar', 'allowed');
		$this->applyGlobalPermission('general', 'changeUsername', 'general', 'editProfile');
		$this->applyGlobalPermission('general', 'approveUsernameChange', 'general', 'approveRejectUser');
		$this->applyGlobalPermission('general', 'bypassNofollowLinks', 'general', 'viewIps');

		// Don't give this to the unconfirmed group as it may not be obvious.
		// If it's desired, it can be explicitly added.
		$this->executeUpgradeQuery("
			DELETE FROM xf_permission_entry
			WHERE user_group_id = 1
				AND user_id = 0
				AND permission_group_id = 'general'
				AND permission_id = 'changeUsername'
		");

		$this->applyGlobalPermission('forum', 'contentVote', 'forum', 'react');
		$this->applyContentPermission('forum', 'contentVote', 'forum', 'react');

		$this->applyGlobalPermission('forum', 'markSolution', 'forum', 'postThread');
		$this->applyContentPermission('forum', 'markSolution', 'forum', 'postThread');

		$this->applyGlobalPermission('forum', 'markSolutionAnyThread', 'forum', 'manageAnyThread');
		$this->applyContentPermission('forum', 'markSolutionAnyThread', 'forum', 'manageAnyThread');

		// profile post / comment attachment permissions
		$this->applyGlobalPermission('profilePost', 'viewAttachment', 'forum', 'viewAttachment');
		$this->applyGlobalPermission('profilePost', 'uploadAttachment', 'conversation', 'uploadAttachment');
		$this->applyGlobalPermission('profilePost', 'uploadVideo', 'conversation', 'uploadVideo');
	}
}