<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 18.11.14
 * Time: 17:01
 */

namespace workflow\visitor\state\entity\property\rule;
use workflow\rules\Rule;

/**
 * Class AbstractRuleVisitor
 *
 * Визитор, посещающий Правило (rule)
 *
 * @package workflow\visitor\state\entity\property\rule
 */
abstract class AbstractRuleVisitor
{
    /**
     * @param Rule $rule
     * @return mixed
     */
    abstract public function visit(Rule $rule);

} 