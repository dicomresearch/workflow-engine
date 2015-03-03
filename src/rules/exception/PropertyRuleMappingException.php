<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.10.14
 * Time: 16:52
 */

namespace workflow\rules\exception;


use Ddeboer\Imap\Exception\Exception;

class PropertyRuleMappingException extends Exception
{
    public static function cantMapRuleName($wrongRuleName, $allRulesName)
    {
        return new static(sprintf(
            'Cant map short rule name "%s". This short alias not found in registered rules. Registered rules: %s',
            $wrongRuleName,
            var_export($allRulesName, true))
        );
    }

    public static function cantMapClassName($wrongClassName, $allRulesName)
    {
        return new static(sprintf(
            'Class name %s not registered in rules mapping. Registered rules: %s',
            $wrongClassName,
            var_export($allRulesName, true)
        ));
    }

    public static function aliasAlreadyRegistered($alias)
    {
        return new static(sprintf(
           'Cant add alias "%s" this alias was already registered', $alias
        ));
    }
} 