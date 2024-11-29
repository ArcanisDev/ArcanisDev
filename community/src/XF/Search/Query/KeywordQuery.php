<?php

namespace XF\Search\Query;

class KeywordQuery extends Query
{
	protected $keywords = '';
	protected $parsedKeywords = null;
	protected $titleOnly = false;

	public function withKeywords($keywords, $titleOnly = false)
	{
		$this->keywords = trim($keywords);
		$this->parsedKeywords = $this->search->getParsedKeywords($this->keywords, $error, $warning);
		$this->titleOnly = (bool)$titleOnly;

		if ($error)
		{
			$this->error('keywords', $error);
		}
		if ($warning)
		{
			$this->warning('keywords', $warning);
		}

		return $this;
	}

	public function getKeywords()
	{
		return $this->keywords;
	}

	public function getParsedKeywords()
	{
		return $this->parsedKeywords;
	}

	public function inTitleOnly($titleOnly = true)
	{
		$this->titleOnly = (bool)$titleOnly;

		return $this;
	}

	public function getTitleOnly()
	{
		return $this->titleOnly;
	}

	public function getUniqueQueryComponents()
	{
		return [
			'keywords' => $this->keywords,
			'titleOnly' => $this->titleOnly
		];
	}
}