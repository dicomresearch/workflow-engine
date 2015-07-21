<?php

namespace dicom\workflow\visitor\state;


use dicom\workflow\state\State;

/**
 * Class AbstractStateVisitor
 *
 * Визитор, посещающий состояние. Необходимость заглянуть во внутрь State полностю возлежит на этом Визиторе
 *
 * Если имется необходимость заглянуть внутрь состояния - пощупать entity и глубже, можно воспользоваться
 * GettingInsideVisitor'ом
 *
 * @package dicom\workflow\visitor\state
 */
abstract class AbstractStateVisitor
{
    abstract public function visit(State $state);
} 