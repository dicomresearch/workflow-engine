<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.10.14
 * Time: 17:32
 */

namespace dicom\workflow\engine\exception;

class WorkflowEngineException extends \Exception
{
    public static function youTryUseNonExistingState($wrongState, $registeredStates)
    {
        return new static(sprintf(
            'You try use non existing state %s. Registered states: %s',
            $wrongState,
            var_export($registeredStates, true)
        ));
    }

    public static function cantFindTransitionSpecification($oldState, $newState, $allSpecifications)
    {
        return new static(sprintf(
            'Cant find transition specification from state "%s" to "%s" . Registered specifications: %s',
            $oldState,
            $newState,
            var_export($allSpecifications, true)
        ));
    }

    public static function cantFindTransitionSpecificationByName($transitionName, $allSpecifications)
    {
        return new static(sprintf(
            'Cant find transition specification: "%s" . Registered specifications: %s',
            $transitionName,
            var_export($allSpecifications, true)
        ));
    }

    public static function cantFindTransitionSpecifications($oldState, $allSpecifications)
    {
        return new static(sprintf(
            'Cant find transition specification from state "%s". Registered specifications: %s',
            $oldState,
            var_export($allSpecifications, true)
        ));
    }
}
