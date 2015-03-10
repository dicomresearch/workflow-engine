<?php

namespace dicom\workflow\rules;
use dicom\workflow\rules\exception\RuleExecutionException;
use dicom\workflow\rules\executionResult\RuleExecutionResult;
use dicom\workflow\rules\RuleInterface\IRuleCheckingPropertyValue;;

/**
 * CurrentUserIsReceiver
 *
 * Transition rule который проверяет является ли текущий пользователь получателем заявки (receiver \Resource)
 *
 * todo вынести из workflow в srRequestWorkflow
 * todo если правило проверяет одно из свойств сущности, то в transition передается вся сущность
 * а в state только значение свойства. нужно унифицировать.
 */
class CurrentUserIsReceiver extends Rule implements IRuleCheckingPropertyValue
{

    /**
     * проверяет есть ли доступ у пользователя к операции
     *
     * @param $newEntityValues
     * @return RuleExecutionResult
     */
    public function execute($newEntityValues)
    {
        $isValid =  $this->isValid($newEntityValues);

        $result = new RuleExecutionResult($this);
        $result->setResult($isValid);

        if (!$isValid) {
            $result->setError($this->constructException());
        }

        return $result;

    }



    /**
     * @param array $newEntityValues
     * @return bool
     */
    protected function isValid($newEntityValues)
    {
        //todo вынести в отдельный класс ошибок
        if (!isset($newEntityValues['receiver_id']) or empty($newEntityValues['receiver_id'])) {
            return new RuleExecutionException(sprintf(
                'Rule "Current user is receiver" checking failed because receiver_id is missing. Access denied'
            ));
        }

        $call = function () use ($newEntityValues) {
            $currentUserResources = \Yii::app()->getUser()->getResource();
            if (is_null($currentUserResources)) {
                return false;
            }

            $currentUserResourcesIds = array_map(
                function ($resource) {
                    return $resource->getAttribute('id');
                },
                $currentUserResources
            );
            $result = in_array($newEntityValues['receiver_id'], $currentUserResourcesIds);
            return $result;
        };

        $isSuccess = call_user_func($call);

        return $isSuccess;
    }

    /**
     * @return RuleExecutionException
     */
    protected function constructException()
    {
        return new RuleExecutionException(sprintf(
            'Rule "Current user is receiver" checking. Access denied'
        ));
    }

} 