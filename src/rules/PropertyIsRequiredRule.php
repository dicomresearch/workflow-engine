<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 10/2/14
 * Time: 5:26 PM
 */

namespace workflow\rules;
use workflow\rules\exception\RuleExecutionException;
use workflow\rules\executionResult\RuleExecutionResult;
use workflow\rules\RuleInterface\IRuleCheckingPropertyValue;
use workflow\rules\RuleInterface\IRuleCompareTwoValueInterface;

/**
 * Class RequiredAttribute
 *
 * Значение аттрибута должны быть обязательно задано для сущности
 *
 * @package modules\workflow\models
 */
class PropertyIsRequiredRule extends Rule implements IRuleCheckingPropertyValue
{
    /**
     * проверяет соответсвует ли значение сущности условиям аттрибута
     *
     * @param $propertyValue
     * @param $outError
     *
     * @return RuleExecutionResult
     */
    public function execute($propertyValue, &$outError = null)
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