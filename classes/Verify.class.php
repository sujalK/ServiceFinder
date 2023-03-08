<?php 

class Verify 
{
    // properties
    private string $token;
    
    // set the token
    public function __construct(string $token = null)
    {
        $this->token = sanitize($token);
    }

    // verify_user: verify token from the link
    public function verify_user(): void
    {
        $connection = $this->get_connection();
        $email      = $this->get_email();
        if ($email) {

            // update user status to verified 
            $verify_sql_for_a_user = "UPDATE users SET token = '', is_verified = 1 WHERE email='". $email ."'";

            // update the database value
            if($connection->query($verify_sql_for_a_user)) {
                $_SESSION['user_verified'] = $this->success_verification_message();
            } else {
                $_SESSION['verification_failed'] = $this->error_verification_message();
            }
        } else {
            $_SESSION['verification_failed'] = $this->error_verification_message();
        }
    }

    // get_email: get email address using token
    private function get_email(): string | false 
    {
        $connection = $this->get_connection();
        $sql        = "SELECT email FROM users WHERE token ='". $connection->escape_string($this->token) ."' AND is_verified=". 0 . " LIMIT 1";
        $query      = $connection->query($sql);
        if ($query) {
            $data = $query->fetch_assoc();
            if ($data) 
                return $data['email'];
            return false;
        }
        return false;
    }

    // success_verification_message: verification message for successful verification
    private function success_verification_message(): string 
    {
        return 'Your account has been activated.';
    }

    // error_verification_message: verification message for unsuccessful verification
    private function error_verification_message(): string 
    {
        return 'Something went wrong, please try again.';
    }

    // get_connection: returns the connection
    private function get_connection(): mysqli
    {
        global $connection;
        return $connection;
    }

}
