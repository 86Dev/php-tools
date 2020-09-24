<?php

declare(strict_types = 1);

namespace PHPTools;

class FullArrayObject extends \ArrayObject
{
	/**
	 * Construct a new array object
	 *
	 * @param array|object $input — The input parameter accepts an array or an Object.
	 * @param int $flags — Flags to control the behaviour of the ArrayObject object.
	 * @param string $iterator_class Specify the class that will be used for iteration of the ArrayObject object. ArrayIterator is the default class used.
	 *
	 * @return self
	 */
	public function __construct($input = [], $flags = \ArrayObject::ARRAY_AS_PROPS, $iterator_class = "ArrayIterator")
	{
		parent::__construct($input, $flags, $iterator_class);
	}

	/**
	 * Indicates if the given value is traversable
	 *
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public static function is_traversable($value): bool
	{
		return is_array($value) || is_subclass_of($value, \Traversable::class);
	}

	/**
	 * Cast an array or Traversable object as array
	 *
	 * @param array|Traversable $array
	 * @param bool $recursive Indicates if all traversable values should also be converted to array recursively.
	 *
	 * @return array
	 */
	public static function to_array($array, $recursive = false): array
	{
		if (static::is_traversable($array)) {
			$tmp = [];
			foreach ($array as $key => &$value) {
				$tmp[$key] = $recursive && static::is_traversable($value) ? static::to_array($value, $recursive) : $value;
			}
			$array = $tmp;
		} else {
			$array = [];
		}
		return $array;
	}

	/**
	 * Cast a list of arrays or Traversable objects to a list of arrays
	 *
	 * @param bool $recursive
	 * @param array|\Traversable ...$arrays
	 *
	 * @return array
	 */
	public static function to_arrays($recursive, ...$arrays): array
	{
		foreach ($arrays as $key => $array) {
			if (static::is_traversable($array)) {
				$arrays[$key] = static::to_array($array, $recursive);
			}
		}
		return $arrays;
	}

	/**
	 * Changes the case of all keys in an array
	 *
	 * @param int $case [optional] Either CASE_UPPER or CASE_LOWER (default)
	 *
	 * @return self an array with its keys lower or uppercased
	 *
	 * @link https://php.net/manual/en/function.array-change-key-case.php
	 */
	public function change_key_case($case = CASE_LOWER): self
	{
		return new static(array_change_key_case($this->getArrayCopy(), $case));
	}

	/**
	 * Split an array into chunks
	 *
	 * @param int $size The size of each chunk
	 * @param bool $preserve_keys [optional] When set to true keys will be preserved. Default is false which will reindex the chunk numerically
	 *
	 * @return self a multidimensional numerically indexed array, starting with zero, with each dimension containing size elements.
	 *
	 * @link https://php.net/manual/en/function.array-chunk.php
	 */
	public function chunk($size, $preserve_keys = false): self
	{
		return new static(array_chunk($this->getArrayCopy(), $size, $preserve_keys));
	}

	/**
	 * Return the values from a single column in the input array
	 *
	 * @param mixed $column The column of values to return. This value may be the integer key of the column you wish to retrieve, or it may be the string key name for an associative array. It may also be NULL to return complete arrays (useful together with index_key to reindex the array).
	 * @param mixed $index_key [optional] The column to use as the index/keys for the returned array. This value may be the integer key of the column, or it may be the string key name.
	 *
	 * @return self Returns an array of values representing a single column from the input array.
	 *
	 * @link https://secure.php.net/manual/en/function.array-column.php
	 */
	public function column($column, $index_key = null): self
	{
		return new static(array_column($this->getArrayCopy(), $column, $index_key));
	}

	/**
	 * Creates an array by using one array for keys and another for its values
	 *
	 * @param array|self $keys Array of keys to be used. Illegal values for key will be converted to string.
	 * @param array|self $values Array of values to be used
	 *
	 * @return self the combined array
	 *
	 * @link https://php.net/manual/en/function.array-combine.php
	 *
	 * @static
	 */
	public static function combine($keys, $values): self
	{
		return new static(array_combine($keys, $values));
	}

	/**
	 * Counts all the values of an array
	 *
	 * @return self an associative array of values from this as keys and their count as value.
	 *
	 * @link https://php.net/manual/en/function.array-count-values.php
	 */
	public function count_values(): self
	{
		return new static(array_count_values($this->getArrayCopy()));
	}

	/**
	 * Computes the difference of arrays with additional index check
	 *
	 * @param Traversable $arrays Arrays to compare against
	 *
	 * @return self an array containing all the values from array1 that are not present in any of the other arrays.
	 *
	 * @link https://php.net/manual/en/function.array-diff-assoc.php
	 */
	public function diff_assoc(...$arrays): self
	{
		$arrays = static::to_arrays(false, ...$arrays);
		return new static(array_diff_assoc($this->getArrayCopy(), ...$arrays));
	}

	/**
	 * Computes the difference of arrays using keys for comparison
	 *
	 * @param array|self $arrays Arrays to compare against
	 *
	 * @return self an array containing all the entries from array1 whose keys are not present in any of the other arrays.
	 *
	 * @link https://php.net/manual/en/function.array-diff-key.php
	 */
	public function diff_key(...$arrays): self
	{
		$arrays = static::to_arrays(false, ...$arrays);
		return new static(array_diff_key($this->getArrayCopy(), ...$arrays));
	}

