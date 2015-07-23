<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 01.07.15
 * Time: 16:06
 */

namespace dicom\workflow\engine\rules\error;

class IsCurrentUserRuleExecutionError extends RuleExecutionError
{
    /**
     * @return static
     */
    public static function create()
    {
        $error =  new static(sprintf('Rule "Current user is receiver" checking. Access denied'));

        return $error;
    }
}
