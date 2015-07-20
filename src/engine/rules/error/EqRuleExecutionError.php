<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 01.07.15
 * Time: 13:35
 */

namespace dicom\workflow\engine\rules\error;

class EqRuleExecutionError extends RuleExecutionError
{
    /**
     * @param $valueGiven
     * @param $valueExpected
     * @return static
     */
    public static function create($valueGiven, $valueExpected)
    {
        $error = new static(sprintf(
            'Value must be equally %s. Given: %s',
            var_export($valueExpected, true),
            var_export($valueGiven, true)
        ));

        return $error;
    }
}
