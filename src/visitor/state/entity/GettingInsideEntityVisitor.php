<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 18.11.14
 * Time: 17:18
 */

namespace dicom\workflow\visitor\state\entity;


use dicom\workflow\entity\Entity;
use dicom\workflow\visitor\state\entity\property\AbstractPropertyVisitor;

/**
 * Class GettingInsideEntityVisitor
 *
 * Визитор, проходящийся по свойствам Entity
 *
 * @package dicom\workflow\visitor\state\entity
 */
class GettingInsideEntityVisitor extends AbstractEntityVisitor
{
    /**
     * @var AbstractPropertyVisitor
     */
    protected $propertyVisitor;

    /**
     * Посетить entity
     *
     * @param Entity $entity
     * @return array
     */
    public function visit(Entity $entity)
    {
        return $this->visitPropertyValidatorIntoEntity($entity);
    }

    /**
     * Посетить все Property ентити
     *
     * @param Entity $entity
     * @return array
     */
    public function visitPropertyValidatorIntoEntity(Entity $entity)
    {
        $result = [];
        foreach ($entity->getProperties() as $property) {
            $result[$property->getName()] = $this->getPropertyVisitor()->visit($property);
        }

        return $result;
    }

    /**
     * @return AbstractPropertyVisitor
     */
    public function getPropertyVisitor()
    {
        return $this->propertyVisitor;
    }

    /**
     * @param AbstractPropertyVisitor $propertyVisitor
     */
    public function setPropertyVisitor($propertyVisitor)
    {
        $this->propertyVisitor = $propertyVisitor;
    }




} 