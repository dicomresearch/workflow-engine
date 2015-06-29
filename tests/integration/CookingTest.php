<?php


namespace integration;


use dicom\workflow\config\WorkflowDescription;
use dicom\workflow\WorkflowEngine;

class CookingTest extends \PHPUnit_Framework_TestCase
{
    public function testCookingBakingPie()
    {
        $jsonConfig = file_get_contents(__DIR__ . '/configs/cooking.json');
        $config = json_decode($jsonConfig, true);

        $wfDescription = new WorkflowDescription($config);
        $engine = new WorkflowEngine($wfDescription);

        $rawPie = [
            'id' => 1,
            'stuffing' => 'cherry',
            'pastry' => 'yeast dough',
            'baking_time' => 0,
        ];

        $bakedPie = [
            'id' => 1,
            'stuffing' => 'cherry',
            'pastry' => 'yeast dough',
            'baking_time' => 50,
        ];

        $transitionResult = $engine->makeTransition('new', 'baked', $bakedPie, $rawPie);
        $this->assertTrue($transitionResult->isSuccess());
    }
}