<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 01.07.15
 * Time: 14:55
 */

namespace dicom\workflow\rules\error;


class GreaterThanRuleExecutionError extends RuleExecutionError
{
    /**
     * @param $value
     * @return static
     */
    public static function create($value)
    {
        $error =  new static(sprintf('Value must be greater than 0. Given: %s', $value));
        $error->setHumanFriendlyMessage('Must be greater than 0');

        return $error;
    }
}