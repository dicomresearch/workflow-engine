<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 27.01.15
 * Time: 12:12
 */

namespace dicom\workflow\tests\unit\rules\creation;


use dicom\workflow\rules\AlwaysTrueRule;
use dicom\workflow\rules\creation\RulesFactory;
use dicom\workflow\rules\executionResult\RuleExecutionResult;
use dicom\workflow\rules\GreaterThan;
use dicom\workflow\rules\RuleInterface\IRule;

class RulesFactoryTest extends \CTestCase
{
    public function testCreateByShortNameWithoutConfig()
    {
        $factory = new RulesFactory();
        $alwaysTrueRule = $factory->createByShortName('alwaystrue');

        $this->assertInstanceOf(AlwaysTrueRule::class, $alwaysTrueRule);
    }

    public function testCreateByShortNameWithConfig()
    {
        $factory = new RulesFactory();
        $rule = $factory->createByShortName('greaterthan', 0);

        $this->assertInstanceOf(GreaterThan::class, $rule);
        $result = $rule->execute(2);

        $this->assertInstanceOf(RuleExecutionResult::class, $result, 'Rule must return RuleExecutionResult object');
        $this->assertTrue($result->isSuccess(), '0 must be < 2');
    }

    public function testCreateBatchByShortNames()
    {
        $factory = new RulesFactory();
        $rules = $factory->createBatchByShortNames(['alwaysTrue', 'alwaysFalse']);

        $this->assertCount(2, $rules, 'contains only 2 rule');
        $this->assertContainsOnlyInstancesOf(IRule::class, $rules, 'contains only Rules');
    }

    public function testConvertToConfiguredRuleConfigDontNeedConvert()
    {
        $rules = [
            [
               'greaterThen' => 43,
            ],
            [
                'lessThen' => 98,
            ]
        ];

        $convertedRules = RulesFactory::convertToAssocRuleConfig($rules);

        $this->assertEquals($rules, $convertedRules, 'dont need to convert. thant ok');
    }

    public function testConvertToConfiguredRuleConfigNeedConvert()
    {
        $rules = [
            'greaterThen',
            'lessThen',
        ];

        $convertedRules = RulesFactory::convertToAssocRuleConfig($rules);

        $this->assertEquals([
            ['greaterThen' => null],
            ['lessThen' => null],
        ], $convertedRules, 'need to convert');
    }

}
