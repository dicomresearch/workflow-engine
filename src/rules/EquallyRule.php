<?php


namespace rules;


use dicom\workflow\rules\ConfiguredRule;
use dicom\workflow\rules\exception\RuleExecutionException;
use dicom\workflow\rules\executionResult\RuleExecutionResult;
use dicom\workflow\rules\Rule;
use dicom\workflow\rules\RuleInterface\IRuleCheckingOneValue;

class EquallyRule extends Rule implements IRuleCheckingOneValue
{
    use ConfiguredRule;
    /**
     * проверяет соответсвует ли значение сущности условиям аттрибута
     *
     * @param $value
     * @return RuleExecutionResult
     */
    public function execute($value)
    {
        $result = new RuleExecutionResult($this);
        $isValid = $this->isValid($value);
        $result->setResult($isValid);

        if (!$isValid) {
            $result->setError($this->constructException($value));
        }

        return $result;
    }

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
    protected function constructException($value = null)
    {
        $e = new RuleExecutionException(sprintf('Value must be greater than 0. Given: %s', $value));
        $e->setHumanFriendlyMessage('Must be greater than 0');
        return $e;
    }


    protected function validateConfig($config)
    {
        if (! is_numeric($config)) {
            throw $this->createConfigurationException('config for must be a numeric', $config);
        }
    }

}