<?php

namespace Pc\XuongOop\Controllers\Client;

use Pc\XuongOop\Commons\Controller;
use Pc\XuongOop\Commons\Helper;
use Pc\XuongOop\Models\User;

class HomeController extends Controller
{
    public function index(){

        // $user =new User();

        // Helper::debug($user);

        $name ='Thu Hằng';
        $this->renderViewClient('home', [
            'name' => $name
        ]);       
    }
}