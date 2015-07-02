<?php


namespace integration;


use dicom\workflow\config\WorkflowDescription;
use dicom\workflow\rules\error\LteRuleExecutionResult;
use dicom\workflow\rules\exception\RuleExecutionException;
use dicom\workflow\WorkflowEngine;

class SigningOfTheOrderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Название конфиг файла
     *
     * @var string
     */
    private $configFile = '/configs/Signing of the order.json';

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
     * Its tests using expressions.
     */
    public function testExpressionDateNow()
    {
        $draftOrder = [
            'id' => 1,
            'title' => 'Приказ на выдачу шапок-ушанок',
            'description' => 'Приказываю всем выдать шапки-ушанки с целью предотвращения обморажения',
        ];

        $newOrder = [
            'id' => 1,
            'title' => 'Приказ на выдачу шапок-ушанок',
            'description' => 'Приказываю всем выдать шапки-ушанки с целью предотвращения обморажения',
            'creationDate' => (new \DateTime('now'))->format('Y-m-d'),
            'creatorSignature' => true
        ];

        $transition = $this->engine->makeTransition('draft', 'new', $newOrder, $draftOrder);
        $this->assertTrue($transition->isSuccess());
    }

    /**
     * Its tests using expressions.
     * Order creation date can't be "tomorrow"
     */
    public function testExpressionDateTomorrow()
    {
        $draftOrder = [
            'id' => 1,
            'title' => 'Приказ на выдачу шапок-ушанок',
            'description' => 'Приказываю всем выдать шапки-ушанки с целью предотвращения обморажения',
        ];

        $newOrder = [
            'id' => 1,
            'title' => 'Приказ на выдачу шапок-ушанок',
            'description' => 'Приказываю всем выдать шапки-ушанки с целью предотвращения обморажения',
            'creationDate' => (new \DateTime('tomorrow'))->format('Y-m-d'),
            'creatorSignature' => true
        ];

        $transition = $this->engine->makeTransition('draft', 'new', $newOrder, $draftOrder);
        
        $this->assertFalse($transition->isSuccess());
        $this->assertCount(1, $transition->getErrors());

        $ruleExecutionError = $transition->getErrors()[0];
        $this->assertInstanceOf(LteRuleExecutionResult::class, $ruleExecutionError);
        $this->assertEquals('creationDate', $ruleExecutionError->getPropertyName());
    }
}