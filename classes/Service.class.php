<?php 

class Service extends DbObject 
{

    // table name
    protected static $table_name = 'services';

    // columns
    protected static $db_columns = ['id', 'service_name', 'is_open', 'images', 'address', 'nearby_popular_destination', 'open_hours', 'about_description', 'is_verified', 'has_certifications', 'certification_images', 'badge_by_company', 'primary_address', 'secondary_address', 'mobile_numbers', 'landline_numbers', 'service_active_status', 'created_at', 'tags', 'user_id', 'hero_image', 'service_cat_id'];

    // properties
    public $id, // not in the UI
        $service_name, 
        $is_open,
        $images,
        $address,
        $nearby_popular_destination,
        $open_hours,
        $about_description,
        $is_verified, // not in the UI
        $has_certifications, // not in the UI
        $certification_images,
        $badge_by_company,
        $primary_address,
        $secondary_address,
        $mobile_numbers,
        $landline_numbers,
        $service_active_status,
        $created_at, // not in the UI
        $tags,
        $user_id, // not in the UI
        $hero_image,
        $service_cat_id;
    
    // constructor
    public function __construct (
        $post = '',
        $user_id = null,
        $created_at           = null,
        $service_cat_id,
        $is_verified          = 0,
        $has_certifications   = 0,
        $image_links          = '',
        $certification_images = '',
        $service_hero_image   = ''
    ) 
    {
        $this->service_name               = $post['service_name'] ?? '';
        $this->is_open                    = $post['is_open'] === 'yes' ? 1 : 0;
        $this->images                     = $image_links ?? '';
        $this->address                    = $post['address'] ?? '';
        $this->nearby_popular_destination = $post['nearby_destination'] ?? '';
        $this->open_hours                 = $post['open_hours'] ?? '';
        $this->about_description          = $post['description'] ?? '';
        $this->certification_images       = $certification_images ?? '';
        $this->badge_by_company           = $badge_by_company ?? '';
        $this->primary_address            = $post['primary_address'] ?? '';
        $this->secondary_address          = $post['secondary_address'] ?? '';
        $this->mobile_numbers             = $post['mobile_numbers'] ?? '';
        $this->landline_numbers           = $post['landline_numbers'] ?? '';
        $this->service_active_status      = $post['service_active_status'] === 'on' ? 1 : 0;
        $this->tags                       = $post['tags'] ?? '';
        $this->user_id                    = $user_id;
        $this->hero_image                 = $service_hero_image ?? '';
        $this->is_verified                = $is_verified ?? 0;
        $this->has_certifications         = $has_certifications ?? 0;
        $this->created_at                 = $created_at;
        $this->service_cat_id             = $service_cat_id ?? null;
    }
    
    // create user
    public function create() 
    {
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

    public function find_by_service_name($service_name) 
    {
        $sql = "SELECT service_name FROM ". static::$table_name ."  WHERE service_name='". self::$database->escape_string($service_name) . "'";

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

        if (
            empty($this->service_name) || 
            empty($this->is_open) || 
            empty($this->images) || 
            empty($this->address) ||
            empty($this->nearby_popular_destination) || 
            empty($this->open_hours) ||
            empty($this->about_description) || 
            empty($this->certification_images) ||
            empty($this->primary_address) ||
            empty($this->secondary_address) ||
            empty($this->mobile_numbers) ||
            empty($this->landline_numbers) ||
            empty($this->service_active_status) ||
            empty($this->tags) ||
            empty($this->hero_image) || 
            empty($this->service_cat_id)
        ) {
            // set errors
            $this->errors[] = 'Please make sure every field is filled properly.';
        } 
        // else if () {

        // }


        return $this->errors;
    }

}