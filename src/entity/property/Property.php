<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 10/2/14
 * Time: 5:20 PM
 */

namespace workflow\entity\property;
use workflow\entity\property\executionResult\PropertyExecutionResult;
use workflow\rules\adapter\RuleAdapter;
use workflow\rules\Rule;
use workflow\transition\Transition;

/**
 * Class Property of Entity
 *
 * Класс описывает одно из свойств сущности. Содержит правила валидации свойства
 *
 * @package workflow\models\entity
 */
class Property
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
     * @param $name
     */
    public function  __construct($name)
    {
        $this->setName($name);
    }


    /**
     * add rule for checking to this property
     *
     * @param Rule $rule
     */
    public function addPropertyRule($rule)
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
     * @param null|mixed $propertyNewValue новое значение аттрибута (например перед сохранением в базу данных)
     * @param null|mixed $propertyOldValue старое значение аттрибута (например причтении из базы)
     *
     * @return PropertyExecutionResult
     */
    public function executeRules($propertyNewValue = null, $propertyOldValue = null)
    {
        $propertyExecutionResult = new PropertyExecutionResult($this);

        foreach ($this->getRules() as $rule) {
            $adapter = new RuleAdapter($rule);
            $executionResult = $adapter->execute($propertyNewValue, $propertyOldValue);
            $propertyExecutionResult->addRuleExecutionResult($executionResult);
        }

        return $propertyExecutionResult;
    }



} 