<?php
session_start();
require_once './models/function.php';

$url = isset($_GET['url']) ? $_GET['url']: "home";

switch ($url) {
    case 'register':
        if(isset($_POST['submit'])){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // kiểm tra name
            if(strlen($name) > 10){
                $error_name ="name không được quá 10 kí tự";
                require_once "./views/register/register.php";
                return;
            }
            if(empty($name)){
                $empty_name = "Name không được bỏ trống";
                require_once "./views/register/register.php";
                return;
            }

            // kiểm tra email
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $error_email ="Email không hợp lễ";
                require_once "./views/register/register.php";
                return;
            }
            if(empty($email)){
                $empty_email = "Email không được bỏ trống";
                require_once "./views/register/register.php";
                return;
            }
         
            // kiểm tra password
            if(!preg_match("/[!@#$%^&*(),.?\":{}|<>]/", $password)){
                $error_password = "Password phải chứa ít nhất 1 kí tự đặc biệt";
                require_once "./views/register/register.php";
                return;
            }
            if(empty($password)){
                $empty_password = "Password không được bỏ trống";
                require_once "./views/register/register.php";
                return;
            }
           
            // Xử lý email đã tồn tại hay không
            $check = "SELECT * FROM user WHERE email = '$email'";
            $result_check = first($check);
            if($result_check){
                $error_null = "Email đã tồn tại, thử email khác" ;
                require_once "./views/register/register.php";
                return;
            }

            // Tiếp tục tạo user nếu không có lỗi
            $sql = "INSERT INTO user(name,email,password) VALUES ('$name','$email','$password')";
            executesql($sql);
            header("location:index.php?url=login");
        }
        else{
            require_once "./views/register/register.php";
           
        }
        break;
    case 'login':
        if(isset($_SESSION['user'])){
            header("location:index.php?url=home;");/// 
        }
        if(isset($_POST['login'])){
            $name = $_POST['name'];
            $password = $_POST['password'];
            $sql = "select * from user where name = '$name' and password = '$password'";
            $user = first($sql);
            if($user){
                // login thành công
                $_SESSION['user'] = $user;
                header("location:index.php?url=home");
            }else{
                $errors = "đăng nhập thông tin không chính xác";
               require_once './views/login/login.php';
            }
        }else{
            require_once './views/login/login.php';
        }
        break;
    case 'logout':
            if(isset($_SESSION['user'])){
                unset($_SESSION['user']);
            }
            header("location:index.php?url=login");
        break;
    default:
        require_once './views/home/dashboard.php';
        break;
}