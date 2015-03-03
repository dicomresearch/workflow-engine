<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 26.01.15
 * Time: 21:37
 */

namespace workflow\rules\RuleInterface;

/**
 * Interface IRuleCheckingPropertyValue
 *
 * Правило проверяет новое значение свойства
 *
 * @package workflow\rules\RuleInterface
 */
interface IRuleCheckingPropertyValue extends IRule
{
    public function execute($propertyValue);
}