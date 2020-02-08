<?php

declare(strict_types = 1);

namespace PHPTools;

/**
 * A set of functions to debug PHP via var_export or JS console.
 *
 * @version 1.0
 * @author 86Dev
 */
abstract class Debug
{
	/**
	 * Dump a value into a "pre" tag
	 *
	 * @param mixed $value
	 */
	public static function dumpit($value) : void
	{
		echo '<pre>'.var_export($value, true).'</pre>';
	}

	/**
	 * Dump a value in the javascript console
	 *
	 * @param mixed  $value
	 * @param string $method Specifies the console method to use. No check is made to ensure the method is valid. Possible values are 'log', 'error', 'info', 'success', 'table'.
	 */
	public static function dumpitscript($value, $method = 'log') : void
	{
		echo "<script>console.{$method}(".json_encode($value).')</script>';
	}

	/**
	 * Get HTML text dumping a value into a "pre" tag
	 *
	 * @param mixed $value
	 */
	public static function reportit($value)
	{
		return '<pre>'.var_export($value, true).'</pre>';
	}

	/**
	 * Get HTML text dumping a value in the javascript console
	 *
	 * @param mixed  $value
	 * @param string $method Specifies the console method to use. No check is made to ensure the method is valid. Possible values are 'log', 'error', 'info', 'success', 'table'.
	 *
	 * @return string
	 */
	public static function reportitscript($value, $method = 'log')
	{
		return "<script>console.{$method}(".json_encode($value).')</script>';
	}

	/**
	 * Convert an exception to array
	 *
	 * @param \Exception $exception
	 *
	 * @return array
	 */
	public static function exception_to_array($exception, $max_recursion = 5)
	{
		if (!$exception) {
			return;
		}
		$ex = [
			'type' => get_class($exception),
			'message' => $exception->getMessage(),
			'code' => $exception->getCode(),
			'file' => $exception->getFile(),
			'line' => $exception->getLine(),
			'trace' => $exception->getTrace(),
			'previous' => $exception->getPrevious()
				? ($max_recursion > 0
					? static::exception_to_array($exception->getPrevious(), $max_recursion - 1)
					: "Too many previous exception")
				: null,
		];
		if (method_exists($exception, 'getSeverity')) {
			$ex['severity'] = call_user_func([$exception, 'getSeverity']);
		}

		return $ex;
	}
}