	/**
	 * Computes the difference of arrays with additional index check which is performed by a user supplied callback function
	 *
	 * @param callable $key_compare_func callback function to use. The callback function must return an integer less than, equal to, or greater than zero if the first argument is considered to be respectively less than, equal to, or greater than the second.
	 * `callback ( mixed $a, mixed $b ) : int`
	 * @param array|self $arrays Arrays to compare against
	 *
	 * @return self an array containing all the entries from array1 that are not present in any of the other arrays.
	 *
	 * @link https://php.net/manual/en/function.array-diff-uassoc.php
	 */
	public function diff_uassoc(callable $key_compare_func, ...$arrays): self
	{
		$arrays = static::to_arrays(false, ...$arrays);
		$args = new static([$this->getArrayCopy()]);
		$args->push(...$arrays);
		$args->push($key_compare_func);
		return new static(call_user_func_array('array_diff_uassoc', $args->getArrayCopy()));
	}

	/**
	 * Computes the difference of arrays using a callback function on the keys for comparison
	 *
	 * @param callable $key_compare_func callback function to use. The callback function must return an integer less than, equal to, or greater than zero if the first argument is considered to be respectively less than, equal to, or greater than the second.
	 * `callback ( mixed $a, mixed $b ) : int`
	 * @param array|self $arrays Arrays to compare against
	 *
	 * @return self an array containing all the entries from array1 that are not present in any of the other arrays.
	 *
	 * @link https://php.net/manual/en/function.array-diff-ukey.php
	 */
	public function diff_ukey(callable $key_compare_func, ...$arrays): self
	{
		$arrays = static::to_arrays(false, ...$arrays);
		$args = new static([$this->getArrayCopy()]);
		$args->push(...$arrays);
		$args->push($key_compare_func);
		return new static(call_user_func_array('array_diff_ukey', $args->getArrayCopy()));
	}

	/**
	 * Computes the difference of arrays
	 *
	 * @param array|self $arrays Arrays to compare against
	 *
	 * @return self an array containing all the entries from array1 that are not present in any of the other arrays.
	 *
	 * @link https://php.net/manual/en/function.array-diff.php
	 */
	public function diff(...$arrays): self
	{
		$arrays = static::to_arrays(false, ...$arrays);
		return new static(array_diff($this->getArrayCopy(), ...$arrays));
	}

	/**
	 * Fill an array with values, specifying keys
	 *
	 * This array values will be used as keys. Illegal values for key will be converted to string.
	 *
	 * @param mixed $value Value to use for filling
	 *
	 * @return self the filled array
	 *
	 * @link https://php.net/manual/en/function.array-fill-keys.php
	 */
	public function fill_keys($value): self
	{
		return new static(array_fill_keys($this->getArrayCopy(), $value));
	}

	/**
	 * Fill an array with values
	 *
	 * @static
	 *
	 * @param int $start_index The first index of the returned array. Supports non-negative indexes only.
	 * @param int $num Number of elements to insert
	 * @param mixed $value Value to use for filling
	 *
	 * @return self the filled array
	 *
	 * @link https://php.net/manual/en/function.array-fill.php
	 */
	public static function fill($start_index, $num, $value): self
	{
		return new static(array_fill($start_index, $num, $value));
	}

	/**
	 * Filters elements of an array using a callback function
	 *
	 * If the callback function returns true, the current value from array is returned into the result array. Array keys are preserved.
	 *
	 * @param callable $callback [optional] The callback function to use
	 *
	 * If no callback is supplied, all entries of input equal to false (see converting to boolean) will be removed.
	 *
	 * @param int $flag [optional] Flag determining what arguments are sent to callback:
	 * + 0 - pass value as the only argument to callback: `callback(mixed $value): bool`
	 * + ARRAY_FILTER_USE_KEY - pass key as the only argument to callback instead of the value: `callback(mixed $key): bool`
	 * + ARRAY_FILTER_USE_BOTH - pass both value and key as arguments to callback instead of the value: `callback(mixed $key, ùixed $value): bool`
	 *
	 * @return self the filtered array.
	 *
	 * @link https://php.net/manual/en/function.array-filter.php
	 */
	public function filter(callable $callback = null, $flag = 0): self
	{
		// array_filter doesn't work if passing empty $callback
		if (!$callback) {
			return new static(array_filter($this->getArrayCopy()));
		}
		return new static(array_filter($this->getArrayCopy(), $callback, $flag));
	}

	/**
	 * Exchanges all keys with their associated values in an array
	 *
	 * @return self Returns the flipped array.
	 *
	 * @link https://php.net/manual/en/function.array-flip.php
	 */
	public function flip(): self
	{
		return new static(array_flip($this->getArrayCopy()));
	}

	/**
	 * Computes the intersection of arrays with additional index check
	 *
	 * @param array|self $arrays Arrays to compare values against.
	 *
	 * @return self an associative array containing all the values in array1 that are present in all of the arguments.
	 *
	 * @link https://php.net/manual/en/function.array-intersect-assoc.php
	 */
	public function intersect_assoc(...$arrays): self
	{
		$arrays = static::to_arrays(false, ...$arrays);
		return new static(array_intersect_assoc($this->getArrayCopy(), ...$arrays));
	}

