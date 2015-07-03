<?php


namespace unit\rules;


use dicom\workflow\rules\compare\GtRule;
use dicom\workflow\rules\error\GtRuleExecutionError;

class GtRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array [testValue, configuredValue]
     */
    public function trueDataProvider()
    {
        return [
            [5, 2]
        ];
    }

    /**
     * @return array [testValue, configuredValue]
     */
    public function falseDataProvider()
    {
        return [
            [1, 1],
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
        $rule = new GtRule();
        $rule->setConfig($configuredValue);

        $ruleExecutionResult = $rule->execute($value);

        $this->assertTrue($ruleExecutionResult->isSuccess(), var_export($value, true) . ' must be greater than '. var_export($configuredValue, true) );
    }

    /**
     * @param $value
     * @param $configuredValue
     *
     * @dataProvider falseDataProvider
     */
    public function testFalse($value, $configuredValue)
    {
        $rule = new GtRule();
        $rule->setConfig($configuredValue);

        $ruleExecutionResult = $rule->execute($value);

        $this->assertFalse($ruleExecutionResult->isSuccess(), var_export($value, true) . ' not must be greater than '. var_export($configuredValue, true));
        $this->assertInstanceOf(GtRuleExecutionError::class, $ruleExecutionResult->getError());
    }


//    public function testConfigureForNumeric()
//    {
//        $rule = new GtRule();
//        $rule->setConfig(5);
//
//        $this->assertEquals(5, $rule->getConfig());
//    }
//
//    public function testConfigureForNotNumeric()
//    {
//        $rule = new GtRule();
//
//        $this->setExpectedException(RuleConfigurationException::class);
//
//        $rule->setConfig(array(1,2,3));
//    }
//
//    public function testGreaterThenNumeric()
//    {
//        $rule = new GtRule();
//        $rule->setConfig(5);
//        $result = $rule->execute(6);
//
//        $this->assertInstanceOf(RuleExecutionResult::class, $result, 'Rule must return RuleExecutionResult object');
//        $this->assertTrue($result->isSuccess(), '5 must be > 6');
//    }
//
//    public function testGreaterThenNumericFalse()
//    {
//        $rule = new GtRule();
//        $rule->setConfig(5);
//        $result = $rule->execute(4);
//
//        $this->assertInstanceOf(RuleExecutionResult::class, $result, 'Rule must return RuleExecutionResult object');
//        $this->assertFalse($result->isSuccess(), '4 must be < 6');
//    }
//
//
//    public function createGreaterThanRule()
//    {
//        $rule = new GtRule();
//        $rule->setConfig(3);
//
//        return $rule;
//    }
//
//    public function testCreateWithConfig()
//    {
//        $rule = $this->createGreaterThanRule();
//        $this->assertEquals(3, $rule->getConfig());
//    }
//
//    public function testExecuteRuleIsTrue()
//    {
//        $rule = $this->createGreaterThanRule();
//        $ruleExecutionResult = $rule->execute(4);
//
//        $this->assertTrue($ruleExecutionResult->isSuccess(), ' 3 > 4');
//    }
//
//    public function testExecuteRuleIsFalse()
//    {
//        $rule = $this->createGreaterThanRule();
//        $ruleExecutionResult = $rule->execute(2);
//
//        $this->assertFalse($ruleExecutionResult->isSuccess(), ' 2 < 3');
//    }
}
