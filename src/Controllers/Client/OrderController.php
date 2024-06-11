<?php

namespace Pc\XuongOop\Controllers\Client;

use Pc\XuongOop\Commons\Controller;
use Pc\XuongOop\Models\Cart;
use Pc\XuongOop\Models\CartDetail;
use Pc\XuongOop\Models\Order;
use Pc\XuongOop\Models\OrderDetail;
use Pc\XuongOop\Models\User;

class OrderController extends Controller
{    
    public User $user;
    public Order $order;
    public OrderDetail $orderDetail;
    private Cart $cart;
    private CartDetail $cartDetail;
    
    public function __construct()
    {
        $this->user         = new User();
        $this->order        = new Order();
        $this->orderDetail  = new OrderDetail();
        $this->cart         = new Cart();
        $this->cartDetail   = new CartDetail();
    }

    public function checkout() {
        // Chưa đăng nhập thì fai tạo tài khoản
        $userID = $_SESSION['user']['id'] ?? null;
        if (! $userID) {
            $conn = $this->user->getConnection();

            $this->user->insert([
                'name' => $_POST['user_name'],
                'email' => $_POST['user_email'],
                'password' => password_hash($_POST['user_email'], PASSWORD_DEFAULT),
                'type' => 'member',
                'is_active' => 0,
            ]);

            $userID = $conn->lastInsertId();
        }

        // Thêm dữ liệu vào Order và OrderDetail
        $conn = $this->order->getConnection();
        $this->order->insert([
            'user_id' => $userID,
            'user_name' => $_POST['user_name'],
            'user_email' => $_POST['user_email'],
            'user_phone' => $_POST['user_phone'],
            'user_address' => $_POST['user_address'],
        ]);

        $orderID = $conn->lastInsertId();

        $key = 'cart';
        if (isset($_SESSION['user'])) {
            $key .= '-' . $_SESSION['user']['id'];
        }

        foreach ($_SESSION[$key] as $productID => $item) {
            $this->orderDetail->insert([
                'order_id' => $orderID,
                'product_id' => $productID,
                'quantity' => $item['quantity'],
                'price_regular' => $item['price_regular'],
                'price_sale' => $item['price_sale'],
            ]);
        }

        // Xóa dữ liệu trong Cart + CartDetail theo CartID - $_SESSION['cart_id']

        // Xóa trong SESSION
        unset($_SESSION[$key]);

        if (isset($_SESSION['user'])) {
            unset($_SESSION['cart_id']);
        }

        header('Location: ' . url());
        exit;
    }
}