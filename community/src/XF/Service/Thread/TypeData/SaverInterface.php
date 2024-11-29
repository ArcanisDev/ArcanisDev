<?php

namespace XF\Service\Thread\TypeData;

interface SaverInterface
{
	public function validate(&$errors = []);

	public function save();
}