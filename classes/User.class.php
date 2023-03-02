<?php 

class User extends DbObject {

    // table name
    protected static $table_name = 'users';

    // columns
    protected static $db_columns = ['id', 'first_name', 'last_name', 'email', 'hashed_password', 'user_role', 'citizenship_file_front', 'citizenship_file_back', 'is_verified', 'created_at', 'account_active_status'];

    // properties
    public $id, $first_name, $last_name, $email, $user_role, $citizenship_file_front, $citizenship_file_back, $is_verified, $created_at, $account_active_status;
    public $password, $confirm_password, $hashed_password;

    // constructor
    public function __construct($first_name = '', $last_name = '', $email = '', $password = '', $confirm_password = '', $user_role = '', $citizenship_file_front = '', $citizenship_file_back = '', $is_verified = 0, $created_at = null, $account_active_status = 1)
    {
        $this->first_name             = $first_name ?? '';
        $this->last_name              = $last_name ?? '';
        $this->email                  = $email ?? '';
        $this->password               = $password ?? '';
        $this->confirm_password       = $confirm_password ?? '';
        $this->user_role              = $user_role ?? '';
        $this->is_verified            = $is_verified ?? '';
        $this->created_at             = $created_at ?? '';
        $this->account_active_status  = $account_active_status ?? '';

        $this->citizenship_file_front = $citizenship_file_front ?? '';
        $this->citizenship_file_back  = $citizenship_file_back ?? '';
    }

    protected function set_hashed_password() 
    {
        $this->hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function verify_password($password)
    {
        return password_verify($password, $this->hashed_password);
    }

    public function create() 
    {
        $this->set_hashed_password();
        return parent::create();
    }

    public function update() 
    {
        return parent::update();
    }

    public function delete() 
    {
        return parent::delete();
    }

    public function find_by_email ($email) 
    {
        $sql     = "SELECT * FROM ". static::$table_name;
        $sql    .= " WHERE email='". self::$database->escape_string($email) . "'";
        $obj_arr = static::find_by_sql($sql);

        if(!empty($obj_arr)) {
            return array_shift($obj_arr);
        } else {
            return false;
        }
    }

    public function validate() 
    {
        $this->errors = [];

        // check input fields are empty
        
    }

}

?>