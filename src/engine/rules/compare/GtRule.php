<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.12.14
 * Time: 15:34
 */

namespace dicom\workflow\engine\rules\compare;

use dicom\workflow\engine\rules\error\GtRuleExecutionError;
use dicom\workflow\engine\rules\RuleCheckingOneValue;
use dicom\workflow\building\rules\RuleInterface\IConfiguredRule;
use dicom\workflow\engine\rules\ConfiguredRule;

/**
 * Class GtRule
 *
 * Проверяет что новое значение сущности больше опредленного значения, заданого в конфиге Workflow
 *
 * @package dicom\workflow\rules\compare
 */
class GtRule extends RuleCheckingOneValue implements IConfiguredRule
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
        return $entityNewValue > $this->getConfiguredValue();
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
        return GtRuleExecutionError::create($value, $this->getConfig());
    }


    protected function validateConfig($config)
    {
        if (! is_numeric($config)) {
            throw $this->createConfigurationException('config for must be a numeric', $config);
        }
    }
}
