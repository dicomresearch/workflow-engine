<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 02.02.15
 * Time: 13:52
 */

namespace dicom\workflow\context\resource\executionResult;


class CompositeResourceExecutionResult extends ResourceExecutionResult
{
    /**
     * @var ResourceExecutionResult[]
     */
    private $subResources = [];

    public function addSubResourceResult(ResourceExecutionResult $resourceExecutionResult)
    {
        $this->subResources[$resourceExecutionResult->getName()] = $resourceExecutionResult;
    }

    /**
     * @return ResourceExecutionResult[]
     */
    public function getSubResources()
    {
        return $this->subResources;
    }

    public function isSuccess()
    {
        foreach ($this->getSubResources() as $subResourceExecutionResult) {
            if (! $subResourceExecutionResult->isSuccess()) {
                return false;
            }
        }

        return true;
    }

    public function getErrors()
    {
        $errors = [];
        foreach ($this->getSubResources() as $subResourceExecutionResult) {
            $errors = array_merge($errors, $subResourceExecutionResult->getErrors());
        }

        return $errors;

    }


}