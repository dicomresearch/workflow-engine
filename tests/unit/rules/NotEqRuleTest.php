<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 13.07.15
 * Time: 15:21
 */

namespace unit\rules;


use dicom\workflow\engine\rules\compare\NotEqRule;
use dicom\workflow\engine\rules\error\NotEqRuleExecutionError;

class NotEqRuleTest extends \PHPUnit_Framework_TestCase
{
    public function trueDataProvider()
    {
        $date1 = new \DateTime();
        $date2 = new \DateTime();
        $date2->modify('+1 day');

        return [
            //[testValue, configuredValue]
            [0, 1],
            [2.3, 5.3],
            ['string', 'arg'],
            [ [1,2,3], [9,7,6] ],
            [null, 2],
            [$date1, $date2],
            [(object) ['value' => 2], (object) ['value' => 3]]
        ];
    }

    public function falseDataProvider()
    {
        $date1 = new \DateTime();
        $date2 = $date1;

        return [
            //[testValue, configuredValue]
            [1, 1],
            [0, 0],
            [2.3, 2.3],
            ['string', 'string'],
            [ [1,2,3], [1,2,3] ],
            [$date1, $date2],
            [(object) ['value' => 2], (object) ['value' => 2]]
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
        $rule = new NotEqRule();
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
        $rule = new NotEqRule();
        $rule->setConfig($configuredValue);

        $ruleExecutionResult = $rule->execute($value);

        $this->assertFalse(
            $ruleExecutionResult->isSuccess(),
            var_export($configuredValue, true) . 'must be not equally '. var_export($value, true)
        );
        $this->assertInstanceOf(NotEqRuleExecutionError::class, $ruleExecutionResult->getError());
    }
}