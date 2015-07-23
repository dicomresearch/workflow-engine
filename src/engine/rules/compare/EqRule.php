<?php


namespace dicom\workflow\engine\rules\compare;

use dicom\workflow\engine\rules\ConfiguredRule;
use dicom\workflow\engine\rules\error\EqRuleExecutionError;
use dicom\workflow\engine\rules\RuleCheckingOneValue;
use dicom\workflow\building\rules\RuleInterface\IConfiguredRule;
use SebastianBergmann\Comparator\ComparisonFailure;
use SebastianBergmann\Comparator\Factory;

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

        $factory = new Factory();
        $comparator = $factory->getComparatorFor($expectedValue, $entityNewValue);

        try {
            $comparator->assertEquals($expectedValue, $entityNewValue);
            return true;
        } catch (ComparisonFailure $failure) {
            return false;
        }
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

        if ($config instanceof \DateTime) {
            return true;
        }

        if (is_object($config)) {
            return true;
        }

        throw $this->createConfigurationException(
            'config for must be a numeric, string, array, DateTime or object',
            $config
        );
    }
}
