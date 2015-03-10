<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 18.11.14
 * Time: 18:01
 */

namespace dicom\workflow\visitor\factory\exceptions;


class GettingInsideFactoryException extends \Exception
{
    /**
     * @param string $visitorName
     * @return static
     */
    public static function visitorMystBeDefined($visitorName)
    {
        return new static(
            sprintf('You must define visitor %s before using GettingInsideVisitorFactory', $visitorName)
        );
    }
} 