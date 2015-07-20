<?php

namespace unit\entity\property;

use dicom\workflow\engine\entity\property\Property;
use dicom\workflow\engine\rules\AlwaysFalseRule;
use dicom\workflow\engine\rules\AlwaysTrueRule;
use dicom\workflow\entity;

class EntityParamTest extends \PHPUnit_Framework_TestCase
{

    public function testErrorsIfAssertionIsNotValid()
    {
        $property = new Property('car');
        $property->addPropertyRule(new AlwaysFalseRule());
        $executionResult = $property->executeRules('4 wheel', '4 wheel');

        static::assertFalse($executionResult->isSuccess());
    }

    public function testErrorsIfAssertionIsValid()
    {
        $property = new Property('car');
        $property->addPropertyRule(new AlwaysTrueRule());
        $executionResult = $property->executeRules('4 wheel', '4 wheel', $errors = []);

        static::assertTrue($executionResult->isSuccess());
    }
}
