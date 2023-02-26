<?php 

class Validator {

    private string $email = '';

    public function __construct(string $email = '')
    {
        $this->set_email($email);
    }

    private function set_email(string $email = ''): object 
    {
        if ($this->validate_email($email)) {
            $this->email = $email;
        }
        return $this;
    }
    
    public function get_email(): string | NULL
    {
        return isset($this->email) ? $this->email : NULL;
    }

    private function validate_email(string $email = ''): bool 
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