<?php

use PHPUnit\Framework\TestCase;
use PHPTools\StringHelper;

final class StringHelperTest extends TestCase
{
	public function test_split_words()
	{
		$this->assertEquals(StringHelper::split_words(''), []);
		$this->assertEquals(StringHelper::split_words('test'), ['test']);
		$this->assertEquals(StringHelper::split_words('test 2'), ['test', '2']);
		$this->assertEquals(StringHelper::split_words('test with multiple words'), ['test', 'with', 'multiple', 'words']);
	}

	public function test_remove_diacritics()
	{
		$this->assertEquals(StringHelper::remove_diacritics('àâäãçéèêëìîïòôöõùûüœ'), 'aaaaceeeeiiioooouuuoe');
		$this->assertEquals(StringHelper::remove_diacritics('ÀÂÄÃÇÉÈÊËÌÎÏÒÔÖÕÙÛÜŒ'), 'AAAACEEEEIIIOOOOUUUOE');
	}

	public function test_capitalize()
	{
		$this->assertEquals(StringHelper::capitalize('test'), 'Test');
		$this->assertEquals(StringHelper::capitalize('test test'), 'Test test');
		$this->assertEquals(StringHelper::capitalize('TEST TEST'), 'Test test');
		$this->assertEquals(StringHelper::capitalize('test 86dev test'), 'Test 86dev test');
		$this->assertEquals(StringHelper::capitalize(' test test'), ' test test');
	}

	public function test_pascal_case()
	{
		$this->assertEquals(StringHelper::pascal_case('test'), 'Test');
		$this->assertEquals(StringHelper::pascal_case('test test'), 'TestTest');
		$this->assertEquals(StringHelper::pascal_case('TEST TEST'), 'TestTest');
		$this->assertEquals(StringHelper::pascal_case('test 86dev test'), 'Test86devTest');
		$this->assertEquals(StringHelper::pascal_case(' test test'), 'TestTest');
		$this->assertEquals(StringHelper::pascal_case('	test	test'), 'TestTest');
		$this->assertEquals(StringHelper::pascal_case('
			test
			test'), 'TestTest');
	}

	public function test_camel_case()
	{
		$this->assertEquals(StringHelper::camel_case('test'), 'test');
		$this->assertEquals(StringHelper::camel_case('test test'), 'testTest');
		$this->assertEquals(StringHelper::camel_case('TEST TEST'), 'testTest');
		$this->assertEquals(StringHelper::camel_case('test 86dev test'), 'test86devTest');
		$this->assertEquals(StringHelper::camel_case(' test test'), 'testTest');
		$this->assertEquals(StringHelper::camel_case('	test	test'), 'testTest');
		$this->assertEquals(StringHelper::camel_case('
			test
			test'), 'testTest');
	}

	public function test_snake_case()
	{
		$this->assertEquals(StringHelper::snake_case('test'), 'test');
		$this->assertEquals(StringHelper::snake_case('test test'), 'test_test');
		$this->assertEquals(StringHelper::snake_case('TEST TEST'), 'test_test');
		$this->assertEquals(StringHelper::snake_case('test 86dev test'), 'test_86dev_test');
		$this->assertEquals(StringHelper::snake_case(' test test'), 'test_test');
		$this->assertEquals(StringHelper::snake_case('	test	test'), 'test_test');
		$this->assertEquals(StringHelper::snake_case('
			test
			test'), 'test_test');
	}

	public function test_upper_snake_case()
	{
		$this->assertEquals(StringHelper::upper_snake_case('test'), 'TEST');
		$this->assertEquals(StringHelper::upper_snake_case('test test'), 'TEST_TEST');
		$this->assertEquals(StringHelper::upper_snake_case('TEST TEST'), 'TEST_TEST');
		$this->assertEquals(StringHelper::upper_snake_case('test 86dev test'), 'TEST_86DEV_TEST');
		$this->assertEquals(StringHelper::upper_snake_case(' test test'), 'TEST_TEST');
		$this->assertEquals(StringHelper::upper_snake_case('	test	test'), 'TEST_TEST');
		$this->assertEquals(StringHelper::upper_snake_case('
			test
			test'), 'TEST_TEST');
	}

	public function test_capital_snake_case()
	{
		$this->assertEquals(StringHelper::capital_snake_case('test'), 'Test');
		$this->assertEquals(StringHelper::capital_snake_case('test test'), 'Test_Test');
		$this->assertEquals(StringHelper::capital_snake_case('TEST TEST'), 'Test_Test');
		$this->assertEquals(StringHelper::capital_snake_case('test 86dev test'), 'Test_86dev_Test');
		$this->assertEquals(StringHelper::capital_snake_case(' test test'), 'Test_Test');
		$this->assertEquals(StringHelper::capital_snake_case('	test	test'), 'Test_Test');
		$this->assertEquals(StringHelper::capital_snake_case('
			test
			test'), 'Test_Test');
	}

	public function test_kebab_case()
	{
		$this->assertEquals(StringHelper::kebab_case('test'), 'test');
		$this->assertEquals(StringHelper::kebab_case('test test'), 'test-test');
		$this->assertEquals(StringHelper::kebab_case('TEST TEST'), 'test-test');
		$this->assertEquals(StringHelper::kebab_case('test 86dev test'), 'test-86dev-test');
		$this->assertEquals(StringHelper::kebab_case(' test test'), 'test-test');
		$this->assertEquals(StringHelper::kebab_case('	test	test'), 'test-test');
		$this->assertEquals(StringHelper::kebab_case('
			test
			test'), 'test-test');
	}

	public function test_train_case()
	{
		$this->assertEquals(StringHelper::train_case('test'), 'Test');
		$this->assertEquals(StringHelper::train_case('test test'), 'Test-Test');
		$this->assertEquals(StringHelper::train_case('TEST TEST'), 'Test-Test');
		$this->assertEquals(StringHelper::train_case('test 86dev test'), 'Test-86dev-Test');
		$this->assertEquals(StringHelper::train_case(' test test'), 'Test-Test');
		$this->assertEquals(StringHelper::train_case('	test	test'), 'Test-Test');
		$this->assertEquals(StringHelper::train_case('
			test
			test'), 'Test-Test');
	}

	public function test_initial()
	{
		$this->assertEquals(StringHelper::initial('test'), 't');
		$this->assertEquals(StringHelper::initial('TEST'), 'T');
		$this->assertEquals(StringHelper::initial('86dev'), '8');
		$this->assertEquals(StringHelper::initial('The Hubble Telescope'), 'THT');
		$this->assertEquals(StringHelper::initial('the Big Bang Theory'), 'tBBT');
	}
}