<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 08.07.15
 * Time: 11:25
 */

namespace dicom\workflow\engine\context;

use dicom\workflow\engine\context\executionResult\ContextExecutionResult;
use dicom\workflow\engine\context\resource\executionResult\ResourceExecutionResult;
use dicom\workflow\engine\context\resource\Resource;

class Context
{
    /**
     * @var Resource[]
     */
    protected $resources;

    /**
     * @param Resource $resource
     */
    public function addResources(Resource $resource)
    {
        $this->resources[$resource->getName()] = $resource;
    }

    /**
     * @param string $resourceName
     */
    public function removeResource($resourceName)
    {
        if (!array_key_exists($resourceName, $this->resources)) {
            return;
        }

        unset($this->resources[$resourceName]);
    }

    /**
     * @return Resource
     */
    public function getResources()
    {
        return $this->resources;
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
        foreach ($this->getResources() as $resourceName => $resource) {
            if (!array_key_exists($resourceName, $context)) {
                $context[$resourceName] = null;
            }

            $resourceExecutionResult = $resource->executeRules($context[$resourceName]);
            $contextExecutionResult->addResourceExecutionResult($resourceExecutionResult);
        }

        return $contextExecutionResult;
    }
}
