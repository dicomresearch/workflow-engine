<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 01.07.15
 * Time: 14:55
 */

namespace dicom\workflow\engine\rules\error;

class GtRuleExecutionError extends RuleExecutionError
{
    /**
     * @param $value
     * @param $config
     *
     * @return static
     */
    public static function create($value, $config)
    {
        $error =  new static(sprintf('Value must be greater than %s. Given: %s', $config, $value));
        $error->setHumanFriendlyMessage(sprintf('Must be greater than %s', $value));

        return $error;
    }
}
