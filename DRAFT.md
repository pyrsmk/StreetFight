Streetfight draft
=================

```php

/*==================================================
    New
==================================================*/

$results = (new PercentageReport(
    StreetFight\createMatch(
        new StreetFight\ChallengerList([
            new StreetFight\Challenger('file_put_contents (overwrite)', function ($filename) {
                file_put_contents($filename, 'Le chat noir est dans le jardin.');
            }),
            new StreetFight\Challenger('fwrite (overwrite)', function ($filename) {
                $f = fopen($filename, 'w');
                fwrite($f, 'Le chat noir est dans le jardin.');
                fclose($f);
            }),
            new StreetFight\Challenger('file_put_contents (append)', function ($filename) {
                file_put_contents($filename, 'Le chat noir est dans le jardin.', FILE_APPEND);
            }),
            new StreetFight\Challenger('fwrite (append)', function ($filename) {
                $f = fopen($filename, 'a');
                fwrite($f, 'Le chat noir est dans le jardin.');
                fclose($f);
            }),
        ]),
        new StreetFight\HookList([
            new StreetFight\Hook\BeginMatch(function () {
                return ['filename' => __DIR__ . '/test'];
            }),
            new StreetFight\Hook\BeginRound(function ($filename) {
                touch($filename);
            }),
            new StreetFight\Hook\EndRound(function ($filename) {
                unlink($filename);
            }),
        ])
    ])->fight(100)
))->compute();

/*==================================================
    Old
==================================================*/

$streetFight = new StreetFight\Match();

$c = $streetFight->getContainer();
$c['filename'] = __DIR__ . '/test';

$streetFight->begin(function ($c) {
    touch($c['filename']);
});

$streetFight->end(function ($c) {
    unlink($c['filename']);
});

$streetFight->add('file_put_contents (overwrite)', function ($c) {
    file_put_contents($c['filename'], 'Le chat noir est dans le jardin.');
});

$streetFight->add('fwrite (overwrite)', function ($c) {
    $f = fopen($c['filename'], 'w');
    fwrite($f, 'Le chat noir est dans le jardin.');
    fclose($f);
});

$streetFight->add('file_put_contents (append)', function ($c) {
    file_put_contents($c['filename'], 'Le chat noir est dans le jardin.', FILE_APPEND);
});

$streetFight->add('fwrite (append)', function ($c) {
    $f = fopen($c['filename'], 'a');
    fwrite($f, 'Le chat noir est dans le jardin.');
    fclose($f);
});

$results = $streetFight->fight();
```
