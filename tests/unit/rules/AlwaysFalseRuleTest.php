<?php


namespace unit\rules;


use dicom\workflow\rules\AlwaysFalseRule;
use dicom\workflow\rules\exception\RuleExecutionError;

class AlwaysFalseRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $rule = new AlwaysFalseRule();
        $ruleExecutionResult = $rule->execute();

        $this->assertFalse($ruleExecutionResult->isSuccess());
        $this->assertTrue($ruleExecutionResult->getError() instanceof RuleExecutionError);
    }
}
