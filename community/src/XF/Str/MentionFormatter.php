<?php

namespace XF\Str;

use function count, strlen;

class MentionFormatter
{
	const STRUCTURED_MENTION_REGEX = '#(?<=^|\s|[\](,/\'"]|--|@)@\[(\d+):(\'|"|&quot;|)(.*)\\2\]#iU';

	protected $placeholders = [];
	protected $mentionedUsers = [];

	public function getMentionsBbCode($message)
	{
		$disabledTags = array_map(
			function($v) { return preg_quote($v, '#'); },
			$this->getMentionDisabledBbCodeTags()
		);
		$message = $this->setupPlaceholders($message,
			'#\[(' . implode('|', $disabledTags) . ')([= ][^\]]*)?](.*)\[/\\1]#siU'
		);

		$matches = $this->getPossibleMentionMatches($message);
		$usersByMatch = $this->getMentionMatchUsers($matches);

		$prefix = \XF::options()->userMentionKeepAt ? '@' : '';

		$message = $this->applyMentionUserMatches(
			$message, $matches, $usersByMatch,
			function($user) use ($prefix)
			{
				return '[USER=' . $user['user_id'] . ']' . $prefix . $user['username'] . '[/USER]';
			}
		);

		$message = $this->restorePlaceholders($message);

		return $message;
	}

	protected function getMentionDisabledBbCodeTags(): array
	{
		$bbCodeRules = \XF::app()->bbCode()->rules('mentions');

		$disabledTags = [];
		foreach ($bbCodeRules->getTags() AS $tagName => $tag)
		{
			if (!empty($tag['stopAutoLink']) || !empty($tag['plain']))
			{
				$disabledTags[] = $tagName;
			}
		}

		// technically mentions can be parsed in quotes, but it's likely they already have
		// and this isn't necessarily text that we want to attribute to the poster
		$disabledTags[] = 'quote';

		return $disabledTags;
	}

	public function getMentionsStructuredText($message)
	{
		$message = $this->setupPlaceholders($message, self::STRUCTURED_MENTION_REGEX);

		$matches = $this->getPossibleMentionMatches($message);
		$usersByMatch = $this->getMentionMatchUsers($matches);

		$prefix = \XF::options()->userMentionKeepAt ? '@' : '';

		$message = $this->applyMentionUserMatches(
			$message, $matches, $usersByMatch,
			function($user) use ($prefix)
			{
				if (strpos($user['username'], ']') !== false)
				{
					if (strpos($user['username'], "'") !== false)
					{
						$username = '"' . $prefix . $user['username'] . '"';
					}
					else
					{
						$username = "'" . $prefix . $user['username'] . "'";
					}
				}
				else
				{
					$username = $prefix . $user['username'];
				}
				return '@[' . $user['user_id'] . ':' . $username . ']';
			}
		);

		$message = $this->restorePlaceholders($message);

		return $message;
	}

	public function getMentionedUsers()
	{
		return $this->mentionedUsers;
	}

	protected function setupPlaceholders($message, $regex)
	{
		$this->placeholders = [];

		return preg_replace_callback($regex, function($match)
		{
			$replace = "\x1A" . count($this->placeholders) . "\x1A";
			$this->placeholders[$replace] = $match[0];

			return $replace;
		}, $message);
	}

	protected function restorePlaceholders($message)
	{
		if ($this->placeholders)
		{
			$message = strtr($message, $this->placeholders);
			$this->placeholders = [];
		}

		return $message;
	}

	protected function getPossibleMentionMatches($message)
	{
		$min = 2;

		if (!preg_match_all(
			'#(?<=^|\s|[\](,/\'"]|--)@(?!\[|\s)(([^\s@]|(?<![\s\](,-])@| ){' . $min . '}((?>[:,.!?](?=[^\s:,.!?[\]()])|' . $this->getTagEndPartialRegex(true) . '+?))*)#iu',
			$message, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER
		))
		{
			return [];
		}

		return $matches;
	}

