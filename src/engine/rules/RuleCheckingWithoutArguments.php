<?php


namespace dicom\workflow\engine\rules;

use dicom\workflow\engine\rules\executionResult\RuleExecutionResult;
use dicom\workflow\building\rules\RuleInterface\IRuleCheckingWithoutArguments;

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
            $result->setError($this->constructValidationError());
        }

        return $result;
    }


    abstract protected function isValid();

    abstract protected function constructValidationError();
}
