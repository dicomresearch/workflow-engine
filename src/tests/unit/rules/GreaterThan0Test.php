<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 27.01.15
 * Time: 12:17
 */

namespace workflow\tests\unit\rules;


use workflow\rules\exception\RuleConfigurationException;
use workflow\rules\executionResult\RuleExecutionResult;
use workflow\rules\GreaterThan;

class GreaterThan0Test extends \CTestCase
{
    public function testConfigureForNumeric()
    {
        $rule = new GreaterThan();
        $rule->setConfig(5);

        $this->assertEquals(5, $rule->getConfig());
    }

    public function testConfigureForNotNumeric()
    {
        $rule = new GreaterThan();

        $this->setExpectedException(RuleConfigurationException::class);

        $rule->setConfig(array(1,2,3));
    }

    public function testGreaterThenNumeric()
    {
        $rule = new GreaterThan();
        $rule->setConfig(5);
        $result = $rule->execute(6);

        $this->assertInstanceOf(RuleExecutionResult::class, $result, 'Rule must return RuleExecutionResult object');
        $this->assertTrue($result->isSuccess(), '5 must be > 6');
    }

    public function testGreaterThenNumericFalse()
    {
        $rule = new GreaterThan();
        $rule->setConfig(5);
        $result = $rule->execute(4);

        $this->assertInstanceOf(RuleExecutionResult::class, $result, 'Rule must return RuleExecutionResult object');
        $this->assertFalse($result->isSuccess(), '4 must be < 6');
    }




}
