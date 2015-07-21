<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 07.10.14
 * Time: 14:36
 */

namespace dicom\workflow\engine\rules;

use dicom\workflow\engine\rules\error\InRuleExecutionError;
use dicom\workflow\building\rules\RuleInterface\IConfiguredRule;

/**
 * Class inRule
 *
 * Проверяет значение, на вхождение в список допустимых значений, заданых в правилах
 *
 * В качестве проверяемого значения можно передавать как простое значение, так и массив значений, в этом случае будет
 * искаться пересечение значений, если хоть одно из значений ссовпадает проверка вернет true
 *
 * @package dicom\workflow\rules
 */
class InRule extends RuleCheckingOneValue implements IConfiguredRule
{
    use ConfiguredRule;

    /**
     * @param $value
     * @return bool
     */
    protected function isValid($value)
    {
        if (is_array($value)) {
            $intersect = array_intersect($value, $this->getConfig());
            $isValid = !empty($intersect);
            return $isValid;
        } else {
            $isValid = in_array($value, $this->getConfig());
            return $isValid;
        }
    }


    protected function constructValidationError($value)
    {
        return InRuleExecutionError::create($value, $this->getConfig());
    }

    /**
     * Validate config
     *
     * must throw exception if config don`t valid
     *
     * @param $config
     *
     * @throws \dicom\workflow\building\rules\exception\RuleConfigurationException
     */
    protected function validateConfig($config)
    {
        if (!is_array($config)) {
            throw $this->createConfigurationException('config for must be a array', $config);
        }
    }
}
