<?php


namespace unit\rules;


class EquallyRuleTest extends \PHPUnit_Framework_TestCase
{

    public function trueDataProvider()
    {
        return [
            [1, 1],
            [0, 0],
            [2.3, 2.3],
            ['string', 'string'],
            [ [1,2,3], [1,2,3] ],
            [null, null],
        ];
    }

    public function falseDataProvider()
    {
        return [
            [0, 1],
            [2.3, 5.3],
            ['string', 'arg'],
            [ [1,2,3], [9,7,6] ],
            [null, 2],
        ];
    }

    /**
     *
     * @param $x
     * @param $y
     *
     * @dataProvider trueDataProvider
     */
    public function testTrue($x, $y)
    {
        $this->assertEquals($x, $y);
    }

    /**
     * @param $x
     * @param $y
     *
     * @dataProvider falseDataProvider
     */
    public function testFalse($x, $y)
    {
        $this->assertNotEquals($x, $y);
    }

}
