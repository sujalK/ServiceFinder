<?php 

    class Session 
    {
        public $user_id;
        public $username;
        // public $user_role;
        
        public function __construct()
        {
            session_start();
        }
        
        public function login($user) 
        {
            if($user) {
                // prevent session fixation attacks
                session_regenerate_id();
                $this->user_id   = $user->id;
                $this->user_id   = $_SESSION['user_id']   = $user->id;
                $this->username  = $_SESSION['username']  = $user->first_name . " ". $user->last_name;
            }
            return true;
        }

        public function logout() 
        {
            unset($_SESSION['user_id']);
            unset($_SESSION['username']);
            unset($this->user_id);
            unset($this->username);
            // header("Location:../login.php");
            return true;
        }

        public function message($msg= '') 
        {
            if(!empty($msg)) {
                $_SESSION['message']= $msg;
                return true;
            } else {
                return $_SESSION['message'] ?? '';
            }
        }

        public static function set_custom_session($key, $message) 
        {
            $_SESSION[$key] = $message;
        }

        public static function unset_custom_session($key) 
        {
            unset($_SESSION[$key]);
        }

    }

?>