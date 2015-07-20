<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 02.07.15
 * Time: 15:39
 */

namespace unit\rules;

use dicom\workflow\engine\rules\BetweenRule;
use dicom\workflow\engine\rules\error\BetweenRuleExecutionError;

class BetweenRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * [$config, $value]
     *
     * @return array
     */
    public function trueDataProvider()
    {
        return [
            [[5, 15], 7],
            [['c', 'q'], 'e']
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
            [[5, 15], 2],
            [['c', 'q'], 'a']
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
        $rule = new BetweenRule();
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
        $rule = new BetweenRule();
        $rule->setConfig($config);
        $ruleExecutionResult = $rule->execute($value);

        $this->assertFalse($ruleExecutionResult->isSuccess());
        $this->assertInstanceOf(BetweenRuleExecutionError::class, $ruleExecutionResult->getError());
    }
}
