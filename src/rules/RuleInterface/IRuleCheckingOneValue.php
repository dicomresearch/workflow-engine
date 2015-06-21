<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 26.01.15
 * Time: 21:37
 */

namespace dicom\workflow\rules\RuleInterface;

/**
 * Interface IRuleCheckingOneValue
 *
 * Правило проверяет новое значение свойства
 *
 * @package dicom\workflow\rules\RuleInterface
 */
interface IRuleCheckingOneValue extends IRule
{
    public function execute($propertyValue);
}