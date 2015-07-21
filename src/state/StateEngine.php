<?php

namespace dicom\workflow\state;


use dicom\workflow\config\WorkflowDescription;
use dicom\workflow\exception\WorkflowEngineException;
use dicom\workflow\factory\StateFactory;
use dicom\workflow\visitor\factory\GettingInsideVisitorFactory;
use dicom\workflow\visitor\state\entity\property\rule\GetNameRuleVisitor;

/**
 * Class StateEngine
 *
 * Движек отвечающйи за состояние сущности
 *
 * @package dicom\workflow\state
 */
class StateEngine
{
    /**
     * @var State[]
     */
    private $states;

    /**
     * @var WorkflowDescription
     */
    private $workflowDescription;

    public function __construct(WorkflowDescription $workflowDescription)
    {
        $this->setWorkflowDescription($workflowDescription);
        $this->createStates();
    }

    /**
     * Получить список состояний, зарегистрированных в системе
     *
     * @return \dicom\workflow\state\State[]
     */
    public function getStateList()
    {
        return $this->states;
    }

    /**
     * Создает объектную структуру по описанию Workflow
     *
     * @return State[]
     */
    protected function createStates()
    {
        $this->states = [];
        foreach ($this->getWorkflowDescription()->getStatesDescription() as $stateName => $stateDesc) {
            $this->states[$stateName] = StateFactory::create($stateName, $stateDesc);
        }

        return $this->states;
    }

    /**
     * проверяет соотвествует ли сущность инвариантам состояния
     *
     * @param string $stateName название состояние, для которого будут проверятся инварианты
     * @param array $newEntityValues key->value набор аттрибутов, характеризующих новое состояния сущности
     * @param array $oldEntityValues key->value набор аттриутов, характеризующих предыдущее состояние сущноси
     * [
     *  'role' => 'admin';
     *  'currentUserId' => 1
     * ]
     * @param array $outErrors ошибки валидации сущностей. key => value, key - название аттрибута, value - список ошибок валидации
     * @return bool
     */
    public function isEntityValidForState($stateName, $newEntityValues, $oldEntityValues, &$outErrors = [])
    {
        $state = $this->getState($stateName);
        return $state->executeRules($newEntityValues, $oldEntityValues, $outErrors);
    }



    /**
     * get registered state or throw exception else
     *
     * @param string $name
     * @return State
     */
    public function getState($name)
    {
        if (!array_key_exists($name, $this->states)) {
            throw WorkflowEngineException::youTryUseNonExistingState($name, array_keys($this->states));
        }

        return $this->states[$name];
    }

    public function getStatePropertiesRules($stateName)
    {
        $state = $this->getState($stateName);

        $factory = new GettingInsideVisitorFactory(new GetNameRuleVisitor());
        $configuredStateVisitor = $factory->createStateVisitor();
        return $configuredStateVisitor->visit($state);
    }

    /**
     * @return mixed
     */
    public function getWorkflowDescription()
    {
        return $this->workflowDescription;
    }

    /**
     * @param mixed $workflowDescription
     */
    public function setWorkflowDescription($workflowDescription)
    {
        $this->workflowDescription = $workflowDescription;
    }

    /**
     * Получить пользовательские экшны которые должны выполнится после того заявка перешла в $stateName
     *
     * @param $stateName
     * @return array
     */
    public function getStateActions($stateName)
    {
        return $this->getState($stateName)->getActions();
    }
} 