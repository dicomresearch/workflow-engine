<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 26.01.15
 * Time: 21:45
 */

namespace workflow\rules\RuleInterface;

/**
 * Interface IRule
 *
 * base interface for Rules
 *
 * @package workflow\rules\RuleInterface
 */
interface IRule
{

    /**
     * Return short (without namespace) class name
     *
     * @return string
     */
    public function getName();

    /**
     * Return full (with namespace) class name
     *
     * @return string
     */
    public function getFullName();
}