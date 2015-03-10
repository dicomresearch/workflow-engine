<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 18.11.14
 * Time: 18:24
 */

namespace dicom\workflow\visitor\state\entity\property\rule;
use dicom\workflow\rules\Rule;
use dicom\workflow\rules\creation\RuleAliasMapping;


/**
 * Class GetNameRuleVisitor
 *
 * Визитор, получающий короткое имя свойства
 *
 * @package dicom\workflow\visitor\state\entity\property\rule
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