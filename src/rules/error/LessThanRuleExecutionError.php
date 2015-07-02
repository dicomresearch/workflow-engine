<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 01.07.15
 * Time: 17:52
 */

namespace dicom\workflow\rules\error;


class LessThanRuleExecutionError extends RuleExecutionError
{
    /**
     * @param $value
     * @param $config
     * @return static
     */
    public static function create($value, $config)
    {
        $error =  new static(sprintf('Value must be less than %s. Given: %s', $config, $value));
        $error->setHumanFriendlyMessage(sprintf('Must be less than %s', $value));

        return $error;
    }
}