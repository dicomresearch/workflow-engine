<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 10/2/14
 * Time: 5:21 PM
 */

namespace dicom\workflow\rules;

use dicom\workflow\rules\RuleInterface\IRule;

/**
 * Class Attribute
 *
 * Параметры имеют аттрибуты, которые описывают правила, по которым будут валидироватсья значения сущностей
 *
 * @package modules\dicom\workflow\models
 */
abstract class Rule implements IRule
{
    /**
     * Возвращает имя правила
     *
     * @return string
     */
    public function getName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }

    public function getFullName()
    {
        return (new \ReflectionClass($this))->getName();
    }
} 