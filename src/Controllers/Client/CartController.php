<?php

namespace Pc\XuongOop\Controllers\Client;

use Pc\XuongOop\Commons\Controller;
use Pc\XuongOop\Commons\Helper;
use Pc\XuongOop\Models\Cart;
use Pc\XuongOop\Models\CartDetail;
use Pc\XuongOop\Models\Product;
use Pc\XuongOop\Models\User;





class CartController extends Controller
{
    private Product $product;
    private Cart $cart;
    private CartDetail $cartDetail;

    public function __construct()
    {
        $this->product = new Product();
        $this->cart = new Cart();
        $this->cartDetail = new CartDetail();
    }

    public function add()
    { // Thêm vào giỏ hàng

        // $conn = $this->cart->getConnection();
        // Helper::debug($conn);
        // Lấy thông tin sản phẩm theo id

        $product = $this->product->findByID($_GET['productID']);

        // Khởi tạo SESSION trong giỏ hàng(cart)
        // Check xem nó đang đăng nhập hay không
        $key = 'cart';
        if (isset($_SESSION['user'])) {
            $key .= '-' . $_SESSION['user']['id'];
        }

        if (!isset($_SESSION[$key][$product['id']])) {


            $_SESSION[$key][$product['id']] = $product + ['quantity' => $_GET['quantity'] ?? 1];

        } else {

            $_SESSION[$key][$product['id']]['quantity'] += $_GET['quantity'];

        }


        // Nếu mà nó đăng nhập thì mình phải lưu nó vào csdl

        if (isset($_SESSION['user'])) {

            $conn = $this->cart->getConnection();

            $conn->beginTransaction();
            try {

                $cart = $this->cart->findByUserID($_SESSION['user']['id']);

                if (empty($cart)) {
                    $this->cart->insert([
                        'user_id' => $_SESSION['user']['id']
                    ]);
                }

                $cartID = $cart['id'] ?? $conn->lastInsertId();

                $_SESSION['cart_id'] = $cartID;
                $this->cartDetail->deleteByCartID($cartID);
                foreach ($_SESSION[$key] as $productID => $item) {
                    $this->cartDetail->insert([
                        'cart_id' => $cartID,
                        'product_id' => $productID,
                        'quantity' => $item['quantity']
                    ]);
                }

                // $conn->commit();
            } catch (\Throwable $th) {
                echo $th->getMessage();
                die;
                // throw $th;
                // $conn->rollBack();
            }
        }

        header('Location: ' . url('cart/detail'));
        exit;
    }

    public function detail()
    {
        // Chi tiết giỏ hàng
        $this->renderViewClient('cart');
    }

    public function quantityInc()
    {
        // Tăng số lượng sản phẩm
        // Lấy ra dữ liệu từ cart_details để đảm bảo nó có tồn tại bản ghi

        // Thay đổi trong SESSION
        $key = 'cart';
        if (isset($_SESSION['user'])) {
            $key .= '-' . $_SESSION['user']['id'];
        }


        $_SESSION[$key][$_GET['productID']]['quantity'] += 1;

        // Helper::debug($_SESSION[$key][$_GET['productID']]);  
        // Thay đổi trong Database
        if (isset($_SESSION['user'])) {
            $this->cartDetail->updateByCartIDAndProductID(
                $_GET['cartID'],
                $_GET['productID'],
                $_SESSION[$key][$_GET['productID']]['quantity']
            );
        }

        header('Location: ' . url('cart/detail'));
        exit;
    }

    public function quantityDec()
    {
        // Giảm số lượng
        // Lấy ra dữ liệu từ cart_details để đảm bảo nó có tồn tại bản ghi

        // Thay đổi trong SESSION
        $key = 'cart';
        if (isset($_SESSION['user'])) {
            $key .= '-' . $_SESSION['user']['id'];
        }

        if ($_SESSION[$key][$_GET['productID']]['quantity'] > 1) {
            $_SESSION[$key][$_GET['productID']]['quantity'] -= 1;
        }

        // Thay đổi trong Database
        if (isset($_SESSION['user'])) {
            $this->cartDetail->updateByCartIDAndProductID(
                $_GET['cartID'],
                $_GET['productID'],
                $_SESSION[$key][$_GET['productID']]['quantity']
            );
        }

        header('Location: ' . url('cart/detail'));
        exit;
    }

    public function remove()
    {
        // Xóa item , xóa trắng
        $key = 'cart';
        if (isset($_SESSION['user'])) {
            $key .= '-' . $_SESSION['user']['id'];
        }

        unset($_SESSION[$key][$_GET['productID']]);

        if (isset($_SESSION['user'])) {
            $this->cartDetail->deleteByCartIDAndProductID($_GET['cartID'], $_GET['productID']);
        }

        header('Location: ' . url('cart/detail'));
        exit;
    }
}