<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.10.14
 * Time: 15:09
 */

namespace dicom\workflow\rules\exception;


/**
 * Class RuleException
 *
 * Ошибка валидации. Это не Exception, это ошибка, говорящая о том, аттрибут не прошел какое-то правило валидации
 *
 */
class RuleExecutionException extends RuleException
{
    protected $humanFriendlyMessage;

    protected $propertyName;

    /**
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($message = '', $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->humanFriendlyMessage = $message;
    }


    /**
     * @return string
     */
    public function getHumanFriendlyMessage()
    {
        return $this->humanFriendlyMessage;
    }

    /**
     * @param string $humanFriendlyMessage
     */
    public function setHumanFriendlyMessage($humanFriendlyMessage)
    {
        $this->humanFriendlyMessage = $humanFriendlyMessage;
    }

    /**
     * @return string
     */
    public function getPropertyName()
    {
        return $this->propertyName;
    }

    /**
     * @param string $propertyName
     */
    public function setPropertyName($propertyName)
    {
        $this->propertyName = $propertyName;
    }




} 