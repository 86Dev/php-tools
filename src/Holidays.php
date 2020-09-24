<?php

declare(strict_types = 1);

namespace PHPTools;

use DateInterval;
use DateTime;
use DateTimeImmutable;

abstract class Holidays
{
	public static $country = '';

	protected static $cache = [];

	protected static $initialized = false;

	/** @var HolidayRules[] */
	public static $holidays = [];

	protected static function init()
	{
		static::$initialized = true;
		static::$holidays = [
			'global' => new HolidayRules([
				'new_year' 					=> HolidayRule::fixed(1, 1),
				'easter' 					=> HolidayRule::complex('\PHPTools\Holidays::easter_day'),
				'christmas' 				=> HolidayRule::fixed(12, 25),
			]),
			'FR' => new HolidayRules([
				'lundi_paques'				=> HolidayRule::relative('easter', 'P1D'),
				'ascension'					=> HolidayRule::relative('easter', 'P39D'),
				'pentecote'					=> HolidayRule::relative('easter', 'P50D'),
				'travail'	 				=> HolidayRule::fixed( 5,  1),
				'armistice_1945'			=> HolidayRule::fixed( 5,  8),
				'national'					=> HolidayRule::fixed( 7, 14),
				'assomption'				=> HolidayRule::fixed( 8, 15),
				'toussaint'					=> HolidayRule::fixed(11,  1),
				'armistice_1918'			=> HolidayRule::fixed(11, 11),
			]),
			'FR_Alsace' => new HolidayRules([
				'inherit'					=> 'FR',
				'vendredi_saint'			=> HolidayRule::relative('easter', 'P-2D'),
				'christmas_next'			=> HolidayRule::fixed(12, 26),
			]),
			'US' => new HolidayRules([
				'easter'					=> false,
				'martin_luther_king'		=> HolidayRule::fixed( 1, 'third monday'),
				'president'					=> HolidayRule::fixed( 2, 'third monday'),
				'memorial'					=> HolidayRule::fixed( 5, 'last monday of May'),
				'independance'				=> HolidayRule::fixed( 7,  4),
				'labor'		 				=> HolidayRule::fixed( 9, 'first monday'),
				'columbus'	 				=> HolidayRule::fixed(10, 'second monday'),
				'veterans'	 				=> HolidayRule::fixed(11, 11),
				'thanksgiving' 				=> HolidayRule::fixed(11, 'fourth thursday'),
			]),
			'US_CA' => new HolidayRules([
				'inherit' 					=> 'US',
				'good_friday'				=> HolidayRule::relative('easter', 'P-2D'),
			]),
		];
	}

	/**
	 * Add a country and its holidays rules.
	 *
	 * Will replace all existing rules if the country alreday exists.
	 *
	 * @param string $country The country name
	 * @param array|HolidayRules $rules The country rules. Add the 'inherit' key in this array to define from which other country this country should use the rules.
	 *
	 * @return void
	 */
	public static function add_country(string $country, $rules)
	{
		if (!static::$initialized) static::init();
		if (!is_array($rules) && !is_a($rules, \Traversable::class)) {
			throw new \InvalidArgumentException("You must provide a valid rules set to add a new country. A rule set can either be a \PHPTools\HolidayRules or an array.");
		}

		if (!is_a($rules, HolidayRules::class)) {
			$rules = new HolidayRules($rules);
		}

		// Check each rule
		foreach ($rules as $holiday => $rule) {
			if (!is_bool($rule) && !is_a($rule, HolidayRule::class)) {
				unset($rules[$holiday]);
			}
		}
		static::$holidays[$country] = $rules;
	}

