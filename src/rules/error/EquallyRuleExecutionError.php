<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 01.07.15
 * Time: 13:35
 */

namespace dicom\workflow\rules\error;


class EquallyRuleExecutionError extends RuleExecutionError
{
    /**
     * @param $valueGiven
     * @param $valueExpected
     * @return static
     */
    public static function create($valueGiven, $valueExpected)
    {
        $error =  new static(sprintf('Value must be equally %s. Given: %s', $valueExpected, $valueGiven));

        return $error;
    }
}