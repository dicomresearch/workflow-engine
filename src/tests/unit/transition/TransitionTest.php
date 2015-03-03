<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 30.01.15
 * Time: 11:43
 */

namespace workflow\tests\unit\transition;


use workflow\transition\Transition;
use workflow\transition\TransitionSpecification;

class TransitionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $transition = new Transition();
        $transition->addTransitionRuleExecutionResult($rulesExecutionResult);
    }

    public function testGetActions()
    {
        $transition = new Transition();
        $transition->getActions();
    }

    /**
     * test getting all errors (transition and states)
     */
    public function testGetErrors()
    {
        $transition = new Transition();
        $transition->getErrors();
    }

    public function testGetErrorForProperty()
    {
        $transition = new Transition();
        $transition->getPropperty($propertyName)->getErrors();
    }


}
