<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\Doctrine\Set\DoctrineSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Symfony\Set\SymfonySetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/config',
        __DIR__ . '/public',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    // register a single rule
    $rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);

    $rectorConfig->sets([
        SymfonySetList::ANNOTATIONS_TO_ATTRIBUTES,
        SymfonySetList::CONFIGS,
        SymfonySetList::SYMFONY_63,
        SymfonySetList::SYMFONY_CODE_QUALITY,
        SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION,
        DoctrineSetList::ANNOTATIONS_TO_ATTRIBUTES,
        DoctrineSetList::DOCTRINE_CODE_QUALITY,
        DoctrineSetList::DOCTRINE_ORM_214,
        DoctrineSetList::DOCTRINE_BUNDLE_210
    ]);
};
