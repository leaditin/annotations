<?php

$rules = [
    '@PSR2' => true,
    'array_syntax' => ['syntax' => 'short'],
    'object_operator_without_whitespace' => true,
    'no_whitespace_in_blank_line' => true,
    'standardize_not_equals' => true,
    'no_extra_consecutive_blank_lines' => ['extra'],
 ];

$finder = \Symfony\Component\Finder\Finder::create()
    ->files()
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
    ->in(__DIR__)
    ->exclude('vendor')
    ->exclude('assets')
    ->exclude('build')
    ->exclude('salt')
    ->exclude('sql')
    ->exclude('var')
    ->notPath('autoload_classmap.php');

return PhpCsFixer\Config::create()
    ->setRules($rules)
    ->setFinder($finder);