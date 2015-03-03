<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 19.11.14
 * Time: 10:14
 */

namespace workflow\rules\creation;

use workflow\rules\exception\PropertyRuleMappingException;

class RuleAliasMapping
{
    private static $ruleNameMapping = [
        'readonly'              => 'workflow\rules\PropertyIsReadOnlyRule',
        'required'              => 'workflow\rules\PropertyIsRequiredRule',
        'alwaystrue'            => 'workflow\rules\AlwaysTrueRule',
        'alwaysfalse'           => 'workflow\rules\AlwaysFalseRule',
        'greaterthan'           => 'workflow\rules\GreaterThan',
        'in'                    => '\workflow\rules\InRule',
        'yiicheckaccess'        => '\workflow\rules\YiiCheckAccess',
        'currentuserisreceiver' => '\workflow\rules\CurrentUserIsReceiver'
    ];

    public static function getClassNameByAlias($alias)
    {
        $alias = strtolower($alias);

        if (!array_key_exists($alias, static::$ruleNameMapping)) {
            throw PropertyRuleMappingException::cantMapRuleName($alias, static::$ruleNameMapping);
        }

        return static::$ruleNameMapping[$alias];
    }

    public static function getAliasByClassName($className)
    {
        if (!in_array($className, static::$ruleNameMapping)) {
            throw PropertyRuleMappingException::cantMapClassName($className, static::$ruleNameMapping);
        }

        $alias = array_search($className, static::$ruleNameMapping);
        return $alias;
    }

    public static function addAlias($alias, $className)
    {
        $alias = strtolower($alias);

        if (array_key_exists($alias, static::$ruleNameMapping)) {
            PropertyRuleMappingException::aliasAlreadyRegistered($alias);
        }

        static::$ruleNameMapping[$alias] = $className;
    }

} 