<?php
/**
 * Created by PhpStorm.
 * User: alsu
 * Date: 06.07.15
 * Time: 17:03
 */

namespace integration;

use dicom\workflow\config\WorkflowDescription;
use dicom\workflow\rules\error\EqRuleExecutionError;
use dicom\workflow\rules\error\InRuleExecutionError;
use dicom\workflow\WorkflowEngine;

class CarsOnTrafficLightsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Название конфиг файла
     *
     * @var string
     */
    private $configFile = '/configs/carsOnTrafficLights.json';

    /**
     * входная точка для WF
     *
     * @var
     */
    private $engine;

    public function __construct()
    {
        parent::__construct();

        $jsonConfig = file_get_contents(__DIR__ . $this->configFile);

        $wfDescription = new WorkflowDescription($jsonConfig);
        $this->engine = new WorkflowEngine($wfDescription);
    }

    /**
     * Возможности перевести из одного статуса в другой
     * все условия выполняются
     *
     * @return true
     */
    public function testPassWithoutStopping()
    {
        $go = [
            'id' => 1,
            'model' => 'policy crown victory',
            'colorOfTrafficLights' => 'green'
        ];

        $passWithoutStopping = [
            'id' => 1,
            'model' => 'policy crown victory',
            'colorOfTrafficLights' => 'yellow'
        ];

        $transitionResult = $this->engine->makeTransition('go', 'passWithoutStopping', $passWithoutStopping, $go);
        $this->assertTrue($transitionResult->isSuccess());
    }

    /**
     * Возможности перевести из одного статуса в другой
     * неправильно передается цвет светофора, при котором можно ехать
     *
     * @return false
     */
    public function testWrongPassWithoutStopping()
    {
        $go = [
            'id' => 1,
            'model' => 'policy crown victory',
            'colorOfTrafficLights' => 'green'
        ];

        $passWithoutStopping = [
            'id' => 1,
            'model' => 'policy crown victory',
            'colorOfTrafficLights' => 'red'
        ];

        $transitionResult = $this->engine->makeTransition('go', 'passWithoutStopping', $passWithoutStopping, $go);
        $this->assertFalse($transitionResult->isSuccess());
        $this->assertEquals(1, count($transitionResult->getErrors()));
        $this->assertInstanceOf(InRuleExecutionError::class, $transitionResult->getErrors()[0]);
    }


    /**
     * Возможности перевести из одного статуса в другой
     * все условия выполняются
     *
     * @return true
     */
    public function testGoStop()
    {
        $go = [
            'id' => 1,
            'model' => 'policy crown victory',
            'colorOfTrafficLights' => 'green'
        ];

        $stop = [
            'id' => 1,
            'model' => 'policy crown victory',
            'colorOfTrafficLights' => 'red'
        ];

        $transitionResult = $this->engine->makeTransition('go', 'stop', $stop, $go);
        $this->assertTrue($transitionResult->isSuccess());
    }

    /**
     * Возможности перевести из одного статуса в другой
     * неправильно передается цвет светофора, при котором можно ехать
     *
     * @return false
     */
    public function testWrongGoStop()
    {
        $go = [
            'id' => 1,
            'model' => 'policy crown victory',
            'colorOfTrafficLights' => 'green'
        ];

        $stop = [
            'id' => 1,
            'model' => 'policy crown victory',
            'colorOfTrafficLights' => 'yellow'
        ];

        $transitionResult = $this->engine->makeTransition('go', 'stop', $stop, $go);
        $this->assertFalse($transitionResult->isSuccess());
        $this->assertEquals(1, count($transitionResult->getErrors()));
        $this->assertInstanceOf(EqRuleExecutionError::class, $transitionResult->getErrors()[0]);
    }

} 