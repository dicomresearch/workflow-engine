<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 01.07.15
 * Time: 16:09
 */

namespace dicom\workflow\rules\error;


class IsEmptyRuleExecutionError extends RuleExecutionError
{
    /**
     * @param $entityNewValue
     * @return static
     */
    public static function create($entityNewValue)
    {
        $error =  new static(
            sprintf(
                'Property is must be empty: but given: %s',
                var_export($entityNewValue, true)
            )
        );

        $error->setHumanFriendlyMessage('Field must be empty');

        return $error;
    }
}