<?php

declare(strict_types = 1);

namespace PHPTools;

/**
 * Class to record timing
 *
 * @version 1.2.0
 * @author 86Dev
 */
class Timer
{
	/**
	 * Start time
	 *
	 * @var float
	 */
	protected $_start;

	/**
	 * End time
	 *
	 * @var float
	 */
	protected $_end;

	/**
	 * Constructor
	 *
	 * @param bool $start If set to true, will automatically start the timer
	 */
	public function __construct($start = false)
	{
		if ($start) {
			$this->start();
		}
	}

	/**
	 * Show timer duration as a human readable string
	 *
	 * @return string
	 */
	public function __toString()
	{
		if (!$this->_start) {
			return 'Not started';
		}

		$seconds = $this->duration();
		$minutes = 0;
		if ($seconds > 60.0) {
			$minutes = intdiv($seconds, 60);
			$seconds -= ($minutes * 60);
		}

		return sprintf('%d:%02.3f', $minutes, $seconds);
	}

	/**
	 * Start the timer
	 *
	 * @return void
	 */
	public function start()
	{
		if ($this->_start) {
			return;
		}
		$this->_start = microtime(true);
	}

	/**
	 * Stop the timer
	 *
	 * @return void
	 */
	public function stop()
	{
		if (!$this->_start) {
			return;
		}
		$this->_end = microtime(true);
	}

	/**
	 * Get timer duration in seconds
	 * Return 0 if the timer have not been started
	 * Return ellapsed seconds since start and now if the timer is not stopped
	 *
	 * @return float
	 */
	public function duration()
	{
		return !$this->_start ? 0 : ($this->_end ? $this->_end - $this->_start : microtime(true) - $this->_start);
	}
}
