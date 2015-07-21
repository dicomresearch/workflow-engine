<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 07.10.14
 * Time: 16:14
 */

namespace dicom\workflow\building\transition;

use dicom\workflow\building\context\resource\ResourceFactory;
use dicom\workflow\building\rules\creation\RulesFactory;
use dicom\workflow\engine\context\Context;
use dicom\workflow\engine\entity\Entity;
use dicom\workflow\building\entity\property\PropertyFactory;
use dicom\workflow\engine\transition\exceptions\TransitionSpecificationNotValid;
use dicom\workflow\WorkflowEngine;
use dicom\workflow\engine\transition\TransitionSpecification;

/**
 * Factory for Transition Specification.
 *
 * Create TransitionSpecification by transition description
 *
 * @package dicom\workflow\transition
 */
class TransitionSpecificationFactory
{
    private $transitionDescription;

    private $transitionSpecification;

    /**
     * @var WorkflowEngine
     */
    private $workflowEngine;

    public function __construct($transitionDescription, WorkflowEngine $workflowEngine)
    {
        $this->setWorkflowEngine($workflowEngine);
        $this->setTransitionDescription($transitionDescription);
    }

    /**
     * Build a Transition Specification
     *
     * @throws TransitionSpecificationNotValid
     */
    public function createTransitionSpecification()
    {
        $this->validateTransitionSpecificationDescription($this->getTransitionDescription());

        $oldState = $this->getWorkflowEngine()->getState($this->transitionDescription['oldState']);
        $newState = $this->getWorkflowEngine()->getState($this->transitionDescription['newState']);

        $this->setTransitionSpecification(new TransitionSpecification($newState, $oldState));

        $this->setActionName($this->getTransitionDescription());
        $this->addRulesToTransitionSpecification($this->getTransitionDescription());
        $this->addClientActionToTransitionSpecification($this->getTransitionDescription());
        $this->addEntityRulesToTransitionSpecification($this->getTransitionDescription());
        $this->addContextRulesToTransitionSpecification($this->getTransitionDescription());

        return $this->getTransitionSpecification();
    }

    /**
     * parse and add rules to transition specification
     *
     * @param array $transitionDescription
     */
    protected function addRulesToTransitionSpecification($transitionDescription)
    {
        if ($this->isSetRule($transitionDescription, 'other')) {
            $rules = RulesFactory::createBatchByShortNames($transitionDescription['rules']['other']);
            $this->getTransitionSpecification()->setRules($rules);
        }
    }

    /**
     * parse and add entity rules to transition specification
     *
     * @param array $transitionDescription
     */
    protected function addEntityRulesToTransitionSpecification($transitionDescription)
    {
        if ($this->isSetRule($transitionDescription, 'entity')) {
            $entity = new Entity();
            foreach ($transitionDescription['rules']['entity'] as $propertyName => $rules) {
                $entity->addProperty(PropertyFactory::create($propertyName, $rules));
                $this->getTransitionSpecification()->setEntity($entity);
            }
        }
    }

    /**
     * parse and add context rules to transition specification
     *
     * @param $transitionDescription
     */
    protected function addContextRulesToTransitionSpecification($transitionDescription)
    {
        if ($this->isSetRule($transitionDescription, 'context')) {
            $context = new Context();
            foreach ($transitionDescription['rules']['context'] as $contextName => $rules) {
                $context->addResources(ResourceFactory::create($contextName, $rules));
                $this->getTransitionSpecification()->setContext($context);
            }
        }
    }

    /**
     * @param $transitionDescription
     */
    protected function addClientActionToTransitionSpecification($transitionDescription)
    {
        if (array_key_exists('client', $transitionDescription)) {
            $this->getTransitionSpecification()->setClient($transitionDescription['client']);
        }
    }

    protected function setActionName(array $transitionDescription)
    {
        $this->getTransitionSpecification()->setActionName($transitionDescription['actionName']);
    }

    /**
     * Проверяет на формальную валидность описание спецификации перехода
     *
     * @param $attributes
     * @throws TransitionSpecificationNotValid
     */
    public function validateTransitionSpecificationDescription($attributes)
    {
        if (!array_key_exists('oldState', $attributes)) {
            throw TransitionSpecificationNotValid::paramNeed('oldState', $attributes);
        }

        if (!array_key_exists('newState', $attributes)) {
            throw TransitionSpecificationNotValid::paramNeed('newState', $attributes);
        }

        if (!array_key_exists('actionName', $attributes)) {
            throw TransitionSpecificationNotValid::paramNeed('actionName', $attributes);
        }
    }

    /**
     * description (array) of transition
     *
     * @return array
     */
    public function getTransitionDescription()
    {
        return $this->transitionDescription;
    }

    /**
     * description (array) of transition
     *
     * @param array $transitionDescription
     */
    public function setTransitionDescription($transitionDescription)
    {
        $this->transitionDescription = $transitionDescription;
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
     * Build a transition specification by transition description
     *
     * @param array $transitionDescription description of transition
     * @param WorkflowEngine $workflowEngine
     * @return TransitionSpecification
     */
    public static function create($transitionDescription, WorkflowEngine $workflowEngine)
    {
        $factory = new static($transitionDescription, $workflowEngine);
        $factory->createTransitionSpecification();


        return $factory->getTransitionSpecification();
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
    public function setWorkflowEngine($workflowEngine)
    {
        $this->workflowEngine = $workflowEngine;
    }

    /**
     * @param $transitionDescription
     * @param $ruleName
     *
     * @return bool
     */
    protected function isSetRule($transitionDescription, $ruleName)
    {
        if (!array_key_exists('rules', $transitionDescription)) {
            return false;
        }

        return  array_key_exists($ruleName, $transitionDescription['rules']);
    }
}
