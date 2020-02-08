<?php

declare(strict_types = 1);

namespace PHPTools\Monolog;

/**
 * Adds unique request ID into records
 */
class RequestIdProcessor
{
	/**
	 * @return array
	 */
	public function __invoke(array $record)
	{
		$record['extra']['request_id'] = hash('crc32b', $_SERVER['REMOTE_ADDR'].$_SERVER['REMOTE_PORT'].$_SERVER['REQUEST_TIME_FLOAT'].$_SERVER['REQUEST_URI']);

		return $record;
	}
}
