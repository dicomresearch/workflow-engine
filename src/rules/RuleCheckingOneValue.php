<?php


namespace dicom\workflow\rules;


use dicom\workflow\rules\executionResult\RuleExecutionResult;
use dicom\workflow\rules\RuleInterface\IRuleCheckingOneValue;

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
            $result->setError($this->constructValidationException($propertyValue));
        }

        return $result;
    }

    abstract protected function isValid($value);

    abstract protected function constructValidationException($value);
}