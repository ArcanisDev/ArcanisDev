<?php

namespace XF\Helper;

class Poll
{
	public function getPollInput(\XF\Http\Request $request)
	{
		$input = $request->filter([
			'poll' => [
				'question' => 'str',

				'existing_responses' => 'array-str',
				'new_responses' => 'array-str',

				'max_votes_type' => 'str',
				'max_votes_value' => 'uint',

				'close' => 'bool',
				'remove_close' => 'bool',
				'close_length' => 'uint',
				'close_units' => 'str',

				'change_vote' => 'bool',
				'public_votes' => 'bool',
				'view_results_unvoted' => 'bool'
			],
		]);

		return $input['poll'];
	}

	public function configureCreatorFromInput(\XF\Service\Poll\Creator $creator, array $pollInput)
	{
		$creator->setQuestion($pollInput['question']);
		$creator->setMaxVotes($pollInput['max_votes_type'], $pollInput['max_votes_value']);

		if ($pollInput['close'])
		{
			$creator->setCloseDateRelative($pollInput['close_length'], $pollInput['close_units']);
		}

		$creator->setOptions([
			'change_vote' => $pollInput['change_vote'],
			'public_votes' => $pollInput['public_votes'],
			'view_results_unvoted' => $pollInput['view_results_unvoted']
		]);

		$creator->addResponses($pollInput['new_responses']);

		return $creator;
	}
}