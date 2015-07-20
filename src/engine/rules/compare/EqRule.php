<?php


namespace dicom\workflow\engine\rules\compare;

use dicom\workflow\engine\rules\ConfiguredRule;
use dicom\workflow\engine\rules\error\EqRuleExecutionError;
use dicom\workflow\engine\rules\RuleCheckingOneValue;
use dicom\workflow\building\rules\RuleInterface\IConfiguredRule;

/**
 * Class EqRule
 * @package dicom\workflow\rules\compare
 */
class EqRule extends RuleCheckingOneValue implements IConfiguredRule
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
        $expectedValue = $this->getConfiguredValue();


        return $entityNewValue === $expectedValue;
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
        return EqRuleExecutionError::create($value, $this->getConfig());
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
