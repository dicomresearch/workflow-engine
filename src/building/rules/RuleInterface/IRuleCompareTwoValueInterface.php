<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 07.10.14
 * Time: 14:27
 */

namespace dicom\workflow\building\rules\RuleInterface;

/**
 * Interface RuleCompareTwoValueInterface
 *
 * Правило, которое для валидации использует сравнение значений 2х сущностей, либо только новой
 *
 * @package dicom\workflow\models\entity\property\rule
 */
interface IRuleCompareTwoValueInterface
{
    /**
     * проверяет соответсвует ли значение сущности условиям аттрибута
     *
     * @param mixed $entityNewValue
     * @param mixed $entityOldValue
     * @return bool
     * @internal param array|null $context
     *
     */
    public function execute($entityNewValue, $entityOldValue);
}