	/**
	 * Computes the intersection of arrays using keys for comparison
	 *
	 * @param array|self $arrays Arrays to compare keys against.
	 *
	 * @return self an associative array containing all the entries of array1 which have keys that are present in all arguments.
	 *
	 * @link https://php.net/manual/en/function.array-intersect-key.php
	 */
	public function intersect_key(...$arrays): self
	{
		$arrays = static::to_arrays(false, ...$arrays);
		return new static(array_intersect_key($this->getArrayCopy(), ...$arrays));
	}

	/**
	 * Computes the intersection of arrays with additional index check, compares indexes by a callback function
	 *
	 * @param callable $key_compare_func User supplied callback function to do the comparison.
	 * @param array|self $arrays Arrays to compare keys against.
	 *
	 * @return array the values of this array whose values exist in all of the arguments.
	 *
	 * @link https://php.net/manual/en/function.array-intersect-uassoc.php
	 */
	public function intersect_uassoc(callable $key_compare_func, ...$arrays): self
	{
		$arrays = static::to_arrays(false, ...$arrays);
		$args = new static([$this->getArrayCopy()]);
		$args->push(...$arrays);
		$args->push($key_compare_func);
		return new static(call_user_func_array('array_intersect_uassoc', $args->getArrayCopy()));
	}

	/**
	 * Computes the intersection of arrays using a callback function on the keys for comparison
	 *
	 * @param callable $key_compare_func User supplied callback function to do the comparison.
	 * @param array|self $arrays Arrays to compare keys against.
	 *
	 * @return self the values of this array whose keys exist in all the arguments.
	 *
	 * @link https://php.net/manual/en/function.array-intersect-ukey.php
	 */
	public function intersect_ukey(callable $key_compare_func, ...$arrays): self
	{
		$arrays = static::to_arrays(false, ...$arrays);
		$args = new static([$this->getArrayCopy()]);
		$args->push(...$arrays);
		$args->push($key_compare_func);
		return new static(call_user_func_array('array_intersect_ukey', $args->getArrayCopy()));
	}

	/**
	 * Computes the intersection of arrays
	 *
	 * @param array|self $arrays Arrays to compare values against.
	 *
	 * @return self an array containing all of the values in array1 whose values exist in all of the parameters.
	 *
	 * @link https://php.net/manual/en/function.array-intersect.php
	 */
	public function intersect(...$arrays): self
	{
		$arrays = static::to_arrays(false, ...$arrays);
		return new static(array_intersect($this->getArrayCopy(), ...$arrays));
	}

	/**
	 * Checks if the given key or index exists in the array
	 *
	 * Alias for offsetExists.
	 *
	 * @param mixed $key Key to check.
	 *
	 * @return bool true on success or false on failure.
	 */
	public function key_exists($key): bool
	{
		return $this->offsetExists($key);
	}

	/**
	 * Gets the first key of an array
	 *
	 * Get the first key of the given array without affecting the internal array pointer.
	 *
	 * @return string|int|null Returns the first key of array if the array is not empty; NULL otherwise.
	 *
	 * @link https://secure.php.net/array_key_first
	 */
	// public function key_first()
	// {
	// 	return array_key_first($this->getArrayCopy());
	// }

	/**
	 * Gets the last key of an array
	 *
	 * Get the last key of the given array without affecting the internal array pointer.
	 *
	 * @return string|int|null Returns the last key of array if the array is not empty; NULL otherwise.
	 *
	 * @link https://secure.php.net/array_key_last
	 */
	// public function key_last()
	// {
	// 	return array_key_last($this->getArrayCopy());
	// }

	/**
	 * Return all the keys or a subset of the keys of an array
	 *
	 * @param mixed $search_value [optional] If specified, then only keys containing these values are returned.
	 *
	 * @param bool $strict [optional] Determines if strict comparison (===) should be used during the search.
	 *
	 * @return self an array of all the keys in input.
	 *
	 * @link https://php.net/manual/en/function.array-keys.php
	 */
	public function keys($search_value = null, $strict = null): self
	{
		$args = [$this->getArrayCopy()];
		$args = array_merge($args, func_get_args());
		return new static(call_user_func_array('array_keys', $args));
	}

	/**
	 * Applies the callback to the elements of the given arrays
	 *
	 * @param callback $callback Callback function to run for each element in each array.
	 *
	 * @param array|self $arrays [optional] Other arrays to run through the callback function.
	 *
	 * @return self an array containing all the elements of arr1 after applying the callback function to each one.
	 *
	 * @link https://php.net/manual/en/function.array-map.php
	 */
	public function map(callable $callback, ...$arrays): self
	{
		$arrays = static::to_arrays(false, ...$arrays);
		return new static(array_map($callback, $this->getArrayCopy(), ...$arrays));
	}

