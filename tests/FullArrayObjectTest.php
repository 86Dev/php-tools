<?php

use PHPTools\FullArrayObject;
use PHPUnit\Framework\TestCase;
require_once "E:\dev\wp-generators\skeleton\includes\base\FullArrayObject.class.php";

class FullArrayObjectTest extends TestCase
{
	public function test_instance()
	{
		$values = [0];
		$a = new FullArrayObject($values);
		$b = new FullArrayObject($values);

		$this->assertNotSame($values, $a);
		$this->assertNotSame($values, $b);
		$this->assertNotSame($a, $b);

		$this->assertNotEquals($values, $a);
		$this->assertNotEquals($values, $b);
		$this->assertEquals($a, $b);

		$this->assertFalse($values == $a);
		$this->assertFalse($values == $b);
		$this->assertTrue($a == $b);

		$this->assertFalse($values === $a);
		$this->assertFalse($values === $b);
		$this->assertFalse($a === $b);

		$this->assertSame($values, $a->getArrayCopy());
		$this->assertSame($values, $b->getArrayCopy());
		$this->assertSame($a->getArrayCopy(), $b->getArrayCopy());

		$this->assertEquals($values, $a->getArrayCopy());
		$this->assertEquals($values, $b->getArrayCopy());
		$this->assertEquals($a->getArrayCopy(), $b->getArrayCopy());

		$this->assertTrue($values == $a->getArrayCopy());
		$this->assertTrue($values == $b->getArrayCopy());
		$this->assertTrue($a->getArrayCopy() == $b->getArrayCopy());

		$this->assertTrue($values === $a->getArrayCopy());
		$this->assertTrue($values === $b->getArrayCopy());
		$this->assertTrue($a->getArrayCopy() === $b->getArrayCopy());
	}

	public function test_is_traversable()
	{
		$this->assertTrue(FullArrayObject::is_traversable([]));
		$this->assertTrue(FullArrayObject::is_traversable([0]));
		$this->assertTrue(FullArrayObject::is_traversable(new ArrayObject()));
		$this->assertTrue(FullArrayObject::is_traversable(new ArrayObject([0])));
		$this->assertTrue(FullArrayObject::is_traversable(new FullArrayObject()));
		$this->assertTrue(FullArrayObject::is_traversable(new FullArrayObject([0])));
	}

	public function test_to_array()
	{
		$value = [0];
		$this->assertSame($value, FullArrayObject::to_array($value, false));
		$this->assertSame($value, FullArrayObject::to_array($value, true));

		$value = [0, [0]];
		$this->assertSame($value, FullArrayObject::to_array($value, false));
		$this->assertSame($value, FullArrayObject::to_array($value, true));

		$value = [0, [0], 'key' => 'value'];
		$this->assertSame($value, FullArrayObject::to_array($value, false));
		$this->assertSame($value, FullArrayObject::to_array($value, true));

		$value = [[0, [0], 'key' => 'value'], [0, [0], 'key' => 'value']];
		$this->assertSame($value, FullArrayObject::to_array($value, false));
		$this->assertSame($value, FullArrayObject::to_array($value, true));
	}

	public function test_traversable_to_array()
	{
		$value = [0];
		$this->assertSame($value, FullArrayObject::to_array(new FullArrayObject($value), false));
		$this->assertSame($value, FullArrayObject::to_array(new FullArrayObject($value), true));

		$value = [0, 1, 'key' => 'value'];
		$this->assertSame($value, FullArrayObject::to_array(new FullArrayObject($value), false));
		$this->assertSame($value, FullArrayObject::to_array(new FullArrayObject($value), true));

		$value = [0, [1], new FullArrayObject([2]), 'key' => 'value'];
		$cast = [0, [1], [2], 'key' => 'value'];
		$this->assertSame($value, FullArrayObject::to_array(new FullArrayObject($value), false));
		$this->assertSame($cast, FullArrayObject::to_array(new FullArrayObject($value), true));

		$value = [[[0]]];
		$test = new FullArrayObject([new FullArrayObject([new FullArrayObject([0])])]);
		$this->assertSame($test->getArrayCopy(), FullArrayObject::to_array($test, false));
		$this->assertSame($value, FullArrayObject::to_array($test, true));
	}