	protected function getTagEndPartialRegex($negated)
	{
		return '[' . ($negated ? '^' : '') . ':;,.!?\s@\'"*/)\]\[-]';
	}

	protected function getMentionMatchUsers(array $matches)
	{
		$db = \XF::db();
		$matchKeys = array_keys($matches);
		$whereParts = [];
		$matchParts = [];
		$usersByMatch = [];

		foreach ($matches AS $key => $match)
		{
			if (utf8_strlen($match[1][0]) > 50)
			{
				// longer than max username length
				continue;
			}

			$sql = 'user.username LIKE ' . $db->quote($db->escapeLike($match[1][0], '?%'));
			$whereParts[] = $sql;
			$matchParts[] = 'IF(' . $sql . ', 1, 0) AS match_' . $key;
		}

		if (!$whereParts)
		{
			return [];
		}

		$userResults = $db->query("
			SELECT user.user_id, user.username,
				" . implode(', ', $matchParts) . "
			FROM xf_user AS user
			WHERE (" . implode(' OR ', $whereParts) . ")
			ORDER BY LENGTH(user.username) DESC
		");
		while ($user = $userResults->fetch())
		{
			$userInfo = [
				'user_id' => $user['user_id'],
				'username' => $user['username'],
				'lower' => utf8_strtolower($user['username'])
			];

			foreach ($matchKeys AS $key)
			{
				if (!empty($user["match_$key"]))
				{
					$usersByMatch[$key][$user['user_id']] = $userInfo;
				}
			}
		}

		return $usersByMatch;
	}

	protected function applyMentionUserMatches($message, array $matches, array $usersByMatch, \Closure $tagReplacement)
	{
		$this->mentionedUsers = [];

		if (!$usersByMatch)
		{
			return $message;
		}

		$newMessage = '';
		$lastOffset = 0;
		$mentionedUsers = [];
		$endMatch = $this->getTagEndPartialRegex(false);

		foreach ($matches AS $key => $match)
		{
			if ($match[0][1] > $lastOffset)
			{
				$newMessage .= substr($message, $lastOffset, $match[0][1] - $lastOffset);
			}
			else if ($lastOffset > $match[0][1])
			{
				continue;
			}

			$lastOffset = $match[0][1] + strlen($match[0][0]);

			$haveMatch = false;
			if (!empty($usersByMatch[$key]))
			{
				$testName = utf8_strtolower($match[1][0]);
				$testOffset = $match[1][1];

				foreach ($usersByMatch[$key] AS $userId => $user)
				{
					// It's possible for the byte length to change between the lower and standard versions
					// due to conversions like İ -> i (2 byte to 1). Therefore, we try to check whether either
					// length matches the name.
					$lowerLen = strlen($user['lower']);
					$originalLen = strlen($user['username']);

					if ($testName === $user['lower'])
					{
						$nameLen = $lowerLen;
					}
					else if (utf8_strtolower(substr($message, $testOffset, $lowerLen)) === $user['lower'])
					{
						$nameLen = $lowerLen;
					}
					else if (
						$lowerLen !== $originalLen
						&& utf8_strtolower(substr($message, $testOffset, $originalLen)) === $user['lower']
					)
					{
						$nameLen = $originalLen;
					}
					else
					{
						$nameLen = null;
					}

					$nextTestOffsetStart = $testOffset + ($nameLen ?: 0);

					if (
						$nameLen
						&& (
							!isset($message[$nextTestOffsetStart])
							|| preg_match('#' . $endMatch . '#i', $message[$nextTestOffsetStart])
						)
					)
					{
						$mentionedUsers[$userId] = $user;
						$newMessage .= $tagReplacement($user);
						$haveMatch = true;
						$lastOffset = $testOffset + strlen($user['username']);
						break;
					}
				}
			}

			if (!$haveMatch)
			{
				$newMessage .= $match[0][0];
			}
		}

		$newMessage .= substr($message, $lastOffset);

		$this->mentionedUsers = $mentionedUsers;

		return $newMessage;
	}
}