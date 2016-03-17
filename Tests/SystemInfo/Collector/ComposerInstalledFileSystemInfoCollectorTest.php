<?php

/**
 * File containing the ComposerInstalledFileSystemInfoCollectorTest class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\EzSupportToolsBundle\Tests\SystemInfo\Collector;

use EzSystems\EzSupportToolsBundle\SystemInfo\Collector\ComposerInstalledFileSystemInfoCollector;
use PHPUnit_Framework_TestCase;

class ComposerInstalledFileSystemInfoCollectorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ComposerInstalledFileSystemInfoCollector
     */
    private $composerCollector;

    public function setUp()
    {
        $this->composerCollector = new ComposerInstalledFileSystemInfoCollector(__DIR__ . '/_fixtures/installed.json');
    }

    public function testBuild()
    {
        $value = $this->composerCollector->build();

        self::assertInstanceOf('EzSystems\EzSupportToolsBundle\SystemInfo\Value\ComposerSystemInfo', $value);

        self::assertEquals(
            [
                'ezsystems/ezpublish-kernel',
                'dev-master',
                'a684036b4824e33bc4e8a59b72ef63f92c602b35',
            ],
            [
                $value->packages['ezsystems/ezpublish-kernel']->name,
                $value->packages['ezsystems/ezpublish-kernel']->version,
                $value->packages['ezsystems/ezpublish-kernel']->source['reference'],
            ]
        );
    }
}