	/**
	 * Applies the callback to the keys of the given arrays
	 *
	 * @param callback $callback Callback function to run for each key in each array.
	 *
	 * @return self an array containing all the elements of this array after applying the callback function to each one.
	 *
	 * @link https://php.net/manual/en/function.array-map.php
	 */
	public function map_keys(callable $callback): self
	{
		return new static(array_map($callback, $this->keys()->getArrayCopy()));
	}

	/**
	 * Applies the callback to the key/value pair of the given arrays
	 *
	 * @param callback $callback Callback function to run for each key/value pair in each array. The callback fucntion should accept 2 parameters: $key and $value
	 *
	 * @return self an array containing all the elements of arr1 after applying the callback function to each one.
	 *
	 * @link https://php.net/manual/en/function.array-map.php
	 */
	public function map_assoc(callable $callback): self
	{
		return new static(array_map($callback, $this->keys()->getArrayCopy(), $this->getArrayCopy()));
	}

	/**
	 * Merge one or more arrays recursively
	 *
	 * @return array|self An array of values resulted from merging the arguments together.
	 *
	 * @link https://php.net/manual/en/function.array-merge-recursive.php
	 */
	public function merge_recursive(...$arrays): self
	{
		$arrays = static::to_arrays(false, ...$arrays);
		return new static(array_merge_recursive($this->getArrayCopy(), ...$arrays));
	}

	/**
	 * Merge one or more arrays
	 *
	 * @param array|self $arrays
	 *
	 * @link https://php.net/manual/en/function.array-merge.php
	 */
	public function merge(...$arrays): self
	{
		$arrays = static::to_arrays(false, ...$arrays);
		return new static(array_merge($this->getArrayCopy(), ...$arrays));
	}

	/**
	 * Sort multiple or multi-dimensional arrays
	 *
	 * @param array|int $array1_sort_order [optional] The order used to sort the previous array argument. Either SORT_ASC to sort ascendingly or SORT_DESC to sort descendingly. This argument can be swapped with array1_sort_flags or omitted entirely, in which case SORT_ASC is assumed.
	 * @param array|int $array1_sort_flags [optional] Sort options for the previous array argument: Sorting type flags:
	 * + `SORT_REGULAR` - compare items normally (don't change types)
	 * + `SORT_NUMERIC` - compare items numerically
	 * + `SORT_STRING` - compare items as strings
	 * + `SORT_LOCALE_STRING` - compare items as strings, based on the current locale. It uses the locale, which can be changed using setlocale()
	 * + `SORT_NATURAL` - compare items as strings using "natural ordering" like natsort()
	 * + `SORT_FLAG_CASE` - can be combined (bitwise OR) with SORT_STRING or SORT_NATURAL to sort strings case-insensitively
	 *
	 * This argument can be swapped with array1_sort_order or omitted entirely, in which case SORT_REGULAR is assumed.
	 * @param array|int $arrays [optional] More arrays, optionally followed by sort order and flags. Only elements corresponding to equivalent elements in previous arrays are compared. In other words, the sort is lexicographical.
	 *
	 * @return self
	 *
	 * @todo should redo this function to use keys insteads of arrays
	 *
	 * @link https://php.net/manual/en/function.array-multisort.php
	 */
	public function multisort($array1_sort_order = null, $array1_sort_flags = null, ...$arrays): self
	{
		// $arrays = static::to_arrays(false, ...$arrays);
		// $array = $this->getArrayCopy();
		// $args = [&$array];
		// if ($array1_sort_order) {
		// 	$args[] = $array1_sort_order;
		// }
		// if ($array1_sort_flags) {
		// 	$args[] = $array1_sort_flags;
		// }
		// $args = array_merge($args, $arrays);
		// call_user_func_array('array_multisort', $args);
		// $this->exchangeArray($array);
		return $this;
	}

	/**
	 * Pad array to the specified length with a value
	 *
	 * @param int $pad_size New size of the array.
	 * @param mixed $pad_value Value to pad if input is less than pad_size.
	 *
	 * @return self a copy of the input padded to size specified by pad_size with value pad_value. If pad_size is positive then the array is padded on the right, if it's negative then on the left. If the absolute value of pad_size is less than or equal to the length of the input then no padding takes place.
	 *
	 * @link https://php.net/manual/en/function.array-pad.php
	 */
	public function pad($pad_size, $pad_value): self
	{
		return new static(array_pad($this->getArrayCopy(), $pad_size, $pad_value));
	}

	/**
	 * Pop the element off the end of array
	 *
	 * @return mixed the last value of array. If array is empty (or is not an array), &null; will be returned.
	 *
	 * @link https://php.net/manual/en/function.array-pop.php
	 */
	public function pop()
	{
		$array = $this->getArrayCopy();
		$value = array_pop($array);
		$this->exchangeArray($array);
		return $value;
	}

	/**
	 * Calculate the product of values in an array
	 *
	 * @return int|float the product as an integer or float.
	 *
	 * @link https://php.net/manual/en/function.array-product.php
	 */
	public function product()
	{
		return array_product($this->getArrayCopy());
	}

	/**
	 * Push one or more elements onto the end of array
	 *
	 * @param mixed $vars
	 *
	 * @return self
	 *
	 * @link https://php.net/manual/en/function.array-push.php
	 */
	public function push(...$vars): self
	{
		foreach ($vars as $var) {
			$this->append($var);
		}
		return $this;
	}

