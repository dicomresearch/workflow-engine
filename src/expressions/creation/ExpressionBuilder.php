<?php


namespace dicom\workflow\expressions\creation;


use dicom\workflow\expressions\creation\exceptions\ExpressionBuildException;
//todo вынести создание в корень, вотдельную папку
//todo сделать этот конфиг объектно-ориентированным
class ExpressionBuilder
{
    public static function buildExpression($config)
    {
        if (! static::isExpressionConfig($config)) {
            throw ExpressionBuildException::thisConfigIsNotExpressionConfig($config);
        }

        $config = static::toExtendedConfig($config);

        return static::createExpressionByAlias($config['expr']['name']);
    }

    public static function isExpressionConfig(array $config)
    {
        if (array_key_exists('expr', $config)) {
            return true;
        }

        return false;
    }

    public static function toExtendedConfig($config)
    {
        if (!is_array($config['expr'])) {
            $config['expr'] = [
                'name' => $config['expr']
            ];
        }

        return $config;
    }

    public static function createExpressionByAlias($alias)
    {
        $className = ExpressionAliasMapping::getClassNameByAlias($alias);

        return new $className();
    }
}