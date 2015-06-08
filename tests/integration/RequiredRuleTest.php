<?php
/**
 * Created by PhpStorm.
 * User: aakhmetshin
 * Date: 10.10.14
 * Time: 11:48
 */

namespace dicom\workflow\tests\integration;


class RequiredRuleTest extends AbstractWorkflowTest {

    public function __construct()
    {
        parent::__construct(dirname(__FILE__).'/../configs/requiredAttributeConfig.json');
    }

    public function testSuccessTransition()
    {
        $this->setOldEntity(['id'=>1234, 'state '=> 'new']);
        $this->setNewEntity(['id'=>123]);
        $this->setTransition('done');
        $result = $this->workflowTest();
        $this->assertTrue($result);

    }

    public function testEmptyNewRequiredAttribute()
    {
        $this->setOldEntity(['id'=>1234, 'state '=> 'new']);
        $this->setNewEntity(['id'=>'']);
        $this->setTransition('done');
        $result = $this->workflowTest();
        $this->assertFalse($result);
    }

} 