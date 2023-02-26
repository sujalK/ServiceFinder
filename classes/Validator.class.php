<?php 

class Validator {
    
    private string $email = '';

    public function __construct($email = '')
    {
        $this->set_email($email);
    }

    private function set_email($email = ''): void {
        if ($this->validate_email($email)) {
            $this->email = $email;
        }
    }

    private function validate_email($email = ''): bool 
    {
       // Remove all illegal characters from email
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        // Validate email
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

}