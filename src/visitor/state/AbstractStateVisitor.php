<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 18.11.14
 * Time: 16:57
 */

namespace workflow\visitor\state;


use workflow\state\State;

/**
 * Class AbstractStateVisitor
 *
 * Визитор, посещающий состояние. Необходимость заглянуть во внутрь State полностю возлежит на этом Визиторе
 *
 * Если имется необходимость заглянуть внутрь состояния - пощупать entity и глубже, можно воспользоваться
 * GettingInsideVisitor'ом
 *
 * @package workflow\visitor\state
 */
abstract class AbstractStateVisitor
{
    abstract public function visit(State $state);
} 