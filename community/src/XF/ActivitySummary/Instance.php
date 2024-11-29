<?php

namespace XF\ActivitySummary;

use XF\Entity\User;

use function count, in_array, strval;

class Instance
{
	/**
	 * @var User
	 */
	protected $user;

	protected $seenIds = [];
	protected $renderedSections = [];
	protected $displayValues = [];

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function getUser(): User
	{
		return $this->user;
	}

	public function getSeen(): array
	{
		return $this->seenIds;
	}

	public function addSeen($type, $id)
	{
		$this->seenIds[$type][] = $id;
	}

	public function hasSeen($type, $id): bool
	{
		return in_array($id, $this->seenIds[$type] ?? []);
	}

	public function getRenderedSections(): array
	{
		return $this->renderedSections;
	}

	public function addRenderedSection($html)
	{
		$this->renderedSections[] = $html;
	}

	public function getDisplayValues(): array
	{
		return $this->displayValues;
	}

	public function addDisplayValue($label, $value)
	{
		$this->displayValues[] = [
			'label' => strval($label),
			'value' => $value
		];
	}

	public function addDisplayValues(array $values)
	{
		foreach ($values AS $value)
		{
			if ($value['value'] != 0)
			{
				$this->addDisplayValue($value['label'], $value['value']);
			}
		}
	}

	public function canSendActivitySummary(): bool
	{
		return count($this->renderedSections) > 0;
	}
}