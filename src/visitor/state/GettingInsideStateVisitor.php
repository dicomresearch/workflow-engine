<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 18.11.14
 * Time: 17:25
 */

namespace workflow\visitor\state;


use workflow\state\State;
use workflow\visitor\state\entity\AbstractEntityVisitor;

/**
 * Class GettingInsideStateVisitor
 *
 * Визитор, который передает действие visit EntityVisitor'у
 *
 * @package workflow\visitor\state
 */
class GettingInsideStateVisitor extends AbstractStateVisitor
{
    /**
     * @var AbstractEntityVisitor
     */
    protected $entityVisitor;

    public function visit(State $state)
    {
        return $this->getEntityVisitor()->visit($state->getEntity());
    }

    /**
     * @return AbstractEntityVisitor
     */
    public function getEntityVisitor()
    {
        return $this->entityVisitor;
    }

    /**
     * @param AbstractEntityVisitor $entityVisitor
     */
    public function setEntityVisitor($entityVisitor)
    {
        $this->entityVisitor = $entityVisitor;
    }



} 