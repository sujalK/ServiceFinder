<?php 

class RegularUser extends DbObject
{
    // table name
    protected static $table_name = 'users';

    // columns
    protected static $db_columns = ['id', 'first_name', 'last_name', 'email', 'hashed_password', 'user_role', 'is_verified', 'created_at', 'account_active_status'];

    // properties
    public $id, $first_name, $last_name, $email, $user_role, $is_verified, $created_at, $account_active_status;
    public $hashed_password;
    public $password, $confirm_password;

    // set up the properties initially
    public function __construct($post = null, $created_at = null, $user_role = 'regular_user', $is_verified = 0, $account_active_status = 1)
    {
        $this->first_name             = $post['first_name'] ?? '';
        $this->last_name              = $post['last_name'] ?? '';
        $this->email                  = $post['email'] ?? '';
        $this->password               = $post['password'] ?? '';
        $this->confirm_password       = $post['confirm_password'] ?? '';
        $this->created_at             = $created_at;
        $this->user_role              = $user_role;
        $this->is_verified            = $is_verified;
        $this->account_active_status  = $account_active_status;
    }

    // set the hashed property to the property
    protected function set_hashed_password() 
    {
        $this->hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // verify password
    public function verify_password($password)
    {
        return password_verify($password, $this->hashed_password);
    }

    // create user
    public function create() 
    {
        $this->set_hashed_password();
        return parent::create();
    }

    // update user
    public function update() 
    {
        return parent::update();
    }

    // delete user
    public function delete() 
    {
        return parent::delete();
    }

    // find user by email
    public function find_by_email ($email) 
    {
        $sql     = "SELECT * FROM ". static::$table_name;
        $sql    .= " WHERE email='". self::$database->escape_string($email) . "' LIMIT 1";
        $obj_arr = static::find_by_sql($sql);
        if(!empty($obj_arr)) {
            return array_shift($obj_arr);
        } else {
            return false;
        }
    }

    // validate user information
    public function validate() 
    {
        $this->errors = [];

        // Validator instance
        $email_validator = new Validator($this->email);

        // verify inputs from the user (fronntend)
        if (empty($this->first_name) || empty($this->last_name) || empty($this->email) || empty($this->password) || empty($this->confirm_password)) {
            $this->errors[] = 'Please make sure all the inputs are filled properly';
        } else if ($email_validator->get_email() === NULL) {
            $this->errors[] = 'Please make sure the email is valid email';
        } else if ($this->password != $this->confirm_password) {
            $this->errors[] = 'Password didn\'t match';
        } else {
            // if the passwords match
            if (strlen($this->password) < 8) {
                $this->errors[] = 'Password length must be at lest 8 characters.';
            } else if (!preg_match('/[A-Z]/', $this->password)) {
                $this->errors[] = "Password must contain at least 1 uppercase letter";
            } else if (!preg_match('/[a-z]/', $this->password)) {
                $this->errors[] = "Password must contain at least 1 lowercase letter";
            } else if (!preg_match('/[0-9]/', $this->password)) {
                $this->errors[] = "Password must contain at least 1 number";
            } else if (!preg_match('/[^A-Za-z0-9\s]/', $this->password)) {
                $this->errors[] = "Password must contain at least 1 symbol";
            }
        }

        return $this->errors;
    }

}