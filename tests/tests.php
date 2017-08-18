<?php

use Symfony\Component\ClassLoader\Psr4ClassLoader;

########################################################### Prepare

error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

$loader = new Psr4ClassLoader();
$loader->addPrefix('StreetFight\\', __DIR__ . '/../src');
$loader->register();

/*
    - time
    - challenger callable
    - kick ne doit rien retourner, et aucune sortie ne doit être détectée
    - format retourné par fight()
    - nombre de challengers (0, 1, 2)
    - interfaces
*/

/*
    Règles de gestion :
        - run() lance juste le callable en catchant toute exception qui se présente
        - test() catch toute exception et affichage l'erreur
        - test() affiche un message de validation si aucune exception n'a été catchée
        - run() n'est pas accessible à l'intérieur de test()
        - throws()/doesNotThrow() sont des helpers pour alléger le code
        - throws()/doesNotThrow() n'est pas accessible à l'extérieur de test()

    Spécificités :
        - aucun support Chernozem, l'hydration peut se faire dans run() et être importée facilement via `use`
        - aucune assertion, on utilise l'instruction PHP7 assert()
*/

$suite = new MiniSuite\Suite('StreetFight\Challenger');

$suite->add('Pass a non-callable to the constructor', function ($assert) {
    $assert->throws(function () {
        new StreetFight\Challenger(72);
    });
});

$suite->add('Pass a callable to the constructor', function ($assert) {
    $assert->doesNotThrow(function () {
        new StreetFight\Challenger(function () {
        });
    });
});

$suite->add('kick() returns NULL', function ($assert) {
    $challenger = new StreetFight\Challenger(function () {
    });
    $assert->isNull($challenger->kick());
});

$suite->add('kick() catches output', function ($assert) {
    $challenger = new StreetFight\Challenger(function () {
        echo 'test';
    });
    ob_start();
    $challenger->kick();
    $assert->isNull(ob_get_clean());
});

$suite->run();
