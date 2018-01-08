Streetfight draft
=================

```php
/*
    - BoardInterface#readResults() : array
    - MatchBoard#__construct(array $roundBoards)
    - RoundBoard#__construct(array $resultLines)

    - ResultLineInterface#which() : ChallengerInterface
    - ResultLineInterface#time() : float
    - ResultLine#__construct(ChallengerInterface $challenger, float $time)

    - ChallengerListInterface#readList() : array
*/

$match = new StreetFight\Match([
    'container' => new Chernozem\Container(),
    'challengerList' => new StreetFight\ChallengerList([
        new StreetFight\Challenger('name', function($container) {}),
        new StreetFight\Challenger('name', function($container) {}),
        new StreetFight\Challenger('name', function($container) {}),
    ]),
    'rounds' => 100,
    'hooks' => [
        new StreetFight\Hook\BeginMatch(function($container) {}),
        new StreetFight\Hook\EndMatch(function($container) {}),
        new StreetFight\Hook\BeginRound(function($container) {}),
        new StreetFight\Hook\EndRound(function($container) {}),
    ],
    'boardClass' => 'StreetFight\Board',
    'chronoClass' => 'StreetFight\Chrono',
    'roundClass' => 'StreetFight\Round',
    'roundIdClass' => 'StreetFight\Round\Id',
]);

/*
    StreetFight\Chrono::start()
    StreetFight\Chrono::stop()
    StreetFight\Chrono::read()

    ou

    (new StreetFight\Chrono($function(){}))->read();
*/

/*$arguments = (new ArgumentsValidator([
    'container' => [
        'type' => 'Psr\Container\ContainerInterface',
        'default' => function() {
            return new Chernozem\Container();
        },
    ],
    'board' => [
        'type' => 'StreetFight\BoardInterface',
        'default' => 'StreetFight\Board',
    ],
    'challengerList' => [
        'type' => 'StreetFight\ChallengerList',
        'required' => true,
    ],
    'rounds' => [
        'type' => 'integer',
        'default' => 100,
    ],
    'round' => [
        'type' => 'Closure',
        'default' => function() {
            return function($challengerList) {
                return new StreetFight\Round([
                    'id' => new StreetFight\Round\Id(),
                    'board' => function(array $results) {
                        return new StreetFight\Board($results);
                    },
                    'challengerList' => $challengerList,
                    'chrono' => new StreetFight\Chrono(),
                ]);
            };
        },
    ],
    'hooks' => [
        'type' => 'array[StreetFight\Hook\HookInterface]',
        'default' => [],
    ],
]))->extract($args);*/

$match = new StreetFight\Match([
    'challengerList' => new StreetFight\ChallengerList([
        new StreetFight\Challenger('name', function($container) {}),
        new StreetFight\Challenger('name', function($container) {}),
        new StreetFight\Challenger('name', function($container) {}),
    ]),
]);

var_dump(
    (
        new PercentageReport($match->fight())
    )->compute()
);

/*
    Old
*/

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
```
