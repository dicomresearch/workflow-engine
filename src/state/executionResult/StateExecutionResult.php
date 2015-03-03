<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 02.02.15
 * Time: 14:19
 */

namespace workflow\state\executionResult;


use workflow\entity\executionResult\EntityExecutionResult;
use workflow\state\State;

class StateExecutionResult
{
    /**
     * @var State
     */
    private $state;

    /**
     * @var EntityExecutionResult
     */
    private $entityExecutionResult;

    /**
     * Create State execution result
     *
     * @param State $state
     */
    public function __construct(State $state)
    {
        $this->setState($state);
    }

    /**
     * does State execution rules success?
     *
     * @return bool
     */
    public function isSuccess()
    {
        return $this->getEntityExecutionResult()->isSuccess();
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->getEntityExecutionResult()->getErrors();
    }


    /**
     * @return State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param State $state
     */
    protected function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return EntityExecutionResult
     */
    public function getEntityExecutionResult()
    {
        return $this->entityExecutionResult;
    }

    /**
     * @param EntityExecutionResult $entityExecutionResult
     */
    public function setEntityExecutionResult($entityExecutionResult)
    {
        $this->entityExecutionResult = $entityExecutionResult;
    }

    /**
     * Get actions for clients code
     *
     * @return array
     */
    public function getActions()
    {
        return $this->getState()->getActions();
    }
}