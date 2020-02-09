# php-tools
A set of tools for PHP

## Boolean
The `BoolHelper` class provides static functions to parse a human boolean string to a boolean.

+ Already boolean value will be returned as is.
+ All non zero numeric value will return true.
+ Null and 0 will return false.
+ Strings like "yes", "true" and "1" will return true. (case insensitive)
+ Strings like "no", "false" and "0" will return false. (case insensitive)
+ International values of this strings

```php
BoolHelper::to_bool('yes'); // true
BoolHelper::to_bool('true'); // true
BoolHelper::to_bool(1); // true
BoolHelper::to_bool(1.5); // true

BoolHelper::to_bool('no'); // false
BoolHelper::to_bool('false'); // false
BoolHelper::to_bool(0); // false
BoolHelper::to_bool(null); // false
```
### Use case
```php
// You can use it to parse user input
BoolHelper::to_bool($_GET['user_input']); // false

// Or check a parameter
function test($param)
{
	$param = BoolHelper::to_bool($param);
}
```
## Strings
The `StringHelper` class provides static functions to convert string to different developper casing.
```php
$value = "Some string with MANY Words";
StringHelper::split_words($value); // ['Some', 'string', 'with', 'MANY', 'Words']
StringHelper::capitalize($value); // Some string with many words
StringHelper::pascal_case($value); // SomeStringWithManyWords
StringHelper::camel_case($value); // someStringWithManyWords
StringHelper::snake_case($value); // some_string_with_many_words
StringHelper::upper_snake_case($value); // SOME_STRING_WITH_MANY_WORDS
StringHelper::capital_snake_case($value); // Some_String_With_Many_Words
StringHelper::kebab_case($value); // some-string-with-many-words
StringHelper::train_case($value); // Some-String-With-Many-Words
StringHelper::initial($value); // SSWMW
```

It also provides a `remove_diacritics` function (used by the functions above) to remove diacritics (é, è, à, â, ç, ...).

## Debug
The `Debug` class provides function to handle error display.

+ `dumpit($value)` use `var_export` to print the $value content in a &lt;pre&gt; tag.
+ `dumpitscript($value)` use `json_encode` to print the $value content in the javascript console.
+ `reportit` does the same as `dumpit` but returns the string instead of printing it.
+ `reportitscript` does the same as `dumpitscript` but returns the string instead of printing it.
+ `exception_to_array($exception, $max_recursion = 5)` transforms the exception to an array. It will recursively call itself if the given $exception has a previous exception and $max_recursion is greater than 0.

## ServerArray

Tired of checking online what are the correct keys for the $_SERVER array ? The `ServerArray` class provides access to all standard $_SERVER keys.

```php
ServerArray::REQUEST_URI();
```

https://www.php.net/manual/en/reserved.variables.server

## HtmlCodes

As the `ServerArray`, the `HtmlCodes` class provides a list of html codes constants.

```php
HtmlCodes::OK; // 200
HtmlCodes::UNAUTHORIZED; // 401
HtmlCodes::FORBIDDEN; // 403
HtmlCodes::NOT_FOUND; // 404
HtmlCodes::IM_A_TEAPOT; // 418
...
```

https://en.wikipedia.org/wiki/List_of_HTTP_status_codes

## Timer
The `Timer` class is a simple class to analyze execution time

```php
$timer = new Timer(true); // true to automatically start the timer

a_long_function();
$first_duration = $timer->duration(); // returns the time in seconds with milliseconds since the timer has been started until now

another_long_function();
$timer->stop(); // stops the timer
$final_duration = $timer->duration(); // returns the time since the timer has been started until it has been stopped.

a_third_long_function();
// calling $timer->duration() now will return the time since the timer has been started until it has been stopped, so the same as $final_duration.

echo $final_duration; // ex: 75.547682
echo $timer; // print m:ss.zzz, ex: 1:15.548
```

## Timers
You can record multiple times with `Timers`.

```php
$timers = new Timers();
$timers->start('all');

$timers->start('first');
a_long_function();
$timers->stop('first');

$timers->start('second');
another_long_function();
$timers->stop('second');

$timers->start('third');
a_third_long_function();
$timers->stop('third');

$timers->stop('all');

echo $timers->get('first');
echo $timers->get('second');
echo $timers->get('third');
echo $timers->get('all');
```

## Monolog\TimerProcessor

The `Monolog\TimerProcessor` class add a duration in seconds with milliseconds to the extra array when using [monolog/monolog](https://github.com/Seldaek/monolog) package.

```php
$logger = new Monolog\Logger('Test');
$logger->pushProcessor(new TimerProcessor());
```

## Monolog\RequestIdProcessor

The `Monolog\RequestIdProcessor` class add a request id to the extra array when using [monolog/monolog](https://github.com/Seldaek/monolog) package.

The id is a hash made of `$_SERVER['REMOTE_ADDR'].$_SERVER['REMOTE_PORT'].$_SERVER['REQUEST_TIME_FLOAT'].$_SERVER['REQUEST_URI']`

The goal is to provide a way to distinguish logged message by different simultaneous requests.

```php
$logger = new Monolog\Logger('Test');
$logger->pushProcessor(new RequestIdProcessor());
```