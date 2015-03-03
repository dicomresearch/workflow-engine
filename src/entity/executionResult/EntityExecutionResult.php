<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 02.02.15
 * Time: 14:00
 */

namespace workflow\entity\executionResult;


use workflow\entity\Entity;
use workflow\entity\property\executionResult\PropertyExecutionResult;

/**
 * Class EntityExecutionResult
 *
 * Result of rules execution. Contains rule execution result of properties
 *
 * @package workflow\entity\executionResult
 */
class EntityExecutionResult
{
    /**
     * @var Entity
     */
    private $entity;

    /**
     * @var PropertyExecutionResult[]
     */
    private $propertyExecutionResult;

    public function __construct(Entity $entity)
    {
        $this->setEntity($entity);
    }

    /**
     * does property rules execute success?
     *
     * @return bool
     */
    public function isSuccess()
    {
        foreach ($this->getPropertyExecutionResult() as $propertyResult) {
            if (! $propertyResult->isSuccess()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get errors for rules execution
     *
     * @return array of key => value, where key = property name, value - array of errors
     */
    public function getErrors()
    {
        $errors = [];
        foreach ($this->getPropertyExecutionResult() as $propertyExecutionResult) {
            if (0 !== count($propertyExecutionResult->getErrors())) {
                $errors = array_merge($errors, $propertyExecutionResult->getErrors());
            }
        }
        return $errors;
    }

    /**
     * @return Entity
     */
    public function getEntity()
    {
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
     * @return PropertyExecutionResult[]
     */
    public function getPropertyExecutionResult()
    {
        return $this->propertyExecutionResult;
    }

    /**
     * @param PropertyExecutionResult $propertyExecutionResult
     */
    public function addPropertyExecutionResult(PropertyExecutionResult $propertyExecutionResult)
    {
        $this->propertyExecutionResult[$propertyExecutionResult->getName()] = $propertyExecutionResult;
    }

}