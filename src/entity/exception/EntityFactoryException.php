<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.10.14
 * Time: 16:39
 */

namespace workflow\entity\exception;


use Ddeboer\Imap\Exception\Exception;

class EntityFactoryException extends Exception
{
    public static function descriptionMustContainsProperty()
    {
        return new static('entity description must contains "properties" section');
    }
} 