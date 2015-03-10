<?php
/**
 * Created by PhpStorm.
 * User: aakhmetshin
 * Date: 10.10.14
 * Time: 12:39
 */

namespace workflowtest;
use dicom\workflow;


class ContextTest extends AbstractWorkflowTest {

    public function __construct()
    {
        parent::__construct(dirname(__FILE__).'/../configs/contextConfig.json');
    }

    /**
     *
     * @expectedException dicom\workflow\context\exception\ContextSpecificationException
     */
    public function testOutContext()
    {
        $this->setOldEntity(['id'=>1234, 'state'=> 'new']);
        $this->setNewEntity(['id'=>1234, 'amount'=>1234]);
        $this->setNewState('payed');
        $result = $this->workflowTest();
        $this->assertFalse($result, "transition не должен выполниться, т.к. не указан performer, а он должен быть строго задан");
    }

    public function testWithoutContext()
    {
        $this->setOldEntity(['id'=>1234, 'state'=> 'new']);
        $this->setNewEntity(['id'=>1234]);
        $this->setNewState('denied');
        $result = $this->workflowTest();
        $this->assertTrue($result);
    }

    public function testAnotherContext()
    {
        $this->setOldEntity(['id'=>1234, 'state'=> 'new']);
        $this->setNewEntity(['id'=>1234, 'amount'=>1234]);
        $this->setNewState('payed');
        $this->setContext(['performer'=>'me']);
        $result = $this->workflowTest();
        $this->assertFalse($result, "не должна отработать, выполняет другой performer");
    }

    public function testSeveralContext()
    {
        $this->setOldEntity(['id'=>1234, 'state'=> 'new']);
        $this->setNewEntity(['id'=>1234, 'amount'=>1234]);
        $this->setNewState('payed');
        $this->setContext(['performer'=>['Queen','Cherry']]);
        $result = $this->workflowTest();
        $this->assertTrue($result);
    }

    public function testOneOfSeveralContext()
    {
        $this->setOldEntity(['id'=>1234, 'state'=> 'new']);
        $this->setNewEntity(['id'=>1234, 'amount'=>1234]);
        $this->setNewState('payed');
        $this->setContext(['performer'=>['Queen','me']]);
        $result = $this->workflowTest();
        $this->assertTrue($result);
    }


    public function testSuccessDenied()
    {
        $this->setNewEntity(['id'=>1234, 'state'=> 'denied']);
        $this->setOldEntity(['id'=>1234]);
        $this->setNewState('freeDanced');
        $result = $this->workflowTest();
        $this->assertFalse($result);
    }



} 