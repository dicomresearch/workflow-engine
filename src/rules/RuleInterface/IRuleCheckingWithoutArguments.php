<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 26.01.15
 * Time: 21:35
 */

namespace dicom\workflow\rules\RuleInterface;

/**
 * Interface IRuleCheckingWithoutArguments
 *
 * don't need arguments for rule checking
 *
 * @package dicom\workflow\rules\RuleInterface
 */
interface IRuleCheckingWithoutArguments extends IRule
{
    /**
     * @return mixed
     */
    public function execute();
}