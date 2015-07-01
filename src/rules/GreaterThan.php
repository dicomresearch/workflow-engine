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
use dicom\workflow\rules\RuleInterface\IRuleCheckingOneValue;

/**
 * Class GreaterThan
 *
 * Проверяет что новое значение сущности больше опредленного значения, заданого в конфиге Workflow
 *
 * @package dicom\workflow\rules
 */
class GreaterThan extends RuleCheckingOneValue implements IRuleCheckingOneValue, IConfiguredRule
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
    protected function constructValidationException($value = null)
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