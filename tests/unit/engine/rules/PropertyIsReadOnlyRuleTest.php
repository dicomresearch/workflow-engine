<?php


namespace unit\engine\rules;

use dicom\workflow\engine\rules\PropertyIsReadOnlyRule;

class PropertyIsReadOnlyRuleTest extends \PHPUnit_Framework_TestCase
{
    public function trueDataProvider()
    {
        return [
            [42, 42],
            ['string', 'string'],
            [null, null],
        ];
    }

    public function falseDataProvider()
    {
        return [
            [2, 42],
            ['string', ' other string'],
            [null, 'some value'],
        ];
    }

    /**
     * @dataProvider trueDataProvider
     *
     * @param $newvalue
     * @param $oldvalue
     */
    public function testExecuteTrue($newvalue, $oldvalue)
    {
        $rule = new PropertyIsReadOnlyRule();
        $executionResult = $rule->execute($newvalue, $oldvalue);

        $this->assertTrue($executionResult->isSuccess());
    }

    /**
     * @dataProvider falseDataProvider
     *
     * @param $newvalue
     * @param $oldvalue
     */
    public function testExecuteFalse($newvalue, $oldvalue)
    {
        $rule = new PropertyIsReadOnlyRule();
        $executionResult = $rule->execute($newvalue, $oldvalue);

        $this->assertFalse($executionResult->isSuccess());
    }
}
