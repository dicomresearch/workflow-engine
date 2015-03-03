<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 26.01.15
 * Time: 21:11
 */

namespace workflow\rules\adapter;


use workflow\rules\adapter\exception\RuleAdapterException;
use workflow\rules\executionResult\RuleExecutionResult;
use workflow\rules\RuleInterface\IRule;
use workflow\rules\RuleInterface\IRuleCheckingPropertyValue;
use workflow\rules\RuleInterface\IRuleCheckingWithoutArguments;
use workflow\rules\RuleInterface\IRuleCompareTwoValueInterface;

/**
 * Class Adapter
 *
 * It allows use different Rule interfaces identically
 *
 * @package workflow\rules\adapter
 */
class RuleAdapter
{
    /**
     * @var IRule
     */
    private $rule;

    /**
     * Create adapter for rule
     *
     * @param IRule $rule
     */
    public function __construct(IRule $rule)
    {
        $this->setRule($rule);
    }

    /**
     * Check the rule
     *
     * @param null|mixed $entityNewValue
     * @param null|mixed $entityOldValue
     *
     * @return RuleExecutionResult
     * @throws RuleAdapterException
     */
    public function execute($entityNewValue = null, $entityOldValue = null)
    {

        switch (true) {
            case ($this->getRule() instanceof IRuleCheckingWithoutArguments):
                $result = $this->getRule()->execute();
                break;
            case ($this->getRule() instanceof IRuleCheckingPropertyValue):
                $result = $this->getRule()->execute($entityNewValue);
                break;
            case ($this->getRule() instanceof IRuleCompareTwoValueInterface):
                $result = $this->getRule()->execute($entityNewValue, $entityOldValue);
                break;
            default :
                throw RuleAdapterException::cantAdaptRule($this->getRule()->getName());
        }

        return $result;

    }


    /**
     * @return IRule|IRuleCheckingWithoutArguments|IRuleCheckingPropertyValue|IRuleCompareTwoValueInterface
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * @param IRule $rule
     */
    public function setRule($rule)
    {
        $this->rule = $rule;
    }


}