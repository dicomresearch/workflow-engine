<?php
use dicom\workflow\entity;

class EntityParamTest extends PHPUnit_Framework_TestCase
{

    public function testErrorsIfAssertionIsNotValid()
    {
        $property = new entity\property\Property('car');
        $property->addPropertyRule(new \dicom\workflow\rules\AlwaysFalseRule());
        $executionResult = $property->executeRules('4 wheel', '4 wheel');

        static::assertFalse($executionResult->isSuccess());
    }

    public function testErrorsIfAssertionIsValid()
    {
        $property = new entity\property\Property('car');
        $property->addPropertyRule(new \dicom\workflow\rules\AlwaysTrueRule());
        $executionResult = $property->executeRules('4 wheel', '4 wheel', $errors = []);

        static::assertTrue($executionResult->isSuccess());
    }
}
 