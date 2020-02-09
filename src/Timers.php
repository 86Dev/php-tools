<?php

declare(strict_types = 1);

namespace PHPTools;

use InvalidArgumentException;

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
	 * @var Timer[]
	 */
	protected $timers = [];

	public function start($key) : void
	{
		if (!$key) {
			throw new InvalidArgumentException("A timer key must be provided");
		}
		$this->timers[$key] = new Timer(true);
	}

	public function stop($key) : void
	{
		if ($key && array_key_exists($key, $this->timers)) {
			$this->timers[$key]->stop();
		}
	}

	public function get($key)
	{
		return $key && array_key_exists($key, $this->timers) ? $this->timers[$key] : null;
	}
}
