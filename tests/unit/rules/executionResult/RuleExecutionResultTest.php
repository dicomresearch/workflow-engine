<?php


namespace unit\rules\executionResult;


use dicom\workflow\rules\AlwaysFalseRule;
use dicom\workflow\rules\exception\RuleExecutionException;
use dicom\workflow\rules\executionResult\RuleExecutionResult;

class RuleExecutionResultTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $ruleExecutionResult = RuleExecutionResult::create(new AlwaysFalseRule(), false, new RuleExecutionException());
        $this->assertFalse($ruleExecutionResult->isSuccess());
        $this->assertTrue($ruleExecutionResult->getError() instanceof RuleExecutionException);
    }
}
