<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.10.14
 * Time: 16:15
 */

namespace dicom\workflow\config;


use dicom\workflow\config\exception\WorkflowConfigurationException;

class WorkflowDescription
{
    protected $states = [];

    protected $transitionSpecifications = [];

    const STATES = 'states';

    const TRANSITIONS = 'transitions';

    /**
     *
     *
     * @param string|array $workflowDescription json string or array
     */
    public function __construct($workflowDescription)
    {
        if (is_null($workflowDescription)) {
            throw WorkflowConfigurationException::ConfigIsNull();
        }

        if (is_string($workflowDescription)) {
            $workflowDescription = $this->decodeJsonConfig($workflowDescription);
        }

        if (!array_key_exists(static::STATES, $workflowDescription)) {
            throw WorkflowConfigurationException::mustContainsStates();
        }

        if (!array_key_exists(static::TRANSITIONS, $workflowDescription)) {
            throw WorkflowConfigurationException::mustContainsTransitions();
        }

        $this->setStates($workflowDescription[static::STATES]);
        $this->setTransitionSpecifications($workflowDescription[static::TRANSITIONS]);
    }

    /**
     * Decode json workflow rules. Return a array
     *
     * @param $jsonConfig
     * @return array
     */
    private function decodeJsonConfig($jsonConfig)
    {
        $workflowDescription = json_decode($jsonConfig, true);

        if (json_last_error()) {
            throw WorkflowConfigurationException::JsonNotParsed(json_last_error_msg());
        }

        return $workflowDescription;
    }

    /**
     * @return array
     */
    public function getStatesDescription()
    {
        return $this->states;
    }

    /**
     * @param array $states
     */
    public function setStates($states)
    {
        $this->states = $states;
    }

    /**
     * @return array
     */
    public function getTransitionSpecifications()
    {
        return $this->transitionSpecifications;
    }

    /**
     * @param array $transitionSpecifications
     */
    public function setTransitionSpecifications($transitionSpecifications)
    {
        $this->transitionSpecifications = $transitionSpecifications;
    }


} 