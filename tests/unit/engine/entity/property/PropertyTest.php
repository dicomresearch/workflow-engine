<?php

namespace unit\engine\entity\property;

use dicom\workflow\engine\entity\property\Property;
use dicom\workflow\engine\rules\AlwaysFalseRule;
use dicom\workflow\engine\rules\AlwaysTrueRule;
use dicom\workflow\engine\rules\PropertyIsRequiredRule;

class PropertyTest extends \PHPUnit_Framework_TestCase
{
    public function testAddRulesToProperty()
    {
        $property = new Property('property');
        $property->addPropertyRule(new PropertyIsRequiredRule());

        $this->assertArrayHasKey(
            (new PropertyIsRequiredRule())->getName(),
            $property->getRules()
        );
    }

    public function testPropertyExecutionResultIsTrue()
    {
        $property = new Property('property');
        $property->addPropertyRule(new AlwaysTrueRule());

        $executionResult = $property->executeRules();
        $this->assertTrue($executionResult->isSuccess());
        $this->assertEmpty($executionResult->getErrors());
    }

    public function testPropertyExecutionResultIsFalse()
    {
        $property = new Property('property');
        $property->addPropertyRule(new AlwaysFalseRule());

        $executionResult = $property->executeRules();
        $this->assertFalse($executionResult->isSuccess());
        $this->assertCount(1, $executionResult->getErrors());
    }

    public function testGetErrors()
    {
        $property = new Property('property');
        $property->addPropertyRule(new AlwaysFalseRule());
        $executionResult = $property->executeRules('some value', 'other some value');

        $this->assertCount(1, $executionResult->getErrors());
    }
}
