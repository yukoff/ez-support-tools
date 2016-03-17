<?php

/**
 * File containing the ComposerPackage class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\EzSupportToolsBundle\SystemInfo\Value;

use Composer\Package\PackageInterface;
use eZ\Publish\API\Repository\Values\ValueObject;

/**
 * Value for information about a Composer package.
 */
class ComposerPackage extends ValueObject implements SystemInfo
{
    /**
     * Internal Composer package object
     *
     * @var \Composer\Package\PackageInterface
     */
    protected $internalPackage;

    /**
     * Magic get function handling access to getters on the internal composer object.
     *
     * Returns value for all readonly (protected) properties.
     *
     * @param string $property Name of the property
     *
     * @return mixed
     */
    public function __get($property)
    {
        $methodName = 'get' . ucfirst($property); //TODO move to private method
        if (method_exists($this->internalPackage, $methodName)) {
            return $this->internalPackage->$methodName();
        }

        parent::__get($property);
    }

    /**
     * Function where list of properties are returned.
     *
     * Used by {@see attributes()}, override to add dynamic properties
     *
     * @uses __isset()
     *
     * @todo Make object traversable and reuse this function there (hence why this is not exposed)
     *
     * @param array $dynamicProperties Additional dynamic properties exposed on the object
     *
     * @return array
     */
    protected function getProperties($dynamicProperties = array())
    {
        $properties = $dynamicProperties;

        // TODO Not very nice. Use hardcoded lookup table instead?
        foreach (get_class_methods($this->internalPackage) as $methodName) {
            if ($methodName === 'getRepository') {
                continue;
            }

            if (substr($methodName, 0, 3) === 'get') {
                $propertyName = lcfirst(substr($methodName, 3)); //TODO move to private method
                $properties[] = $propertyName;
            }
        }

        return $properties;
    }

    /**
     * TODO this just exposes getProperties() publicly, hack for temporary dump command.
     *
     * @return array
     */
    public function publicProperties()
    {
        return $this->getProperties();
    }
}
