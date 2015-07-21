<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 08.07.15
 * Time: 13:51
 */

namespace dicom\workflow\context\resource;


use dicom\workflow\context\resource\executionResult\CompositeResourceExecutionResult;

/**
 * Class CompositeResource
 *
 * Описывает свойство, представляющее из себя объект (context),
 * который в свою очередь содержит вложеные свойства
 *
 * @package dicom\workflow\context\resources
 */
class CompositeResource extends Resource
{
    /**
     * @var Resource []
     */
    protected $resources = [];

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

        foreach ($this->resources as $subResource) {
            $subResourceExecutionResult = $subResource->executeRules(
                (isset ($contextValue[$subResource->getName()]) ? $contextValue[$subResource->getName()] : null)
            );

            $resourceExecutionResult->addSubPropertyResult($subResourceExecutionResult);
        }

        return $resourceExecutionResult;
    }

    /**
     * app sub resources
     *
     * @param Resource $resource
     */
    public function addResource(Resource $resource)
    {
        $this->resources[$resource->getName()] = $resource;
    }

    /**
     * Get list of resources
     *
     * @return Resource[]
     */
    public function getResources()
    {
        return $this->resources;
    }
}