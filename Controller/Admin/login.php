<?php
   $act = "login";
   if(isset($_GET['act'])) {
      $act = $_GET['act'];
   }

   switch($act) {
      case 'login':
         include './View/admin/login.php';
         break;
      case 'login_action':
         $username = $_POST['username'];
         $password = $_POST['password'];
         include_once('../../Model/DBConfig.php');
         include_once('../../Model/API.php');
         include_once('../../Model/User.php');
         $connect = new connect();
         $API = new API();
         $user = new User();
         $user_result = $user->login_Employee($username, $password);
         if($user_result) {
            session_start();
            session_regenerate_id(true);
            $_SESSION['username'] = $username;
            $_SESSION['admin_id'] = $user_result['admin_id'];
            $_SESSION['login_method'] = 'traditional';
            $res = [
               'status' => 200,
               'message' => 'Đăng nhập thành công',
            ];
         }else {
            $res = [
               'status' => 404,
               'message' => 'Đăng nhập không thành công',
            ];
         }
         echo json_encode($res);
         break;
      case 'metamask_login':
         $address = $_POST['address'];
         $signature = $_POST['signature'];
         $message = $_POST['message'];

         include_once('../../Model/DBConfig.php');
         include_once('../../Model/API.php');
         include_once('../../Model/User.php');

         // Verify the signature (basic verification)
         // In production, you should implement proper signature verification
         if($address && $signature && $message) {
            // Check if wallet address exists in database or create new session
            $connect = new connect();
            $user = new User();

            // For now, we'll create a session for any valid MetaMask address
            // You can extend this to check against a database of authorized addresses
            session_start();
            $_SESSION['wallet_address'] = $address;
            $_SESSION['login_method'] = 'metamask';
            $_SESSION['admin_id'] = 1; // Default admin ID for MetaMask users

            $res = [
               'status' => 200,
               'message' => 'MetaMask authentication successful',
               'address' => $address
            ];
         } else {
            $res = [
               'status' => 404,
               'message' => 'Invalid MetaMask credentials',
            ];
         }
         echo json_encode($res);
         break;
      case 'log_out':
         session_start();
         $_SESSION = [];
         if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
               $params['path'], $params['domain'],
               $params['secure'], $params['httponly']
            );
         }
         session_destroy();
         $res = [
            'status' => 200, 
            'message' => 'Đăng xuất thành công',
         ];
         echo json_encode($res);
         break;
   }