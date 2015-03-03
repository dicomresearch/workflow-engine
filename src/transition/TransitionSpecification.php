<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 07.10.14
 * Time: 15:06
 */

namespace workflow\transition;

use workflow\rules\adapter\RuleAdapter;
use workflow\rules\RuleInterface\IRule;
use workflow\state\State;
use workflow\visitor\VisitorInterface;

/**
 * Class TransitionSpecification
 *
 * Перемещение из одного состоянияч в другое
 *
 * @package workflow\transition
 */
class TransitionSpecification
{
    /**
     * old state of entity
     *
     * @var State
     */
    private $oldState;

    /**
     * new state of entity
     *
     * @var State
     */
    private $newState;

    /**
     * @var IRule
     */
    private $rules;

    /**
     * @var string
     */
    private $actionName;

    /**
     * Данные, необходимые клиенскому коду
     *
     * @var array;
     */
    private $client = [];


    /**
     * @param State $newState
     * @param State $oldState
     */
    public function __construct($newState, $oldState)
    {
        $this->setNewState($newState);
        $this->setOldState($oldState);
    }

    /**
     * Проверяет что все правила перехода соблюдены
     * и состояние сущности не противоречит правилам нового состояния
     *
     * @param array $newEntityValues
     * @param array $oldEntityValues
     *
     * @return Transition
     * @throws \workflow\rules\adapter\exception\RuleAdapterException
     */
    public function makeTransition($newEntityValues, $oldEntityValues)
    {
        $transition = $this->createTransition();
        $transition = $this->executeTransitionRules($newEntityValues, $oldEntityValues, $transition);
        $transition = $this->executeStateRules($newEntityValues, $oldEntityValues, $transition);

        return $transition;
    }

    /**
     * are Transition rules satisfied?
     *
     * @param $newEntityValues
     * @param $oldEntityValues
     * @param Transition $transition
     * @return Transition
     * @throws \workflow\rules\adapter\exception\RuleAdapterException
     */
    public function executeTransitionRules($newEntityValues, $oldEntityValues = null, Transition $transition = null)
    {
        $transition = null !== $transition ? $transition: $this->createTransition();
        $transition->setTransitionSpecification($this);

        foreach ($this->getRules() as $rule) {
            $adapter = new RuleAdapter($rule);
            $executionResult = $adapter->execute($newEntityValues, $oldEntityValues);
            $transition->addTransitionRuleExecutionResult($executionResult);
        }

        return $transition;
    }

    /**
     * Are state rules satisfied?
     *
     * @param $newEntityValues
     * @param $oldEntityValues
     * @param Transition $transition
     * @return Transition
     */
    public function executeStateRules($newEntityValues, $oldEntityValues, Transition $transition = null)
    {
        $transition = null !== $transition ? $transition: $this->createTransition();
        $stateExecutionResult = $this->getNewState()->executeRules($newEntityValues, $oldEntityValues);
        $transition->setStateRulesExecutionResult($stateExecutionResult);

        return $transition;

    }

    /**
     * get Transition specification name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getOldState()->getName() . ' to ' . $this->getNewState()->getName();
    }

    /**
     * Create Transition by this transition specification
     *
     * @return Transition
     */
    protected function createTransition()
    {
        $transition = new Transition();
        $transition->setTransitionSpecification($this);

        return $transition;
    }


    public function accept(VisitorInterface $visitor)
    {
        $visitor->visit($this);
    }

    /**
     * @return State
     */
    public function getNewState()
    {
        return $this->newState;
    }

    /**
     * @param State $newState
     */
    public function setNewState($newState)
    {
        $this->newState = $newState;
    }

    /**
     * @return State
     */
    public function getOldState()
    {
        return $this->oldState;
    }

    /**
     * @param State $oldState
     */
    public function setOldState($oldState)
    {
        $this->oldState = $oldState;
    }

    /**
     * @return IRule[]
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param string[] $value
     */
    public function setRules($value)
    {
        $this->rules = $value;
    }

    /**
     * @param string $value
     */
    public function addRule($value)
    {
        $this->rules[] = $value;
    }

    /**
     * @return string
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * @param string $actionName
     */
    public function setActionName($actionName)
    {
        $this->actionName = $actionName;
    }

    /**
     * @param string $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return bool
     */
    public function hasClientActions()
    {
        return array_key_exists('actions', $this->client);
    }

    /**
     * Get actions for transition and new state
     *
     * @return array
     */
    public function getActions()
    {
        $transitionActions = $this->getTransitionActions();
        $clientActions = $this->getStateActions();

        return array_merge_recursive($transitionActions, $clientActions);
    }


    /**
     * get actions for transition
     *
     * @return mixed
     */
    protected function getTransitionActions()
    {
        if (! $this->hasClientActions()) {
            return [];
        }

        return $this->client['actions'];
    }

    /**
     * Get actions for state
     *
     * @return array
     */
    protected function getStateActions()
    {
        return $this->getNewState()->getActions();
    }



}