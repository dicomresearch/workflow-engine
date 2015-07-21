<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 13.07.15
 * Time: 14:17
 */

namespace dicom\workflow\engine\rules\compare;

use dicom\workflow\building\rules\RuleInterface\IConfiguredRule;
use dicom\workflow\engine\rules\ConfiguredRule;
use dicom\workflow\engine\rules\RuleCheckingOneValue;
use dicom\workflow\engine\rules\error\NotEqRuleExecutionError;
use SebastianBergmann\Comparator\ComparisonFailure;
use SebastianBergmann\Comparator\Factory;

class NotEqRule extends RuleCheckingOneValue implements IConfiguredRule
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
            return false;
        } catch (ComparisonFailure $failure) {
            return true;
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
        return NotEqRuleExecutionError::create($value, $this->getConfig());
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