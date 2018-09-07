<?php

namespace PHPTools;

/**
 * Manage a timers list
 */
class Timers
{
	/**
	 * Timers' list
	 *
	 * @var Timer
	 */
	protected $timers = [];

	public function start()
	{
		$this->timers[] = new Timer(true);
	}

	public function stop()
	{
		end($this->timers)->stop();
	}
}