	public function test_to_arrays()
	{
		$values = [[0], [0]];
		$this->assertSame($values, FullArrayObject::to_arrays(false, ...$values));
		$this->assertSame($values, FullArrayObject::to_arrays(true, ...$values));

		$traversables = [new FullArrayObject([0]), new FullArrayObject([0])];
		$this->assertSame($values, FullArrayObject::to_arrays(false, ...$traversables));
		$this->assertSame($values, FullArrayObject::to_arrays(true, ...$traversables));

		$values = [[0]];
		$this->assertSame($values, FullArrayObject::to_arrays(false, ...$values));
		$this->assertSame($values, FullArrayObject::to_arrays(true, ...$values));

		$traversables = [new FullArrayObject([0])];
		$this->assertSame($values, FullArrayObject::to_arrays(false, ...$traversables));
		$this->assertSame($values, FullArrayObject::to_arrays(true, ...$traversables));
	}

    public function test_empty()
    {
        $array = new FullArrayObject();
		$this->assertCount(0, $array);
		$this->assertTrue(FullArrayObject::is_traversable($array));
	}

	public function test_​change_​key_​case()
	{
		$test = new FullArrayObject(['a' => 'a', 'b' => 'b', 'c' => 'c']);
		$this->assertEquals(new FullArrayObject(['A' => 'a', 'B' => 'b', 'C' => 'c']), $upper = $test->change_key_case(CASE_UPPER));
		$this->assertEquals($test, $upper->change_key_case(CASE_LOWER));
	}

	public function test_​chunk()
	{
		$test = new FullArrayObject(['a' => 'a', 'b' => 'b', 'c' => 'c']);
		$this->assertEquals(new FullArrayObject([['a', 'b'], ['c']]), $test->chunk(2, false));
		$this->assertEquals(new FullArrayObject([['a' => 'a', 'b' => 'b'], ['c' => 'c']]), $test->chunk(2, true));
	}

	public function test_​column()
	{
		$test = new FullArrayObject([
			['last_name' => 'A', 'first_name' => 'a'],
			['last_name' => 'B', 'first_name' => 'b'],
			['last_name' => 'C', 'first_name' => 'c'],
		]);
		$this->assertEquals(new FullArrayObject(['A', 'B', 'C']), $test->column('last_name'));
		$this->assertEquals(new FullArrayObject(['A' => 'a', 'B' => 'b', 'C' => 'c']), $test->column('first_name', 'last_name'));
	}

	public function test_​combine()
	{
		$values = ['A', 'B', 'C'];
		$keys = ['a', 'b', 'c'];
		$this->assertEquals(new FullArrayObject(array_combine($keys, $values)), FullArrayObject::combine($keys, $values));
	}

	public function test_​count_​values()
	{
		$test = new FullArrayObject([1, 2, 2, 3, 3, 3]);
		$this->assertEquals(new FullArrayObject(['1' => 1, '2' => 2, '3' => 3]), $test->count_values());
	}

	public function test_​diff_​assoc()
	{
		$testA = new FullArrayObject(['a' => 'A', 'b' => 'B']);
		$testB = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C']);
		$testC = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D']);
		$this->assertEquals(new FullArrayObject(), $testA->diff_assoc($testB));
		$this->assertEquals(new FullArrayObject(['c' => 'C']), $testB->diff_assoc($testA));
		$this->assertEquals(new FullArrayObject(['d' => 'D']), $testC->diff_assoc($testA, $testB));

	}

	public function test_​diff_​key()
	{
		$testA = new FullArrayObject(['a' => 'A', 'b' => 'B']);
		$testB = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C']);
		$testC = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D']);
		$this->assertEquals(new FullArrayObject(), $testA->diff_key($testB));
		$this->assertEquals(new FullArrayObject(['c' => 'C']), $testB->diff_key($testA));
		$this->assertEquals(new FullArrayObject(['d' => 'D']), $testC->diff_key($testA, $testB));
	}

