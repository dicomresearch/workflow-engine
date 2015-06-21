<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 10/2/14
 * Time: 5:26 PM
 */

namespace dicom\workflow\rules;
use dicom\workflow\rules\exception\RuleExecutionException;

/**
 * Class RequiredAttribute
 *
 * Значение аттрибута должны быть обязательно задано для сущности
 *
 * @package modules\dicom\workflow\models
 */
class PropertyIsRequiredRule extends RuleCheckingOneValue
{


    protected function isValid($entityNewValue)
    {
        return !empty($entityNewValue);
    }


    protected function constructValidationException($entityNewValue)
    {
        $error =  new RuleExecutionException(
            sprintf(
                'Property is required: but given: %s',
                var_export($entityNewValue, true)
            )
        );

        $error->setHumanFriendlyMessage('Is required field');

        return $error;
    }
} 