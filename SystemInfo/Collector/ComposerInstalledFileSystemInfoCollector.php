<?php

/**
 * File containing the ComposerInstalledFileSystemInfoCollector class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\EzSupportToolsBundle\SystemInfo\Collector;

use Composer\Json\JsonFile;
use Composer\Package\Dumper\ArrayDumper;
use Composer\Repository\InstalledFilesystemRepository;
//use EzSystems\EzSupportToolsBundle\SystemInfo\ComposerInstalledFileNotFoundException; //TODO
use EzSystems\EzSupportToolsBundle\SystemInfo\Value;

/**
 * Collects information about installed Composer packages, by reading json from composer.lock.
 */
class ComposerInstalledFileSystemInfoCollector implements SystemInfoCollector
{
    /**
     * @var string Composer installed.json file with full path
     */
    private $installedFile;

    public function __construct($installedFile)
    {
        $this->installedFile = $installedFile;
    }

    /**
     * Builds information about installed composer packages.
     *
     * @return Value\ComposerSystemInfo
     */
    public function build()
    {
        if (!file_exists($this->installedFile)) {
            //TODO
//            throw new ComposerInstalledFileNotFoundException(
//                "Composer lock file '$this->installedFile' not found, cannot build package list.",
//            );
        }

        $repository = new InstalledFilesystemRepository(
            new JsonFile($this->installedFile)
        );
        $packages = [];

        foreach ($repository->getPackages() as $package) {
            $packageValue = new Value\ComposerPackage([
                'internalPackage' => $package,
            ]);
            $packages[$package->getName()] = $packageValue;
        }

        ksort($packages, SORT_FLAG_CASE | SORT_STRING);

        return new Value\ComposerSystemInfo([
            'packages' => $packages,
        ]);
    }
}
