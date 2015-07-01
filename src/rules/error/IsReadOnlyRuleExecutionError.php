<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 01.07.15
 * Time: 16:14
 */

namespace dicom\workflow\rules\error;


class IsReadOnlyRuleExecutionError extends RuleExecutionError
{
    /**
     * @param $entityOldValue
     * @param $entityNewValue
     * @return static
     */
    public static function create($entityOldValue, $entityNewValue)
    {
        $error = new static(
            sprintf(
                'Property is readOnly. But value has been modified:, Old Value: %s, New value: %s',
                var_export($entityOldValue, true),
                var_export($entityNewValue, true)
            )
        );

        $error->setHumanFriendlyMessage('Is read only field');

        return $error;
    }
}