<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 19.11.14
 * Time: 10:14
 */

namespace dicom\workflow\building\rules\creation;

use dicom\workflow\building\rules\exception\PropertyRuleMappingException;

class RuleAliasMapping
{
    private static $ruleNameMapping = [
        'readonly'              => 'dicom\workflow\engine\rules\PropertyIsReadOnlyRule',
        'required'              => 'dicom\workflow\engine\rules\PropertyIsRequiredRule',
        'empty'                 => 'dicom\workflow\engine\rules\IsEmptyRule',
        'alwaystrue'            => 'dicom\workflow\engine\rules\AlwaysTrueRule',
        'alwaysfalse'           => 'dicom\workflow\engine\rules\AlwaysFalseRule',
        'in'                    => '\dicom\workflow\engine\rules\InRule',
        'yiicheckaccess'        => '\dicom\workflow\engine\rules\YiiCheckAccess',
        'currentuserisreceiver' => '\dicom\workflow\engine\rules\CurrentUserIsReceiver',
        'between'               => 'dicom\workflow\engine\rules\BetweenRule',
        'notbetween'            => 'dicom\workflow\engine\rules\NotBetweenRule',
        'eq'                    => 'dicom\workflow\engine\rules\compare\EqRule',
        'gte'                   => 'dicom\workflow\engine\rules\compare\GteRule',
        'gt'                    => 'dicom\workflow\engine\rules\compare\GtRule',
        'lte'                   => 'dicom\workflow\engine\rules\compare\LteRule',
        'lt'                    => 'dicom\workflow\engine\rules\compare\LtRule',
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
