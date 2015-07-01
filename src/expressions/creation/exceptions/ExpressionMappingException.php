<?php


namespace dicom\workflow\expressions\creation\exceptions;


class ExpressionMappingException extends \Exception
{
    public static function cantFindExpressionByAlias($aliasName, $registeredAliases)
    {
        return new static(
            sprintf(
                'Cant find Expression by alias "%s". Registered aliases are: %s',
                $aliasName,
                array_keys($registeredAliases)
            ));
    }

    public static function cantFindAliasForExpression($expressionFullName, $registeredExpressions)
    {
        return new static(
            sprintf(
                'Cant find alias for expression "%s". Registered aliases are: %s',
                $expressionFullName,
                var_export($registeredExpressions, true)
            ));
    }

    public static function aliasAlreadyRegistered($aliasName, $aliasClass, $registeredExpressions)
    {
        return new static(
            sprintf(
                'Cant register expression "%s" with name "%s" . Registered aliases are: %s',
                $aliasClass,
                $aliasName,
                var_export($registeredExpressions, true)
            ));
    }
}