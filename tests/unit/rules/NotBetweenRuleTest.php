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
    public function createNotBetweenRule()
    {
        $rule = new NotBetweenRule();
        $rule->setConfig([5, 15]);

        return $rule;
    }

    public function testExecuteRuleIsTrue()
    {
        $rule = $this->createNotBetweenRule();
        $ruleExecutionResult = $rule->execute(2);

        $this->assertTrue($ruleExecutionResult->isSuccess(), '2 < 5');
    }

    public function testExecuteRuleIsFalse()
    {
        $rule = $this->createNotBetweenRule();
        $ruleExecutionResult = $rule->execute(7);

        $this->assertFalse($ruleExecutionResult->isSuccess(), '5 <= 7 <= 15');
    }
}