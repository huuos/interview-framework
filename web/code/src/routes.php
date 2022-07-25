<?php

declare(strict_types = 1);

/**
 * Map request method/uri to a controller/action.
 */
return [
    ['POST', '/example/create', ['Example\Controller\ExampleController', 'createExample']],
    ['GET', '/', ['Example\Controller\HomeController', 'index']],
    ['GET', '/example/get', ['Example\Controller\ExampleController', 'get']], //Test Getting Data
    ['POST', '/example/set', ['Example\Controller\ExampleController', 'set']], //Test Setting Data
    ['POST', '/example/add', ['Example\Controller\ExampleController', 'add']], //Add 2 numbers server-sided
];
