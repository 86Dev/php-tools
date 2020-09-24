<?php

use PHPTools\HolidayRule;
use PHPUnit\Framework\TestCase;

final class HolidayRuleTest extends TestCase
{
	public function test_fixed()
	{
		$rule = HolidayRule::fixed(1, 1);
		$this->assertEquals(1, $rule->month);
		$this->assertEquals(1, $rule->day);
		$this->assertNull($rule->callback);
		$this->assertNull($rule->relative_holiday);
		$this->assertNull($rule->interval);
		$this->assertEquals('2020-01-01', $rule->calc('FR', 2020)->format('Y-m-d'));
	}

	public function test_fixed_relative()
	{
		$rule = HolidayRule::fixed(1, 'first monday');
		$this->assertEquals(1, $rule->month);
		$this->assertEquals('first monday', $rule->day);
		$this->assertNull($rule->callback);
		$this->assertNull($rule->relative_holiday);
		$this->assertNull($rule->interval);
		$this->assertEquals('2020-01-06', $rule->calc('FR', 2020)->format('Y-m-d'));
	}

	public function test_relative()
	{
		$rule = HolidayRule::relative('christmas', 'P1D');
		$this->assertNull($rule->month);
		$this->assertNull($rule->day);
		$this->assertNull($rule->callback);
		$this->assertEquals('christmas', $rule->relative_holiday);
		$this->assertEquals('P1D', $rule->interval);
		$this->assertEquals('2020-12-26', $rule->calc('FR', 2020)->format('Y-m-d'));
	}

	public function test_relative_negative()
	{
		$rule = HolidayRule::relative('christmas', 'P-1D');
		$this->assertNull($rule->month);
		$this->assertNull($rule->day);
		$this->assertNull($rule->callback);
		$this->assertEquals('christmas', $rule->relative_holiday);
		$this->assertEquals('P-1D', $rule->interval);
		$this->assertEquals('2020-12-24', $rule->calc('FR', 2020)->format('Y-m-d'));
	}

	public function test_relative_easter()
	{
		$rule = HolidayRule::relative('easter', 'P1D');
		$this->assertNull($rule->month);
		$this->assertNull($rule->day);
		$this->assertNull($rule->callback);
		$this->assertEquals('easter', $rule->relative_holiday);
		$this->assertEquals('P1D', $rule->interval);
		$this->assertEquals('2020-04-13', $rule->calc('US_CA', 2020)->format('Y-m-d'));
	}

	public function test_relative_easter_negative()
	{
		$rule = HolidayRule::relative('easter', 'P-1D');
		$this->assertNull($rule->month);
		$this->assertNull($rule->day);
		$this->assertNull($rule->callback);
		$this->assertEquals('easter', $rule->relative_holiday);
		$this->assertEquals('P-1D', $rule->interval);
		$this->assertEquals('2020-04-11', $rule->calc('US_CA', 2020)->format('Y-m-d'));
	}

	public function test_complex()
	{
		$rule = HolidayRule::complex("\PHPTools\Holidays::easter_day");
		$this->assertNull($rule->month);
		$this->assertNull($rule->day);
		$this->assertEquals("\PHPTools\Holidays::easter_day", $rule->callback);
		$this->assertNull($rule->relative_holiday);
		$this->assertNull($rule->interval);
		$this->assertEquals('2020-04-12', $rule->calc('FR', 2020)->format('Y-m-d'));
	}
}