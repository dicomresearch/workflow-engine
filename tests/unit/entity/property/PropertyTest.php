<?php

class PropertyTest extends PHPUnit_Framework_TestCase
{
    public function testAddRulesToProperty()
    {
        $property = new \dicom\workflow\entity\property\Property('property');
        $property->addPropertyRule(new \dicom\workflow\rules\PropertyIsRequiredRule());

        $this->assertArrayHasKey(
            (new \dicom\workflow\rules\PropertyIsRequiredRule())->getName(),
            $property->getRules()
        );
    }

    public function testCheckPropertyIsTrue()
    {
        $property = new \dicom\workflow\entity\property\Property('property');
        $property->addPropertyRule(new \dicom\workflow\rules\AlwaysTrueRule());

        $this->assertTrue($property->executeRules()->isSuccess());
    }

    public function testCheckPropertyIsFalse()
    {
        $property = new \dicom\workflow\entity\property\Property('property');
        $property->addPropertyRule(new \dicom\workflow\rules\AlwaysFalseRule());

        $this->assertFalse($property->executeRules()->isSuccess());
    }

    public function testGetErrors()
    {
        $property = new \dicom\workflow\entity\property\Property('property');
        $property->addPropertyRule(new \dicom\workflow\rules\AlwaysFalseRule());
        $executionResult = $property->executeRules(null, null);

        $this->assertCount(1, $executionResult->getErrors());
    }
}
 