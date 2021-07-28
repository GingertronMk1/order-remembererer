<?php

$finder = PhpCsFixer\Finder::create();
$finder
    ->exclude('bootstrap')
    ->exclude('vendor')
    ->exclude('storage')
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();
$config->setRules([
        '@PhpCsFixer' => true
]);
$config->setFinder($finder);

return $config;
