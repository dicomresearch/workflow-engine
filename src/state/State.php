<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 10/2/14
 * Time: 5:18 PM
 */

namespace workflow\state;


use workflow\entity\Entity;
use workflow\entity\Property;
use workflow\state\exception\StateException;
use workflow\state\executionResult\StateExecutionResult;
use workflow\visitor\state\AbstractStateVisitor;
use workflow\visitor\VisitorInterface;

/**
 * Class State
 *
 * Состояния сущности. Отражает конечную или промежуточную точку, куда может переместится сущность
 *
 * @package workflow\state
 */
class State
{
    /**
     * @var Entity
     */
    protected $entity;

    /**
     * @var string
     */
    protected $name;

    protected $actions = [];

    public function __construct($stateName)
    {
        $this->setName($stateName);
    }

    /**
     * Проверяет валидно ли состояние сущностей для этого состояния
     *
     * @param array $newEntityAttributes
     * @param array $oldEntityAttributes
     *
     * @return StateExecutionResult
     * @throws StateException
     */
    public function executeRules($newEntityAttributes, $oldEntityAttributes)
    {
        $stateExecutionResult = new StateExecutionResult($this);
        $entityExecutionResult = $this->getEntity()->executeRules($newEntityAttributes, $oldEntityAttributes);
        $stateExecutionResult->setEntityExecutionResult($entityExecutionResult);

        return $stateExecutionResult;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /**
     * get entity or throw exception if entity not set
     *
     * @throws \workflow\state\exception\StateException
     * @return Entity
     */
    public function getEntity()
    {
        if (is_null($this->entity)) {
            throw StateException::stateNotContainsEntity($this->getName());
        }
        return $this->entity;
    }

    /**
     * @param Entity $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * @param array $actions
     */
    public function setActions($actions)
    {
        $this->actions = $actions;
    }
}