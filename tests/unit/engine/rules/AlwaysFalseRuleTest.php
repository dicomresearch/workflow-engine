<?php


namespace unit\engine\rules;

use dicom\workflow\engine\rules\AlwaysFalseRule;
use dicom\workflow\engine\rules\error\AlwaysFalseRuleExecutionError;

class AlwaysFalseRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $rule = new AlwaysFalseRule();
        $ruleExecutionResult = $rule->execute();

        $this->assertFalse($ruleExecutionResult->isSuccess());
        $this->assertTrue($ruleExecutionResult->getError() instanceof AlwaysFalseRuleExecutionError);
    }
}
