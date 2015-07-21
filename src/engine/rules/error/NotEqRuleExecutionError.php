<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 13.07.15
 * Time: 14:19
 */

namespace dicom\workflow\engine\rules\error;

class NotEqRuleExecutionError extends RuleExecutionError
{
    public static function create($valueGiven, $valueExpected)
    {
        $error =  new static(sprintf(
            'Value not must be equally %s. Given: %s',
            var_export($valueExpected, true),
            var_export($valueGiven, true)
        ));

        return $error;
    }
}
