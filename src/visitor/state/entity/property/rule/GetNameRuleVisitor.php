<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 18.11.14
 * Time: 18:24
 */

namespace workflow\visitor\state\entity\property\rule;
use workflow\rules\Rule;
use workflow\rules\creation\RuleAliasMapping;


/**
 * Class GetNameRuleVisitor
 *
 * Визитор, получающий короткое имя свойства
 *
 * @package workflow\visitor\state\entity\property\rule
 */
class GetNameRuleVisitor extends AbstractRuleVisitor
{
    /**
     * @param Rule $rule
     * @return mixed
     */
    public function visit(Rule $rule)
    {
        return RuleAliasMapping::getAliasByClassName($rule->getFullName());
    }

} 