	/**
	 * Pick one or more random keys out of an array
	 *
	 * @param int $num_req [optional] Specifies how many entries you want to pick.
	 *
	 * @return mixed|self If you are picking only one entry, array_rand returns the key for a random entry. Otherwise, it returns an array of keys for the random entries. This is done so that you can pick random keys as well as values out of the array.
	 *
	 * @link https://php.net/manual/en/function.array-rand.php
	 */
	public function rand($num_req = null)
	{
		$result = array_rand($this->getArrayCopy(), $num_req);
		if ($num_req > 1) {
			return new static($result);
		} else {
			return $result;
		}
	}

	/**
	 * Iteratively reduce the array to a single value using a callback function
	 *
	 * @param callable $function The callback function.
	 *
	 * @param mixed $initial [optional] If the optional initial is available, it will be used at the beginning of the process, or as a final result in case the array is empty.
	 *
	 * @return mixed the resulting value.
	 *
	 * If the array is empty and initial is not passed, array_reduce returns null.
	 *
	 * @link https://php.net/manual/en/function.array-reduce.php
	 */
	public function reduce(callable $function, $initial = null)
	{
		return array_reduce($this->getArrayCopy(), $function, $initial);
	}

	/**
	 * Replaces elements from passed arrays into the first array recursively.
	 *
	 * The difference with array_merge is that this function will replace by indexes as well as by keys, while array_merge replace by keys and append indexed values.
	 *
	 * If a key from the this array exists in the second array, its value will be replaced by the value from the second array. If the key exists in the second array, and not in this, it will be created in this. If a key only exists in this, it will be left as is. If several arrays are passed for replacement, they will be processed in order, the later arrays overwriting the previous values.
	 *
	 * @param array|self ...$arrays Arrays from which elements will be extracted.
	 *
	 * @return self
	 *
	 * @link https://php.net/manual/en/function.array-replace.php
	 */
	public function replace_recursive(...$arrays): self
	{
		$arrays = static::to_arrays(false, ...$arrays);
		return new static(array_replace_recursive($this->getArrayCopy(), ...$arrays));
	}

	/**
	 * Replaces elements from passed arrays into this array.
	 *
	 * The difference with array_merge is that this function will replace by indexes as well as by keys, while array_merge replace by keys and append indexed values.
	 *
	 * If a key from this array exists in the second array, its value will be replaced by the value from the second array. If the key exists in the second array, and not in this, it will be created in this array. If a key only exists in this array, it will be left as is. If several arrays are passed for replacement, they will be processed in order, the later arrays overwriting the previous values. array_replace() is not recursive : it will replace values in the first array by whatever type is in the second array.
	 *
	 * @param array|self ...$arrays Arrays from which elements will be extracted.
	 *
	 * @return self
	 *
	 * @link https://php.net/manual/en/function.array-replace.php
	 */
	public function replace(...$arrays): self
	{
		$arrays = static::to_arrays(false, ...$arrays);
		return new static(array_replace($this->getArrayCopy(), ...$arrays));
	}

	/**
	 * Return an array with elements in reverse order
	 *
	 * @param bool $preserve_keys [optional] If set to true keys are preserved.
	 *
	 * @return self the reversed array.
	 *
	 * @link https://php.net/manual/en/function.array-reverse.php
	 */
	public function reverse($preserve_keys = false)
	{
		return new static(array_reverse($this->getArrayCopy(), $preserve_keys));
	}

	/**
	 * Searches the array for a given value and returns the corresponding key if successful
	 *
	 * @param mixed $needle The searched value.
	 *
	 * If needle is a string, the comparison is done in a case-sensitive manner.
	 *
	 * @param bool $strict [optional] If the third parameter strict is set to true then the array_search function will also check the types of the needle in the haystack.
	 *
	 * @return int|string|false the key for needle if it is found in the array, false otherwise.
	 *
	 * If needle is found in haystack more than once, the first matching key is returned. To return the keys for all matching values, use array_keys with the optional search_value parameter instead.
	 *
	 * @link https://php.net/manual/en/function.array-search.php
	 */
	public function search($needle, $strict = false)
	{
		return array_search($needle, $this->getArrayCopy(), $strict);
	}

	/**
	 * Shift an element off the beginning of array
	 *
	 * @return mixed the shifted value, or null if array is empty or is not an array.
	 *
	 * @link https://php.net/manual/en/function.array-shift.php
	 */
	public function shift()
	{
		$array = $this->getArrayCopy();
		$value = array_shift($array);
		$this->exchangeArray($array);
		return $value;
	}

	/**
	 * Extract a slice of the array
	 *
	 * @param int $offset If offset is non-negative, the sequence will start at that offset in the array. If offset is negative, the sequence will start that far from the end of the array.
	 *
	 * @param int $length [optional] If length is given and is positive, then the sequence will have that many elements in it. If length is given and is negative then the sequence will stop that many elements from the end of the array. If it is omitted, then the sequence will have everything from offset up until the end of the array.
	 *
	 * @param bool $preserve_keys [optional] Note that array_slice will reorder and reset the array indices by default. You can change this behaviour by setting preserve_keys to true.
	 *
	 * @return self the slice.
	 *
	 * @link https://php.net/manual/en/function.array-slice.php
	 */
	public function slice($offset, $length = null, $preserve_keys = false): self
	{
		return new static(array_slice($this->getArrayCopy(), $offset, $length, $preserve_keys));
	}

