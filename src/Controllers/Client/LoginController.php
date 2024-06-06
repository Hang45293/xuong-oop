<?php

namespace Pc\XuongOop\Controllers\Client;

use Pc\XuongOop\Commons\Controller;
use Pc\XuongOop\Commons\Helper;
use Pc\XuongOop\Models\User;

class LoginController extends Controller
{
    public function showFormLogin(){

        $this->renderViewClient('login');       
    }

    public function login(){

        Helper::debug($_POST);     
    }
}