<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 18.11.14
 * Time: 17:01
 */

namespace dicom\workflow\engine\visitor\state\entity\property\rule;

use dicom\workflow\engine\rules\Rule;

/**
 * Class AbstractRuleVisitor
 *
 * Визитор, посещающий Правило (rule)
 *
 * @package dicom\workflow\visitor\state\entity\property\rule
 */
abstract class AbstractRuleVisitor
{
    /**
     * @param Rule $rule
     * @return mixed
     */
    abstract public function visit(Rule $rule);
}
