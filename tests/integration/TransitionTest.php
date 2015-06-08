<?php
/**
 * Created by PhpStorm.
 * User: aakhmetshin
 * Date: 10.10.14
 * Time: 13:16
 */

namespace dicom\workflow\tests\integration;

class TransitionTest extends AbstractWorkflowTest {

    public function __construct()
    {
        parent::__construct(dirname(__FILE__).'/../configs/transitionConfig.json');
    }


    public function testNewInBakedPie()
    {
        $this->setOldEntity(['id'=>1, 'stuffing'=>'apple', 'pastry'=>'barm', 'state'=> 'new']);
        $this->setNewEntity(['id'=>1, 'stuffing'=>'apple', 'pastry'=>'barm']);
        $this->setNewState('baked');
        $this->setContext(['time_minut'=>'50']);
        $result = $this->workflowTest();
        $this->assertTrue($result);
    }

    /**
     * @expectedException dicom\workflow\exception\WorkflowEngineException
     */
    public function testBakedInNewPie()
    {
        $this->setOldEntity(['id'=>1, 'stuffing'=>'apple', 'pastry'=>'barm', 'state'=> 'baked']);
        $this->setNewEntity(['id'=>1, 'stuffing'=>'apple', 'pastry'=>'barm']);
        $this->setNewState('new');
        //$this->setContext(['time_minut'=>'30']);
        $result = $this->workflowTest();
        $this->assertFalse($result);
    }

    /**
     * @expectedException dicom\workflow\exception\WorkflowEngineException
     */

    public function testUnknownStatesPie()
    {
        $this->setOldEntity(['id'=>1, 'stuffing'=>'apple', 'pastry'=>'barm', 'state'=> 'tutu1']);
        $this->setNewEntity(['id'=>1, 'stuffing'=>'apple', 'pastry'=>'barm']);
        $this->setNewState('tutu2');
        $result = $this->workflowTest();
    }

} 