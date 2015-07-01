<?php


namespace dicom\workflow\rules;


use dicom\workflow\rules\executionResult\RuleExecutionResult;
use dicom\workflow\rules\RuleInterface\IRuleCheckingWithoutArguments;

abstract class RuleCheckingWithoutArguments extends Rule implements IRuleCheckingWithoutArguments
{
    /**
     * execute a rule.
     *
     * If rule dont match than throw RuleExecutionError
     */
    public function execute()
    {
        $result = new RuleExecutionResult($this);

        $isValid = $this->isValid();
        $result->setResult($isValid);

        if (!$isValid) {
            $result->setError($this->constructValidationException());
        }

        return $result;
    }


    abstract protected function isValid();

    abstract protected function constructValidationException();

}