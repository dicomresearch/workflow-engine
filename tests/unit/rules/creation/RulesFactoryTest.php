<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 27.01.15
 * Time: 12:12
 */

namespace dicom\workflow\tests\unit\rules\creation;

use dicom\workflow\building\rules\creation\RulesFactory;
use dicom\workflow\engine\rules\AlwaysTrueRule;
use dicom\workflow\engine\rules\compare\GtRule;
use dicom\workflow\engine\rules\executionResult\RuleExecutionResult;
use dicom\workflow\building\rules\RuleInterface\IRule;

class RulesFactoryTest extends \PHPUnit_Framework_TestCase
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
        $rule = $factory->createByShortName('gt', 0);

        $this->assertInstanceOf(GtRule::class, $rule);
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
               'gt' => 43,
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
            'gt',
            'lessThen',
        ];

        $convertedRules = RulesFactory::convertToAssocRuleConfig($rules);

        $this->assertEquals([
            ['gt' => null],
            ['lessThen' => null],
        ], $convertedRules, 'need to convert');
    }
}
