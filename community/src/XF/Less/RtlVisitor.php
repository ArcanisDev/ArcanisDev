<?php

namespace XF\Less;

use function count, is_array, strlen;

class RtlVisitor extends \Less_VisitorReplacing
{
	/**
	 * @var bool[]
	 */
	protected $shorthandProperties = [
		'margin' => true,
		'padding' => true,
		'border-color' => true,
		'border-width' => true,
		'border-radius' => true,
		'border-style' => true,
	];

	/**
	 * @var bool[]
	 */
	protected $keywordProperties = [
		'float' => true,
		'text-align' => true,
		'clear' => true
	];

	/**
	 * @var bool
	 */
	protected $doReverseKeywords = false;

	/**
	 * @var string
	 */
	protected $doReorderShorthand = '';

	/**
	 * @var int
	 */
	protected $disabledCount = 0;

	/**
	 * @var bool
	 */
	protected $isRtl = false;

	public function __construct(bool $isRtl)
	{
		parent::__construct();

		$this->isRtl = $isRtl;
	}

	public function run(\Less_Tree_Ruleset $root)
	{
		return $this->visitObj($root);
	}

	public function isRtl(): bool
	{
		return $this->isRtl;
	}

	/**
	 * @return \Less_Tree_Comment|null
	 */
	public function visitComment(\Less_Tree_Comment $comment)
	{
		if ($comment instanceof CommentRtl)
		{
			if ($comment->rtlMode == 'enable')
			{
				if ($this->disabledCount > 0)
				{
					$this->disabledCount--;
				}
			}
			else
			{
				$this->disabledCount++;
			}

			return null;
		}
		else
		{
			return $comment;
		}
	}

	/**
	 * @return \Less_Tree_Rule|null
	 */
	public function visitRule(\Less_Tree_Rule $ruleNode)
	{
		if ($ruleNode->variable || $this->disabledCount)
		{
			return $ruleNode;
		}

		$nodeName = $this->processNodeName($ruleNode->name);
		if (!$nodeName)
		{
			return null;
		}

		if ($nodeName != $ruleNode->name)
		{
			return new \Less_Tree_Rule(
				$nodeName,
				$ruleNode->value,
				$ruleNode->important,
				$ruleNode->merge,
				$ruleNode->index,
				$ruleNode->currentFileInfo,
				$ruleNode->inline
			);
		}
		else
		{
			return $ruleNode;
		}
	}

	public function visitRuleOut()
	{
		$this->resetForNewRule();
	}

	/**
	 * @return \Less_Tree_NameValue|null
	 */
	public function visitNameValue(\Less_Tree_NameValue $nameValue)
	{
		if ($this->disabledCount)
		{
			return $nameValue;
		}

		$nodeName = $this->processNodeName($nameValue->name);
		if (!$nodeName)
		{
			return null;
		}

		$value = $nameValue->value;
		if (substr($value, -11) == ' !important')
		{
			$value = substr($value, 0, -11);
			$important = ' !important';
		}
		else
		{
			$important = '';
		}

		$reversed = $this->reverseKeyword($value);

		if ($nodeName != $nameValue->name || $reversed)
		{
			return new \Less_Tree_NameValue(
				$nodeName,
				($reversed ?: $value) . $important,
				$nameValue->index,
				$nameValue->currentFileInfo
			);
		}
		else
		{
			return $nameValue;
		}
	}

	public function visitNameValueOut()
	{
		$this->resetForNewRule();
	}

	/**
	 * @return \Less_Tree_Anonymous|null
	 */
	public function visitAnonymous(\Less_Tree_Anonymous $anonymous)
	{
		$reversed = $this->reverseKeyword($anonymous->value);
		if ($reversed)
		{
			return new \Less_Tree_Anonymous(
				$reversed,
				$anonymous->index,
				$anonymous->currentFileInfo,
				$anonymous->mapLines
			);
		}

		// When not compressing, an anonymous value is output for simple cases ("1px 2px 3px 4px") so we need
		// to account for that.
		if ($this->doReorderShorthand)
		{
			$parts = preg_split('/\s+/', $anonymous->value);
			if (count($parts) == 4)
			{
				if ($this->doReorderShorthand === 'radius')
				{
					$value = "$parts[1] $parts[0] $parts[3] $parts[2]";
				}
				else
				{
					$value = "$parts[0] $parts[3] $parts[2] $parts[1]";
				}

				return new \Less_Tree_Anonymous(
					$value,
					$anonymous->index,
					$anonymous->currentFileInfo,
					$anonymous->mapLines
				);
			}
		}

		return $anonymous;
	}

	/**
	 * @return \Less_Tree_Keyword|null
	 */
	public function visitKeyword(\Less_Tree_Keyword $keyword)
	{
		$reversed = $this->reverseKeyword($keyword->value);
		if ($reversed)
		{
			return new \Less_Tree_Keyword($reversed);
		}
		else
		{
			return $keyword;
		}
	}

	/**
	 * @return \Less_Tree_Expression|null
	 */
	public function visitExpression(\Less_Tree_Expression $expression)
	{
		$value = $expression->value;

		if ($this->doReorderShorthand && is_array($value) && count($value) == 4)
		{
			if ($this->doReorderShorthand === 'radius')
			{
				$value = [$value[1], $value[0], $value[3], $value[2]];
			}
			else
			{
				$value = [$value[0], $value[3], $value[2], $value[1]];
			}

			$this->doReorderShorthand = '';

			return new \Less_Tree_Expression($value, $expression->parens);
		}
		else
		{
			return $expression;
		}
	}

	/**
	 * @return string|null
	 */
	protected function processNodeName(string $nodeName)
	{
		$dirPrefix = substr($nodeName, 0, 5);
		$doReverse = $this->isRtl;

		if (preg_match('/^(-rtl-ltr-|-ltr-rtl-)/', $nodeName, $match))
		{
			// disable reversing
			$nodeName = substr($nodeName, strlen($match[0]));
			$doReverse = false;
		}
		else if ($dirPrefix == '-ltr-')
		{
			// LTR only
			if ($this->isRtl)
			{
				return null;
			}
			else
			{
				$nodeName = substr($nodeName, 5);
			}
		}
		else if ($dirPrefix == '-rtl-')
		{
			// RTL only - this won't be reversed either
			if ($this->isRtl)
			{
				$nodeName = substr($nodeName, 5);
				$doReverse = false;
			}
			else
			{
				return null;
			}
		}

		if ($doReverse)
		{
			if (preg_match('/(^|-)(left|right)($|-)/', $nodeName))
			{
				$nodeName = preg_replace_callback(
					'/(^|-)(left|right)($|-)/i',
					function ($match)
					{
						if ($match[2] == 'left')
						{
							$replacePart = 'right';
						}
						else
						{
							$replacePart = 'left';
						}

						return $match[1] . $replacePart . $match[3];
					},
					$nodeName
				);
			}

			if (isset($this->keywordProperties[$nodeName]))
			{
				$this->doReverseKeywords = true;
			}

			if (isset($this->shorthandProperties[$nodeName]))
			{
				$this->doReorderShorthand = $nodeName === 'border-radius'
					? 'radius'
					: 'normal';
			}
		}

		return $nodeName;
	}

	/**
	 * @return string|null
	 */
	protected function reverseKeyword(string $value)
	{
		if ($this->doReverseKeywords)
		{
			switch ($value)
			{
				case 'left': return 'right';
				case 'right': return 'left';
			}
		}

		return null;
	}

	protected function resetForNewRule()
	{
		$this->doReverseKeywords = false;
		$this->doReorderShorthand = '';
	}
}