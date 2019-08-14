# StreetFight

StreetFight is a benchmarking tool aiming to quickly know what code have better performance against another one. It is not intended to be an exhaustive profiling library and probably won't grow any further.

## Install

StreetFight requires PHP 7.2.

```
composer require pyrsmk/streetfight
```

## Use

```php
$match = new StreetFight\Facade(
    StreetFight\Facade::PERCENTAGE_REPORT
);

$match->add('Pre-increment', function () {
    $i = 0;
    ++$i;
});

$match->add('Post-increment', function () {
    $i = 0;
    $i++;
});

var_dump($match->fight());
/*
    [
        'Post-increment' => 100,
        'Pre-increment' => 98.84
    ]
*/
```

## Set some hooks

If you need to run some specific routines, you can use some hooks:

```php
$match->begin(function () {
    // Run at the very beginning
});

$match->before(function () {
    // Run before each task, at each iteration
});

$match->after(function () {
    // Run after each task, at each iteration
});

$match->end(function () {
    // Run at the very end
});
```

Here's an example:

```php
$match->before(function () {
    touch('foo.txt');
});

$match->after(function () {
    unlink('foo.txt');
});

$match->add('file_put_contents (overwrite)', function () {
    file_put_contents('foo.txt', 'bar');
});

$match->add('fwrite (overwrite)', function () {
    $f = fopen('foo.txt', 'w');
    fwrite($f, 'bar');
    fclose($f);
});

$match->add('file_put_contents (append)', function () {
    file_put_contents('foo.txt', 'bar', FILE_APPEND);
});

$match->add('fwrite (append)', function () {
    $f = fopen('foo.txt', 'a');
    fwrite($f, 'bar');
    fclose($f);
});
```

## Passing some data to tasks

As you can see from the above example, the same data is used across all tasks. Furthermore, we could need to generate random data at each iteration. But since mutability makes it really difficult for StreetFight to keep track on the data (and passing it into objects complicates the API), it has been decided to define it outside of StreetFight itself in a procedural way. So, here's how you would use arbitrary data, based on the previous example:

```php
$data = [
    'filename' => 'foo.txt',
    'content' => 'bar'
];

$match->before(function () use ($data) {
    touch($data['filename']);
});

$match->after(function () use ($data) {
    unlink($data['filename']);
});

$match->add('file_put_contents (overwrite)', function () use ($data) {
    file_put_contents($data['filename'], $data['content']);
});

$match->add('fwrite (overwrite)', function () use ($data) {
    $f = fopen($data['filename'], 'w');
    fwrite($f, $data['content']);
    fclose($f);
});

$match->add('file_put_contents (append)', function () use ($data) {
    file_put_contents($data['filename'], $data['content'], FILE_APPEND);
});

$match->add('fwrite (append)', function () use ($data) {
    $f = fopen($data['filename'], 'a');
    fwrite($f, $data['content']);
    fclose($f);
});
```

## Reports

There are different report formats available as constants in the `StreetFight\Facade` object:

- `SECONDS_REPORT` (default)
- `ROUNDEDSECONDS_REPORT`
- `MICROSECONDS_REPORT`
- `MILLISECONDS_REPORT`
- `PERCENTAGE_REPORT`

```php
$match = new StreetFight\Facade(
    StreetFight::ROUNDEDSECONDS_REPORT
);
```

## Running time

By default, the maximum time of the global benchmark will be automatically computed so the results will be more accurate. But you can specify an arbitrary time (in milliseconds) in the `fight()` method. Please note that if a task takes 10 seconds to execute, defining the maximum time to 1 second won't decrease the real time: the whole iteration will be completed before exiting the benchmark routine.

```php
// The benchmark will took AT LEAST 2 seconds
$match->fight(2000);
```

## Side note

Depending on what code you're benchmarking, execution time can exceed the `max_execution_time` directive of PHP. Just set `set_time_limit(0)` and you'll be all good.

## License

[MIT](http://dreamysource.mit-license.org).
