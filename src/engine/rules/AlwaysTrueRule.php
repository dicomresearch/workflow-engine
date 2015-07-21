<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.10.14
 * Time: 14:42
 */

namespace dicom\workflow\engine\rules;

use dicom\workflow\engine\rules\error\AlwaysTrueRuleExecutionError;
use dicom\workflow\engine\rules\executionResult\RuleExecutionResult;

/**
 * Class AlwaysTrueRule
 *
 * Правило, возврщающее при проверка всегда true
 * Нужно для тестирования в первую очередь
 *
 * @package dicom\workflow\models\entity\property\rule
 */
class AlwaysTrueRule extends RuleCheckingWithoutArguments
{
    private $hasBeenChecked = false;

    public function hasBeenChecked()
    {
        return $this->hasBeenChecked;
    }

    /**
     * проверяет соответсвует ли значение сущности условиям аттрибута
     *
     * @return RuleExecutionResult
     *
     */
    public function execute()
    {
        $this->hasBeenChecked = true;
        return parent::execute();
    }

    /**
     * Проверить удовлятеворяют ли переданые значения правилу
     *
     * @return mixed
     */
    protected function isValid()
    {
        return true;
    }

    /**
     * Создать Exception, описывающий ошибку проверки
     *
     * @return mixed
     */
    protected function constructValidationError()
    {
        return AlwaysTrueRuleExecutionError::create();
    }
}