	/**
	 * Remove a portion of the array and replace it with something else
	 *
	 * @param int $offset If offset is positive then the start of removed portion is at that offset from the beginning of the input array. If offset is negative then it starts that far from the end of the input array.
	 * @param int $length [optional] If length is omitted, removes everything from offset to the end of the array. If length is specified and is positive, then that many elements will be removed. If length is specified and is negative then the end of the removed portion will be that many elements from the end of the array. Tip: to remove everything from offset to the end of the array when replacement is also specified, use count($input) for length.
	 * @param mixed $replacement [optional] If replacement array is specified, then the removed elements are replaced with elements from this array.
	 *
	 * If offset and length are such that nothing is removed, then the elements from the replacement array are inserted in the place specified by the offset. Note that keys in replacement array are not preserved.
	 *
	 * If replacement is just one element it is not necessary to put array() around it, unless the element is an array itself.
	 *
	 * @return self the array consisting of the extracted elements.
	 *
	 * @link https://php.net/manual/en/function.array-splice.php
	 */
	public function splice($offset, $length = null, $replacement = null): self
	{
		$array = $this->getArrayCopy();
		$result = new static(array_splice($array, $offset, $length, $replacement));
		$this->exchangeArray($array);
		return $result;
	}

	/**
	 * Calculate the sum of values in an array
	 *
	 * @return int|float — the sum of values as an integer or float.
	 *
	 * @link https://php.net/manual/en/function.array-sum.php
	 */
	public function sum()
	{
		return array_sum($this->getArrayCopy());
	}

	/**
	 * Computes the difference of arrays with additional index check, compares data by a callback function
	 *
	 * @param callable $data_compare_func The callback comparison function.
	 *
	 * The user supplied callback function is used for comparison. It must return an integer less than, equal to, or greater than zero if the first argument is considered to be respectively less than, equal to, or greater than the second.
	 * The comparison of arrays' data is performed by using an user-supplied callback : data_compare_func. In this aspect the behaviour is opposite to the behaviour of array_diff_assoc which uses internal function for comparison.
	 * `callback ( mixed $a, mixed $b ) : int`
	 * @param callable $key_compare_func
	 * The comparison of keys (indices) is done also by the callback function key_compare_func. This behaviour is unlike what array_udiff_assoc does, since the latter compares the indices by using an internal function.
	 * `callback ( mixed $a, mixed $b ) : int`
	 * @param array|self ...$arrays Arrays.
	 *
	 * @return self array containing all the values from array1 that are not present in any of the other arguments.
	 *
	 * @link https://php.net/manual/en/function.array-udiff-uassoc.php
	 */
	public function udiff_assoc(callable $data_compare_func, ...$arrays): self
	{
		$arrays = static::to_arrays(false, ...$arrays);
		$args = new static([$this->getArrayCopy()]);
		$args->push(...$arrays);
		$args->push($data_compare_func);
		return new static(call_user_func_array('array_udiff_assoc', $args->getArrayCopy()));
	}

	/**
	 * Computes the difference of arrays with additional index check, compares data and indexes by a callback function
	 *
	 * @param callable $data_compare_func The callback comparison function.
	 *
	 * The user supplied callback function is used for comparison. It must return an integer less than, equal to, or greater than zero if the first argument is considered to be respectively less than, equal to, or greater than the second.
	 * The comparison of arrays' data is performed by using an user-supplied callback : data_compare_func. In this aspect the behaviour is opposite to the behaviour of array_diff_assoc which uses internal function for comparison.
	 * `callback ( mixed $a, mixed $b ) : int`
	 *
	 * @param callable $key_compare_func
	 * The comparison of keys (indices) is done also by the callback function key_compare_func. This behaviour is unlike what array_udiff_assoc does, since the latter compares the indices by using an internal function.
	 * `callback ( mixed $a, mixed $b ) : int`
	 *
	 * @param array|self ...$arrays
	 *
	 * @return self An array containing all the values from array1 that are not present in any of the other arguments.
	 *
	 * @link https://php.net/manual/en/function.array-udiff-uassoc.php
	 */
	public function udiff_uassoc(callable $data_compare_func, callable $key_compare_func, ...$arrays): self
	{
		$arrays = static::to_arrays(false, ...$arrays);
		$args = new static([$this->getArrayCopy()]);
		$args->push(...$arrays);
		$args->push($data_compare_func);
		$args->push($key_compare_func);
		return new static(call_user_func_array('array_udiff_uassoc', $args->getArrayCopy()));
	}

