<?php

namespace App;

require 'vendor/autoload.php';

use DI\ContainerBuilder;

$builder = new ContainerBuilder();
$builder->addDefinitions([
    QueryBuilderHelper::class => \Di\get(App\Helpers\QueryBuilderHelper::class),
    QueryBuilder::class => \Di\get(App\Services\QueryBuilder::class),
    NodeMapper::class => \Di\get(App\Services\NodeMapper::class),
]);

$container = $builder->build();
$container->call(['App\Services\Parser', 'run'], []);
