<?php


namespace unit\rules;


use dicom\workflow\rules\GreaterThan;

class GreaterThanTest extends \PHPUnit_Framework_TestCase
{
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
