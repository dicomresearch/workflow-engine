<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 01.07.15
 * Time: 18:07
 */

namespace unit\rules;


use dicom\workflow\rules\LessThan;

class LessThanTest extends \PHPUnit_Framework_TestCase
{
    public function createLessThanRule()
    {
        $rule = new LessThan();
        $rule->setConfig(3);

        return $rule;
    }

    public function testCreateWithConfig()
    {
        $rule = $this->createLessThanRule();
        $this->assertEquals(3, $rule->getConfig());
    }

    public function testExecuteRuleIsTrue()
    {
        $rule = $this->createLessThanRule();
        $ruleExecutionResult = $rule->execute(2);

        $this->assertTrue($ruleExecutionResult->isSuccess(), ' 2 < 3');
    }

    public function testExecuteRuleIsFalse()
    {
        $rule = $this->createLessThanRule();
        $ruleExecutionResult = $rule->execute(4);

        $this->assertFalse($ruleExecutionResult->isSuccess(), ' 3 > 4');
    }
}