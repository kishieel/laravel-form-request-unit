<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create();
$finder->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

return (new PhpCsFixer\Config())
    ->setRules(['@PSR2' => true])
    ->setFinder($finder);
