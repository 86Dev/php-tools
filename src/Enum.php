<?php

namespace PHPTools;

/**
 * Basic enum implementation for PHP
 *
 * @url https://stackoverflow.com/questions/254514/php-and-enumerations
 * @version 1.0
 * @author 86Dev
 */
abstract class Enum
{
	/**
	 * Cached constants from all inherited classes
	 * @var array
	 */
	private static $constCacheArray = null;

    /**
     * Get constants using the calling class
     * @return array
     */
    private static function getConstants()
	{
        if (self::$constCacheArray == null)
		{
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray))
		{
            $reflect = new \ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }
        return self::$constCacheArray[$calledClass];
    }

    /**
     * Check if a name is valid
     * @param string $name The constant name to check
     * @param bool $strict Determine if the name comparison is case sensitive (true) or not (false)
     * @return bool
     */
    public static function isValidName($name, $strict = false)
	{
        $constants = self::getConstants();

        if ($strict)
		{
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    /**
     * Check if a  value is valid
     * @param mixed $value
     * @param bool $strict Determine if the value comparison should also check value type (true) or not (false)
     * @return bool
     */
    public static function isValidValue($value, $strict = true)
	{
        return in_array($value, array_values(self::getConstants()), $strict);
    }

	/**
	 * Get values list
	 * @return string[]
	 */
	public static function values()
	{
		return array_values(self::getConstants());
	}
}