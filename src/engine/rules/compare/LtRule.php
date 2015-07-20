<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 01.07.15
 * Time: 17:48
 */

namespace dicom\workflow\engine\rules\compare;

use dicom\workflow\engine\rules\error\LtRuleExecutionError;
use dicom\workflow\engine\rules\RuleCheckingOneValue;
use dicom\workflow\building\rules\RuleInterface\IConfiguredRule;
use dicom\workflow\engine\rules\ConfiguredRule;

/**
 * Class LtRule
 * @package dicom\workflow\rules\compare
 */
class LtRule extends RuleCheckingOneValue implements IConfiguredRule
{
    use ConfiguredRule {
        ConfiguredRule::validateConfig as configuratorValidateConfig;
    }

    /**
     * Проверить удовлятеворяют ли переданые значения правилу
     *
     * @param null|mixed $entityNewValue

     * @return mixed
     */
    protected function isValid($entityNewValue = null)
    {
        return $entityNewValue < $this->getConfiguredValue();
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
        $e = new LtRuleExecutionError($this->getConfiguredValue(), $value);
        return $e;
    }


    protected function validateConfig($config)
    {
        if ($this->configuratorValidateConfig($config)) {
            return true;
        }

        if (is_numeric($config)) {
            return true;
        }

        if (is_string($config)) {
            return true;
        }

        if (is_array($config)) {
            return true;
        }

        throw $this->createConfigurationException('config for must be a numeric', $config);
    }
}
