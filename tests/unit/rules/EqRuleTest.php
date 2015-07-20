<?php


namespace unit\rules;

use dicom\workflow\engine\rules\compare\EqRule;
use dicom\workflow\engine\rules\error\EqRuleExecutionError;

class EqRuleTest extends \PHPUnit_Framework_TestCase
{

    public function trueDataProvider()
    {
        return [
            //[testValue, configuredValue]
            [1, 1],
            [0, 0],
            [2.3, 2.3],
            ['string', 'string'],
            [ [1,2,3], [1,2,3] ],
        ];
    }

    public function falseDataProvider()
    {
        return [
            //[testValue, configuredValue]
            [0, 1],
            [2.3, 5.3],
            ['string', 'arg'],
            [ [1,2,3], [9,7,6] ],
            [null, 2],
        ];
    }

    /**
     *
     * @param $value
     * @param $configuredValue
     *
     * @dataProvider trueDataProvider
     */
    public function testTrue($value, $configuredValue)
    {
        $rule = new EqRule();
        $rule->setConfig($configuredValue);

        $ruleExecutionResult = $rule->execute($value);

        $this->assertTrue(
            $ruleExecutionResult->isSuccess(),
            var_export($configuredValue, true) . 'must be equally '. var_export($value, true)
        );
    }

    /**
     * @param $value
     * @param $configuredValue
     *
     * @dataProvider falseDataProvider
     */
    public function testFalse($value, $configuredValue)
    {
        $rule = new EqRule();
        $rule->setConfig($configuredValue);

        $ruleExecutionResult = $rule->execute($value);

        $this->assertFalse(
            $ruleExecutionResult->isSuccess(),
            var_export($configuredValue, true) . 'must be not equally '. var_export($value, true)
        );
        $this->assertInstanceOf(EqRuleExecutionError::class, $ruleExecutionResult->getError());
    }
}
