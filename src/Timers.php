<?php

declare(strict_types = 1);

namespace PHPTools;

/**
 * Manage a timers list
 *
 * @version 1.2.0
 * @author 86Dev
 */
class Timers
{
	/**
	 * Timers' list
	 *
	 * @var Timer
	 */
	protected $timers = [];

	public function start() : void
	{
		$this->timers[] = new Timer(true);
	}

	public function stop() : void
	{
		end($this->timers)->stop();
	}
}
