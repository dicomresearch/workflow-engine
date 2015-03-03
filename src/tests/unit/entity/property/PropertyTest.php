<?php

class PropertyTest extends PHPUnit_Framework_TestCase
{
    public function testAddRulesToProperty()
    {
        $property = new \workflow\entity\property\Property('property');
        $property->addPropertyRule(new \workflow\rules\PropertyIsRequiredRule());

        $this->assertArrayHasKey(
            (new \workflow\rules\PropertyIsRequiredRule())->getName(),
            $property->getRules()
        );
    }

    public function testCheckPropertyIsTrue()
    {
        $property = new \workflow\entity\property\Property('property');
        $property->addPropertyRule(new \workflow\rules\AlwaysTrueRule());

        $this->assertTrue($property->executeRules());
    }

    public function testCheckPropertyIsFalse()
    {
        $property = new \workflow\entity\property\Property('property');
        $property->addPropertyRule(new \workflow\rules\AlwaysFalseRule());

        $this->assertFalse($property->executeRules());
    }

    public function testGetErrors()
    {
        $property = new \workflow\entity\property\Property('property');
        $property->addPropertyRule(new \workflow\rules\AlwaysFalseRule());
        $property->executeRules(null, null, $errors);

        $this->assertCount(1, $errors);
    }
}
 