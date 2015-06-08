<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 07.10.14
 * Time: 14:36
 */

namespace dicom\workflow\rules;
use dicom\workflow\rules\exception\RuleExecutionException;
use dicom\workflow\rules\executionResult\RuleExecutionResult;
use dicom\workflow\rules\RuleInterface\IConfiguredRule;
use dicom\workflow\rules\RuleInterface\IRuleCheckingPropertyValue;

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
class InRule extends Rule implements IConfiguredRule, IRuleCheckingPropertyValue
{

    /**
     * Перечисление значений, удовлетворея одному из них правило будет выполнено
     *
     * @var array
     */
    private $config = [];

    public function __construct($arguments)
    {
        $this->setConfig($arguments);
    }

    /**
     * проверяет соответсвует ли значение сущности условиям аттрибут
     *
     * @param mixed $value
     * @param null $outError
     * @return RuleExecutionResult
     */
    public function execute($value = null)
    {
        $result = new RuleExecutionResult($this);
        $isValid = $this->isValid($value);
        $result->setResult($isValid);


        if (!$isValid) {
            $result->setError($this->constructValidationException($value));
        }

        return $result;
    }


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


    protected function constructValidationException($value)
    {
        return new RuleExecutionException(sprintf(
            'Value: "%s" not In %s',
            var_export($value, true),
            var_export($this->getConfig(), true)
        ));
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }
} 