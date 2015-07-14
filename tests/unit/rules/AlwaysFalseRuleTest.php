<?php


namespace unit\rules;


use dicom\workflow\rules\AlwaysFalseRule;
use dicom\workflow\rules\error\AlwaysFalseRuleExecutionError;
use dicom\workflow\rules\error\RuleExecutionError;

class AlwaysFalseRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $rule = new AlwaysFalseRule();
        $ruleExecutionResult = $rule->execute();

        $this->assertFalse($ruleExecutionResult->isSuccess());
        $this->assertTrue($ruleExecutionResult->getError() instanceof AlwaysFalseRuleExecutionError);
    }

    public function testWrong()
    {
        $this->assertTrue(false, 'this is bad test');
    }
}
