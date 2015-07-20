<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 26.01.15
 * Time: 21:24
 */

namespace dicom\workflow\tests\unit\rules;

use dicom\workflow\engine\rules\AlwaysTrueRule;
use dicom\workflow\engine\rules\executionResult\RuleExecutionResult;

class AlwaysTrueRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $rule = new AlwaysTrueRule();
        $result = $rule->execute();

        static::assertInstanceOf(RuleExecutionResult::class, $result, 'Rule must return RuleExecutionResult object');
        static::assertTrue($result->isSuccess());
    }
}
