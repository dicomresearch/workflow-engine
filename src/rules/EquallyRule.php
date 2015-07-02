<?php


namespace dicom\workflow\rules;

use dicom\workflow\rules\error\EquallyRuleExecutionError;
use dicom\workflow\rules\RuleInterface\IConfiguredRule;

class EquallyRule extends RuleCheckingOneValue implements  IConfiguredRule
{
    use ConfiguredRule{
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
        return EquallyRuleExecutionError::create($value, $this->getConfig());
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

        throw $this->createConfigurationException('config for must be a numeric', $config);
    }

}