<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 26.01.15
 * Time: 21:12
 */

namespace unit\engine\rules\adapter;

use dicom\workflow\engine\rules\adapter\RuleAdapter;
use dicom\workflow\engine\rules\AlwaysTrueRule;
use dicom\workflow\engine\rules\executionResult\RuleExecutionResult;
use dicom\workflow\engine\rules\PropertyIsRequiredRule;

class AdapterTest extends \PHPUnit_Framework_TestCase
{
    public function testTrue()
    {
        $this->assertTrue(true);
    }

    public function testWithoutArguments()
    {
        $adapter = new RuleAdapter(new AlwaysTrueRule());
        $result = $adapter->execute();

        $this->assertInstanceOf(RuleExecutionResult::class, $result, 'Rule must return RuleExecutionResult object');
        $this->assertTrue($result->isSuccess(), 'Always true rule always return true!');
    }

    public function testPropertyValueInterface()
    {
        $adapter = new RuleAdapter(new PropertyIsRequiredRule());
        $result = $adapter->execute('42');

        $this->assertInstanceOf(RuleExecutionResult::class, $result, 'Rule must return RuleExecutionResult object');
        $this->assertTrue($result->isSuccess());
    }
}
