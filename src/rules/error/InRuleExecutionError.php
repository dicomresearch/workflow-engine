<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 01.07.15
 * Time: 15:19
 */

namespace dicom\workflow\rules\error;


class InRuleExecutionError extends RuleExecutionError
{
    /**
     * @param $value
     * @param $config
     * @return static
     */
    public static function create($value, $config)
    {
        $error =  new static(sprintf(
            'Value: "%s" not In %s',
            var_export($value, true),
            var_export($config, true)));

        return $error;
    }
}