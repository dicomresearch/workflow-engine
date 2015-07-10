<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 02.02.15
 * Time: 14:00
 */

namespace dicom\workflow\context\executionResult;

use dicom\workflow\context\Context;
use dicom\workflow\context\resource\executionResult\ResourceExecutionResult;

class ContextExecutionResult
{
    /**
     * @var Context
     */
    private $context;

    /**
     * @var ResourceExecutionResult[]
     */
    private $resourceExecutionResult;

    public function __construct(Context $context)
    {
        $this->setContext($context);
    }

    /**
     * does resource rules execute success?
     *
     * @return bool
     */
    public function isSuccess()
    {
        foreach ($this->getResourceExecutionResult() as $resourceResult) {
            if (! $resourceResult->isSuccess()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get errors for rules execution
     *
     * @return array of key => value, where key = resource name, value - array of errors
     */
    public function getErrors()
    {
        $errors = [];
        foreach ($this->getResourceExecutionResult() as $resourceExecutionResult) {
            if (0 !== count($resourceExecutionResult->getErrors())) {
                $errors = array_merge($errors, $resourceExecutionResult->getErrors());
            }
        }
        return $errors;
    }

    /**
     * @return Context
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param Context $context
     */
    public function setContext(Context $context)
    {
        $this->context = $context;
    }

    /**
     * @return ResourceExecutionResult[]
     */
    public function getResourceExecutionResult()
    {
        return $this->resourceExecutionResult;
    }

    /**
     * @param ResourceExecutionResult $resourceExecutionResult
     */
    public function addResourceExecutionResult(ResourceExecutionResult $resourceExecutionResult)
    {
        $this->resourceExecutionResult[$resourceExecutionResult->getName()] = $resourceExecutionResult;
    }

}