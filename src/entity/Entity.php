<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.10.14
 * Time: 15:35
 */

namespace workflow\entity;

use workflow\entity\executionResult\EntityExecutionResult;
use workflow\entity\property\Property;
use workflow\visitor\VisitorInterface;

/**
 * Class Entity
 *
 * Сущность - содержащая набор свойств
 *
 * @package workflow\models\entity
 */
class Entity
{
    /**
     * Параметры сущности
     *
     * @var Property[]
     */
    protected $properties;


    /**
     * @param Property $property
     */
    public function addProperty(Property $property)
    {
        $this->properties[$property->getName()] = $property;
    }

    /**
     * @param string $propertyName
     */
    public function removeProperty($propertyName)
    {
        if (!array_key_exists($propertyName, $this->properties)) {
            return;
        }

        unset($this->properties[$propertyName]);
    }

    /**
     * @return Property[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Проверяет что все параметры удовлетвоярют своим инвариантам
     *
     * @param null $entityNewValue
     * @param null $entityOldValue
     * @return EntityExecutionResult
     */
    public function executeRules($entityNewValue = null, $entityOldValue = null)
    {
        $entityExecutionResult = new EntityExecutionResult($this);

        foreach ($this->getProperties() as $propertyName => $property) {

            if (!array_key_exists($propertyName, $entityNewValue)) {
                $entityNewValue[$propertyName] = null;
            }

            if (!array_key_exists($propertyName, $entityOldValue)) {
                $entityOldValue[$propertyName] = null;
            }

            $propertyExecutionResult = $property->executeRules($entityNewValue[$propertyName], $entityOldValue[$propertyName]);
            $entityExecutionResult->addPropertyExecutionResult($propertyExecutionResult);
        }

        return $entityExecutionResult;
    }

} 