<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.10.14
 * Time: 16:39
 */

namespace dicom\workflow\building\entity\exception;

class EntityFactoryException extends \Exception
{
    public static function descriptionMustContainsProperty()
    {
        return new static('entity description must contains "properties" section');
    }
}