	/**
	 * Add a holiday to an existing country
	 *
	 * @param string $country
	 * @param string $holiday
	 * @param HolidayRule|bool $rule A new HolidayRule to apply or a boolean to enable/disable the inherited holiday
	 *
	 * @throws \InvalidArgumentException When $country or $holiday are empty, or if $rule is not a HolidayRule or a boolean.
	 *
	 * @return bool True if the rule has been added, false otherwise
	 */
	public static function add_country_rule(string $country, string $holiday, $rule)
	{
		if (!static::$initialized) static::init();
		if (!$country) {
			throw new \InvalidArgumentException("You must provide a valid country name to add a new rule");
		}
		if (!$holiday) {
			throw new \InvalidArgumentException("You must provide a valid holiday name to add a new rule");
		}
		if (!is_bool($rule) && !is_a($rule, HolidayRule::class)) {
			throw new \InvalidArgumentException("You must provide a valid rule to add a new rule. A rule can either be a \PHPTools\HolidayRule or a boolean.");
		}
		if (array_key_exists($country, static::$holidays)) {
			static::$holidays[$country][$holiday] = $rule;
			return true;
		}
		return false;
	}

	/**
	 * Get easter day for a specific year
	 *
	 * @param int $year
	 *
	 * @return DateTimeImmutable
	 */
	public static function easter_day($year)
	{
		$easter = new DateTimeImmutable("$year-03-21");
		$easter = $easter->add(new DateInterval("P".easter_days($year)."D"));
		return $easter;
	}

	/**
	 * Get a holiday date
	 *
	 * @param string $holiday
	 * @param int $year
	 * @param string $country
	 *
	 * @return DateTimeImmutable
	 */
	public static function get_holiday($holiday, $year, $country = '')
	{
		$country = static::check_country($country);
		$result = static::get_cache($country, $year, $holiday);
		if (!$result) {
			$rule = static::get_rule($country, $holiday, $year);
			if ($rule) {
				$result = $rule->calc($country, $year);
				if ($result) {
					static::set_cache($country, $year, $holiday, $result);
				}
			}
		}
		return $result;
	}

	/**
	 * Get all holidays
	 *
	 * @param string $country
	 * @param int $year
	 *
	 * @return array
	 */
	public static function get_holidays($year, $country = '')
	{
		if (!static::$initialized) static::init();
		if (!$country && !$year) {
			return static::$holidays;
		}

		$holidays = [];
		$rules = static::get_country_rules($country);

		if ($year) {
			foreach ($rules as $holiday => $rule) {
				$holidays[$holiday] = static::get_holiday($holiday, $year, $country);
			}
		}
		return $holidays;
	}

	/**
	 * Check the country
	 *
	 * @param string $country
	 *
	 * @throws \InvalidArgumentException if country and static::$country are empty
	 * @throws \Exception if no holidays are defined for the country
	 *
	 * @return string
	 */
	protected static function check_country($country)
	{
		if (!static::$initialized) static::init();
		if (!$country) {
			$country = static::$country;
		}
		if (!$country) {
			throw new \InvalidArgumentException("You must provide a country. You can define a global country for all your queries by using Holidays::\$country.");
		}
		if (!array_key_exists($country, static::$holidays)) {
			throw new \Exception("The country $country is not valid.");
		}
		return $country;
	}

	/**
	 * Get all holidays for a specific country
	 *
	 * @param string $country
	 *
	 * @return HolidayRules
	 */
	public static function get_country_rules($country)
	{
		$country = static::check_country($country);
		$holidays = new HolidayRules(static::$holidays[$country]);

		if ($holidays->key_exists('inherit')) {
			$parent_holidays = static::get_country_rules($holidays['inherit']);
			$holidays->offsetUnset('inherit');
		} else {
			$parent_holidays = static::$holidays['global'];
		}

		foreach ($parent_holidays as $holiday => $rule) {
			if ($holidays->key_exists($holiday)) {
				if ($holidays[$holiday] === true && !is_bool($rule)) {
					$holidays[$holiday] = $rule;
				}
			} else {
				$holidays[$holiday] = $rule;
			}
		}

		$holidays = $holidays->filter();
		return $holidays;
	}

