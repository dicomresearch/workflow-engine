<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.10.14
 * Time: 16:19
 */

namespace workflow\config\exception;


use Ddeboer\Imap\Exception\Exception;
use workflow\config\WorkflowDescription;

class WorkflowConfigurationException extends Exception
{
    public static function mustContainsStates()
    {
        return new static('WorkflowDescription must contains "' . WorkflowDescription::STATES .'" section');
    }

    public static function mustContainsTransitions()
    {
        return new static('WorkflowDescription must contains "' . WorkflowDescription::TRANSITIONS .'" section');
    }

    public static function ConfigIsNull()
    {
        return new static('Workflow description must be not null');
    }

    public static function JsonNotParsed($jsonError)
    {
        return new static('workflow description is not valid json. Parse error: ' . $jsonError);
    }
} 