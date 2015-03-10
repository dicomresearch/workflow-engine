<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 18.11.14
 * Time: 17:05
 */

namespace dicom\workflow\visitor\state\entity\property;


use dicom\workflow\entity\property\CompositeProperty;
use dicom\workflow\entity\property\Property;
use dicom\workflow\visitor\state\entity\property\rule\AbstractRuleVisitor;

/**
 * Class GettingInsidePropertyVisitor
 *
 * Визитор, посещающий свойства и проходящий по всем ее правилам
 *
 * @package dicom\workflow\visitor\state\entity\property
 */
class GettingInsidePropertyVisitor extends AbstractPropertyVisitor
{
    /**
     * @var AbstractRuleVisitor
     */
    protected $ruleVisitor;


    /**
     * Посетить свойство
     *
     * @param Property $property
     * @return array
     */
    public function visit(Property $property)
    {
        return $this->visitRuleValidatorToEachRule($property);
    }

    /**
     * Сводить Rule валидатор в каждое правило
     *
     * @param Property $property
     * @return array
     */
    protected function visitRuleValidatorToEachRule(Property $property)
    {
        $result = [];
        if ($property instanceof CompositeProperty) {
            foreach ($property->getProperties() as $subProperty) {
                $result[$subProperty->getName()] = $this->visit($subProperty);
            }
        } else {
            foreach ($property->getRules() as $rule) {
                $result[$rule->getName()] = $this->getRuleVisitor($rule)->visit($rule);
            }
        }
        return $result;
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



} 