<?php


namespace dicom\workflow\engine\rules;

use dicom\workflow\engine\rules\error\IsEmptyRuleExecutionError;

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
