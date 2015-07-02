<?php


namespace dicom\workflow\rules;


use dicom\workflow\rules\error\IsEmptyRuleExecutionError;

class IsEmptyRule extends RuleCheckingOneValue
{


    protected function isValid($entityNewValue)
    {
        return empty($entityNewValue);
    }

    protected function constructValidationError($entityNewValue)
    {
        return IsEmptyRuleExecutionError::create($entityNewValue);
    }
}