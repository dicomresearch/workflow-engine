<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 02.07.15
 * Time: 15:39
 */

namespace unit\rules;


use dicom\workflow\rules\NotBetweenRule;

class NotBetweenRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * [$config, $value]
     *
     * @return array
     */
    public function trueDataProvider()
    {
        return [
            [[5, 15], 2],
            [['c', 'q'], 'a']
        ];
    }

    /**
     * [$config, $value]
     *
     * @return array
     */
    public function falseDataProvider()
    {
        return [
            [[5, 15], 7],
            [['c', 'q'], 'e']
        ];
    }

    /**
     * @param $config
     * @param $value
     *
     * @dataProvider trueDataProvider
     */
    public function testExecuteRuleIsTrue($config, $value)
    {
        $rule = new NotBetweenRule();
        $rule->setConfig($config);
        $ruleExecutionResult = $rule->execute($value);

        $this->assertTrue($ruleExecutionResult->isSuccess());
    }

    /**
     * @param $config
     * @param $value
     *
     * @dataProvider falseDataProvider
     */
    public function testExecuteRuleIsFalse($config, $value)
    {
        $rule = new NotBetweenRule();
        $rule->setConfig($config);
        $ruleExecutionResult = $rule->execute($value);

        $this->assertFalse($ruleExecutionResult->isSuccess());
    }
}