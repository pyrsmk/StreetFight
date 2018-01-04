<?php

namespace StreetFight;

/*$match = StreetFight\createMatch(
    'challengers' => [
        'name' => function($container) {},
        'name' => function($container) {},
        'name' => function($container) {},
    ],
    'rounds' => 100,
    'beginMatch' => function($container) {},
    'endMatch' => function($container) {},
    'beginRound' => function($container) {},
    'endRound' => function($container) {}
);*/

/**
 * Create an instance of Match
 *
 * @param array $arguments
 * @return Match
 */
function createMatch(array $args) : Match
{
    $arguments = (new Jeerz\Arguments([
        'challengers' => [
            'type' => 'array[Closure]',
        ],
        'rounds' => [
            'type' => 'integer',
            'optional' => true,
            'default' => 100,
        ],
        'beginMatch' => [
            'type' => 'Closure',
            'optional' => true,
            'default' => function(){},
        ],
        'endMatch' => [
            'type' => 'Closure',
            'optional' => true,
            'default' => function () {},
        ],
        'beginRound' => [
            'type' => 'Closure',
            'optional' => true,
            'default' => function () {},
        ],
        'endRound' => [
            'type' => 'Closure',
            'optional' => true,
            'default' => function () {},
        ],
    ]))->extract($args);

    return new StreetFight\Match([
        'container' => new Chernozem\Container(),
        'board' => function(array $results) {
            return new StreetFight\Board($results);
        },
        'challengerList' => createChallengerList($arguments['challengers']),
        'rounds' => $arguments['rounds'],
        'round' => function($challengerList) {
            return new StreetFight\Round([
                'id' => new StreetFight\Round\Id(),
                'board' => function(array $results) {
                    return new StreetFight\Board($results);
                },
                'challengerList' => $challengerList,
                'chrono' => new StreetFight\Chrono(),
                'beginRoutine' => new StreetFight\Routine(function($container) {}),
                'endRoutine' => new StreetFight\Routine(function($container) {})
            ]);
        },
        'beginRoutine' => $arguments['beginMatch'],
        'endRoutine' => new StreetFight\Routine(function($container) {})
    ]);
}

/**
 * Create an instance of ChallengerList
 *
 * @param array $challengers
 * @return ChallengerList
 */
function createChallengerList(array $challengers) : ChallengerList
{
    return new StreetFight\ChallengerList(array_map(
        function ($name, $closure)
        {
            return new StreetFight\Challenger($name, $closure);
        },
        array_keys($challengers),
        $challengers,
    ));
}
