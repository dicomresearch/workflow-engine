<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 07.10.14
 * Time: 16:17
 */

namespace workflow\transition\exceptions;


class TransitionSpecificationNotValid extends \Exception
{
    public static function paramNeed($paramName, array $specification)
    {
        return new static(sprintf(
            'Param %s need for transition specification. Given %s',
            $paramName,
            var_export($specification, true)
            )
        );
    }
} 