<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 30.01.15
 * Time: 11:42
 */

namespace workflow\transition;


use workflow\rules\exception\RuleExecutionException;
use workflow\rules\executionResult\RuleExecutionResult;
use workflow\state\executionResult\StateExecutionResult;

/**
 * Class Transition
 *
 * Отражает состояние конеретного перехода. Успешен ли переход, какие ошибки?
 *
 * @package workflow\transition
 */
class Transition
{
    /**
     *
     * @var TransitionSpecification
     */
    private $transitionSpecification;

    /**
     * @var RuleExecutionResult[]
     */
    protected $transitionRulesExecutionResult = [];

    /**
     * @var StateExecutionResult
     */
    protected $stateRuleExecutionResult;

    /**
     * Добавить результат выполнения правила перехода
     *
     * @param RuleExecutionResult $ruleExecutionResult
     */
    public function addTransitionRuleExecutionResult(RuleExecutionResult $ruleExecutionResult)
    {
        $this->transitionRulesExecutionResult[] = $ruleExecutionResult;
    }

    /**
     * @return RuleExecutionResult[]
     */
    public function getTransitionRulesExecutionResult()
    {
        return $this->transitionRulesExecutionResult;
    }

    /**
     * @param StateExecutionResult $stateExecutionResult
     */
    public function setStateRulesExecutionResult(StateExecutionResult $stateExecutionResult)
    {
        $this->stateRuleExecutionResult = $stateExecutionResult;
    }

    /**
     * @return StateExecutionResult
     */
    public function getStateRuleExecutionResult()
    {
        return $this->stateRuleExecutionResult;
    }

    /**
     * @return TransitionSpecification
     */
    public function getTransitionSpecification()
    {
        return $this->transitionSpecification;
    }

    /**
     * @param TransitionSpecification $transitionSpecification
     */
    public function setTransitionSpecification($transitionSpecification)
    {
        $this->transitionSpecification = $transitionSpecification;
    }

    /**
     * Все правила успешно выполнены?
     *
     * @return bool
     */
    public function isSuccess()
    {
        if (null !== $this->getStateRuleExecutionResult() && ! $this->getStateRuleExecutionResult()->isSuccess()) {
            return false;
        }

        foreach ($this->getTransitionRulesExecutionResult() as $ruleResult) {
            if (!$ruleResult->isSuccess()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Получить список ошибок, которые возникли в результате перемещения сущности
     *
     * @return RuleExecutionException[]
     */
    public function getErrors()
    {
        $errors = [];
        if (null !== $this->getStateRuleExecutionResult()) {
            $errors = $this->getStateRuleExecutionResult()->getErrors();
        }


        foreach ($this->getTransitionRulesExecutionResult() as $ruleResult) {
            if (null !== $ruleResult->getError()) {
                $errors[] = $ruleResult->getError();
            }
        }

        return $errors;
    }

    /**
     * Get actions for clients code
     *
     * @return array
     */
    public function getActions()
    {
        return $this->getTransitionSpecification()->getActions();
    }


}