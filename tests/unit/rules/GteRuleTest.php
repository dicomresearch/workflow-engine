<?php


namespace unit\rules;

use dicom\workflow\engine\rules\compare\GteRule;
use dicom\workflow\engine\rules\error\GteRuleExecutionError;

class GteRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array [testValue, configuredValue]
     */
    public function trueDataProvider()
    {
        return [
            [1, 1],
            [5, 2]
        ];
    }

    /**
     * @return array [testValue, configuredValue]
     */
    public function falseDataProvider()
    {
        return [
            [2, 5],
        ];
    }

    /**
     *
     * @param $value
     * @param $configuredValue
     *
     * @dataProvider trueDataProvider
     */
    public function testTrue($value, $configuredValue)
    {
        $rule = new GteRule();
        $rule->setConfig($configuredValue);

        $ruleExecutionResult = $rule->execute($value);

        $this->assertTrue(
            $ruleExecutionResult->isSuccess(),
            var_export($value, true) . 'must be greater or equally than '. var_export($configuredValue, true)
        );
    }

    /**
     * @param $value
     * @param $configuredValue
     *
     * @dataProvider falseDataProvider
     */
    public function testFalse($value, $configuredValue)
    {
        $rule = new GteRule();
        $rule->setConfig($configuredValue);

        $ruleExecutionResult = $rule->execute($value);

        $this->assertFalse(
            $ruleExecutionResult->isSuccess(),
            var_export($value, true) . 'not must be greater or equally than '. var_export($configuredValue, true)
        );
        $this->assertInstanceOf(GteRuleExecutionError::class, $ruleExecutionResult->getError());
    }
}
