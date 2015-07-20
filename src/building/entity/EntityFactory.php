<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.10.14
 * Time: 16:37
 */

namespace dicom\workflow\building\entity;

use dicom\workflow\engine\entity\Entity;
use dicom\workflow\building\entity\exception\EntityFactoryException;
use dicom\workflow\building\entity\property\PropertyFactory;

class EntityFactory
{
    public static function createBasedOnDescription($entityDescription)
    {
        $entity = new Entity();

        if (!array_key_exists('properties', $entityDescription)) {
            throw EntityFactoryException::descriptionMustContainsProperty();
        }
        foreach ($entityDescription['properties'] as $propertyName => $rules) {
            $entity->addProperty(PropertyFactory::create($propertyName, $rules));
        }

        return $entity;
    }
}
