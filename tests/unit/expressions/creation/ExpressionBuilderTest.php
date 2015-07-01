<?php


namespace unit\expressions\creation;



use dicom\workflow\expressions\creation\ExpressionBuilder;

class ExpressionBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildByShortConfig()
    {
        $config = ['expr' => 'currentDate'];

        $expression = ExpressionBuilder::buildExpression($config);

        $this->assertInstanceOf('dicom\workflow\expressions\CurrentDateExpression', $expression);
    }

    public function testBuildByExtendedConfig()
    {
        (new \DateTime())->format('Y-m-d');
        $config = [
            'expr' =>
                ['name' => 'currentDate'],
            ];

        $expression = ExpressionBuilder::buildExpression($config);

        $this->assertInstanceOf('dicom\workflow\expressions\CurrentDateExpression', $expression);
    }

    public function testShortToExtendedConfig()
    {
        $shortConfig = ['expr' => 'currentDate'];
        $actualExtendedConfig = ExpressionBuilder::toExtendedConfig($shortConfig);

        $correctExtendedConfig =
            [
                'expr' => [
                    'name' => 'currentDate'
            ]
        ];

        $this->assertEquals($correctExtendedConfig, $actualExtendedConfig);
    }

    public function testExtendedToExtendedConfig()
    {
        $defaultExtendedConfig =
            [
                'expr' => [
                    'name' => 'currentDate'
                ]
            ];
        $actualExtendedConfig = ExpressionBuilder::toExtendedConfig($defaultExtendedConfig);

        $this->assertEquals($defaultExtendedConfig, $actualExtendedConfig);
    }
}
