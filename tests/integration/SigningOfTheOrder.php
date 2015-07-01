<?php


namespace integration;


use dicom\workflow\config\WorkflowDescription;
use dicom\workflow\WorkflowEngine;

class SignatureingOfTheOrder extends \PHPUnit_Framework_TestCase
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

    public function testExpression()
    {
        $draftOrder = [
            'id' => 1,
            'title' => 'Приказ на выдачу шапок-ушанок',
            'description' => 'Приказываю всем выдать шапки-ушанки с целью предотвращения обморажения',
        ];

        $neworder = [
            'id' => 1,
            'title' => 'Приказ на выдачу шапок-ушанок',
            'description' => 'Приказываю всем выдать шапки-ушанки с целью предотвращения обморажения',
            'creationDate' => (new \DateTime())->format('Y-m-d'),
            'creatorSignature' => true
        ];

        $transition = $this->engine->makeTransition('draft', 'new', $neworder, $draftOrder);
        $this->assertTrue($transition->isSuccess());


    }
}