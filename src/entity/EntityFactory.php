<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.10.14
 * Time: 16:37
 */

namespace dicom\workflow\entity;


use dicom\workflow\entity\exception\EntityFactoryException;
use dicom\workflow\entity\property\PropertyFactory;

class EntityFactory
{
    public static function createBasedOnDescription($entityDescription)
    {
        $entity = new Entity();

        if (!array_key_exists('entity', $entityDescription)) {
            throw EntityFactoryException::descriptionMustContainsProperty();
        }
        foreach ($entityDescription['entity'] as $propertyName => $rules) {
            $entity->addProperty(PropertyFactory::create($propertyName, $rules));
        }

        return $entity;
    }
} 