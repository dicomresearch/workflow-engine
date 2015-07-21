<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 01.07.15
 * Time: 14:48
 */

namespace dicom\workflow\engine\rules\error;

class AlwaysTrueRuleExecutionError extends RuleExecutionError
{
    /**
     * @return static
     */
    public static function create()
    {
        $error =  new static(sprintf('You never been saw this exception. This rule always true'));

        return $error;
    }
}
