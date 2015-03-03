<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.10.14
 * Time: 16:37
 */

namespace workflow\entity;


use workflow\entity\exception\EntityFactoryException;
use workflow\entity\property\PropertyFactory;

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