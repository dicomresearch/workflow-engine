<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 10/2/14
 * Time: 5:26 PM
 */

namespace dicom\workflow\rules;
use dicom\workflow\rules\exception\RuleExecutionException;
use dicom\workflow\rules\executionResult\RuleExecutionResult;
use dicom\workflow\rules\RuleInterface\IRuleCheckingOneValue;

/**
 * Class RequiredAttribute
 *
 * Значение аттрибута должны быть обязательно задано для сущности
 *
 * @package modules\dicom\workflow\models
 */
class PropertyIsRequiredRule extends Rule implements IRuleCheckingOneValue
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
        return !empty($entityNewValue);
    }

    protected function constructException($entityNewValue)
    {
        $error =  new RuleExecutionException(
            sprintf(
                'Property is required: but given: %s',
                var_export($entityNewValue, true)
            )
        );

        $error->setHumanFriendlyMessage('Is required field');

        return $error;
    }
} 