	public function test_​diff_​uassoc()
	{
		$testA = new FullArrayObject(['a' => 'A', 'b' => 'B']);
		$testB = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C']);
		$testC = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D']);
		$this->assertEquals(new FullArrayObject(), $testA->diff_uassoc(function($a, $b) { return strcmp($a, $b); }, $testB));
		$this->assertEquals(new FullArrayObject(['c' => 'C']), $testB->diff_uassoc(function($a, $b) { return strcmp($a, $b); }, $testA));
		$this->assertEquals(new FullArrayObject(['d' => 'D']), $testC->diff_uassoc(function($a, $b) { return strcmp($a, $b); }, $testA, $testB));
	}

	public function test_​diff_​ukey()
	{
		$testA = new FullArrayObject(['a' => 'A', 'b' => 'B']);
		$testB = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C']);
		$testC = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D']);
		$this->assertEquals(new FullArrayObject(), $testA->diff_ukey(function($a, $b) { return strcmp($a, $b); }, $testB));
		$this->assertEquals(new FullArrayObject(['c' => 'C']), $testB->diff_ukey(function($a, $b) { return strcmp($a, $b); }, $testA));
		$this->assertEquals(new FullArrayObject(['d' => 'D']), $testC->diff_ukey(function($a, $b) { return strcmp($a, $b); }, $testA, $testB));
	}

	public function test_​diff()
	{
		$testA = new FullArrayObject(['a' => 'A', 'b' => 'B']);
		$testB = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C']);
		$testC = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D']);
		$this->assertEquals(new FullArrayObject(), $testA->diff($testB));
		$this->assertEquals(new FullArrayObject(['c' => 'C']), $testB->diff($testA));
		$this->assertEquals(new FullArrayObject(['d' => 'D']), $testC->diff($testA, $testB));
	}

	public function test_​fill_​keys()
	{
		$test = new FullArrayObject(['a', 'b', 'c']);
		$this->assertEquals(new FullArrayObject(), (new FullArrayObject())->fill_keys(0));
		$this->assertEquals(new FullArrayObject(['a' => 0, 'b' => 0, 'c' => 0]), $test->fill_keys(0));
	}

	public function test_​fill()
	{
		$this->assertEquals(new FullArrayObject(), FullArrayObject::fill(0, 0, 0));
		$this->assertEquals(new FullArrayObject([0, 0, 0]), FullArrayObject::fill(0, 3, 0));
		$this->assertEquals(new FullArrayObject([5 => 0, 0, 0]), FullArrayObject::fill(5, 3, 0));
	}

	public function test_​filter()
	{
		$test = new FullArrayObject([0, 1, 'a' => 'a']);
		$this->assertEquals(new FullArrayObject([1 => 1, 'a' => 'a']), $test->filter());
		$this->assertEquals(new FullArrayObject([0, 1]), $test->filter('is_numeric'));
		$this->assertEquals(new FullArrayObject(['a' => 'a']), $test->filter('is_string', ARRAY_FILTER_USE_KEY));
		$this->assertEquals(new FullArrayObject([1 => 1]), $test->filter(function($key, $value) { return is_numeric($key) && !!$value; }, ARRAY_FILTER_USE_BOTH));
	}

	public function test_​flip()
	{
		$test = new FullArrayObject(['a', 'b', 'c']);
		$this->assertEquals(new FullArrayObject(['a' => 0, 'b' => 1, 'c' => 2]), $test->flip());
	}

