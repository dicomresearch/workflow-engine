<?php


namespace dicom\workflow\rules;


use dicom\workflow\rules\exception\RuleExecutionError;
use dicom\workflow\rules\executionResult\RuleExecutionResult;
use dicom\workflow\rules\RuleInterface\IRuleCheckingOneValue;

class IsEmptyRule extends RuleCheckingOneValue
{


    protected function isValid($entityNewValue)
    {
        return empty($entityNewValue);
    }

    protected function constructValidationException($entityNewValue)
    {
        $error =  new RuleExecutionError(
            sprintf(
                'Property is must be empty: but given: %s',
                var_export($entityNewValue, true)
            )
        );

        $error->setHumanFriendlyMessage('Field must be empty');

        return $error;
    }
}