<?php


namespace integration;


use dicom\workflow\config\WorkflowDescription;
use dicom\workflow\exception\WorkflowEngineException;
use dicom\workflow\WorkflowEngine;

class CookingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Название конфиг файла
     *
     * @var string
     */
    private $configFile = '/configs/cooking.json';

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
        $config = json_decode($jsonConfig, true);

        $wfDescription = new WorkflowDescription($config);
        $this->engine = new WorkflowEngine($wfDescription);
    }

    /**
     * Возможности перевести из одного статуса в другой
     * все условия выполняются
     *
     * @return true
     */
    public function testCookingBakingPie()
    {
        $rawPie = [
            'id' => 1,
            'stuffing' => 'cherry',
            'pastry' => 'yeast dough',
            'baking_time' => 0
        ];

        $bakedPie = [
            'id' => 1,
            'stuffing' => 'cherry',
            'pastry' => 'yeast dough',
            'baking_time' => 50
        ];

        $transitionResult = $this->engine->makeTransition('new', 'baked', $bakedPie, $rawPie);
        $this->assertTrue($transitionResult->isSuccess());
    }

    /**
     * Попытка изменить параметр который readonly
     *
     * @return false
     */
    public function testCookingChangeStuffing()
    {
        $rawPie = [
            'id' => 1,
            'stuffing' => 'cherry',
            'pastry' => 'yeast dough',
            'baking_time' => 0
        ];

        $bakedPie = [
            'id' => 1,
            'stuffing' => 'strawberry', // меняем параметр, который нельзя менять.
                                        // в результате transitions не должна быть выполнена
            'pastry' => 'yeast dough',
            'baking_time' => 50
        ];

        $transitionResult = $this->engine->makeTransition('new', 'baked', $bakedPie, $rawPie);
        $this->assertFalse($transitionResult->isSuccess());

        $this->assertCount(1, $transitionResult->getErrors());
        $this->assertInstanceOf('dicom\workflow\rules\error\IsReadOnlyRuleExecutionError', $transitionResult->getErrors()[0]);
    }

    /**
     * Проверка properties заданных в transitions
     *
     * @return false
     */
    public function testCookingBurntPie()
    {
        $rawPie = [
            'id' => 1,
            'stuffing' => 'cherry',
            'pastry' => 'yeast dough',
            'baking_time' => 0
        ];

        $bakedPie = [
            'id' => 1,
            'stuffing' => 'cherry',
            'pastry' => 'yeast dough',
            'baking_time' => 60 // при значениях более 50, пирог считается пригоревшим.
                                // transitions выполняться не должна
        ];

        $transitionResult = $this->engine->makeTransition('new', 'baked', $bakedPie, $rawPie);
        $this->assertFalse($transitionResult->isSuccess());

        $this->assertCount(1, $transitionResult->getErrors());
        $this->assertInstanceOf('dicom\workflow\rules\error\EquallyRuleExecutionError', $transitionResult->getErrors()[0]);
    }

    /**
     * Список всех возможных переходов из статуса new
     * всего доступно 2 перехода
     *
     * @return true
     */
    public function testViewAllCookingState()
    {
        $rawPie = [
            'id' => 1,
            'stuffing' => 'cherry',
            'pastry' => 'yeast dough',
            'baking_time' => 0
        ];

        $transitions = $this->engine->getAvailableStates('new', $rawPie);
        $this->assertCount(2, $transitions);
    }

    /**
     * Готовоим без начинки.
     * Не указываем required поле
     *
     * @return false
     */
    public function testCookingWithoutStuffing()
    {
        $rawPie = [
            'id' => 1,
            'stuffing' => 'cherry',
            'pastry' => 'yeast dough',
            'baking_time' => 0
        ];

        // не указываем начинку. transition не должна выполниться
        $bakedPie = [
            'id' => 1,
            'pastry' => 'yeast dough',
            'baking_time' => 50
        ];

        $transitionResult = $this->engine->makeTransition('new', 'baked', $bakedPie, $rawPie);
        $this->assertFalse($transitionResult->isSuccess());

        $this->assertCount(2, $transitionResult->getErrors());
        $this->assertInstanceOf('dicom\workflow\rules\error\IsRequiredRuleExecutionError', $transitionResult->getErrors()[0]);
        $this->assertInstanceOf('dicom\workflow\rules\error\IsReadOnlyRuleExecutionError', $transitionResult->getErrors()[1]);
    }

    /**
     * Пытаемся выполнить переход в статус, который не описан в конфиге
     *
     * @return false
     */
    public function testCookingDriedPie()
    {
        $rawPie = [
            'id' => 1,
            'stuffing' => 'cherry',
            'pastry' => 'yeast dough',
            'baking_time' => 0
        ];

        $driedPie = [
            'id' => 1,
            'pastry' => 'yeast dough',
            'stuffing' => 'cherry',
            'baking_time' => 50
        ];

        // при попытке перевести в неописанный статус выкидывается исключение
        try {
            $transitionResult = $this->engine->makeTransition('new', 'dried', $driedPie, $rawPie);
            $this->assertFalse($transitionResult->isSuccess());
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof WorkflowEngineException);
        }
    }

    /**
     * Переход между статусами, который не описан в конфиге
     *
     * @return false
     */
    public function testCookingNewPieFromBaked()
    {
        $rawPie = [
            'id' => 1,
            'stuffing' => 'cherry',
            'pastry' => 'yeast dough',
            'baking_time' => 0
        ];

        $bakedPie = [
            'id' => 1,
            'pastry' => 'yeast dough',
            'baking_time' => 50
        ];

        try {
            $transitionResult = $this->engine->makeTransition('baked', 'new', $rawPie, $bakedPie);
            $this->assertFalse($transitionResult->isSuccess());
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof WorkflowEngineException);
        }

    }
}