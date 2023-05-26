<?php 

class FileUploader 
{
    // File-specific config
    private static array $accepted_file_types = ['png', 'jpg', 'jpeg'];
    private static int $max_filesize_limit    = 50000000; // 5 MB

    // File informations
    private static string $file_name = '', $file_tmp = '', $file_type = '';
    private static int $file_size = 0, $file_error = 0;

    // errors and extras
    private static $errors = [];

    /* 
     * set_file_info()
     * accepts file and sets up the file details
    */
    public static function set_file_info (array $file = [])
    {
        self::$file_name  = $file['name'];
        self::$file_tmp   = $file['tmp_name'];
        self::$file_type  = $file['type'];
        self::$file_size  = $file['size'];
        self::$file_error = $file['error'];
    }

    /* 
     * upload(string file): string | bool
     * Uploads file to the HDD
    */
    public static function upload(array $file = [], string $upload_path = ''): string | bool 
    {
        // set file info
        self::set_file_info($file);

        // file extesion
        $extension = self::get_file_extension(self::$file_name);

        if (self::has_valid_type($extension)) {
            if (self::$file_error === 0) {

                if (self::has_valid_size()) {
                    // save file to the disk
                    return self::save_file_to_disk(self::$file_tmp, self::get_file_path($upload_path));
                } else {
                    self::$errors[] = 'File size exceeded.';
                }

            } else {
                self::$errors[] = 'Sorry, there was something wrong while uploading the file.';
            }
        } else {
            self::$errors[] = 'Invalid file type';
        }

        return false;
    }

    private static function save_file_to_disk(string $file_name, string $path): bool | string 
    {
        // if there are no errors/ the file is valid, then save it to the disk
        if (empty(self::$errors)) {
            move_uploaded_file($file_name, $path);
            // return the path of the file that is uploaded
            return $path;
        }
        return false;
    }
    
    public static function get_file_extension(string $file_name): string 
    {
        $file_parts = explode('.', $file_name);
        return strtolower(end($file_parts));
    }

    public static function get_errors(): array
    {
        return self::$errors;
    }

    /* 
     * add_accepted_files(): void
     * Adds acceptable file extensions to the
     * accepted_file_types array (property)
    */
    public static function add_accepted_file_types (string $file_type): void 
    {
        self::$accepted_file_types[] = $file_type;
    }

    public static function set_max_upload_size(int $filesize): void 
    {
        self::$max_filesize_limit = $filesize;
    }

    private static function has_valid_size(): bool 
    {
        if (self::$file_size < self::$max_filesize_limit) {
            return true;
        }
        return false;
    }

    /* 
     * has_valid_type: checks if the file has the correct extension
     * so that it only uploads the file with the acceptable extensions
    */
    private static function has_valid_type (string $file_type = ''): bool 
    {
        // check if the file we're uploading is acceptable
        if (in_array($file_type, self::$accepted_file_types)) {
            return true;
        }
        return false;
    }

    /* 
     * get_file_name_and_path
     * returns the unique file name with the path to upload the file
    */
    public static function get_file_path(string $new_path = ''): string 
    {
        return (!empty($new_path) ? $new_path : 'uploads/'). uniqid('', true) . ".". self::get_file_extension(self::$file_name);
    }

}