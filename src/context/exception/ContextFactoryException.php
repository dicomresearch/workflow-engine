<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 08.07.15
 * Time: 13:29
 */

namespace dicom\workflow\context\exception;


class ContextFactoryException extends \Exception
{
    public static function descriptionMustContainsContext()
    {
        return new static('entity description must contains "context" section');
    }
}