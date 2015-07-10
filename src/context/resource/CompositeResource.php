<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 08.07.15
 * Time: 13:51
 */

namespace dicom\workflow\context\resource;


use dicom\workflow\context\resource\executionResult\CompositeResourceExecutionResult;

class CompositeResource extends Resource
{
    /**
     * @var Resource []
     */
    protected $resource = [];

    /**
     * проверяет, что все правила данного свойства удовлетворены
     *
     * @param null|mixed $contextValue новое значение аттрибута (например перед сохранением в базу данных)
     *
     * @return CompositeResourceExecutionResult
     */
    public function executeRules($contextValue = null)
    {
        $resourceExecutionResult = new CompositeResourceExecutionResult($this);

        foreach ($this->resource as $subResource) {
            $subResourceExecutionResult = $subResource->executeRules(
                (isset ($contextValue[$subResource->getName()]) ? $contextValue[$subResource->getName()] : null)
            );

            $resourceExecutionResult->addSubPropertyResult($subResourceExecutionResult);
        }

        return $resourceExecutionResult;
    }

    /**
     * app sub resource
     *
     * @param Resource $resource
     */
    public function addProperty(Resource $resource)
    {
        $this->$resource[$resource->getName()] = $resource;
    }

    /**
     * Get list of resource
     *
     * @return Resource[]
     */
    public function getResource()
    {
        return $this->resource;
    }
}