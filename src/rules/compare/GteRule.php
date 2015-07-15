<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.12.14
 * Time: 15:34
 */

namespace dicom\workflow\rules\compare;

use dicom\workflow\rules\ConfiguredRule;
use dicom\workflow\rules\error\GteRuleExecutionError;
use dicom\workflow\rules\RuleCheckingOneValue;
use dicom\workflow\rules\RuleInterface\IConfiguredRule;

/**
 * Class GteRule
 *
 * Проверяет что новое значение сущности больше или равно опредленного значения, заданого в конфиге Workflow
 *
 * @package dicom\workflow\rules\compare
 */
class GteRule extends RuleCheckingOneValue implements IConfiguredRule
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
        return $entityNewValue >= $this->getConfiguredValue();
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
        return GteRuleExecutionError::create($value, $this->getConfig());
    }


    protected function validateConfig($config)
    {
        if (! is_numeric($config)) {
            throw $this->createConfigurationException('config for must be a numeric', $config);
        }
    }

} 