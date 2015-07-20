<?php

namespace dicom\workflow\engine\state;

use dicom\workflow\engine\entity\Entity;
use dicom\workflow\engine\state\exception\StateException;
use dicom\workflow\engine\state\executionResult\StateExecutionResult;

/**
 * Class State
 *
 * Состояния сущности. Отражает конечную или промежуточную точку, куда может переместится сущность
 *
 * @package dicom\workflow\state
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
     * @throws \dicom\workflow\engine\state\exception\StateException
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
