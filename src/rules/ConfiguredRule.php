<?php


namespace dicom\workflow\rules;

use dicom\workflow\rules\exception\RuleConfigurationException;
use dicom\workflow\rules\RuleInterface\IConfiguredRule;

/**
 * Class ConfiguredRule
 *
 * For executing this rule config is required
 *
 *
 * @package dicom\workflow\rules
 */
abstract class ConfiguredRule extends Rule implements IConfiguredRule
{
    /**
     *
     * @var double
     */
    protected $config;

    public function __construct($config = null)
    {
        if (null !== $config) {
            $this->setConfig($config);
        }
    }


    /**
     * Set configuration
     *
     * @param mixed $config
     * @return $this
     */
    public function setConfig($config)
    {
        $this->validateConfig($config);
        $this->config = $config;
        return $this;
    }

    /**
     * Validate config
     *
     * must throw exception if config don`t valid
     *
     * @param $config
     * @return mixed
     */
    abstract protected function validateConfig($config);

    /**
     * Get configuration
     *
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param string $message error message
     * @param mixed $config config
     * @return RuleConfigurationException
     */
    protected function createConfigurationException($message, $config)
    {
        return new RuleConfigurationException(sprintf(
                'Configuration error for rule %s: ' . $message, ' .Config: %s',
                $this->getName(),
                var_export($config, true))
        );
    }

}