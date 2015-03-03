<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 10/2/14
 * Time: 5:48 PM
 */

namespace workflow\rules;


use workflow\rules\exception\RuleExecutionException;
use workflow\rules\executionResult\RuleExecutionResult;
use workflow\rules\RuleInterface\IRuleCompareTwoValueInterface;

class PropertyIsReadOnlyRule extends Rule implements IRuleCompareTwoValueInterface
{
    /**
     * проверяет соответсвует ли значение сущности условиям аттрибута
     *
     * @param $newValue
     * @param $oldValue
     * @return RuleExecutionResult
     * @internal param $propertyValue
     */
    function execute($newValue, $oldValue)
    {
        $result = new RuleExecutionResult($this);
        $isValid = $this->isValid($newValue, $oldValue);
        $result->setResult($isValid);

        if (!$isValid) {
            $result->setError($this->constructException($newValue, $oldValue));
        }

        return $result;
    }

    /**
     * Проверяет на идентичность значений
     *
     * @param null|mixed $entityNewValue
     * @param null|mixed $entityOldValue

     * @return bool
     */
    protected function isValid($entityNewValue = null, $entityOldValue = null)
    {
        return $entityOldValue == $entityNewValue;
    }

    /**
     *
     * @param null|mixed $entityNewValue
     * @param null|mixed $entityOldValue
     *
     * @return RuleExecutionException
     */
    protected function constructException($entityNewValue = null, $entityOldValue = null)
    {
        $error = new RuleExecutionException(
            sprintf(
                'Property is readOnly. But value has been modified:, Old Value: %s, New value: %s',
                var_export($entityOldValue, true),
                var_export($entityNewValue, true)
            )
        );

        $error->setHumanFriendlyMessage('Is read only field');

        return $error;
    }

} 