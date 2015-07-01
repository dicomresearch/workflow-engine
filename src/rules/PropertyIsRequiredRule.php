<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 10/2/14
 * Time: 5:26 PM
 */

namespace dicom\workflow\rules;
use dicom\workflow\rules\error\IsRequiredRuleExecutionError;
use dicom\workflow\rules\error\RuleExecutionError;

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


    protected function constructValidationError($entityNewValue)
    {
        return IsRequiredRuleExecutionError::create($entityNewValue);
    }
} 