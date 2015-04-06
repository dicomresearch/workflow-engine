<?php


namespace dicom\workflow\rules;


use dicom\workflow\rules\exception\RuleExecutionException;
use dicom\workflow\rules\executionResult\RuleExecutionResult;
use dicom\workflow\rules\RuleInterface\IRuleCheckingPropertyValue;

class IsEmptyRule extends Rule implements IRuleCheckingPropertyValue
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
            $result->setError($this->constructException($propertyValue));
        }

        return $result;
    }


    protected function isValid($entityNewValue)
    {
        return empty($entityNewValue);
    }

    protected function constructException($entityNewValue)
    {
        $error =  new RuleExecutionException(
            sprintf(
                'Property is must be empty: but given: %s',
                var_export($entityNewValue, true)
            )
        );

        $error->setHumanFriendlyMessage('Field must be empty');

        return $error;
    }
}