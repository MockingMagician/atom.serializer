#!/usr/bin/env php
<?php

$author = '@author Marc MOREAU <moreau.marc.web@gmail.com>';
$license = '@license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0';
$link = '@link https://github.com/MockingMagician/atom.serializer/blob/master/README.md';

$finder = PhpCsFixer\Finder::create()
    ->exclude('vendor')
    ->in(__DIR__)
;

$config = PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        '@PhpCsFixer' => true,
        'php_unit_test_class_requires_covers' => false,
        'yoda_style' => true,
        'native_function_invocation' => [
            'include' => [
                '@internal',
            ],
        ],
        'final_internal_class' => false,
        'header_comment' => [
            'header' => implode("\n", [$author, $license, $link]),
            'comment_type' => 'PHPDoc',
        ],
    ])
    ->setFinder($finder)
;

return $config;
