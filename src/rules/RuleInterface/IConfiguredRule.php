<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 26.01.15
 * Time: 14:28
 */

namespace dicom\workflow\rules\RuleInterface;

/**
 * Interface ConfiguredRule
 *
 * Rule must configured on instance before using
 *
 * @package dicom\workflow\rules\RuleInterface
 */
interface IConfiguredRule
{
    /**
     * Set configuration
     *
     * @param mixed $config
     * @return mixed
     */
    public function setConfig($config);

    /**
     * Get configuration
     *
     * @return mixed
     */
    public function getConfig();
}