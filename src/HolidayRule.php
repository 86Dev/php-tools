<?php

declare(strict_types = 1);

namespace PHPTools;

use DateInterval;
use DateTimeImmutable;

class HolidayRule
{
	/** @var int|string|null */
	public $month = null;

	/** @var int|string|null */
	public $day = null;

	/** @var callable|null */
	public $callback = null;

	/** @var string|null */
	public $relative_holiday = null;

	/** @var string|DateInterval|null */
	public $interval = null;

	public function __construct($month = null, $day = null, $callback = null, $relative_holiday = null, $interval = null)
	{
		$this->month = $month;
		$this->day = $day;
		$this->callback = $callback;
		$this->relative_holiday = $relative_holiday;
		$this->interval = $interval;
	}

	public static function fixed($month, $day)
	{
		return new HolidayRule($month, $day);
	}

	public static function relative($holiday, $interval)
	{
		return new HolidayRule(null, null, null, $holiday, $interval);
	}

	public static function complex($callback)
	{
		return new HolidayRule(null, null, $callback);
	}

	public function calc($country, $year)
	{
		if ($this->callback) {
			if (!is_callable($this->callback)) {
				$callback_string = is_array($this->callback) ? implode('::', $this->callback) : $this->callback;
				throw new \Exception("The specified callback \"{$callback_string}\" is not valid.");
			}
			return call_user_func($this->callback, $year);
		} elseif ($this->relative_holiday) {
			$rule = Holidays::get_rule($country, $this->relative_holiday, true);
			if ($rule) {
				$d = $rule->calc($country, $year);
				if (strpos($this->interval, '-') > 0) {
					return $d->sub(new DateInterval(str_replace('-', '', $this->interval)));
				} else {
					return $d->add(new DateInterval($this->interval));
				}
			} else {
				throw new \Exception("Relative rule \"{$this->relative_holiday}\" not found for country \"{$country}\".");
			}
		} elseif (is_numeric($this->month) && is_numeric($this->day)) {
			return new DateTimeImmutable("{$year}-{$this->month}-{$this->day} 00:00:00");
		} elseif (is_numeric($this->month)) {
			$d = strtotime($this->day, mktime(0, 0, 0, $this->month, 1, $year));
			return new DateTimeImmutable(date('Y-m-d H:i:s', $d));
		}
		return null;
	}
}