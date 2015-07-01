<?php


namespace unit\rules;


use dicom\workflow\rules\exception\RuleConfigurationException;
use dicom\workflow\rules\executionResult\RuleExecutionResult;
use dicom\workflow\rules\GreaterThan;

class GreaterThanTest extends \PHPUnit_Framework_TestCase
{
    public function testConfigureForNumeric()
    {
        $rule = new GreaterThan();
        $rule->setConfig(5);

        $this->assertEquals(5, $rule->getConfig());
    }

    public function testConfigureForNotNumeric()
    {
        $rule = new GreaterThan();

        $this->setExpectedException(RuleConfigurationException::class);

        $rule->setConfig(array(1,2,3));
    }

    public function testGreaterThenNumeric()
    {
        $rule = new GreaterThan();
        $rule->setConfig(5);
        $result = $rule->execute(6);

        $this->assertInstanceOf(RuleExecutionResult::class, $result, 'Rule must return RuleExecutionResult object');
        $this->assertTrue($result->isSuccess(), '5 must be > 6');
    }

    public function testGreaterThenNumericFalse()
    {
        $rule = new GreaterThan();
        $rule->setConfig(5);
        $result = $rule->execute(4);

        $this->assertInstanceOf(RuleExecutionResult::class, $result, 'Rule must return RuleExecutionResult object');
        $this->assertFalse($result->isSuccess(), '4 must be < 6');
    }


    public function createGreaterThanRule()
    {
        $rule = new GreaterThan();
        $rule->setConfig(3);

        return $rule;
    }

    public function testCreateWithConfig()
    {
        $rule = $this->createGreaterThanRule();
        $this->assertEquals(3, $rule->getConfig());
    }

    public function testExecuteRuleIsTrue()
    {
        $rule = $this->createGreaterThanRule();
        $ruleExecutionResult = $rule->execute(4);

        $this->assertTrue($ruleExecutionResult->isSuccess(), ' 3 > 4');
    }

    public function testExecuteRuleIsFalse()
    {
        $rule = $this->createGreaterThanRule();
        $ruleExecutionResult = $rule->execute(2);

        $this->assertFalse($ruleExecutionResult->isSuccess(), ' 2 < 3');
    }
}
