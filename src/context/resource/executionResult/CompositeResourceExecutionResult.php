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
    private $subResource = [];

    public function addSubResourceResult(ResourceExecutionResult $resourceExecutionResult)
    {
        $this->subResource[$resourceExecutionResult->getName()] = $resourceExecutionResult;
    }

    /**
     * @return ResourceExecutionResult[]
     */
    public function getSubResource()
    {
        return $this->subResource;
    }

    public function isSuccess()
    {
        foreach ($this->getSubResource() as $subResourceExecutionResult) {
            if (! $subResourceExecutionResult->isSuccess()) {
                return false;
            }
        }

        return true;
    }

    public function getErrors()
    {
        $errors = [];
        foreach ($this->getSubResource() as $subResourceExecutionResult) {
            $errors = array_merge($errors , $subResourceExecutionResult->getErrors());
        }

        return $errors;

    }


}