<?php

namespace dicom\workflow;

use dicom\workflow\building\config\WorkflowDescription;
use dicom\workflow\engine\state\State;
use dicom\workflow\engine\state\StateEngine;
use dicom\workflow\engine\transition\Transition;
use dicom\workflow\engine\transition\TransitionEngine;
use dicom\workflow\engine\transition\TransitionSpecification;

/**
 * Class WorkflowEngine
 *
 * Вхоная точка для Workflow
 *
 * @package workflow
 */
class WorkflowEngine
{
    /**
     * Описание конкретных правил для workflow
     *
     * @var WorkflowDescription
     */
    private $workflowDescription;

    /**
     * @var TransitionEngine
     */
    private $transitionEngine;

    /**
     * @var StateEngine
     */
    private $stateEngine;


    /**
     * Инициализировать WorkflowEngine
     *
     * @param WorkflowDescription $wfDesc
     */
    public function __construct(WorkflowDescription $wfDesc)
    {
        $this->setWorkflowDescription($wfDesc);
        $this->setStateEngine(new StateEngine($this->getWorkflowDescription()));
        $this->setTransitionEngine(new TransitionEngine($this->getWorkflowDescription(), $this));
    }

    /**
     * Делает переход сущности из одного состояния в другое.
     *
     * При этом создается объект, отражающий результат перемещения, из которого можно узнать
     * * удачной ли была попытка перемещения
     * * какие ошибки произошли в процессе перемещения
     * * какие действия необходимо выполнить клиентскому коду?
     *
     * @param string $oldStateName Entity old state name
     * @param string $newStateName Entity target state name
     * @param array $newEntityValues key-value array, where key - entity attribute name, value - its value
     * @param array $oldEntityValues key-value array, where key - entity attribute name, value - its value
     * @return Transition
     */
    public function makeTransition($oldStateName, $newStateName, $newEntityValues, $oldEntityValues)
    {
        return $this->getTransitionEngine()->makeTransition(
            $oldStateName,
            $newStateName,
            $newEntityValues,
            $oldEntityValues
        );
    }

    /**
     * Получить список состояний, куда можно перевести сущность
     *
     * @param string $oldStateName
     * @param array $entityValues
     * @return TransitionSpecification[]
     */
    public function getAvailableStates($oldStateName, $entityValues)
    {
        return $this->getTransitionEngine()->getAvailableStates($oldStateName, $entityValues);
    }

    /**
     * Получить список действий, которые надо совершить пользовательскому коду, при переходе из статуса в статус
     *
     * @param $oldStateName
     * @param $newStateName
     *
     * @return array
     */
    public function getActions($oldStateName, $newStateName)
    {
        return $this->getTransitionEngine()->getTransitionSpecification($oldStateName, $newStateName)->getActions();
    }

    /**
     * Отдать список возможных состояния
     *
     * @return \dicom\workflow\engine\state\State[]
     */
    public function getStateList()
    {
        return $this->stateEngine->getStateList();
    }

    /**
     * Get the state by name
     *
     * @param string $name
     * @return State
     */
    public function getState($name)
    {
        return $this->stateEngine->getState($name);
    }


    /**
     * @return WorkflowDescription
     */
    public function getWorkflowDescription()
    {
        return $this->workflowDescription;
    }

    /**
     * @param WorkflowDescription $workflowDescription
     */
    public function setWorkflowDescription($workflowDescription)
    {
        $this->workflowDescription = $workflowDescription;
    }

    /**
     * @return TransitionEngine
     */
    public function getTransitionEngine()
    {
        return $this->transitionEngine;
    }

    /**
     * @param TransitionEngine $transitionEngine
     */
    public function setTransitionEngine($transitionEngine)
    {
        $this->transitionEngine = $transitionEngine;
    }

    /**
     * @return StateEngine
     */
    public function getStateEngine()
    {
        return $this->stateEngine;
    }

    /**
     * @param StateEngine $stateEngine
     */
    public function setStateEngine($stateEngine)
    {
        $this->stateEngine = $stateEngine;
    }

    /**
     * Получить список свойств, определенных для статуса
     *
     * @param string $stateName
     * @return mixed
     */
    public function getStatePropertiesRules($stateName)
    {
        return $this->stateEngine->getStatePropertiesRules($stateName);
    }

    /**
     * Получаем список свойств при переходе между статусами
     *
     * @param $oldStateName
     * @param $newStateName
     *
     * @return array
     */
    public function getTransitionProperties($oldStateName, $newStateName)
    {
        return $this->getTransitionEngine()->getTransitionSpecification($oldStateName, $newStateName)->getProperties();
    }

    /**
     * Получить список свойств из state и transition
     *
     * @param string $oldStateName
     * @param string $newStateName
     * @return mixed
     */
    public function getPropertiesRules($oldStateName, $newStateName)
    {
        $stateProperty = $this->getStatePropertiesRules($newStateName);
        $transition = $this->getTransitionEngine()->getTransitionSpecification($oldStateName, $newStateName);
        $transitionProperty = $this->getTransitionEngine()->getTransitionPropertiesRules($transition);

        $result = array_merge($stateProperty, $transitionProperty);

        return $result;
    }
}
