<?php

/**
 * File containing the ComposerPackage class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\EzSupportToolsBundle\SystemInfo\Value;

use eZ\Publish\API\Repository\Values\ValueObject;

/**
 * Value for information about a Composer package.
 */
class ComposerPackage extends ValueObject implements SystemInfo
{
    /**
     * Version.
     *
     * Example: v2.7.10
     *
     * @var string
     */
    public $version;

    /**
     * Date and time string.
     *
     * Example: 2016-02-28 20:37:19
     *
     * @var string
     */
    public $dateTimeString;

    /**
     * Homepage URL.
     *
     * Example: https://symfony.com
     *
     * @var string
     */
    public $homepage;

    /**
     * Reference.
     *
     * Example: 9a3b6bf6ebee49370aaf15abc1bdeb4b1986a67d
     *
     * @var string
     */
    public $reference;
}
