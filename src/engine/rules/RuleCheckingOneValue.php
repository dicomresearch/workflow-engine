<?php


namespace dicom\workflow\engine\rules;

use dicom\workflow\engine\rules\executionResult\RuleExecutionResult;
use dicom\workflow\building\rules\RuleInterface\IRuleCheckingOneValue;

abstract class RuleCheckingOneValue extends Rule implements IRuleCheckingOneValue
{
    /**
     * проверяет соответсвует ли значение сущности условиям аттрибута
     *
     * @param $propertyValue
     *
     * @return RuleExecutionResult
     */
    public function execute($propertyValue)
    {
        $result = new RuleExecutionResult($this);

        $isValid = $this->isValid($propertyValue);
        $result->setResult($isValid);

        if (!$isValid) {
            $result->setError($this->constructValidationError($propertyValue));
        }

        return $result;
    }

    abstract protected function isValid($value);

    abstract protected function constructValidationError($value);
}
