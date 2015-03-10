<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.10.14
 * Time: 17:42
 */

namespace dicom\workflow\state\exception;


class StateException
{
    public static function stateNotContainsEntity($stateName)
    {
        return new static(sprintf(
            'You try use entity of state "%s". You must set Entity to State before use it', $stateName)
        );
    }
} 