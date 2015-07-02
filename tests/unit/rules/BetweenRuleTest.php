<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 02.07.15
 * Time: 15:39
 */

namespace unit\rules;


use dicom\workflow\rules\BetweenRule;

class BetweenRuleTest extends \PHPUnit_Framework_TestCase
{
    public function createBetweenRule()
    {
        $rule = new BetweenRule();
        $rule->setConfig([5, 15]);

        return $rule;
    }

    public function testExecuteRuleIsTrue()
    {
        $rule = $this->createBetweenRule();
        $ruleExecutionResult = $rule->execute(7);

        $this->assertTrue($ruleExecutionResult->isSuccess(), ' 5 <= 7 <= 15');
    }

    public function testExecuteRuleIsFalse()
    {
        $rule = $this->createBetweenRule();
        $ruleExecutionResult = $rule->execute(2);

        $this->assertFalse($ruleExecutionResult->isSuccess(), ' 2 < 5');
    }
}