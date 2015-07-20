<?php


namespace dicom\workflow\engine\expressions;

class CurrentDateExpression implements ExpressionInterface
{
    /**
     * one of supported "DateTime::format()" format
     *
     * @var string
     */
    protected $outputFormat = 'Y-m-d';

    public function run()
    {
        $dateTime = new \DateTime('now');

        return $dateTime->format($this->outputFormat);
    }

    public function setConfig($config)
    {
        $this->outputFormat = $config['outputFormat'];
    }
}
