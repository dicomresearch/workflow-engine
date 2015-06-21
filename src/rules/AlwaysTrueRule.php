<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.10.14
 * Time: 14:42
 */

namespace dicom\workflow\rules;
use dicom\workflow\rules\exception\RuleExecutionException;
use dicom\workflow\rules\executionResult\RuleExecutionResult;
use dicom\workflow\rules\RuleInterface\IRuleCheckingWithoutArguments;

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
    protected function constructValidationException()
    {
        $e = new RuleExecutionException('You never been saw this exception. This rule always true');
        $e->setHumanFriendlyMessage('You never been saw this exception. This rule always true');
        return $e;
    }


} 