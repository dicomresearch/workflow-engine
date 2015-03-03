<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 10/3/14
 * Time: 10:38 AM
 */
use workflow\entity;

class EntityParamTest extends PHPUnit_Framework_TestCase
{

    public function testErrorsIfAssertionIsNotValid()
    {
        $property = new entity\property\Property('car');
        $property->addPropertyRule(new \workflow\rules\AlwaysFalseRule());
        $isValid = $property->executeRules('4 wheel', '4 wheel', $errors);

        $this->assertFalse($isValid);
        $this->assertCount(1, $errors);
    }

    public function testErrorsIfAssertionIsValid()
    {
        $property = new entity\property\Property('car');
        $property->addPropertyRule(new \workflow\rules\AlwaysTrueRule());
        $isValid = $property->executeRules('4 wheel', '4 wheel', $errors = []);

        $this->assertTrue($isValid);
        $this->assertCount(0, $errors);
    }
}
 