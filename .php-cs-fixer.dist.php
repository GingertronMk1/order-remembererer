<?php

$finder = PhpCsFixer\Finder::create();
$finder
    ->exclude('bootstrap')
    ->exclude('vendor')
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();
$config->setRules([
        '@PhpCsFixer' => true
]);
$config->setFinder($finder);

return $config;
