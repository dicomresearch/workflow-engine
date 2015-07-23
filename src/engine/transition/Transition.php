<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 30.01.15
 * Time: 11:42
 */

namespace dicom\workflow\engine\transition;

use dicom\workflow\engine\context\executionResult\ContextExecutionResult;
use dicom\workflow\engine\entity\executionResult\EntityExecutionResult;
use dicom\workflow\engine\rules\error\RuleExecutionError;
use dicom\workflow\engine\rules\executionResult\RuleExecutionResult;
use dicom\workflow\engine\state\executionResult\StateExecutionResult;

/**
 * Class Transition
 *
 * Отражает состояние конеретного перехода. Успешен ли переход, какие ошибки?
 *
 * @package dicom\workflow\transition
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
     * @var EntityExecutionResult
     */
    protected $entityRuleExecutionResult;

    /**
     * @var ContextExecutionResult
     */
    protected $contextRuleExecutionResult;

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
     * @param EntityExecutionResult $entityExecutionResult
     */
    public function setEntityRulesExecutionResult(EntityExecutionResult $entityExecutionResult)
    {
        $this->entityRuleExecutionResult = $entityExecutionResult;
    }

    /**
     * @return EntityExecutionResult
     */
    public function getEntityRuleExecutionResult()
    {
        return $this->entityRuleExecutionResult;
    }

    /**
     * @param ContextExecutionResult $contextRuleExecutionResult
     */
    public function setContextRuleExecutionResult(ContextExecutionResult $contextRuleExecutionResult)
    {
        $this->contextRuleExecutionResult = $contextRuleExecutionResult;
    }

    /**
     * @return ContextExecutionResult
     */
    public function getContextRuleExecutionResult()
    {
        return $this->contextRuleExecutionResult;
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

        if ($this->getEntityRuleExecutionResult() !== null && !$this->getEntityRuleExecutionResult()->isSuccess()) {
            return false;
        }

        if ($this->getContextRuleExecutionResult() !== null && !$this->getContextRuleExecutionResult()->isSuccess()) {
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
     * @return RuleExecutionError[]
     */
    public function getErrors()
    {
        $errors = [];
        if (null !== $this->getStateRuleExecutionResult()) {
            $errors = $this->getStateRuleExecutionResult()->getErrors();
        }

        if (null !== $this->getEntityRuleExecutionResult()) {
            $errors = array_merge_recursive($errors, $this->getEntityRuleExecutionResult()->getErrors());
        }

        if (null !== $this->getContextRuleExecutionResult()) {
            $errors = array_merge_recursive($errors, $this->getContextRuleExecutionResult()->getErrors());
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