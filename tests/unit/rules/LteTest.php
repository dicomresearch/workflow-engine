<?php


namespace unit\rules;


use dicom\workflow\expressions\CurrentDateExpression;
use dicom\workflow\rules\Lte;

class LteTest extends \PHPUnit_Framework_TestCase
{
    public function trueDataProvider()
    {
        return
        [
            //[value, config]
            [2, 1000],
            [-1, 0],
            [0, 0],
            [0, 0.0],

            [(new \DateTime('now'))->format('Y-m-d'), new CurrentDateExpression()],
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

            [(new \DateTime('tomorrow'))->format('Y-m-d'), new CurrentDateExpression()],
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
        $rule = new Lte();
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
        $rule = new Lte();
        $rule->setConfig($config);

        $ruleExecutionResult = $rule->execute($value);

        $this->assertFalse($ruleExecutionResult->isSuccess());
    }


}
