<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 08.07.15
 * Time: 11:32
 */

namespace dicom\workflow\engine\context\resource;

use dicom\workflow\building\rules\RuleInterface\IRule;
use dicom\workflow\engine\context\resource\executionResult\ResourceExecutionResult;
use dicom\workflow\engine\rules\adapter\RuleAdapter;

/**
 * Class Resource
 *
 * Класс описывает одно из свойств контекста. Содержит правила валидации свойства
 *
 * @package dicom\workflow\context\resources
 */
class Resource
{
    /**
     * @var string название параметра
     */
    protected $name;

    /**
     * @var IRule
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
     * @param IRule[] $rules
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
