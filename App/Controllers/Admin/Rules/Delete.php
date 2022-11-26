<?php

/**
 * @package SDWPRM
 */

namespace App\Controllers\Admin\Rules;

use App\Base\Controller;

class Delete extends Controller
{
    public function post (){
        return wp_redirect ($this->route ('rules'));
    }
}
