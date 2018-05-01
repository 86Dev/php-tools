<?php

use PHPUnit\Framework\TestCase;
use PHPTools\BoolHelper;

final class BoolHelperTest extends TestCase
{
	public function testIsTrueString()
	{
		$this->assertEquals(true, BoolHelper::is_true_string('true'));
		$this->assertEquals(true, BoolHelper::is_true_string('yes'));
		$this->assertEquals(true, BoolHelper::is_true_string('vrai'));
		$this->assertEquals(true, BoolHelper::is_true_string('oui'));

		$this->assertEquals(true, BoolHelper::is_true_string('True'));
		$this->assertEquals(true, BoolHelper::is_true_string('Yes'));
		$this->assertEquals(true, BoolHelper::is_true_string('Vrai'));
		$this->assertEquals(true, BoolHelper::is_true_string('Oui'));

		$this->assertEquals(true, BoolHelper::is_true_string('TRUE'));
		$this->assertEquals(true, BoolHelper::is_true_string('YES'));
		$this->assertEquals(true, BoolHelper::is_true_string('VRAI'));
		$this->assertEquals(true, BoolHelper::is_true_string('OUI'));

		$this->assertEquals(true, BoolHelper::is_true_string('1'));
		$this->assertEquals(false, BoolHelper::is_true_string('0'));

		$this->assertEquals(false, BoolHelper::is_true_string('false'));
		$this->assertEquals(false, BoolHelper::is_true_string('no'));
		$this->assertEquals(false, BoolHelper::is_true_string('faux'));
		$this->assertEquals(false, BoolHelper::is_true_string('non'));

		$this->assertEquals(false, BoolHelper::is_true_string('False'));
		$this->assertEquals(false, BoolHelper::is_true_string('No'));
		$this->assertEquals(false, BoolHelper::is_true_string('Faux'));
		$this->assertEquals(false, BoolHelper::is_true_string('Non'));

		$this->assertEquals(false, BoolHelper::is_true_string('FALSE'));
		$this->assertEquals(false, BoolHelper::is_true_string('NO'));
		$this->assertEquals(false, BoolHelper::is_true_string('FAUX'));
		$this->assertEquals(false, BoolHelper::is_true_string('NON'));
	}

	public function testToBool()
	{
		$this->assertEquals(true, BoolHelper::to_bool('true'));
		$this->assertEquals(true, BoolHelper::to_bool('yes'));
		$this->assertEquals(true, BoolHelper::to_bool('vrai'));
		$this->assertEquals(true, BoolHelper::to_bool('oui'));

		$this->assertEquals(true, BoolHelper::to_bool('True'));
		$this->assertEquals(true, BoolHelper::to_bool('Yes'));
		$this->assertEquals(true, BoolHelper::to_bool('Vrai'));
		$this->assertEquals(true, BoolHelper::to_bool('Oui'));

		$this->assertEquals(true, BoolHelper::to_bool('TRUE'));
		$this->assertEquals(true, BoolHelper::to_bool('YES'));
		$this->assertEquals(true, BoolHelper::to_bool('VRAI'));
		$this->assertEquals(true, BoolHelper::to_bool('OUI'));

		$this->assertEquals(true, BoolHelper::to_bool('1'));
		$this->assertEquals(true, BoolHelper::to_bool(1));
		$this->assertEquals(true, BoolHelper::to_bool(true));
		$this->assertEquals(false, BoolHelper::to_bool(false));
		$this->assertEquals(false, BoolHelper::to_bool(0));
		$this->assertEquals(false, BoolHelper::to_bool('0'));

		$this->assertEquals(false, BoolHelper::to_bool('false'));
		$this->assertEquals(false, BoolHelper::to_bool('no'));
		$this->assertEquals(false, BoolHelper::to_bool('faux'));
		$this->assertEquals(false, BoolHelper::to_bool('non'));

		$this->assertEquals(false, BoolHelper::to_bool('False'));
		$this->assertEquals(false, BoolHelper::to_bool('No'));
		$this->assertEquals(false, BoolHelper::to_bool('Faux'));
		$this->assertEquals(false, BoolHelper::to_bool('Non'));

		$this->assertEquals(false, BoolHelper::to_bool('FALSE'));
		$this->assertEquals(false, BoolHelper::to_bool('NO'));
		$this->assertEquals(false, BoolHelper::to_bool('FAUX'));
		$this->assertEquals(false, BoolHelper::to_bool('NON'));
	}

	public function testIsFalseString()
	{
		$this->assertEquals(false, BoolHelper::is_false_string('true'));
		$this->assertEquals(false, BoolHelper::is_false_string('yes'));
		$this->assertEquals(false, BoolHelper::is_false_string('vrai'));
		$this->assertEquals(false, BoolHelper::is_false_string('oui'));

		$this->assertEquals(false, BoolHelper::is_false_string('True'));
		$this->assertEquals(false, BoolHelper::is_false_string('Yes'));
		$this->assertEquals(false, BoolHelper::is_false_string('Vrai'));
		$this->assertEquals(false, BoolHelper::is_false_string('Oui'));

		$this->assertEquals(false, BoolHelper::is_false_string('TRUE'));
		$this->assertEquals(false, BoolHelper::is_false_string('YES'));
		$this->assertEquals(false, BoolHelper::is_false_string('VRAI'));
		$this->assertEquals(false, BoolHelper::is_false_string('OUI'));

		$this->assertEquals(false, BoolHelper::is_false_string('1'));
		$this->assertEquals(true, BoolHelper::is_false_string('0'));

		$this->assertEquals(true, BoolHelper::is_false_string('false'));
		$this->assertEquals(true, BoolHelper::is_false_string('no'));
		$this->assertEquals(true, BoolHelper::is_false_string('faux'));
		$this->assertEquals(true, BoolHelper::is_false_string('non'));

		$this->assertEquals(true, BoolHelper::is_false_string('False'));
		$this->assertEquals(true, BoolHelper::is_false_string('No'));
		$this->assertEquals(true, BoolHelper::is_false_string('Faux'));
		$this->assertEquals(true, BoolHelper::is_false_string('Non'));

		$this->assertEquals(true, BoolHelper::is_false_string('FALSE'));
		$this->assertEquals(true, BoolHelper::is_false_string('NO'));
		$this->assertEquals(true, BoolHelper::is_false_string('FAUX'));
		$this->assertEquals(true, BoolHelper::is_false_string('NON'));
	}
}