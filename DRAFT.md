```php
$sf = new StreetFight\Facade();

$data = new Pure\MutableData([
    'filename' => __DIR__ . '/test',
    'text' => 'Le chat noir est dans le jardin.',
]);

$sf->before(function () use ($data) {
    touch($data->filename);
});

$sf->after(function () use ($data) {
    unlink($data->filename);
});

$sf->add('file_put_contents (overwrite)', function () use ($data) {
    file_put_contents($data->filename, $data->text);
});

$sf->add('fwrite (overwrite)', function () use ($data) {
    $f = fopen($data->filename, 'w');
    fwrite($f, $data->text);
    fclose($f);
});

$sf->add('file_put_contents (append)', function () use ($data) {
    file_put_contents($data->filename, $data->text, FILE_APPEND);
});

$sf->add('fwrite (append)', function () use ($data) {
    $f = fopen($data->filename, 'a');
    fwrite($f, $data->text);
    fclose($f);
});

$sf->fight();
```
