<?php


namespace unit\rules;

use dicom\workflow\engine\rules\PropertyIsRequiredRule;

class PropertyIsRequiredRuleTest extends \PHPUnit_Framework_TestCase
{

    public function trueDataProvider()
    {
        return [
            [23],
            ['string'],
            [new \stdClass()],
        ];
    }

    public function falseDataProvider()
    {
        return [
            [0], //may be true?
            [''],
            [null],
            ['0'], //may be true?
        ];
    }

    /**
     * @dataProvider trueDataProvider
     */
    public function testExecuteTrue($value)
    {
        $rule = new PropertyIsRequiredRule();
        $executionResult = $rule->execute($value);

        $this->assertTrue($executionResult->isSuccess());
    }

    /**
     * @dataProvider falseDataProvider
     */
    public function testExecuteFalse($value)
    {
        $rule = new PropertyIsRequiredRule();
        $executionResult = $rule->execute($value);

        $this->assertFalse($executionResult->isSuccess());
    }
}
