Streetfight draft
=================

```php
/*==================================================
    New
==================================================*/

/*
    OOPS 1.0
    ========

    CollectionInterface#__construct(array $list)
    CollectionInterface#list() : array
    CollectionInterface#iterate() : Generator
    CollectionInterface#mix($value) : CollectionInterface

    ControlStructureInterface#apply() : mixed

    ActionCollection<-CollectionInterface
    Action#__construct(string $name, mixed $dataIfTrue)

    If#__construct(bool $condition, mixed $dataIfTrue, mixed $dataIfFalse)
    Switch#__construct(bool $condition, ActionCollection $actions, mixed $defaultData)
*/

$results = (new PercentageReport(
    (new StreetFight\Match(
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
    ]))->fight(100)
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

<<<<<<< HEAD
/*
    New
*/

$streetFight = new StreetFight\Match([
    'challengerList' => new StreetFight\ChallengerList([
        new StreetFight\Challenger('file_put_contents (overwrite)', function ($c) {
            file_put_contents($c['filename'], 'Le chat noir est dans le jardin.');
        }),
        new StreetFight\Challenger('fwrite (overwrite)', function ($c) {
            $f = fopen($c['filename'], 'w');
            fwrite($f, 'Le chat noir est dans le jardin.');
            fclose($f);
        }),
        new StreetFight\Challenger('file_put_contents (append)', function ($c) {
            file_put_contents($c['filename'], 'Le chat noir est dans le jardin.', FILE_APPEND);
        }),
        new StreetFight\Challenger('fwrite (append)', function ($c) {
            $f = fopen($c['filename'], 'a');
            fwrite($f, 'Le chat noir est dans le jardin.');
            fclose($f);
        }),
    ]),
    'hooks' => [
        new StreetFight\Hook\BeginMatch(function($container) {
            $c['filename'] = __DIR__ . '/test';
        }),
        new StreetFight\Hook\BeginRound(function($container) {
            touch($c['filename']);
        }),
        new StreetFight\Hook\EndRound(function($container) {
            unlink($c['filename']);
        }),
    ]
]);

/*
    Faut il gérer des objets pour les types? (string, boolean, int, collection...)
    Faut il gérer des objets pour les structures de contrôle?

    Est-ce que ça revient pas à simplement déplacer la logique à un autre endroit?
    Il est vrai que lors de l'instantiation de beaucoup d'objets, et dont certaines dépendances requièrent un IF,
    alors il faut nécessairement instantier la dépendance en dehors de l'instantiation de l'objet parent.
*/
=======
$results = $streetFight->fight();
>>>>>>> Update v6.5 draft
```
