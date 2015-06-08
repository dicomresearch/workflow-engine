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

    public function testPropertyExecutionResultIsTrue()
    {
        $property = new \dicom\workflow\entity\property\Property('property');
        $property->addPropertyRule(new \dicom\workflow\rules\AlwaysTrueRule());

        $executionResult = $property->executeRules();
        $this->assertTrue($executionResult->isSuccess());
        $this->assertEmpty($executionResult->getErrors());
    }

    public function testPropertyExecutionResultIsFalse()
    {
        $property = new \dicom\workflow\entity\property\Property('property');
        $property->addPropertyRule(new \dicom\workflow\rules\AlwaysFalseRule());

        $executionResult = $property->executeRules();
        $this->assertFalse($executionResult->isSuccess());
        $this->assertCount(1, $executionResult->getErrors());
    }

    public function testGetErrors()
    {
        $property = new \dicom\workflow\entity\property\Property('property');
        $property->addPropertyRule(new \dicom\workflow\rules\AlwaysFalseRule());
        $executionResult = $property->executeRules('some value', 'other some value');

        $this->assertCount(1, $executionResult->getErrors());
    }
}
 