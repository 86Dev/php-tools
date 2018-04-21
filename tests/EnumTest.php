<?php

use PHPUnit\Framework\TestCase;
use PHPTools\Enum;

abstract class TestEnum extends Enum
{
	const VALUE1 = 'value1';
	const VALUE2 = 'value2';
}

final class EnumTest extends TestCase
{
	public function testValues()
	{
		$this->assertEquals(TestEnum::values(), ['value1', 'value2']);
	}

	public function testIsValidName_true()
	{
		$this->assertEquals(TestEnum::isValidName('VALUE1'), true);
	}

	public function testIsValidName_false()
	{
		$this->assertEquals(TestEnum::isValidName('invalid'), false);
	}

	public function testIsValidValue_true()
	{
		$this->assertEquals(TestEnum::isValidValue('value1'), true);
	}

	public function testIsValidValue_false()
	{
		$this->assertEquals(TestEnum::isValidValue('invalid'), false);
	}
}