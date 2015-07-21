<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 08.07.15
 * Time: 11:51
 */

namespace dicom\workflow\engine\context\resource\executionResult;

use dicom\workflow\engine\context\resource\Resource;
use dicom\workflow\engine\rules\executionResult\RuleExecutionResult;

class ResourceExecutionResult
{
    /**
     * @var Resource
     */
    private $resource;

    /**
     * @var RuleExecutionResult[]
     */
    private $rulesExecutionResult = [];

    /**
     * @param Resource $resource
     */
    public function __construct(Resource $resource)
    {
        $this->setResource($resource);
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
        return $this->getResource()->getName();
    }

    /**
     * @return Resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param Resource $resource
     */
    public function setResource(Resource $resource)
    {
        $this->resource = $resource;
    }

    public function addRuleExecutionResult(RuleExecutionResult $executionResult)
    {
        $this->rulesExecutionResult[] = $executionResult;
    }

    /**
     * @return RuleExecutionResult[]
     */
    public function getRulesExecutionResult()
    {
        return $this->rulesExecutionResult;
    }
}
