<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.12.14
 * Time: 15:34
 */

namespace dicom\workflow\rules;


use dicom\workflow\rules\error\GreaterThanRuleExecutionError;
use dicom\workflow\rules\exception\RuleConfigurationException;
use dicom\workflow\rules\error\RuleExecutionError;
use dicom\workflow\rules\executionResult\RuleExecutionResult;
use dicom\workflow\rules\RuleInterface\IConfiguredRule;
use dicom\workflow\rules\RuleInterface\IRuleCheckingOneValue;

/**
 * Class GreaterThan
 *
 * Проверяет что новое значение сущности больше опредленного значения, заданого в конфиге Workflow
 *
 * @package dicom\workflow\rules
 */
class GreaterThan extends RuleCheckingOneValue implements IRuleCheckingOneValue, IConfiguredRule
{
    use ConfiguredRule;

    /**
     * Проверить удовлятеворяют ли переданые значения правилу
     *
     * @param null|mixed $entityNewValue

     * @return mixed
     */
    protected function isValid($entityNewValue = null)
    {
        $entityNewValue = (int) $entityNewValue;
        return $entityNewValue > $this->getConfig();
    }

    /**
     * Создать Exception, описывающий ошибку проверки
     *
     * @param null $value
     *
     * @return mixed
     */
    protected function constructValidationError($value = null)
    {
        return GreaterThanRuleExecutionError::create($value);
    }


    protected function validateConfig($config)
    {
        if (! is_numeric($config)) {
            throw $this->createConfigurationException('config for must be a numeric', $config);
        }
    }

} 