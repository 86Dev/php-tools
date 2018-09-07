<?php

namespace PHPTools;

class Timer
{
	/**
	 * STart time
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
	 * @param boolean $start If set to true, will automatically start the timer
	 */
	public function __construct($start = false)
	{
		if ($start) $this->start();
	}

	/**
	 * Start the timer
	 *
	 * @return void
	 */
	public function start()
	{
		if ($this->_start) return;
		$this->_start = microtime(true);
	}

	/**
	 * Stop the timer
	 *
	 * @return void
	 */
	public function stop()
	{
		if (!$this->_start) return;
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

	/**
	 * Show timer duration as a human readable string
	 *
	 * @return string
	 */
	public function __toString()
	{
		if (!$this->_start) return 'Not started';
		else
		{
			$seconds = $this->duration();
			$minutes = 0;
			if ($seconds > 60.0)
			{
				$minutes = intdiv($seconds, 60);
				$seconds -= ($minutes * 60);
			}
			return sprintf("%d:%f", $minutes, $seconds);
		}
	}
}