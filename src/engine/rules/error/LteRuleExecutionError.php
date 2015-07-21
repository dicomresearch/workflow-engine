<?php


namespace dicom\workflow\engine\rules\error;

class LteRuleExecutionError extends RuleExecutionError
{
    public static function create($configValue, $value)
    {
        $error =  new static(sprintf('Value must be letter or equal "%s" . Given: %s', $configValue, $value));
        $error->setHumanFriendlyMessage('Must be greater letter or equally ' . $configValue);

        return $error;
    }
}
