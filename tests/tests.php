<?php

use Symfony\Component\ClassLoader\Psr4ClassLoader;

########################################################### Prepare

error_reporting(E_ALL);

require 'vendor/autoload.php';

$loader = new Psr4ClassLoader;
$loader->addPrefix('StreetFight\\', '../src');
$loader->register();

$suite = new MiniSuite\Suite('StreetFight');
