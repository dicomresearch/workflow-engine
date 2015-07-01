<?php


namespace dicom\workflow\rules;

use dicom\workflow\expressions\ExpressionInterface;
use dicom\workflow\rules\exception\RuleConfigurationException;
use dicom\workflow\rules\RuleInterface\IConfiguredRule;

/**
 * Trait ConfiguredRule
 *
 * For executing this rule config is required
 *
 *
 * @package dicom\workflow\rules
 */
trait ConfiguredRule
{
    /**
     *
     * @var mixed
     */
    protected $config;

    public function __construct($config = null)
    {
        if (null !== $config) {
            $this->setConfig($config);
        }
    }

    /**
     * get a value from config
     *
     * @return mixed
     */
    public function getConfiguredValue()
    {
        if (is_array($this->config) && array_key_exists('value', $this->config['value'])) {
            $value = $this->config['value'];
        } else {
            $value = $this->config;
        }

        if ($value instanceof ExpressionInterface) {
            $value = $value->run();
        }

        return $value;
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
    protected function validateConfig($config)
    {
        if ($config instanceof ExpressionInterface) {
            return true;
        }

        return false;
    }

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