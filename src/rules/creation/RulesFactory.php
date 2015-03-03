<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.10.14
 * Time: 16:46
 */

namespace workflow\rules\creation;
use workflow\rules\Rule;
use workflow\rules\creation\RuleAliasMapping;
use workflow\rules\RuleInterface\IConfiguredRule;


/**
 * Class PropertyRuleFactory
 *
 * Create property Rules
 *
 * @package workflow\models\entity\property\rule
 */
class RulesFactory
{

    /**
     * Create batch
     *
     * @param array $rulesDescription
     * @return array
     */
    public static function createBatchByShortNames(array $rulesDescription)
    {
        $rules = [];
        $rulesDescription = static::convertToAssocRuleConfig($rulesDescription);
        foreach ($rulesDescription as $ruleDescription) {
            $rules[] = static::createByDescription($ruleDescription);
        }

        return $rules;
    }

    /**
     * Create rule by description
     *
     * @param array $ruleDescription [ruleName => config]
     * @return Rule
     */
    public static function createByDescription($ruleDescription)
    {
        list($shortName, $ruleDescription) = each($ruleDescription);
        return static::createByShortName($shortName, $ruleDescription);
    }

    /**
     * Создать правило по его короткому имени
     *
     * @param string|array $shortName if array then [ruleName => RuleDescription]
     * @return Rule
     */
    public static function createByShortName($shortName, $ruleDescription = null)
    {
        $className = RuleAliasMapping::getClassNameByAlias($shortName);

        $rule = new $className();
        if ($rule instanceof IConfiguredRule) {
            $rule->setConfig($ruleDescription);
        }

        return $rule;
    }

    /**
     * Приводит разношерстное описание конфигов к одному виду:
     * [
     *      [ruleName1 => config],
     *      [ruleName2 => config],
     * ]
     *
     * На вход может получать конфиги вида
     * [ruleName1, ruleName2] или смешанные
     *
     * @param array $rules
     * @return array
     */
    public static function convertToAssocRuleConfig($rules)
    {
        $convertedRules = [];
        foreach ($rules as $value) {
            // if not configured rule
            if (!is_array($value)) {
                $convertedRules[] = [$value => null];
            } else {
                $convertedRules[] = $value;
            }
        }

        return $convertedRules;
    }

} 