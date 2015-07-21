<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 08.07.15
 * Time: 11:33
 */

namespace dicom\workflow\context\resource;


use dicom\workflow\context\resource\exception\ResourceFactoryException;
use dicom\workflow\rules\creation\RulesFactory;

class ResourceFactory
{
    public static function create($name, $definition)
    {

        if (array_key_exists('context', $definition)) {
            $resource = static::createCompositeResource($name, $definition);
        } else {
            $resource = static::createLeafProperty($name, $definition);
        }

        return $resource;
    }

    /**
     * Создать Resource содержащее правила
     *
     * @param $name
     * @param $rules
     * @return Resource
     */
    protected static function createLeafProperty($name, $rules)
    {
        $resource = new Resource($name);
        $resource->setRules(RulesFactory::createBatchByShortNames($rules));

        return $resource;
    }

    /**
     * Создать Resource содержащее другие Resource
     *
     * @param $contextName
     * @param $definitions
     * @return CompositeResource
     * @throws ResourceFactoryException
     */
    protected static function createCompositeResource($contextName, $definitions)
    {
        if (!array_key_exists('context', $definitions)) {
            throw ResourceFactoryException::CompositeResourceMustContainsSubResourceDefinitions($contextName, $definitions);
        }

        $resource = new CompositeResource($contextName);
        foreach ($definitions['context'] as $contextName => $contextDefinition) {
            $subResource = ResourceFactory::create($contextName, $contextDefinition);
            $resource->addResource($subResource);
        }

        return $resource;
    }
}