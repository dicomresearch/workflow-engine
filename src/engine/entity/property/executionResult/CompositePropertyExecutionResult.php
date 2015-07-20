<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 02.02.15
 * Time: 13:52
 */

namespace dicom\workflow\engine\entity\property\executionResult;

class CompositePropertyExecutionResult extends PropertyExecutionResult
{
    /**
     * @var PropertyExecutionResult[]
     */
    private $subProperties = [];

    public function addSubPropertyResult(PropertyExecutionResult $propertyExecutionResult)
    {
        $this->subProperties[$propertyExecutionResult->getName()] = $propertyExecutionResult;
    }

    /**
     * @return PropertyExecutionResult[]
     */
    public function getSubProperties()
    {
        return $this->subProperties;
    }

    public function isSuccess()
    {
        foreach ($this->getSubProperties() as $subPropertiesExecutionResult) {
            if (! $subPropertiesExecutionResult->isSuccess()) {
                return false;
            }
        }

        return true;
    }

    public function getErrors()
    {
        $errors = [];
        foreach ($this->getSubProperties() as $subPropertiesExecutionResult) {
            $errors = array_merge($errors, $subPropertiesExecutionResult->getErrors());
        }

        return $errors;

    }
}
