<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 07.10.14
 * Time: 16:14
 */

namespace dicom\workflow\transition;

use dicom\workflow\entity\Entity;
use dicom\workflow\entity\property\PropertyFactory;
use dicom\workflow\rules\creation\RulesFactory;
use dicom\workflow\transition\exceptions\TransitionSpecificationNotValid;
use dicom\workflow\WorkflowEngine;

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
        $this->addPropertiesToTransitionSpecification($this->getTransitionDescription());

        return $this->getTransitionSpecification();
    }

    /**
     * parse and add rules to transition specification
     *
     * @param array $transitionDescription
     */
    protected function addRulesToTransitionSpecification($transitionDescription)
    {
        if (array_key_exists('rules', $transitionDescription)) {
            $rules = RulesFactory::createBatchByShortNames($transitionDescription['rules']);
            $this->getTransitionSpecification()->setRules($rules);
        }
    }

    /**
     * parse and add properties to transition specification
     *
     * @param array $transitionDescription
     */
    protected function addPropertiesToTransitionSpecification($transitionDescription)
    {
        if (array_key_exists('properties', $transitionDescription)) {
            $entity = new Entity();
            foreach ($transitionDescription['properties'] as $propertyName => $rules) {
                $entity->addProperty(PropertyFactory::create($propertyName, $rules));
                $this->getTransitionSpecification()->setEntity($entity);
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



} 