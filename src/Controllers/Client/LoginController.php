<?php

namespace Pc\XuongOop\Controllers\Client;

use Pc\XuongOop\Commons\Controller;
use Pc\XuongOop\Commons\Helper;
use Pc\XuongOop\Models\User;
use Rakit\Validation\Rules\Url;



class LoginController extends Controller
{
    private User $user;
    public function __construct()
    {
        $this->user = new User();
    }
    public function showFormLogin()
    {
        auth_check();
        $this->renderViewClient('login');
    }

    public function login()
    {
        auth_check();
        try {

            $user = $this->user->findByEmail($_POST['email']);

            if (empty($user)) {
                throw new \Exception('Không Tồn Tại Email : ' . $_POST['email']);
            }

            $flag = password_verify($_POST['password'], $user['password']);

            if ($flag) {

                $_SESSION['user'] = $user;

                unset($_SESSION['cart']);

                if ($user['type'] == 'admin') {
                    header('Location: ' . url('admin/'));
                    exit;
                }

                header('Location: ' . url(''));
                exit;
            }
            // Helper::debug($user);
            throw new \Exception('Password không đúng rồi');
        } catch (\Throwable $th) {
            $_SESSION['error'] = $th->getMessage();

            header("Location: " . url('login'));

            exit;
        }
    }


    public function logout()
    {
        unset($_SESSION['cart-' . $_SESSION['user']['id']]);

        unset($_SESSION['user']);

        header("Location: " . url(''));
    }
}

