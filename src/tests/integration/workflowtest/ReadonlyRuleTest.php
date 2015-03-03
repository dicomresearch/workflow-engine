<?php
/**
 * Created by PhpStorm.
 * User: aakhmetshin
 * Date: 10.10.14
 * Time: 12:14
 */

namespace workflowtest;


use workflow\config\WorkflowDescription;
use workflow\WorkflowEngine;

class ReadonlyRuleTest extends AbstractWorkflowTest {

    public function __construct()
    {
        parent::__construct(dirname(__FILE__).'/../configs/readonlyAttributeConfig.json');
    }

    public function testReadonlyAttribute()
    {
        $this->setOldEntity(['id'=>1234, 'state '=> 'new']);
        $this->setNewEntity(['id'=>1234]);
        $this->setTransition('done');
        $result = $this->workflowTest();
        $this->assertTrue($result);
    }

    public function testChangeReadonlyAttribute()
    {
        $this->setOldEntity(['id'=>1234, 'state '=> 'new']);
        $this->setNewEntity(['id'=>123]);
        $this->setTransition('done');
        $result = $this->workflowTest();
        $this->assertFalse($result);
    }

} 