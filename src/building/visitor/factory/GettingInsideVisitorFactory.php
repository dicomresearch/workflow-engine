<?php

namespace dicom\workflow\building\visitor\factory;

use dicom\workflow\building\visitor\factory\exceptions\GettingInsideFactoryException;
use dicom\workflow\engine\visitor\state\entity\GettingInsideEntityVisitor;
use dicom\workflow\engine\visitor\state\entity\property\GettingInsidePropertyVisitor;
use dicom\workflow\engine\visitor\state\entity\property\rule\AbstractRuleVisitor;
use dicom\workflow\engine\visitor\state\GettingInsideStateVisitor;

/**
 * Class GettingInsideVisitorFactory
 *
 * Визиторы представляют четкую иерархию, соответсвующую иерархии классов state->entity->property->rule
 *
 * Фабрика, позволяющая конструировать иерархию визиторов.
 * По умолчанию все визиторы, кроме Rule заполянются GettingInside...Visitor
 *
 * Необходимо указать какой визитор будет использоваться для Rule
 *
 *
 * @package dicom\workflow\visitor\factory
 */
class GettingInsideVisitorFactory
{
    /**
     * @var GettingInsideStateVisitor
     */
    protected $stateVisitor;

    /**
     * @var GettingInsideEntityVisitor
     */
    protected $entityVisitor;

    /**
     * @var GettingInsidePropertyVisitor
     */
    protected $propertyVisitor;

    /**
     * @var AbstractRuleVisitor
     */
    protected $ruleVisitor;

    public function __construct(AbstractRuleVisitor $ruleVisitor)
    {
        $this->fillDefaultVisitors();

        $this->setRuleVisitor($ruleVisitor);
    }

    /**
     * Задать визиторов по умолчанию
     */
    protected function fillDefaultVisitors()
    {
        $this->setStateVisitor(new GettingInsideStateVisitor());
        $this->setEntityVisitor(new GettingInsideEntityVisitor());
        $this->setPropertyVisitor(new GettingInsidePropertyVisitor());
    }

    /**
     * Проверим что все Визиторы определены
     *
     * @throws GettingInsideFactoryException
     */
    protected function validateFactory()
    {
        if (is_null($this->getStateVisitor())) {
            throw GettingInsideFactoryException::visitorMystBeDefined('EntityVisitor');
        }

        if (is_null($this->getEntityVisitor())) {
            throw GettingInsideFactoryException::visitorMystBeDefined('EntityVisitor');
        }

        if (is_null($this->getPropertyVisitor())) {
            throw GettingInsideFactoryException::visitorMystBeDefined('PropertyVisitor');
        }

        if (is_null($this->getRuleVisitor())) {
            throw GettingInsideFactoryException::visitorMystBeDefined('RuleVisitor');
        }
    }

    /**
     * Создать иерархию визиторов, в самом низу которой будет StateVisitor
     *
     * @return GettingInsideStateVisitor
     */
    public function createStateVisitor()
    {
        $this->validateFactory();

        $this->getStateVisitor()->setEntityVisitor($this->getEntityVisitor());
        $this->getEntityVisitor()->setPropertyVisitor($this->getPropertyVisitor());
        $this->getPropertyVisitor()->setRuleVisitor($this->getRuleVisitor());

        return $this->getStateVisitor();
    }

    /**
     * @return GettingInsideEntityVisitor
     */
    public function getEntityVisitor()
    {
        return $this->entityVisitor;
    }

    /**
     * @param GettingInsideEntityVisitor $entityVisitor
     */
    public function setEntityVisitor($entityVisitor)
    {
        $this->entityVisitor = $entityVisitor;
    }

    /**
     * @return GettingInsidePropertyVisitor
     */
    public function getPropertyVisitor()
    {
        return $this->propertyVisitor;
    }

    /**
     * @param GettingInsidePropertyVisitor $propertyVisitor
     */
    public function setPropertyVisitor($propertyVisitor)
    {
        $this->propertyVisitor = $propertyVisitor;
    }

    /**
     * @return AbstractRuleVisitor
     */
    public function getRuleVisitor()
    {
        return $this->ruleVisitor;
    }

    /**
     * @param AbstractRuleVisitor $ruleVisitor
     */
    public function setRuleVisitor($ruleVisitor)
    {
        $this->ruleVisitor = $ruleVisitor;
    }

    /**
     * @return GettingInsideStateVisitor
     */
    public function getStateVisitor()
    {
        return $this->stateVisitor;
    }

    /**
     * @param GettingInsideStateVisitor $stateVisitor
     */
    public function setStateVisitor($stateVisitor)
    {
        $this->stateVisitor = $stateVisitor;
    }
}
