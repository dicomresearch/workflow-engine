<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 02.07.15
 * Time: 15:51
 */

namespace dicom\workflow\engine\rules;

use dicom\workflow\engine\rules\error\NotBetweenRuleExecutionError;
use dicom\workflow\building\rules\RuleInterface\IConfiguredRule;
use dicom\workflow\building\rules\exception\RuleConfigurationException;

class NotBetweenRule extends RuleCheckingOneValue implements IConfiguredRule
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
        $config = $this->getConfig();

        return $entityNewValue < $config[0] || $entityNewValue > $config[1];
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
        return NotBetweenRuleExecutionError::create($value, $this->getConfig());
    }


    /**
     * [15, 30]
     *
     * @param $config
     * @throws RuleConfigurationException
     */
    protected function validateConfig($config)
    {
        if (!is_array($config) || count($config) !== 2) {
            throw $this->createConfigurationException('config for must be a array', $config);
        }

        if ($config[0] >= $config[1]) {
            throw $this->createConfigurationException('the first element must be less than the second', $config);
        }
    }
}