	/**
	 * Computes the difference of arrays by using a callback function for data comparison
	 *
	 * @param callable $data_compare_func The callback comparison function.
	 *
	 * The user supplied callback function is used for comparison. It must return an integer less than, equal to, or greater than zero if the first argument is considered to be respectively less than, equal to, or greater than the second.
	 * `callback ( mixed $a, mixed $b ) : int`
	 *
	 * @param array|self ...$arrays
	 *
	 * @return self An array containing all the values of this array that are not present in any of the other arrays.
	 *
	 * @link https://php.net/manual/en/function.array-udiff.php
	 */
	public function udiff(callable $data_compare_func, ...$arrays): self
	{
		$arrays = static::to_arrays(false, ...$arrays);
		$args = new static([$this->getArrayCopy()]);
		$args->push(...$arrays);
		$args->push($data_compare_func);
		return new static(call_user_func_array('array_udiff', $args->getArrayCopy()));
	}

	/**
	 * Computes the intersection of arrays with additional index check, compares data by a callback function
	 *
	 * @param callable $data_compare_func The callback comparison function.
	 *
	 * The user supplied callback function is used for comparison. It must return an integer less than, equal to, or greater than zero if the first argument is considered to be respectively less than, equal to, or greater than the second.
	 * `callback ( mixed $a, mixed $b ) : int`
	 *
	 * @param array|self ...$arrays
	 *
	 * @return self An array containing all the values of this array that are present in all arrays.
	 *
	 * @link https://php.net/manual/en/function.array-uintersect-assoc.php
	 */
	public function uintersect_assoc(callable $data_compare_func, ...$arrays): self
	{
		$arrays = static::to_arrays(false, ...$arrays);
		$args = new static([$this->getArrayCopy()]);
		$args->push(...$arrays);
		$args->push($data_compare_func);
		return new static(call_user_func_array('array_uintersect_assoc', $args->getArrayCopy()));
	}

	/**
	 * Computes the intersection of arrays with additional index check, compares data and indexes by separate callback functions
	 *
	 * @param callable $data_compare_func The callback comparison function.
	 *
	 * The user supplied callback function is used for comparison. It must return an integer less than, equal to, or greater than zero if the first argument is considered to be respectively less than, equal to, or greater than the second.
	 * `callback ( mixed $a, mixed $b ) : int`
	 *
	 * @param callable $key_compare_func — Key comparison callback function.
	 * @param array|self ...$arrays
	 *
	 * @return self An array containing all the values of this array that are present in all arrays.
	 *
	 * @link https://php.net/manual/en/function.array-uintersect-uassoc.php
	 */
	public function uintersect_uassoc(callable $data_compare_func, callable $key_compare_func, ...$arrays): self
	{
		$arrays = static::to_arrays(false, ...$arrays);
		$args = new static([$this->getArrayCopy()]);
		$args->push(...$arrays);
		$args->push($data_compare_func);
		$args->push($key_compare_func);
		return new static(call_user_func_array('array_uintersect_uassoc', $args->getArrayCopy()));
	}

	/**
	 * Computes the intersection of arrays, compares data by a callback function
	 *
	 * @param callable $data_compare_func The callback comparison function.
	 *
	 * The user supplied callback function is used for comparison. It must return an integer less than, equal to, or greater than zero if the first argument is considered to be respectively less than, equal to, or greater than the second.
	 * `callback ( mixed $a, mixed $b ) : int`
	 *
	 * @param array|self ...$arrays
	 *
	 * @return self An array containing all the values of this array that are present in all arrays.
	 *
	 * @link https://php.net/manual/en/function.array-uintersect.php
	 */
	public function uintersect(callable $data_compare_func, ...$arrays): self
	{
		$arrays = static::to_arrays(false, ...$arrays);
		$args = new static([$this->getArrayCopy()]);
		$args->push(...$arrays);
		$args->push($data_compare_func);
		return new static(call_user_func_array('array_uintersect', $args->getArrayCopy()));
	}

	/**
	 * Removes duplicate values from an array
	 *
	 * @param int $sort_flags [optional] The optional second parameter sort_flags may be used to modify the sorting behavior using these values:
	 *
	 * Sorting type flags:
	 *  + `SORT_REGULAR` - compare items normally (don't change types)
	 *  + `SORT_NUMERIC` - compare items numerically
	 *  + `SORT_STRING` - compare items as strings
	 *  + `SORT_LOCALE_STRING` - compare items as strings, based on the current locale
	 * @return self the filtered array.
	 *
	 * @link https://php.net/manual/en/function.array-unique.php
	 */
	public function unique($sort_flags = SORT_STRING): FullArrayObject
	{
		return new static(array_unique($this->getArrayCopy(), $sort_flags));
	}

	/**
	 * Prepend one or more elements to the beginning of an array
	 *
	 * @param mixed $vars — [optional] The prepended variables.
	 *
	 * @return self
	 *
	 * @link https://php.net/manual/en/function.array-unshift.php
	 */
	public function unshift(...$vars): self
	{
		$array = $this->getArrayCopy();
		array_unshift($array, ...$vars);
		$this->exchangeArray($array);
		return $this;
	}

	/**
	 * Return all the values of an array
	 *
	 * @return self An indexed array of values.
	 *
	 * @link https://php.net/manual/en/function.array-values.php
	 */
	public function values(): self
	{
		return new static(array_values($this->getArrayCopy()));
	}

