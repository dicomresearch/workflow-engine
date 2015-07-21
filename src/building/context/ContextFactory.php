<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 08.07.15
 * Time: 13:25
 */

namespace dicom\workflow\building\context;

use dicom\workflow\engine\context\Context;
use dicom\workflow\building\context\exception\ContextFactoryException;
use dicom\workflow\building\context\resource\ResourceFactory;

class ContextFactory
{
    public static function createBasedOnDescription($contextDescription)
    {
        $context = new Context();

        if (!array_key_exists('context', $contextDescription)) {
            throw ContextFactoryException::descriptionMustContainsContext();
        }

        foreach ($contextDescription['context'] as $contextName => $rules) {
            $context->addResources(ResourceFactory::create($contextName, $rules));
        }

        return $context;
    }
}