	public function test_​intersect_​assoc()
	{
		$testA = new FullArrayObject(['a' => 'A', 'b' => 'B']);
		$testB = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C']);
		$testC = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D']);
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testA->intersect_assoc($testB));
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testB->intersect_assoc($testA));
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testC->intersect_assoc($testA, $testB));
	}

	public function test_​intersect_​key()
	{
		$testA = new FullArrayObject(['a' => 'A', 'b' => 'B']);
		$testB = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C']);
		$testC = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D']);
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testA->intersect_key($testB));
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testB->intersect_key($testA));
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testC->intersect_key($testA, $testB));
	}

	public function test_​intersect_​uassoc()
	{
		$testA = new FullArrayObject(['a' => 'A', 'b' => 'B']);
		$testB = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C']);
		$testC = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D']);
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testA->intersect_uassoc(function($a, $b) { return strcmp($a, $b); }, $testB));
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testB->intersect_uassoc(function($a, $b) { return strcmp($a, $b); }, $testA));
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testC->intersect_uassoc(function($a, $b) { return strcmp($a, $b); }, $testA, $testB));
	}

	public function test_​intersect_​ukey()
	{
		$testA = new FullArrayObject(['a' => 'A', 'b' => 'B']);
		$testB = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C']);
		$testC = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D']);
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testA->intersect_ukey(function($a, $b) { return strcmp($a, $b); }, $testB));
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testB->intersect_ukey(function($a, $b) { return strcmp($a, $b); }, $testA));
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testC->intersect_ukey(function($a, $b) { return strcmp($a, $b); }, $testA, $testB));
	}

	public function test_​intersect()
	{
		$testA = new FullArrayObject(['a' => 'A', 'b' => 'B']);
		$testB = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C']);
		$testC = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D']);
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testA->intersect($testB));
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testB->intersect($testA));
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testC->intersect($testA, $testB));
	}

	public function test_​key_​exists()
	{
		$test = new FullArrayObject([0, 'a' => 1]);
		$this->assertTrue($test->key_exists(0));
		$this->assertTrue($test->key_exists('a'));
		$this->assertFalse($test->key_exists(1));
		$this->assertFalse($test->key_exists('b'));
	}

	// public function test_​key_​first()
	// {
	// 	$test = new FullArrayObject([0, 1, 2]);
	// 	$this->assertSame(0, $test->key_first());
	// }

	// public function test_​key_​last()
	// {
	// 	$test = new FullArrayObject([0, 1, 2]);
	// 	$this->assertSame(2, $test->key_first());
	// }

	public function test_​keys()
	{
		$test = new FullArrayObject([null, 'a' => 10, 'aa' => '10']);
		$this->assertEquals(new FullArrayObject([0, 'a', 'aa']), $test->keys());
		$this->assertEquals(new FullArrayObject(['a', 'aa']), $test->keys(10));
		$this->assertEquals(new FullArrayObject(['a']), $test->keys(10, true));
	}

	public function test_​map()
	{
		$test = new FullArrayObject([0, 'a']);
		$this->assertEquals(new FullArrayObject([true, false]), $test->map('is_numeric'));
	}

	public function test_​merge_​recursive()
	{
		$testA = new FullArrayObject(['a' => 'A', 'a']);
		$testB = new FullArrayObject(['a' => 'B', 'b']);
		$testC = new FullArrayObject(['a' => 'C', 'c']);
		$this->assertEquals(new FullArrayObject(['a' => ['A', 'B'], 'a', 'b']), $testA->merge_recursive($testB));
		$this->assertEquals(new FullArrayObject(['a' => ['B', 'A'], 'b', 'a']), $testB->merge_recursive($testA));
		$this->assertEquals(new FullArrayObject(['a' => ['C', 'B', 'A'], 'c', 'b', 'a']), $testC->merge_recursive($testB, $testA));
	}

	public function test_​merge()
	{
		$testA = new FullArrayObject(['a' => 'A', 'a']);
		$testB = new FullArrayObject(['a' => 'B', 'b']);
		$testC = new FullArrayObject(['a' => 'C', 'c']);
		$this->assertEquals(new FullArrayObject(['a' => 'B', 'a', 'b']), $testA->merge($testB));
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b', 'a']), $testB->merge($testA));
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'c', 'b', 'a']), $testC->merge($testB, $testA));
	}

	public function test_​multisort()
	{
		$this->assertFalse(false);
		// $test = new FullArrayObject([3, 2, 1, 'a', 'A', '0']);
		// $test->multisort();
		// $this->assertEquals(new FullArrayObject(['0', 'A', 'a', 1, 2, 3]), $test);
		// $test->multisort(SORT_DESC);
		// $this->assertEquals(new FullArrayObject([3, 2, 1, 'a', 'A', '0']), $test);
		// $test->multisort(SORT_ASC, SORT_STRING);
		// $this->assertEquals(new FullArrayObject(['0', 1, 2, 3, 'A', 'a']), $test);

		// $test = new FullArrayObject([
		// 	'name' => new FullArrayObject(['Alan', 'Charlie', 'Bob', 'Zoe', 'Charlie']),
		// 	'age' => new FullArrayObject([23, 54, 37, 6, 75]),
		// ]);
		// $test->name->multisort(SORT_ASC, SORT_REGULAR, $test->age);
		// $this->assertEquals(new FullArrayObject(['Alan', 'Bob', 'Charlie', 'Charlie', 'Zoe']), $test->name);
		// $this->assertEquals(new FullArrayObject([23, 37, 54, 75, 6]), $test->age);
		// $test->multisort(SORT_DESC);
		// $this->assertEquals(new FullArrayObject([3, 2, 1, 'a', 'A', '0']), $test);
		// $test->multisort(SORT_ASC, SORT_STRING);
		// $this->assertEquals(new FullArrayObject(['0', 1, 2, 3, 'A', 'a']), $test);
	}

	public function test_​pad()
	{
		$test = new FullArrayObject([0, 1]);
		$this->assertEquals(new FullArrayObject([0, 1, null, null, null]), $test->pad(5, null));
		$this->assertEquals(new FullArrayObject([null, null, null, 0, 1]), $test->pad(-5, null));
		$this->assertEquals(new FullArrayObject([0, 1]), $test->pad(2, null));
	}

	public function test_​pop()
	{
        $array = new FullArrayObject(['1']);
		$value = $array->pop();
		$this->assertSame(0, $array->count());
		$this->assertEmpty($array);
		$this->assertSame('1', $value);
	}

	public function test_​product()
	{
		$test = new FullArrayObject([3, 3]);
		$this->assertSame(9, $test->product());
	}

	public function test_​push()
	{
        $array = new FullArrayObject();
		$array->push('1');
		$this->assertSame(1, $array->count());
        $this->assertNotEmpty($array);
	}

	public function test_​rand()
	{
		$test = new FullArrayObject(['a', 'b', 'c']);
		$rand = $test->rand(1);
		$this->assertIsInt($rand);
		$this->assertTrue($test->key_exists($rand));

		$rand = $test->rand(2);
		$this->assertInstanceOf(FullArrayObject::class, $rand);
		$this->assertCount(2, $rand);
		foreach ($rand as $value) {
			$this->assertTrue($test->key_exists($value));
		}
	}

	public function test_​reduce()
	{
		$values = [1, 3];
		$test = new FullArrayObject($values);
		$this->assertEquals(4, $test->reduce(function ($initial, $value) { return $initial + $value; }, 0));
	}

	public function test_​replace_​recursive()
	{
		$test = new FullArrayObject([0, 1, 'a' => ['A', 'b' => 'B']]);
		$test2 = new FullArrayObject([2, 'a' => ['AA'], 'b' => 'BB']);
		$test3 = new FullArrayObject([1 => 2, 4 => 2, 'a' => ['b' => 'BBB']]);
		$this->assertEquals(new FullArrayObject([2, 1, 'a' => ['AA', 'b' => 'B'], 'b' => 'BB']), $test->replace_recursive($test2));
		$this->assertEquals(new FullArrayObject([2, 2, 4 => 2, 'a' => ['AA', 'b' => 'BBB'], 'b' => 'BB']), $test->replace_recursive($test2, $test3));
	}

	public function test_​replace()
	{
		$test =new FullArrayObject([0, 1, 'a' => 'A']);
		$test2 = new FullArrayObject([2, 'a' => 'AA', 'b' => 'BB']);
		$test3 = new FullArrayObject([1 => 2, 4 => 2, 'a' => 'AAA']);
		$this->assertEquals(new FullArrayObject([2, 1, 'a' => 'AA', 'b' => 'BB']), $test->replace($test2));
		$this->assertEquals(new FullArrayObject([2, 2, 4 => 2, 'a' => 'AAA', 'b' => 'BB']), $test->replace($test2, $test3));
	}

	public function test_​reverse()
	{
		$test = new FullArrayObject([0, 1, 2, 3]);
		$this->assertEquals(new FullArrayObject([3, 2, 1, 0]), $test->reverse());
		$this->assertEquals(new FullArrayObject([3 => 3, 2 => 2, 1 => 1, 0 => 0]), $test->reverse(true));
	}

	public function test_​search()
	{
		$test = new FullArrayObject([0, 1, 2, 3]);
		$this->assertSame(0, $test->search(0));
		$this->assertSame(1, $test->search('1'));
		$this->assertFalse($test->search('1', true));
	}

	public function test_​shift()
	{
        $array = new FullArrayObject(['1', '2']);
		$value = $array->shift();
		$this->assertNotEmpty($array);
		$this->assertSame(1, $array->count());
		$this->assertSame('1', $value);
	}

	public function test_​slice()
	{
		$test = new FullArrayObject([0, 1, 2, 3]);
		$this->assertEquals(new FullArrayObject([1, 2]), $test->slice(1, 2));
		$this->assertEquals(new FullArrayObject([1 => 1, 2]), $test->slice(1, 2, true));
	}

	public function test_​splice()
	{
		$test = new FullArrayObject([0, 1, 2, 3]);
		$result = $test->splice(0, 1);
		$this->assertEquals(new FullArrayObject([1, 2, 3]), $test);
		$this->assertEquals(new FullArrayObject([0]), $result);
	}

	public function test_​sum()
	{
		$test = new FullArrayObject([3, 4]);
		$this->assertSame(7, $test->sum());
	}

	public function test_​udiff_​assoc()
	{
		$testA = new FullArrayObject(['a' => 'A', 'b' => 'B']);
		$testB = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C']);
		$testC = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D']);
		$this->assertEquals(new FullArrayObject(), $testA->udiff_assoc('strcmp', $testB));
		$this->assertEquals(new FullArrayObject(['c' => 'C']), $testB->udiff_assoc('strcmp', $testA));
		$this->assertEquals(new FullArrayObject(['d' => 'D']), $testC->udiff_assoc('strcmp', $testA, $testB));

	}

	public function test_​udiff_​uassoc()
	{
		$testA = new FullArrayObject(['a' => 'A', 'b' => 'B']);
		$testB = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C']);
		$testC = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D']);
		$this->assertEquals(new FullArrayObject(), $testA->udiff_uassoc('strcmp', 'strcmp', $testB));
		$this->assertEquals(new FullArrayObject(['c' => 'C']), $testB->udiff_uassoc('strcmp', 'strcmp', $testA));
		$this->assertEquals(new FullArrayObject(['d' => 'D']), $testC->udiff_uassoc('strcmp', 'strcmp', $testA, $testB));

	}

	public function test_​udiff()
	{
		$testA = new FullArrayObject(['a' => 'A', 'b' => 'B']);
		$testB = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C']);
		$testC = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D']);
		$this->assertEquals(new FullArrayObject(), $testA->udiff('strcmp', $testB));
		$this->assertEquals(new FullArrayObject(['c' => 'C']), $testB->udiff('strcmp', $testA));
		$this->assertEquals(new FullArrayObject(['d' => 'D']), $testC->udiff('strcmp', $testA, $testB));
	}

	public function test_​uintersect_​assoc()
	{
		$testA = new FullArrayObject(['a' => 'A', 'b' => 'B']);
		$testB = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C']);
		$testC = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D']);
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testA->uintersect_assoc('strcmp', $testB));
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testB->uintersect_assoc('strcmp', $testA));
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testC->uintersect_assoc('strcmp', $testA, $testB));
	}

	public function test_​uintersect_​uassoc()
	{
		$testA = new FullArrayObject(['a' => 'A', 'b' => 'B']);
		$testB = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C']);
		$testC = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D']);
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testA->uintersect_uassoc('strcmp', 'strcmp', $testB));
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testB->uintersect_uassoc('strcmp', 'strcmp', $testA));
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testC->uintersect_uassoc('strcmp', 'strcmp', $testA, $testB));
	}

	public function test_​uintersect()
	{
		$testA = new FullArrayObject(['a' => 'A', 'b' => 'B']);
		$testB = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C']);
		$testC = new FullArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D']);
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testA->uintersect('strcmp', $testB));
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testB->uintersect('strcmp', $testA));
		$this->assertEquals(new FullArrayObject(['a' => 'A', 'b' => 'B']), $testC->uintersect('strcmp', $testA, $testB));
	}

	public function test_​unique()
	{
		$test = new FullArrayObject([0, 0, 1, 1, 2]);
		$this->assertEquals(new FullArrayObject([0, 2 => 1, 4 => 2]), $test->unique());
	}

	public function test_​unshift()
	{
		$test = new FullArrayObject([0, 1, 2, 3]);
		$this->assertEquals(new FullArrayObject([-1, 0, 1, 2, 3]), $test->unshift(-1));
	}

	public function test_​values()
	{
		$test = new FullArrayObject(['A' => 'a', 'B' => 'b', 'C' => 'c']);
		$this->assertEquals(new FullArrayObject(['a', 'b', 'c']), $test->values());
	}

	public function test_​walk_​recursive()
	{
		$this->assertFalse(false);

	}

	public function test_​walk()
	{

		$this->assertFalse(false);
	}

	public function test_arsort()
	{
		$this->assertFalse(false);

	}

	public function test_asort()
	{
		$this->assertFalse(false);

	}

	public function test_count()
	{
		$this->assertFalse(false);

	}

	public function test_current()
	{
		$this->assertFalse(false);

	}

	public function test_end()
	{
		$this->assertFalse(false);

	}

	public function test_includes()
	{
		$test = new FullArrayObject([0, 1, 2]);
		$this->assertTrue($test->includes(0));
		$this->assertFalse($test->includes(3));
	}

	public function test_krsort()
	{
		$test = new FullArrayObject([0, 1, 2]);
		$this->assertEquals(new FullArrayObject([0, 1, 2]), $test->krsort());

		$test = new FullArrayObject([0, 'b' => 1, 'a' => 2]);
		$this->assertEquals(new FullArrayObject(['b' => 1, 'a' => 2, 0 => 0]), $test->krsort());
	}

	public function test_ksort()
	{
		$test = new FullArrayObject([0, 1, 2]);
		$test->ksort();
		$this->assertEquals(new FullArrayObject([0, 1, 2]), $test);

		$test = new FullArrayObject([0, 'b' => 1, 'a' => 2]);
		$test->ksort();
		$this->assertEquals(new FullArrayObject([0, 'a' => 2, 'b' => 1]), $test);
	}

	public function test_natcasesort()
	{
		$this->assertFalse(false);

	}

	public function test_natsort()
	{
		$this->assertFalse(false);

	}

	public function test_next()
	{
		$this->assertFalse(false);

	}

	public function test_pos()
	{
		$this->assertFalse(false);

	}

	public function test_prev()
	{
		$this->assertFalse(false);

	}

	public function test_range()
	{
		$this->assertFalse(false);

	}

	public function test_reset()
	{
		$this->assertFalse(false);

	}

	public function test_rsort()
	{
		$this->assertFalse(false);

	}

	public function test_shuffle()
	{
		$this->assertFalse(false);

	}

	public function test_sort()
	{
		$this->assertFalse(false);

	}

	public function test_uasort()
	{
		$this->assertFalse(false);

	}

	public function test_uksort()
	{
		$this->assertFalse(false);

	}

	public function test_usort()
	{
		$this->assertFalse(false);

	}

	public function test_jsonencode()
	{
		$test = new FullArrayObject([
			'a' => 'A',
			'b' => 'B',
			'c' => [0, 1, 2],
			'd' => new FullArrayObject(['e' => 'E']),
			'f' => true,
			'g' => false,
			'h' => null
		]);
		$this->assertSame('{"a":"A","b":"B","c":[0,1,2],"d":{"e":"E"},"f":true,"g":false,"h":null}', json_encode($test));
	}
}