	/**
	 * Get a holiday rule
	 *
	 * @param string $country
	 * @param string $holiday
	 * @param bool $even_if_disabled If the rule is disabled for the country, try to find it in parent or global.
	 * Used to calculate relative dates, for example, if easter is disabled for the country, but good friday is enabled, we need to find easter rule anyway.
	 *
	 * @return HolidayRule|null
	 */
	public static function get_rule($country, $holiday, $even_if_disabled = false)
	{
		$country = static::check_country($country);
		if (static::$holidays[$country]->key_exists($holiday) && (static::$holidays[$country][$holiday] || !$even_if_disabled)) {
			if (is_bool(static::$holidays[$country][$holiday])) {
				if (!static::$holidays[$country][$holiday] && !$even_if_disabled) {
					// If the rule is false and $even_if_disabled is false, return null
					return null;
				}
				// else if the rule is true or/and $even_if_disabled is true, continue to test for inherited or global rules
				// In that case, we force $even_if_disabled to true in the case an inherited country has this rule to false
				$even_if_disabled = true;
			} else {
				return static::$holidays[$country][$holiday] ?: null;
			}
		}

		if (static::$holidays[$country]->key_exists('inherit')) {
			return static::get_rule(static::$holidays[$country]['inherit'], $holiday, $even_if_disabled);
		}

		if (static::$holidays['global']->key_exists($holiday)) {
			return static::get_rule('global', $holiday, $even_if_disabled);
		}
		return null;
	}

	/**
	 * Get a cached holiday date
	 *
	 * @param string $country
	 * @param int $year
	 * @param string $holiday
	 *
	 * @return DateTimeImmutable|false
	 */
	protected static function get_cache($country, $year, $holiday)
	{
		if (array_key_exists($country, static::$cache)
			&& array_key_exists($year, static::$cache[$country])
			&& array_key_exists($holiday, static::$cache[$country][$year])
		) {
			return new DateTimeImmutable(static::$cache[$country][$year][$holiday]);
		}
		return false;
	}

	/**
	 * Set a holiday date in cache
	 *
	 * @param string $country
	 * @param int $year
	 * @param string $holiday
	 * @param int|string|DateTime|DateTimeImmutable $value
	 *
	 * @return void
	 */
	protected static function set_cache($country, $year, $holiday, $value)
	{
		if (!array_key_exists($country, static::$cache)) {
			static::$cache[$country] = [];
		}
		if (!array_key_exists($year, static::$cache[$country])) {
			static::$cache[$country][$year] = [];
		}
		static::$cache[$country][$year][$holiday] = is_a($value, DateTime::class) || is_a($value, DateTimeImmutable::class)
			? $value->format('Y-m-d H:i:s')
			: date('Y-m-d H:i:s', !is_numeric($value) ? strtotime($value) : $value);
	}
}

/**
 * A country's holidays rules
 *
 * Add any key as a holiday. Each key may a HolidayRule to define the holiday or a boolean to enable/disable the inherited holiday
 *
 * @property string $inherit The name of the country from which this country use the same holidays. For example California (US_CA) inherits USA (US) holidays
 */
class HolidayRules extends FullArrayObject
{
	/**
	 * @return HolidayRule|bool
	 */
	public function __get($name)
	{
		return $this->offsetGet($name);
	}

	/**
	 * @inheritDoc
	 *
	 * @param string $name
	 * @param HolidayRule|bool $value
	 */
	public function __set($name, $value)
	{
		$this->offsetSet($name, $value);
	}

	/**
	 * @inheritDoc
	 *
	 * @return HolidayRule|bool
	 */
	public function offsetGet($index)
	{
		return parent::offsetGet($index);
	}

	/**
	 * @inheritdoc
	 *
	 * @param HolidayRule|bool $newval
	 *
	 * @return void
	 */
	public function offsetSet($index, $newval)
	{
		parent::offsetSet($index, $newval);
	}
}