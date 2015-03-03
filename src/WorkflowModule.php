<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 10/2/14
 * Time: 5:56 PM
 */

//namespace workflow;


class WorkflowModule extends \WebModule
{
    public function init()
    {
        $this->setImport([
            'protocol.models.*',
            'protocol.models.entity.*',
            'protocol.models.attributes.*',
            'protocol.components.*',
        ]);
    }
} 