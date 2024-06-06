<?php

namespace Pc\XuongOop\Controllers\Admin;

use Pc\XuongOop\Commons\Controller;
use Pc\XuongOop\Commons\Helper;

class DashboardController extends Controller
{
    public function dashboard() {        
        $this->renderViewAdmin(__FUNCTION__);
    }
}