<?php


namespace unit\rules;


use dicom\workflow\rules\PropertyIsReadOnlyRule;

class PropertyIsReadOnlyRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testExecuteSameValues()
    {
        $rule = new PropertyIsReadOnlyRule();
        $executionResult = $rule->execute(42, 42);

        $this->assertTrue($executionResult->isSuccess());
    }

    public function testExecuteDifferentValues()
    {
        $rule = new PropertyIsReadOnlyRule();
        $executionResult = $rule->execute(0, 42);

        $this->assertFalse($executionResult->isSuccess());
    }

    public function testExecuteDifferentTypeOfValues()
    {
        $rule = new PropertyIsReadOnlyRule();
        $executionResult = $rule->execute(42, '42');

        $this->assertTrue($executionResult->isSuccess());
    }
}
