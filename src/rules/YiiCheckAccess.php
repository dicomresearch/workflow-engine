<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 08.10.14
 * Time: 11:30
 */

namespace dicom\workflow\rules;
use dicom\workflow\rules\exception\RuleCreationException;
use dicom\workflow\rules\exception\RuleExecutionException;
use dicom\workflow\rules\executionResult\RuleExecutionResult;
use dicom\workflow\rules\RuleInterface\IConfiguredRule;
use dicom\workflow\rules\RuleInterface\IRuleCheckingWithoutArguments;

/**
 * Class YiiCheckAccess
 *
 * Проверяет права пользователя методом Yii::app()->user->checkAccess()
 *
 * @package dicom\workflow\rules
 */
class YiiCheckAccess extends Rule implements IConfiguredRule, IRuleCheckingWithoutArguments
{
    /**
     * @var array аргументы, с которыми будут вызываться проверка прав
     */
    protected $config;

    /**
     * проверяет есть ли доступ у пользователя к операции
     *
     * @return RuleExecutionResult
     */
    public function execute()
    {
        $result = new RuleExecutionResult($this);


        $isValid = $this->isValid();
        $result->setResult($isValid);

        if (!$isValid) {
            $result->setError($this->constructValidationException());
        }

        return $result;
    }


    /**
     * @return bool
     */
    protected function isValid()
    {
        //call_user_func_array не может вызвать \Yii::app()->user->checkAccess() или у меня не получилось
        $call = function ($operation, $params = []) {
            return \Yii::app()->user->checkAccess($operation, $params);
        };

        $result = call_user_func_array($call, $this->getConfig());
        return $result;
    }

    protected function constructValidationException()
    {
        return new RuleExecutionException(sprintf(
            'Rule "Yii Check Access" checking failed: User id: "%s", login: "%s" cant access to operation: %s',
            \Yii::app()->getUser()->getId(),
            \Yii::app()->getUser()->getLogin(),
            var_export($this->getConfig(), true)
            ));
    }

    /**
     * Set configuration
     *
     * @param array $config
     *
     * @return mixed|void mixed
     *
     * @throws RuleCreationException
     */
    public function setConfig($config)
    {
        if (!is_array($config)) {
            throw new RuleCreationException(
                'Config for rule %s must be a array. Give %s',
                $this->getName(),
                var_export($config, true)
                );
        }

        if (!array_key_exists(0, $config)) {
            throw new RuleCreationException(
                'Config for rule %s must contains first operation name. Give %s',
                $this->getName(),
                var_export($config, true)
            );
        }
        $this->config = $config;
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

    public function getOperationName()
    {
        return $this->getConfig()[0];
    }


} 