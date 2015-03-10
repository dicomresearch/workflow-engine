<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 02.02.15
 * Time: 12:31
 */

namespace dicom\workflow\entity\property\executionResult;


use dicom\workflow\entity\property\Property;
use dicom\workflow\rules\executionResult\RuleExecutionResult;

class PropertyExecutionResult
{
    /**
     * @var Property
     */
    private $property;

    /**
     * @var RuleExecutionResult[]
     */
    private $rulesExecutionResult = [];

    /**
     * Create PropertyExecutionResult
     *
     * @param Property $property
     */
    public function __construct(Property $property)
    {
        $this->setProperty($property);
    }

    /**
     * Get errors for rule execution
     *
     * @return array of key => value, where key = rule name, value = error message
     */
    public function getErrors()
    {
        $errors = [];

        foreach ($this->getRulesExecutionResult() as $ruleExecutionResult) {
            if (null !== $ruleExecutionResult->getError()) {
                $ruleExecutionResult->getError()->setPropertyName($this->getName());
                $errors[] = $ruleExecutionResult->getError();
            }
        }

        return $errors;
    }

    /**
     * does rules execute success?
     *
     * @return bool
     */
    public function isSuccess()
    {
        foreach ($this->getRulesExecutionResult() as $ruleExecutionResult) {
            if (! $ruleExecutionResult->isSuccess()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get property name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getProperty()->getName();
    }

    /**
     * @return Property
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param Property $property
     */
    public function setProperty($property)
    {
        $this->property = $property;
    }

    public function addRuleExecutionResult(RuleExecutionResult $executionResult)
    {
        $this->rulesExecutionResult[] = $executionResult;
    }

    /**
     * @return \dicom\workflow\rules\executionResult\RuleExecutionResult[]
     */
    public function getRulesExecutionResult()
    {
        return $this->rulesExecutionResult;
    }





}