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
        $composerLockFile = $this->installDir . 'composer.lock';
        if (!file_exists($composerLockFile)) {
            trigger_error(
                "Composer lock file '$composerLockFile' not found, cannot build package list.",
                E_USER_WARNING
            );
            return new Value\ComposerSystemInfo([]);
        }

        $packages = [];
        $lockData = json_decode(file_get_contents($composerLockFile), true);
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
