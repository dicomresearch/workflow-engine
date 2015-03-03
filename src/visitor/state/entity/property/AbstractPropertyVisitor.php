<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 18.11.14
 * Time: 17:03
 */

namespace workflow\visitor\state\entity\property;


use workflow\entity\property\Property;

/**
 * Class AbstractPropertyVisitor
 *
 * Визитор, посещающий Property
 *
 * @package workflow\visitor\state\entity\property
 */
abstract class AbstractPropertyVisitor
{
    abstract public function visit(Property $property);
} 