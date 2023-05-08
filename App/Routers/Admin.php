<?php

/**
 * @package SWPRM
 */

namespace SWPRM\Routers;

use SWPRM\Base\Controller;
use SWPRM\Controllers\Admin\Error404;
use SWPRM\Controllers\Admin\Settings;
use SWPRM\Controllers\Admin\Rules\Index as RulesIndex;
use SWPRM\Controllers\Admin\Rules\Edit as RulesEdit;
use SWPRM\Controllers\Admin\Rules\Create as RulesCreate;
use SWPRM\Controllers\Admin\Rules\Delete as RulesDelete;

class Admin extends Controller
{
    public function routes()
    {
        return [
            'rules' => [
                [
                    'action' => 'index',
                    'class' => RulesIndex::class,
                    'methods' => ['get'],
                ],
                [
                    'action' => 'create',
                    'class' => RulesCreate::class,
                    'methods' => ['get', 'post'],
                ],
                [
                    'action' => 'edit',
                    'class' => RulesEdit::class,
                    'methods' => ['get', 'post'],
                ],
                [
                    'action' => 'delete',
                    'class' => RulesDelete::class,
                    'methods' => ['post'],
                ],
            ],
            'error_404' => [
                [
                    'action' => 'index',
                    'class' => Error404::class,
                    'methods' => ['get'],
                ],
            ],
            'settings' => [
                [
                    'action' => 'index',
                    'class' => Settings::class,
                    'methods' => ['get', 'post'],
                ],
            ],
        ];
    }
}
