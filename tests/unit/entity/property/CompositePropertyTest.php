<?php


namespace unit\entity\property;


use dicom\workflow\entity\property\CompositeProperty;
use dicom\workflow\entity\property\Property;
use dicom\workflow\rules\AlwaysTrueRule;
use dicom\workflow\rules\compare\GtRule;


class CompositePropertyTest extends \PHPUnit_Framework_TestCase
{
    protected function createTestGirl()
    {
        $boobsSize = new Property('boobsSize');
        $greaterThenRule = new GtRule();
        $greaterThenRule->setConfig(2);
        $boobsSize->addPropertyRule($greaterThenRule);

        $prettyFace = new Property('prettyFace');
        $prettyFace->addPropertyRule(new AlwaysTrueRule());

        $girl = new CompositeProperty('girl');
        $girl->addProperty($boobsSize);
        $girl->addProperty($prettyFace);

        return $girl;
    }

    public function testAddProperty()
    {
        $girl = $this->createTestGirl();
        $this->arrayHasKey('boobsSize', $girl->getProperties());
        $this->arrayHasKey('prettyFace', $girl->getProperties());
    }

    public function testExecutionIsTrue()
    {
        $girl = $this->createTestGirl();

        $anna = [
            'boobsSize' => 3,
            'prettyFace' => 'yes'
        ];

        $executionResult = $girl->executeRules($anna, $anna);
        $this->assertTrue($executionResult->isSuccess());
    }

    public function testExecutionIsFalse()
    {
        $girl = $this->createTestGirl();

        $jane = [
            'boobsSize' => 1,
            'prettyFace' => 'yes'
        ];

        $executionResult = $girl->executeRules($jane, $jane);
        $this->assertFalse($executionResult->isSuccess());
    }
}
