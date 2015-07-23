<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.12.14
 * Time: 12:35
 */

namespace dicom\workflow\engine\entity\property;

use dicom\workflow\engine\entity\property\executionResult\CompositePropertyExecutionResult;

/**
 * Class CompositeProperty
 *
 * Описывает свойство, представляющее из себя объект (entity),
 * который в свою очередь содержит вложеные свйоства
 *
 * @package dicom\workflow\entity\property
 */
class CompositeProperty extends Property
{
    /**
     * @var Property[]
     */
    protected $properties = [];

    /**
     * проверяет, что все правила данного свойства удовлетворены
     *
     * @param null|mixed $propertyNewValue новое значение аттрибута (например перед сохранением в базу данных)
     * @param null|mixed $propertyOldValue старое значение аттрибута (например причтении из базы)
     *
     * @return CompositePropertyExecutionResult
     */
    public function executeRules($propertyNewValue = null, $propertyOldValue = null)
    {
        $propertyExecutionResult = new CompositePropertyExecutionResult($this);

        foreach ($this->properties as $subProperty) {
            $subPropertyExecutionResult = $subProperty->executeRules(
                (isset($propertyNewValue[$subProperty->getName()]) ? $propertyNewValue[$subProperty->getName()] : null),
                (isset($propertyOldValue[$subProperty->getName()]) ? $propertyOldValue[$subProperty->getName()] : null)
            );

            $propertyExecutionResult->addSubPropertyResult($subPropertyExecutionResult);
        }

        return $propertyExecutionResult;
    }

    /**
     * app sub property
     *
     * @param Property $property
     */
    public function addProperty(Property $property)
    {
        $this->properties[$property->getName()] = $property;
    }

    /**
     * Get list of properties
     *
     * @return Property[]
     */
    public function getProperties()
    {
        return $this->properties;
    }
}
