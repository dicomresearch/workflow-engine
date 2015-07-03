<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 01.07.15
 * Time: 14:55
 */

namespace dicom\workflow\rules\error;

/**
 * Class GteRuleExecutionError
 * @package dicom\workflow\rules\error
 */
class GteRuleExecutionError extends RuleExecutionError
{
    /**
     * @param $value
     * @param $config
     *
     * @return static
     */
    public static function create($value, $config)
    {
        $error =  new static(sprintf('Value must be greater or equally than %s. Given: %s', $config, $value));
        $error->setHumanFriendlyMessage(sprintf('Must be greater than %s', $value));

        return $error;
    }
}