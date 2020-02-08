<?php

declare(strict_types = 1);

namespace PHPTools\Monolog;

use PHPTools\Timer;

/**
 * Adds ellapsed time into records
 */
class TimerProcessor
{
	/**
	 * Timer
	 *
	 * @var Timer
	 */
	protected $timer;

	public function __construct()
	{
		$this->timer = new Timer(true);
	}

	/**
	 * @return array
	 */
	public function __invoke(array $record)
	{
		$record['extra']['duration'] = $this->timer->duration();

		return $record;
	}
}
