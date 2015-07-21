<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 02.07.15
 * Time: 12:06
 */

namespace dicom\workflow\engine\rules\error;

class BetweenRuleExecutionError extends RuleExecutionError
{
    /**
     * @param $valueGiven
     * @param $config
     * @return static
     */
    public static function create($valueGiven, $config)
    {
        $error = new static(sprintf(
            'value should be in the interval from %d to %d. Given: %d',
            $config[0],
            $config[1],
            $valueGiven
        ));

        return $error;
    }
}
