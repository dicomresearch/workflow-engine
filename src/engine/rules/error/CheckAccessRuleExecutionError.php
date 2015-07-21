<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 01.07.15
 * Time: 17:21
 */

namespace dicom\workflow\engine\rules\error;

class CheckAccessRuleExecutionError extends RuleExecutionError
{
    /**
     * @param $config
     * @return static
     */
    public static function create($config)
    {
        $error =  new static(
            sprintf(
                'Rule "Yii Check Access" checking failed: User id: "%s", login: "%s" cant access to operation: %s',
                \Yii::app()->getUser()->getId(),
                \Yii::app()->getUser()->getLogin(),
                var_export($config, true)
            )
        );

        $error->setHumanFriendlyMessage('Is required field');

        return $error;
    }
}
