<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 08.07.15
 * Time: 11:25
 */

namespace dicom\workflow\context;

use dicom\workflow\context\executionResult\ContextExecutionResult;
use dicom\workflow\context\resource\Resource;

class Context
{
    /**
     * @var Resource
     */
    protected $resource;

    /**
     * @param Resource $resource
     */
    public function addResource(Resource $resource)
    {
        $this->resource[$resource->getName()] = $resource;
    }

    /**
     * @param string $resourceName
     */
    public function removeResource($resourceName)
    {
        if (!array_key_exists($resourceName, $this->resource)) {
            return;
        }

        unset($this->resource[$resourceName]);
    }

    /**
     * @return Resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Проверяет что все параметры удовлетвоярют своим инвариантам
     *
     * @param array $context
     * @return ContextExecutionResult
     */
    public function executeRules(array $context = [])
    {
        $contextExecutionResult = new ContextExecutionResult($this);
        foreach ($this->getResource() as $resourceName => $resource) {
            if (!array_key_exists($resourceName, $context)) {
                $context[$resourceName] = null;
            }

            $resourceExecutionResult = $resource->executeRules($context[$resourceName]);
            $contextExecutionResult->addResourceExecutionResult($resourceExecutionResult);
        }

        return $contextExecutionResult;
    }
}