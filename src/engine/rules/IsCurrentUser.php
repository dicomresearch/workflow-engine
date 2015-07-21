<?php

namespace dicom\workflow\engine\rules;

use dicom\workflow\engine\rules\error\IsCurrentUserRuleExecutionError;
use dicom\workflow\engine\rules\executionResult\RuleExecutionResult;
use dicom\workflow\engine\rules\error\RuleExecutionError;

/**
 * IsCurrentUser
 *
 * Transition rule который проверяет является ли текущий пользователь получателем заявки (receiver \Resource)
 *
 * todo вынести из workflow в srRequestWorkflow
 */
class IsCurrentUser extends Rule
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
        if (empty($newEntityValues)) {
            return new RuleExecutionError(sprintf(
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
            $result = in_array($newEntityValues, $currentUserResourcesIds);
            return $result;
        };

        $isSuccess = call_user_func($call);

        return $isSuccess;
    }

    /**
     * @return RuleExecutionError
     */
    protected function constructException()
    {
        return IsCurrentUserRuleExecutionError::create();
    }
}
