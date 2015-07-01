<?php


namespace dicom\workflow\expressions\creation;


use dicom\workflow\expressions\creation\exceptions\ExpressionMappingException;

class ExpressionAliasMapping
{
    private static $registeredExpressionAliases = [
        'currentdate' => 'dicom\workflow\expressions\CurrentDateExpression',
    ];

    public static function getClassNameByAlias($alias)
    {
        $alias = strtolower($alias);

        if (!array_key_exists($alias, static::$registeredExpressionAliases)) {
            throw ExpressionMappingException::cantFindExpressionByAlias($alias, static::$registeredExpressionAliases);
        }

        return static::$registeredExpressionAliases[$alias];
    }

    public static function getAliasByClassName($className)
    {
        if (!in_array($className, static::$registeredExpressionAliases)) {
            throw ExpressionMappingException::cantFindAliasForExpression($className, static::$registeredExpressionAliases);
        }

        $alias = array_search($className, static::$registeredExpressionAliases);
        return $alias;
    }

    public static function addAlias($alias, $className)
    {
        $alias = strtolower($alias);

        if (array_key_exists($alias, static::$registeredExpressionAliases)) {
            throw ExpressionMappingException::aliasAlreadyRegistered($alias, $className, static::$registeredExpressionAliases);
        }

        static::$registeredExpressionAliases[$alias] = $className;
    }
}