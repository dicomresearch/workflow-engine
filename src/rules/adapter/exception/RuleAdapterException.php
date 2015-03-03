<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 26.01.15
 * Time: 21:39
 */

namespace workflow\rules\adapter\exception;


class RuleAdapterException extends \Exception
{
    /**
     * Не известный интерфейс у правила, нельзя адаптировать к существующим
     *
     * @param $ruleName
     * @return static
     */
    public static function cantAdaptRule($ruleName)
    {
        return new static(sprintf('Cant adapt rule %s for known interfaces', $ruleName));
    }

}