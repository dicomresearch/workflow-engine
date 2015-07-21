<?php


namespace unit\engine\rules;

use dicom\workflow\engine\rules\IsEmptyRule;

class IsEmptyRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testExecuteWithInt()
    {
        $rule = new IsEmptyRule();
        $executionResult = $rule->execute(42);

        $this->assertFalse($executionResult->isSuccess());
    }

    public function testExecuteWithInt0()
    {
        $rule = new IsEmptyRule();
        $executionResult = $rule->execute(0);

        $this->assertTrue($executionResult->isSuccess());
    }

    public function testExecuteWithNullValue()
    {
        $rule = new IsEmptyRule();
        $executionResult = $rule->execute(null);

        $this->assertTrue($executionResult->isSuccess());
    }
}
