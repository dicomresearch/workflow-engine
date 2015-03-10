<?php
/**
 * Created by PhpStorm.
 * User: aakhmetshin
 * Date: 08.10.14
 * Time: 18:25
 */

namespace dicom\workflowtest;

abstract class AbstractWorkflowTest extends \WorkflowTestCase {


    private $oldEntity;
    private $newEntity;
    private $context;
    private $newState;

    /**
     * @param mixed $newState
     */
    public function setNewState($newState)
    {
        $this->newState = $newState;
    }

    /**
     * @return mixed
     */
    public function getNewState()
    {
        return $this->newState;
    }



    /**
     * @param mixed $oldEntity
     */
    public function setOldEntity($oldEntity)
    {
        $this->oldEntity = $oldEntity;
    }

    /**
     * @return mixed
     */
    public function getOldEntity()
    {
        return $this->oldEntity;
    }

    /**
     * @param mixed $newEntity
     */
    public function setNewEntity($newEntity)
    {
        $this->newEntity = $newEntity;
    }

    /**
     * @return mixed
     */
    public function getNewEntity()
    {
        return $this->newEntity;
    }

    /**
     * @param mixed $context
     */
    public function setContext($context)
    {
        $this->context = $context;
    }

    /**
     * @return mixed
     */
    public function getContext()
    {
        return $this->context;
    }

    public function workflowTest()
    {
        if ($this->engine->getStateEngine()->isEntityValidForState(
            $this->getNewState(), $this->getNewEntity(), $this->getOldEntity(), $this->getContext())==false)
            return false;
        $result = $this->engine->getTransitionEngine()->makeTransition(
            $this->getOldEntity()['state'],
            $this->getNewState(), $this->getContext());
        return $result;

    }


} 