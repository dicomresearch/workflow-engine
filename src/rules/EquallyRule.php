<?php


namespace dicom\workflow\rules;

use dicom\workflow\rules\exception\RuleExecutionError;
use dicom\workflow\rules\RuleInterface\IConfiguredRule;

class EquallyRule extends RuleCheckingOneValue implements  IConfiguredRule
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
        return $entityNewValue === $this->getConfig();
    }

    /**
     * Создать Exception, описывающий ошибку проверки
     *
     * @param null $value
     *
     * @return mixed
     */
    protected function constructValidationException($value = null)
    {
        return EquallyRuleExecutionError::create($value, $this->getConfig());
    }


    protected function validateConfig($config)
    {
        if (! is_numeric($config)) {
            throw $this->createConfigurationException('config for must be a numeric', $config);
        }
    }

}

class EquallyRuleExecutionError extends RuleExecutionError
{
    public static function create($valueGiven, $valueExpected)
    {
        $error =  new static(sprintf('Value must be equally %s. Given: %s', $valueGiven, $valueExpected));
        $error->setHumanFriendlyMessage('Must be greater than ' . $valueExpected);

        return $error;
    }
}