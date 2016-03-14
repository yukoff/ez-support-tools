<?php

/**
 * File containing the ComposerSystemInfoCollectorTest class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\EzSupportToolsBundle\Tests\SystemInfo\Collector;

use EzSystems\EzSupportToolsBundle\SystemInfo\Collector\ComposerSystemInfoCollector;
use EzSystems\EzSupportToolsBundle\SystemInfo\Value\ComposerSystemInfo;
use PHPUnit_Framework_TestCase;

class ComposerSystemInfoCollectorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ComposerSystemInfoCollector
     */
    private $composerCollector;

    public function setUp()
    {
        $this->composerCollector = new ComposerSystemInfoCollector(__DIR__ . '/_fixtures/');
    }

    public function testBuild()
    {
        $expected = new ComposerSystemInfo([
            'packages' => [
                'ezsystems/ezpublish-kernel' => [
                    'version' => 'dev-master',
                    'time' => '2016-02-28 14:30:53',
                    'homepage' => 'http://share.ez.no',
                    'reference' => 'ec897baa77c63b745749acf201e85b92bd614723',
                ],
                'doctrine/dbal' => [
                    'version' => 'v2.5.4',
                    'time' => '2016-01-05 22:11:12',
                    'homepage' => 'http://www.doctrine-project.org',
                    'reference' => 'abbdfd1cff43a7b99d027af3be709bc8fc7d4769',
                ],
                'symfony/symfony' => [
                    'version' => 'v2.7.10',
                    'time' => '2016-02-28 20:37:19',
                    'homepage' => 'https://symfony.com',
                    'reference' => '9a3b6bf6ebee49370aaf15abc1bdeb4b1986a67d',
                ],
                'zetacomponents/system-information' => [
                    'version' => '1.1',
                    'time' => '2014-09-27 19:26:09',
                    'homepage' => 'https://github.com/zetacomponents',
                    'reference' => 'be0e5b69dde0a51f8d2a036b891964521939769f',
                ],
            ],
        ]);

        $value = $this->composerCollector->build();

        self::assertInstanceOf('EzSystems\EzSupportToolsBundle\SystemInfo\Value\ComposerSystemInfo', $value);

        self::assertEquals($expected, $value);
    }
}
