<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 08.07.15
 * Time: 13:42
 */

namespace dicom\workflow\context\resource\exception;


class ResourceFactoryException extends \Exception
{
    public static function CompositeResourceMustContainsSubResourceDefinitions($propertyName, $subPropertyDefinitions)
    {
        return new static(
            sprintf(
                'Cant create Composite Resource %s. Resource Definition must contains subResourceDefinitions %s',
                $propertyName,
                var_export($subPropertyDefinitions, true)
            )
        );
    }
}