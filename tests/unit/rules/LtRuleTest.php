<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 01.07.15
 * Time: 18:07
 */

namespace unit\rules;


use dicom\workflow\expressions\CurrentDateExpression;
use dicom\workflow\rules\compare\LtRule;

class LtRuleTest extends \PHPUnit_Framework_TestCase
{
    public function trueDataProvider()
    {
        return
            [
                //[value, config]
                [2, 1000],
                [-1, 0],

                [(new \DateTime('yesterday'))->format('Y-m-d'), new CurrentDateExpression()],
            ];
    }

    public function falseDataProvider()
    {
        return
            [
                //[value, config]
                [1000, 2],
                [0, -1],
                [0, 0],
                [0, 0.0],

                [(new \DateTime('tomorrow'))->format('Y-m-d'), new CurrentDateExpression()],
                [(new \DateTime('now'))->format('Y-m-d'), new CurrentDateExpression()],
            ];
    }

    /**
     *
     * @dataProvider trueDataProvider
     *
     * @param $value
     * @param $config
     */
    public function testTrue($value, $config)
    {
        $rule = new LtRule();
        $rule->setConfig($config);

        $ruleExecutionResult = $rule->execute($value);

        $this->assertTrue($ruleExecutionResult->isSuccess());
    }

    /**
     *
     * @dataProvider falseDataProvider
     *
     * @param $value
     * @param $config
     */
    public function testFalse($value, $config)
    {
        $rule = new LtRule();
        $rule->setConfig($config);

        $ruleExecutionResult = $rule->execute($value);

        $this->assertFalse($ruleExecutionResult->isSuccess());
    }
}