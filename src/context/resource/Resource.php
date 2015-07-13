<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 08.07.15
 * Time: 11:32
 */

namespace dicom\workflow\context\resource;

use dicom\workflow\context\resource\executionResult\ResourceExecutionResult;
use dicom\workflow\rules\adapter\RuleAdapter;
use dicom\workflow\rules\Rule;
use dicom\workflow\rules\RuleInterface\IRule;

/**
 * Class Resource
 *
 * @package dicom\workflow\context\resource
 */
class Resource
{
    /**
     * @var string название параметра
     */
    protected $name;

    /**
     * @var Rule
     */
    protected $rules;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->setName($name);
    }

    /**
     * add rule for checking to this property
     *
     * @param IRule $rule
     */
    public function addPropertyRule(IRule $rule)
    {
        $this->rules[$rule->getName()] = $rule;
    }

    /**
     * @param Rule[] $rules
     */
    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    /**
     * clear all rules for this property
     */
    public function clearPropertyRules()
    {
        $this->rules = [];
    }

    /**
     * @return Rule[]
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * проверяет, что все правила данного свойства удовлетворены
     *
     * @param null|mixed $context какие внешнии состояния среды
     *
     * @return ResourceExecutionResult
     */
    public function executeRules($context = null)
    {
        $resourceExecutionResult = new ResourceExecutionResult($this);

        foreach ($this->getRules() as $rule) {
            $adapter = new RuleAdapter($rule);
            $executionResult = $adapter->execute($context);
            $resourceExecutionResult->addRuleExecutionResult($executionResult);
        }

        return $resourceExecutionResult;
    }
}