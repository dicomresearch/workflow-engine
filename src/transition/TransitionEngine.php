<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 08.10.14
 * Time: 12:13
 */

namespace dicom\workflow\transition;


use dicom\workflow\config\WorkflowDescription;
use dicom\workflow\exception\WorkflowEngineException;
use dicom\workflow\WorkflowEngine;

/**
 * Class TransitionEngine
 *
 * Движек, отвечающий за перемещение сущности
 *
 * @package dicom\workflow\transition
 */
class TransitionEngine
{
    /**
     * @var TransitionSpecification[]
     */
    private $transitionsSpecifications;

    /**
     * @var WorkflowEngine
     */
    private $workflowEngine;

    /**
     * Инстанцировать экземпляр TransitionEngine
     *
     * @param WorkflowDescription $workflowDescription описание конкретного воркфлоу
     * @param WorkflowEngine $workflowEngine
     */
    public function __construct(WorkflowDescription $workflowDescription, WorkflowEngine $workflowEngine)
    {
        $this->setWorkflowEngine($workflowEngine);
        $this->createTransitionSpecifications($workflowDescription);

    }


    /**
     * @param WorkflowDescription $workflowDescription
     * @return array|TransitionSpecification[]
     */
    protected function createTransitionSpecifications(WorkflowDescription $workflowDescription)
    {
        $this->transitionsSpecifications = [];

        foreach ($workflowDescription->getTransitionSpecifications() as $transitionSpecification) {
            $transitionSpecification = TransitionSpecificationFactory::create($transitionSpecification, $this->getWorkflowEngine());
            $this->transitionsSpecifications[$transitionSpecification->getName()] = $transitionSpecification;
        }

        return $this->transitionsSpecifications;
    }

    /**
     * Разрешено ли правилами перемещать сущность из статуса oldStateName в newStateName
     *
     * @param string $oldStateName название статуса, в котором сейчас находится сущность
     * @param string $newStateName название статуса, в который заявка хочет переместится
     * @param array $newEntityValues key=>value, where key - property name of entity, value - property value of new entity
     * @param array $oldEntityValues key=>value, where key - property name of entity, value - property value of old entity
     * @return Transition
     */
    public function makeTransition($oldStateName, $newStateName, $newEntityValues, $oldEntityValues)
    {
        $transitionSpecification = $this->getTransitionSpecification($oldStateName, $newStateName);
        return $transitionSpecification->makeTransition($newEntityValues, $oldEntityValues);
    }

    /**
     * Получить набор доступных перемещений для сущности из статуса oldState
     *
     * @param string $oldStateName название статуса, в котором сейчас находится сущность
     * @param $entityValues
     *
     * @return TransitionSpecification
     */
    public function getAvailableStates($oldStateName, $entityValues)
    {
        /**
         * @var TransitionSpecification[] $foundedTransitionSpecifications
         */
        $foundedTransitionSpecifications = [];
        foreach ($this->getTransitionsSpecifications() as $transition) {
            if ($transition->getOldState()->getName() === $oldStateName) {
                $foundedTransitionSpecifications[] = $transition;
            }
        }

        if (is_null($foundedTransitionSpecifications)) {
            return [];
        }

        $satisfiedTransitionSpecifications = [];
        foreach ($foundedTransitionSpecifications as $transition) {
            if ($transition->executeTransitionRules($entityValues)->isSuccess()) {
                $satisfiedTransitionSpecifications[] = $transition;
            }
        }

        return $satisfiedTransitionSpecifications;
    }

    /**
     * Получает Transition Specification для перемещения сущности из oldState в newState
     *
     * @param string $oldStateName
     * @param string $newStateName
     * @return null|TransitionSpecification
     */
    public function getTransitionSpecification($oldStateName, $newStateName)
    {
        $foundedTransitionSpecification = null;
        foreach ($this->transitionsSpecifications as $transition) {
            if ($transition->getOldState()->getName() === $oldStateName && $transition->getNewState()->getName() === $newStateName) {
                $foundedTransitionSpecification = $transition;
            }
        }

        if (is_null($foundedTransitionSpecification)) {
            throw WorkflowEngineException::cantFindTransitionSpecification($oldStateName, $newStateName, array_keys($this->getTransitionsSpecifications()));
        }

        return $foundedTransitionSpecification;
    }

    /**
     * Зарегистрировано ли перемещение с таким именем?
     *
     * @param string $transitionName
     * @return bool
     */
    public function hasTransitionSpecification($transitionName)
    {
        return array_key_exists($transitionName, $this->transitionsSpecifications);
    }

    /**
     * @return TransitionSpecification[]
     */
    public function getTransitionsSpecifications()
    {
        return $this->transitionsSpecifications;
    }

    /**
     * @return WorkflowEngine
     */
    public function getWorkflowEngine()
    {
        return $this->workflowEngine;
    }

    /**
     * @param WorkflowEngine $workflowEngine
     */
    protected function setWorkflowEngine($workflowEngine)
    {
        $this->workflowEngine = $workflowEngine;
    }


} 