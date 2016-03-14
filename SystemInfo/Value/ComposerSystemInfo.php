<?php

/**
 * File containing the ComposerSystemInfo class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\EzSupportToolsBundle\SystemInfo\Value;

use eZ\Publish\API\Repository\Values\ValueObject;

/**
 * Value for information about installed Composer packages.
 */
class ComposerSystemInfo extends ValueObject implements SystemInfo
{
    /**
     * Packages.
     *
     * A two-dimensional hash of composer names and package information, or null if packages cannot be read.
     *
     * Example of a single entry:
     * 'ezsystems/ezpublish-kernel' =>
     * array (
     *   'version' => 'dev-master',
     *   'time' => '2016-02-28 14:30:53',
     *   'homepage' => 'http://share.ez.no',
     *   'reference' => 'ec897baa77c63b745749acf201e85b92bd614723',
     * )
     *
     * @var array|null
     */
    public $packages;
}
