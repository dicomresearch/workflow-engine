<?php


namespace dicom\workflow\engine\rules\compare;

use dicom\workflow\engine\rules\ConfiguredRule;
use dicom\workflow\engine\rules\error\LteRuleExecutionError;
use dicom\workflow\engine\rules\RuleCheckingOneValue;
use dicom\workflow\building\rules\RuleInterface\IConfiguredRule;

/**
 * Class GreaterThan
 *
 * Проверяет что новое значение сущности больше опредленного значения, заданого в конфиге Workflow
 *
 * @package dicom\workflow\rules\compare
 */
class LteRule extends RuleCheckingOneValue implements IConfiguredRule
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
        return $entityNewValue <= $this->getConfiguredValue();
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
        $e = new LteRuleExecutionError($this->getConfiguredValue(), $value);
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

        throw $this->createConfigurationException('config for must be a numeric or Expression', $config);
    }
}
