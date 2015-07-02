<?php


namespace dicom\workflow\expressions\creation\exceptions;


class ExpressionBuildException
{
    public static function thisConfigIsNotExpressionConfig($config)
    {
        return new static(
            sprintf(
                'Config "%s" is not expression config',
                $config
            ));
    }
}