<?php


namespace unit\rules;


use dicom\workflow\rules\InRule;

class InRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testExecuteTrue()
    {
        $germanCarsRule = new InRule(['bmw', 'audi', 'opel']);
        $executionResult = $germanCarsRule->execute('bmw');

        $this->assertTrue($executionResult->isSuccess());
    }

    public function testExecuteFalse()
    {
        $germanCarsRule = new InRule(['bmw', 'audi', 'opel']);
        $executionResult = $germanCarsRule->execute('tagaz');

        $this->assertFalse($executionResult->isSuccess());
    }
}
