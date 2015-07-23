<?php
/**
 * Created by PhpStorm.
 * User: alsu
 * Date: 06.07.15
 * Time: 19:01
 */

namespace integration;

use dicom\workflow\building\config\WorkflowDescription;
use dicom\workflow\engine\rules\error\EqRuleExecutionError;
use dicom\workflow\engine\rules\error\GteRuleExecutionError;
use dicom\workflow\engine\rules\error\LteRuleExecutionError;
use dicom\workflow\engine\rules\error\NotBetweenRuleExecutionError;
use dicom\workflow\WorkflowEngine;

class RateOfBloodSugarTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Название конфиг файла
     *
     * @var string
     */
    private $configFile = '/configs/rateOfBloodSugar.json';

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
    public function testNormToNotNorm()
    {
        $norm = [
            'id' => 1,
            'sex' => 'man'
        ];

        $notNorm = [
            'id' => 1,
            'sex' => 'man',
            'fasting' => 3
        ];

        $transitionResult = $this->engine->makeTransition('norm', 'notNorm', $notNorm, $norm);
        $this->assertTrue($transitionResult->isSuccess());
    }

    /**
     * Возможности перевести из одного статуса в другой
     * неправильно передается норма сахара в крови, которая входит в пределы нормы
     *
     * @return false
     */
    public function testWrongNormToNotNorm()
    {
        $norm = [
            'id' => 1,
            'sex' => 'man'
        ];

        $notNorm = [
            'id' => 1,
            'sex' => 'man',
            'fasting' => 3.3
        ];

        $transitionResult = $this->engine->makeTransition('norm', 'notNorm', $notNorm, $norm);
        $this->assertFalse($transitionResult->isSuccess());
        $this->assertEquals(1, count($transitionResult->getErrors()));
        $this->assertInstanceOf(NotBetweenRuleExecutionError::class, $transitionResult->getErrors()[0]);
    }

    /**
     * Возможности перевести из одного статуса в другой
     * неправильно передается пол человека
     *
     * @return false
     */
    public function testWrongProperty()
    {
        $norm = [
            'id' => 1,
            'sex' => 'man'
        ];

        $notNorm = [
            'id' => 1,
            'sex' => 'woman',
            'fasting' => 3
        ];

        $transitionResult = $this->engine->makeTransition('norm', 'notNorm', $notNorm, $norm);
        $this->assertFalse($transitionResult->isSuccess());
        $this->assertEquals(1, count($transitionResult->getErrors()));
        $this->assertInstanceOf(EqRuleExecutionError::class, $transitionResult->getErrors()[0]);
    }

    /**
     * Возможности перевести из одного статуса в другой
     * все условия выполняются
     *
     * @return true
     */
    public function testNormToBelowNorm()
    {
        $norm = [
            'id' => 1,
            'sex' => 'man'
        ];

        $belowNorm = [
            'id' => 1,
            'sex' => 'man',
            'fasting' => 3
        ];

        $transitionResult = $this->engine->makeTransition('norm', 'belowNorm', $belowNorm, $norm);
        $this->assertTrue($transitionResult->isSuccess());
    }

    /**
     * Возможности перевести из одного статуса в другой
     * неправильно передается норма сахара в крови, которая входит в пределы нормы
     *
     * @return false
     */
    public function testWrongNormToBelowNorm()
    {
        $norm = [
            'id' => 1,
            'sex' => 'man'
        ];

        $belowNorm = [
            'id' => 1,
            'sex' => 'man',
            'fasting' => 3.3
        ];

        $transitionResult = $this->engine->makeTransition('norm', 'belowNorm', $belowNorm, $norm);
        $this->assertFalse($transitionResult->isSuccess());
        $this->assertEquals(1, count($transitionResult->getErrors()));
        $this->assertInstanceOf(LteRuleExecutionError::class, $transitionResult->getErrors()[0]);
    }

    /**
     * Возможности перевести из одного статуса в другой
     * все условия выполняются
     *
     * @return true
     */
    public function testNormToAboveNorm()
    {
        $norm = [
            'id' => 1,
            'sex' => 'man'
        ];

        $aboveNorm = [
            'id' => 1,
            'sex' => 'man',
            'fasting' => 5.6
        ];

        $transitionResult = $this->engine->makeTransition('norm', 'aboveNorm', $aboveNorm, $norm);
        $this->assertTrue($transitionResult->isSuccess());
    }

    /**
     * Возможности перевести из одного статуса в другой
     * неправильно передается норма сахара в крови, которая входит в пределы нормы
     *
     * @return false
     */
    public function testWrongNormToAboveNorm()
    {
        $norm = [
            'id' => 1,
            'sex' => 'man'
        ];

        $aboveNorm = [
            'id' => 1,
            'sex' => 'man',
            'fasting' => 5.5
        ];

        $transitionResult = $this->engine->makeTransition('norm', 'aboveNorm', $aboveNorm, $norm);
        $this->assertFalse($transitionResult->isSuccess());
        $this->assertEquals(1, count($transitionResult->getErrors()));
        $this->assertInstanceOf(GteRuleExecutionError::class, $transitionResult->getErrors()[0]);
    }
}
