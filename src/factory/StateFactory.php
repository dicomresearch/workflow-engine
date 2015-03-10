<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.10.14
 * Time: 16:14
 */

namespace dicom\workflow\factory;


use dicom\workflow\entity\EntityFactory;
use dicom\workflow\state\State;

class StateFactory
{
    /**
     * @param $stateName
     * @param $entityDescription
     * @return State
     */
    public static function create($stateName, $entityDescription)
    {
        $state = new State($stateName);
        $state->setEntity(EntityFactory::createBasedOnDescription($entityDescription));

        if (array_key_exists('actions', $entityDescription)) {
            $state->setActions($entityDescription['actions']);
        }

        return $state;
    }
} 