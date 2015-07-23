<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.10.14
 * Time: 14:56
 */

namespace dicom\workflow\engine\rules;

use dicom\workflow\engine\rules\error\AlwaysFalseRuleExecutionError;
use dicom\workflow\engine\rules\executionResult\RuleExecutionResult;
use dicom\workflow\building\rules\RuleInterface\IRuleCheckingWithoutArguments;

/**
 * Class AlwaysFalseRule
 *
 * Правило, возврщающее при проверка всегда false
 * Нужно для тестирования в первую очередь
 *
 * @package dicom\workflow\models\entity\property\rule
 */
class AlwaysFalseRule extends RuleCheckingWithoutArguments implements IRuleCheckingWithoutArguments
{
    private $hasBeenChecked = false;


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
     * @return bool
     */
    protected function isValid()
    {
        $this->hasBeenChecked = true;
        return false;
    }

    /**
     * Создать Exception, описывающий ошибку проверки
     *
     * @return AlwaysFalseRuleExecutionError
     */
    protected function constructValidationError()
    {
        return AlwaysFalseRuleExecutionError::create();
    }


    public function hasBeenChecked()
    {
        return $this->hasBeenChecked;
    }
}
