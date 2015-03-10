<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 26.01.15
 * Time: 21:24
 */

namespace dicom\workflow\tests\unit\rules;


use dicom\workflow\rules\AlwaysTrueRule;
use dicom\workflow\rules\executionResult\RuleExecutionResult;

class AlwaysTrueRuleTest extends \CTestCase
{
    public function testExecute()
    {
        $rule = new AlwaysTrueRule();
        $result = $rule->execute();

        $this->assertInstanceOf(RuleExecutionResult::class, $result, 'Rule must return RuleExecutionResult object');
        $this->assertTrue($result->isSuccess());
    }
}
