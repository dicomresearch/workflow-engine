<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 08.07.15
 * Time: 13:25
 */

namespace dicom\workflow\context;


use dicom\workflow\context\exception\ContextFactoryException;
use dicom\workflow\context\resource\ResourceFactory;

class ContextFactory
{
    public static function createBasedOnDescription($contextDescription)
    {
        $context = new Context();

        if (!array_key_exists('context', $contextDescription)) {
            throw ContextFactoryException::descriptionMustContainsContext();
        }

        foreach ($contextDescription['context'] as $contextName => $rules) {
            $context->addResource(ResourceFactory::create($contextName, $rules));
        }

        return $context;
    }
}