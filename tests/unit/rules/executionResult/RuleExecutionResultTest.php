<?php


namespace unit\rules\executionResult;

use dicom\workflow\engine\rules\AlwaysFalseRule;
use dicom\workflow\engine\rules\error\RuleExecutionError;
use dicom\workflow\engine\rules\executionResult\RuleExecutionResult;

class RuleExecutionResultTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $ruleExecutionResult = RuleExecutionResult::create(new AlwaysFalseRule(), false, new RuleExecutionError());
        $this->assertFalse($ruleExecutionResult->isSuccess());
        $this->assertTrue($ruleExecutionResult->getError() instanceof RuleExecutionError);
    }
}
