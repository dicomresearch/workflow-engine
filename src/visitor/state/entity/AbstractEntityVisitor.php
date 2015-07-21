<?php

namespace dicom\workflow\visitor\state\entity;


use dicom\workflow\entity\Entity;

/**
 * Class AbstractEntityVisitor
 *
 * Визитор, помещающий Entity. Обход внутренностей entity - ее свойств полностью лежит на клиентском коде (визиторе)
 * Если имется необходимость заглянуть внутрь entity можно воспользоваться GettingInsideEntityVisitor'ом
 *
 * @package dicom\workflow\visitor\state\entity
 */
abstract class AbstractEntityVisitor
{
    abstract public function visit(Entity $entity);
} 