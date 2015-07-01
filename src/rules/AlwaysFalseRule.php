<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.10.14
 * Time: 14:56
 */

namespace dicom\workflow\rules;
use dicom\workflow\rules\exception\RuleExecutionError;
use dicom\workflow\rules\executionResult\RuleExecutionResult;
use dicom\workflow\rules\RuleInterface\IRuleCheckingWithoutArguments;

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
     * @return RuleExecutionError
     */
    protected function constructValidationException()
    {
        $e = new RuleExecutionError('This rule is always return false');
        $e->setHumanFriendlyMessage('This rule is always return false');
        return $e;
    }


    public function hasBeenChecked()
    {
        return $this->hasBeenChecked;
    }
} 