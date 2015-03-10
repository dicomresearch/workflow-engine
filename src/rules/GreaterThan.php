<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.12.14
 * Time: 15:34
 */

namespace dicom\workflow\rules;


use dicom\workflow\rules\exception\RuleConfigurationException;
use dicom\workflow\rules\exception\RuleExecutionException;
use dicom\workflow\rules\executionResult\RuleExecutionResult;
use dicom\workflow\rules\RuleInterface\IConfiguredRule;
use dicom\workflow\rules\RuleInterface\IRuleCheckingPropertyValue;

/**
 * Class GreaterThan
 *
 * Проверяет что новое значение сущности больше опредленного значения, заданого в конфиге Workflow
 *
 * @package dicom\workflow\rules
 */
class GreaterThan extends Rule implements IConfiguredRule, IRuleCheckingPropertyValue
{

    /**
     *
     * @var double
     */
    private $config;

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
        return $entityNewValue > $this->getConfig();
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

    /**
     * Set configuration
     *
     * @param mixed $config
     * @return mixed
     */
    public function setConfig($config)
    {
        $this->validateConfig($config);
        $this->config = $config;
    }

    protected function validateConfig($config)
    {
        if (! is_numeric($config)) {
            throw new RuleConfigurationException(sprintf(
                'config for %s must be a numeric, but given: %s',
                $this->getName(),
                var_export($config, true))
            );
        }
    }

    /**
     * Get configuration
     *
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }


} 