	/**
	 * Apply a user function recursively to every member of an array
	 *
	 * @param callback $funcname Typically, funcname takes on two parameters. The input parameter's value being the first, and the key/index second.
	 *
	 * If funcname needs to be working with the actual values of the array, specify the first parameter of funcname as a reference. Then, any changes made to those elements will be made in the original array itself.
	 *
	 * @param mixed $userdata [optional] If the optional userdata parameter is supplied, it will be passed as the third parameter to the callback funcname.
	 *
	 * @return bool — true on success or false on failure.
	 *
	 * @link https://php.net/manual/en/function.array-walk-recursive.php
	 */
	public function walk_recursive(callable $funcname, $userdata = null): bool
	{
		return array_walk_recursive($this, $funcname, $userdata);
	}

	/**
	 * Apply a user supplied function to every member of an array
	 *
	 * @param callback $funcname Typically, funcname takes on two parameters. The array parameter's value being the first, and the key/index second.
	 *
	 * If funcname needs to be working with the actual values of the array, specify the first parameter of funcname as a reference. Then, any changes made to those elements will be made in the original array itself.
	 *
	 * Users may not change the array itself from the callback function. e.g. Add/delete elements, unset elements, etc. If the array that array_walk is applied to is changed, the behavior of this function is undefined, and unpredictable.
	 *
	 * @param mixed $userdata [optional] If the optional userdata parameter is supplied, it will be passed as the third parameter to the callback funcname.
	 *
	 * @return bool — true on success or false on failure.
	 *
	 * @link https://php.net/manual/en/function.array-walk.php
	 */
	public function walk(callable $funcname, $userdata = null): bool
	{
		return array_walk($this, $funcname, $userdata);
	}

	/**
	 * Sort an array in reverse order and maintain index association
	 *
	 * @param int $sort_flags [optional] You may modify the behavior of the sort using the optional parameter sort_flags, for details see sort.
	 *
	 * @return self
	 *
	 * @link https://php.net/manual/en/function.arsort.php
	 */
	public function arsort($sort_flags = null): self
	{
		$array = $this->getArrayCopy();
		arsort($array, $sort_flags);
		$this->exchangeArray($array);
		return $this;
	}

	/**
	 * Checks if a value exists in an array
	 *
	 * @param mixed $needle The searched value.
	 *
	 * If needle is a string, the comparison is done in a case-sensitive manner.
	 *
	 * @param bool $strict [optional] If the third parameter strict is set to true then the in_array function will also check the types of the needle in the haystack.
	 *
	 * @return bool — true if needle is found in the array, false otherwise.
	 *
	 * @link https://php.net/manual/en/function.in-array.php
	 */
	public function includes($needle, $strict = false): bool
	{
		return in_array($needle, $this->getArrayCopy(), $strict);
	}

	/**
	 * Sort an array by key in reverse order
	 *
	 * @param int $sort_flags [optional] You may modify the behavior of the sort using the optional parameter sort_flags, for details see sort.
	 *
	 * @return self
	 *
	 * @link https://php.net/manual/en/function.krsort.php
	 */
	public function krsort($sort_flags = 0): self
	{
		$array = $this->getArrayCopy();
		krsort($array, $sort_flags);
		$this->exchangeArray($array);
		return $this;
	}

	/**
	 * Create an array containing a range of elements
	 *
	 * @param mixed $start — First value of the sequence.
	 *
	 * @param mixed $end — The sequence is ended upon reaching the end value.
	 *
	 * @param int|float $step [optional] If a step value is given, it will be used as the increment between elements in the sequence. step should be given as a positive number. If not specified, step will default to 1.
	 *
	 * @return self An array of elements from start to end, inclusive.
	 *
	 * @link https://php.net/manual/en/function.range.php
	 *
	 * @static
	 */
	public static function range($start, $end, $step = 1)
	{
		return new static(range($start, $end, $step));
	}

	/**
	 * Set the internal pointer of an array to its first element
	 *
	 * @link https://php.net/manual/en/arrayiterator.rewind.php
	 */
	public function reset(): self
	{
		$this->getIterator()->rewind();
		return $this;
	}

	/**
	 * Sort an array in reverse order
	 *
	 * @param int $sort_flags [optional] You may modify the behavior of the sort using the optional parameter sort_flags, for details see sort.
	 *
	 * @return self
	 *
	 * @link https://php.net/manual/en/function.rsort.php
	 */
	public function rsort($sort_flags = null): self
	{
		$array = $this->getArrayCopy();
		rsort($array, $sort_flags);
		$this->exchangeArray($array);
		return $this;
	}

	/**
	 * Shuffle an array.
	 *
	 * @link https://php.net/manual/en/function.shuffle.php
	 */
	public function shuffle(): self
	{
		$array = $this->getArrayCopy();
		shuffle($array);
		$this->exchangeArray($array);
		return $this;
	}

	/**
	 * Sort an array by values using a user-defined comparison function.
	 * Mutate the current array.
	 *
	 * @param callback $cmp_function The comparison function must return an integer less than, equal to, or greater than zero if the first argument is considered to be respectively less than, equal to, or greater than the second.
	 *
	 * @return self
	 *
	 * @link https://php.net/manual/en/function.usort.php
	 */
	public function usort(callable $cmp_function): self
	{
		$array = $this->getArrayCopy();
		usort($array, $cmp_function);
		$this->exchangeArray($array);
		return $this;
	}
}
