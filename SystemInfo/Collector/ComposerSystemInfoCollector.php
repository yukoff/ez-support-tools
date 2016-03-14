<?php

/**
 * File containing the ComposerSystemInfoCollector class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\EzSupportToolsBundle\SystemInfo\Collector;

use EzSystems\EzSupportToolsBundle\SystemInfo\Value;

/**
 * Collects information about installed Composer packages.
 */
class ComposerSystemInfoCollector implements SystemInfoCollector
{
    /**
     * @var string Installation root directory
     */
    private $installDir;

    public function __construct($installDir)
    {
        $this->installDir = $installDir;
    }

    /**
     * Builds information about installed composer packages.
     *
     * @return Value\ComposerSystemInfo
     */
    public function build()
    {
        if (!file_exists($this->installDir . 'composer.lock')) {
            return new Value\ComposerSystemInfo([]); // @TODO something more informative?
        }

        $packages = [];
        $lockData = json_decode(file_get_contents($this->installDir . 'composer.lock'), true);
        foreach ($lockData['packages'] as $packageData) {
            $packages[$packageData['name']] = [
                'version' => $packageData['version'],
                'time' => $packageData['time'],
                'homepage' => isset($packageData['homepage']) ? $packageData['homepage'] : '',
                'reference' => $packageData['source']['reference'],
            ];
        }

        ksort($packages, SORT_FLAG_CASE | SORT_STRING);

        return new Value\ComposerSystemInfo([
            'packages' => $packages,
        ]);
    }
}
