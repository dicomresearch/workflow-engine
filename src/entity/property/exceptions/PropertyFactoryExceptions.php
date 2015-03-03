<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.12.14
 * Time: 14:02
 */

namespace workflow\entity\property\exceptions;


class PropertyFactoryExceptions extends \Exception
{
    public static function CompositePropertyMustContainsSubPropertiesDefinitions($propertyName, $subPropertyDefinitions)
    {
        return new static(
            sprintf(
                'Cant create Composite Property %s. Property Definition must contains subPropertyDefinitions %s',
                $propertyName,
                var_export($subPropertyDefinitions, true)
            )
        );
    }
} 