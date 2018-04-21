<?php

use PHPUnit\Framework\TestCase;
use PHPTools\BoolHelper;

final class BoolHelperTest extends TestCase
{
	public function testIsTrueString()
	{
		$this->assertEquals(BoolHelper::is_true_string('true'), true);
		$this->assertEquals(BoolHelper::is_true_string('yes'), true);
		$this->assertEquals(BoolHelper::is_true_string('vrai'), true);
		$this->assertEquals(BoolHelper::is_true_string('oui'), true);

		$this->assertEquals(BoolHelper::is_true_string('True'), true);
		$this->assertEquals(BoolHelper::is_true_string('Yes'), true);
		$this->assertEquals(BoolHelper::is_true_string('Vrai'), true);
		$this->assertEquals(BoolHelper::is_true_string('Oui'), true);

		$this->assertEquals(BoolHelper::is_true_string('TRUE'), true);
		$this->assertEquals(BoolHelper::is_true_string('YES'), true);
		$this->assertEquals(BoolHelper::is_true_string('VRAI'), true);
		$this->assertEquals(BoolHelper::is_true_string('OUI'), true);

		$this->assertEquals(BoolHelper::is_true_string('1'), true);
		$this->assertEquals(BoolHelper::is_true_string('0'), false);

		$this->assertEquals(BoolHelper::is_true_string('false'), false);
		$this->assertEquals(BoolHelper::is_true_string('no'), false);
		$this->assertEquals(BoolHelper::is_true_string('faux'), false);
		$this->assertEquals(BoolHelper::is_true_string('non'), false);

		$this->assertEquals(BoolHelper::is_true_string('False'), false);
		$this->assertEquals(BoolHelper::is_true_string('No'), false);
		$this->assertEquals(BoolHelper::is_true_string('Faux'), false);
		$this->assertEquals(BoolHelper::is_true_string('Non'), false);

		$this->assertEquals(BoolHelper::is_true_string('FALSE'), false);
		$this->assertEquals(BoolHelper::is_true_string('NO'), false);
		$this->assertEquals(BoolHelper::is_true_string('FAUX'), false);
		$this->assertEquals(BoolHelper::is_true_string('NON'), false);
	}

	public function testToBool()
	{
		$this->assertEquals(BoolHelper::to_bool('true'), true);
		$this->assertEquals(BoolHelper::to_bool('yes'), true);
		$this->assertEquals(BoolHelper::to_bool('vrai'), true);
		$this->assertEquals(BoolHelper::to_bool('oui'), true);

		$this->assertEquals(BoolHelper::to_bool('True'), true);
		$this->assertEquals(BoolHelper::to_bool('Yes'), true);
		$this->assertEquals(BoolHelper::to_bool('Vrai'), true);
		$this->assertEquals(BoolHelper::to_bool('Oui'), true);

		$this->assertEquals(BoolHelper::to_bool('TRUE'), true);
		$this->assertEquals(BoolHelper::to_bool('YES'), true);
		$this->assertEquals(BoolHelper::to_bool('VRAI'), true);
		$this->assertEquals(BoolHelper::to_bool('OUI'), true);

		$this->assertEquals(BoolHelper::to_bool('1'), true);
		$this->assertEquals(BoolHelper::to_bool(1), true);
		$this->assertEquals(BoolHelper::to_bool(0), false);
		$this->assertEquals(BoolHelper::to_bool('0'), false);

		$this->assertEquals(BoolHelper::to_bool('false'), false);
		$this->assertEquals(BoolHelper::to_bool('no'), false);
		$this->assertEquals(BoolHelper::to_bool('faux'), false);
		$this->assertEquals(BoolHelper::to_bool('non'), false);

		$this->assertEquals(BoolHelper::to_bool('False'), false);
		$this->assertEquals(BoolHelper::to_bool('No'), false);
		$this->assertEquals(BoolHelper::to_bool('Faux'), false);
		$this->assertEquals(BoolHelper::to_bool('Non'), false);

		$this->assertEquals(BoolHelper::to_bool('FALSE'), false);
		$this->assertEquals(BoolHelper::to_bool('NO'), false);
		$this->assertEquals(BoolHelper::to_bool('FAUX'), false);
		$this->assertEquals(BoolHelper::to_bool('NON'), false);
	}

	public function testIsFalseString()
	{
		$this->assertEquals(BoolHelper::is_false_string('true'), false);
		$this->assertEquals(BoolHelper::is_false_string('yes'), false);
		$this->assertEquals(BoolHelper::is_false_string('vrai'), false);
		$this->assertEquals(BoolHelper::is_false_string('oui'), false);

		$this->assertEquals(BoolHelper::is_false_string('True'), false);
		$this->assertEquals(BoolHelper::is_false_string('Yes'), false);
		$this->assertEquals(BoolHelper::is_false_string('Vrai'), false);
		$this->assertEquals(BoolHelper::is_false_string('Oui'), false);

		$this->assertEquals(BoolHelper::is_false_string('TRUE'), false);
		$this->assertEquals(BoolHelper::is_false_string('YES'), false);
		$this->assertEquals(BoolHelper::is_false_string('VRAI'), false);
		$this->assertEquals(BoolHelper::is_false_string('OUI'), false);

		$this->assertEquals(BoolHelper::is_false_string('1'), false);
		$this->assertEquals(BoolHelper::is_false_string('0'), true);

		$this->assertEquals(BoolHelper::is_false_string('false'), true);
		$this->assertEquals(BoolHelper::is_false_string('no'), true);
		$this->assertEquals(BoolHelper::is_false_string('faux'), true);
		$this->assertEquals(BoolHelper::is_false_string('non'), true);

		$this->assertEquals(BoolHelper::is_false_string('False'), true);
		$this->assertEquals(BoolHelper::is_false_string('No'), true);
		$this->assertEquals(BoolHelper::is_false_string('Faux'), true);
		$this->assertEquals(BoolHelper::is_false_string('Non'), true);

		$this->assertEquals(BoolHelper::is_false_string('FALSE'), true);
		$this->assertEquals(BoolHelper::is_false_string('NO'), true);
		$this->assertEquals(BoolHelper::is_false_string('FAUX'), true);
		$this->assertEquals(BoolHelper::is_false_string('NON'), true);
	}
}