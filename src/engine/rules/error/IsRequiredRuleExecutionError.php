<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 01.07.15
 * Time: 17:15
 */

namespace dicom\workflow\engine\rules\error;

class IsRequiredRuleExecutionError extends RuleExecutionError
{
    /**
     * @param $entityNewValue
     * @return static
     */
    public static function create($entityNewValue)
    {
        $error =  new static(
            sprintf(
                'Property is required: but given: %s',
                var_export($entityNewValue, true)
            )
        );

        $error->setHumanFriendlyMessage('Is required field');

        return $error;
    }
}
