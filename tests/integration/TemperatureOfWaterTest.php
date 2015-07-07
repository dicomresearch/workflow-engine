<?php
/**
 * Created by PhpStorm.
 * User: alsu
 * Date: 06.07.15
 * Time: 12:30
 */

namespace integration;

use dicom\workflow\config\WorkflowDescription;
use dicom\workflow\rules\error\BetweenRuleExecutionError;
use dicom\workflow\rules\error\GtRuleExecutionError;
use dicom\workflow\rules\error\LtRuleExecutionError;
use dicom\workflow\WorkflowEngine;

class temperatureOfWaterTest extends \PHPUnit_Framework_TestCase{

    /**
     * Название конфиг файла
     *
     * @var string
     */
    private $configFile = '/configs/temperatureOfWater.json';

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
    public function testYetWater()
    {
        $water1 = [
            'id' => 1,
            'volume' => 1,
            'temperature' => 10
        ];

        $water2 = [
            'id' => 1,
            'volume' => 1,
            'temperature' => 50
        ];

        $transitionResult = $this->engine->makeTransition('water', 'water', $water2, $water1);
        $this->assertTrue($transitionResult->isSuccess());
    }

    /**
     * Возможности перевести из одного статуса в другой
     * все условия выполняются
     * проверяются на предельных температурах
     *
     * @return true
     */
    public function testYetWaterLimitOfTemperature()
    {
        $water1 = [
            'id' => 1,
            'volume' => 1,
            'temperature' => 0
        ];

        $water2 = [
            'id' => 1,
            'volume' => 1,
            'temperature' => 100
        ];

        $transitionResult = $this->engine->makeTransition('water', 'water', $water2, $water1);
        $this->assertTrue($transitionResult->isSuccess());
    }

    /**
     * Возможности перевести из одного статуса в другой
     * все условия выполняются
     * проверяются на предельных температурах
     *
     * @return true
     */
    public function testYetWaterDecimalValuesOfTemperature()
    {
        $water1 = [
            'id' => 1,
            'volume' => 1,
            'temperature' => 0.1
        ];

        $water2 = [
            'id' => 1,
            'volume' => 1,
            'temperature' => 90.9
        ];

        $transitionResult = $this->engine->makeTransition('water', 'water', $water2, $water1);
        $this->assertTrue($transitionResult->isSuccess());
    }

    /**
     * Возможности перевести из одного статуса в другой
     * неправильно передается температура, слишком высокая, вода уже должна превращаться в пар
     *
     * @return false
     */
    public function testWrongWaterWater()
    {
        $water = [
            'id' => 1,
            'volume' => 1,
            'temperature' => 10
        ];

        $exhalation = [
            'id' => 1,
            'volume' => 1,
            'temperature' => 120
        ];

        $transitionResult = $this->engine->makeTransition('water', 'water', $exhalation, $water);
        $this->assertFalse($transitionResult->isSuccess());
        $this->assertEquals(1, count($transitionResult->getErrors()));
        $this->assertInstanceOf(BetweenRuleExecutionError::class, $transitionResult->getErrors()[0]);
    }

    /**
     * Возможности перевести из одного статуса в другой
     * передается слишком низкая температура, чтоб вода смогла закипеть и превратиться в пар
     * проверяются на предельных температурах
     *
     * @return false
     */
    public function testWrongBoilWaterLimitOfTemperature()
    {
        $water1 = [
            'id' => 1,
            'volume' => 1,
            'temperature' => 5
        ];

        $water2 = [
            'id' => 1,
            'volume' => 1,
            'temperature' => 100
        ];

        $transitionResult = $this->engine->makeTransition('water', 'exhalation', $water2, $water1);
        $this->assertFalse($transitionResult->isSuccess());
        $this->assertEquals(1, count($transitionResult->getErrors()));
        $this->assertInstanceOf(GtRuleExecutionError::class, $transitionResult->getErrors()[0]);
    }

    /**
     * Возможности перевести из одного статуса в другой
     * все условия выполняются
     * передается предельная температура для закипания
     *
     * @return true
     */
    public function testBoilWaterLimitOfTemperature()
    {
        $water = [
            'id' => 1,
            'volume' => 1,
            'temperature' => 5
        ];

        $exhalation = [
            'id' => 1,
            'volume' => 1,
            'temperature' => 101
        ];

        $transitionResult = $this->engine->makeTransition('water', 'exhalation', $exhalation, $water);
        $this->assertTrue($transitionResult->isSuccess());
    }

    /**
     * Возможности перевести из одного статуса в другой
     * все условия выполняются
     * передается предельная температура для заморозки
     *
     * @return true
     */
    public function testIceWaterLimitOfTemperature()
    {
        $water = [
            'id' => 1,
            'volume' => 1,
            'temperature' => 5
        ];

        $ice = [
            'id' => 1,
            'volume' => 1,
            'temperature' => -1
        ];

        $transitionResult = $this->engine->makeTransition('water', 'ice', $ice, $water);
        $this->assertTrue($transitionResult->isSuccess());
    }

    /**
     * Возможности перевести из одного статуса в другой
     * передается слишком высокая температура, чтоб вода смогла замерзнуть
     * проверяются на предельных температурах
     *
     * @return false
     */
    public function testWrongIceWaterLimitOfTemperature()
    {
        $water = [
            'id' => 1,
            'volume' => 1,
            'temperature' => 5
        ];

        $ice = [
            'id' => 1,
            'volume' => 1,
            'temperature' => 0
        ];

        $transitionResult = $this->engine->makeTransition('water', 'ice', $ice, $water);
        $this->assertFalse($transitionResult->isSuccess());
        $this->assertEquals(1, count($transitionResult->getErrors()));
        $this->assertInstanceOf(LtRuleExecutionError::class, $transitionResult->getErrors()[0]);
    }

} 