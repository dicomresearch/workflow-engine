<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 01.07.15
 * Time: 14:30
 */

namespace dicom\workflow\rules\error;


class AlwaysFalseRuleExecutionError extends RuleExecutionError
{
    /**
     * @return static
     */
    public static function create()
    {
        $error =  new static(sprintf('This rule is always return false'));

        return $error;
    }
}