<?php


namespace unit\rules;


use dicom\workflow\expressions\CurrentDateExpression;
use dicom\workflow\rules\compare\EqRule;

class RuleUsesExpressionTest extends \PHPUnit_Framework_TestCase
{

    public function testUseExpression()
    {
        $expression = new CurrentDateExpression();

        $rule = new EqRule();
        $rule->setConfig($expression);

        $currentDate = (new \DateTime())->format('Y-m-d');
        $ruleExecutionResult = $rule->execute($currentDate);

        $this->assertTrue($ruleExecutionResult->isSuccess());
    }
}
