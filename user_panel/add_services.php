<?php include "./includes/header.php"; ?>
<?php 
// check if the extension is valid
function has_valid_extension(array $ext = [], array $accepted_ext = []): bool {

    foreach($ext as $extension) {
        if (!in_array($extension, $accepted_ext)) {
            return false;
        }
    }

    return true;
}

// check if there is any errors
function has_errors(array $errors = []): bool {
    foreach($errors as $err) {
        if ($err !== 0) return true;
    }

    return false;
}

// check if size is of the valid size
function has_valid_size(array $sizes = []): bool {

    foreach ($sizes as $size) {
        if ($size > 50000000) return false;
    }

    return true;
}


// check if the request is the post request
if (is_post() && isset($_FILES['multiple_images']) && $_SESSION['user_role'] === 'business_owner' ) {

    // accepted extensions
    $accepted_ext = ['jpg', 'png', 'jpeg'];

    // images temporary locations
    $tmp_locations = [];
    $file_names    = [];
    $file_sizes    = [];
    $errors        = [];
    $extensions    = [];

    // custom errors
    $custom_errors = [];

    // final file names
    $final_file_paths = [];


    // loop over file to store extensions
    foreach($_FILES['multiple_images']['name'] as $file) {
        $file_parts   = explode(".", $file);
        $extension    = end($file_parts);
        $extensions[] = $extension;
    }

    // loop over file to store file sizes
    foreach ($_FILES['multiple_images']['size'] as $size) {
        $file_sizes[] = $size;
    }

    // loop over to store the errors
    foreach ($_FILES['multiple_images']['error'] as $error) {
        $errors[] = $error;
    }

    // to combine temp locations with the file extensions
    $combined_ext_with_tmp_file = array_combine($_FILES['multiple_images']['tmp_name'], $extensions);

    
    // check extensions of the files uploaded
    if (has_valid_size($file_sizes) && has_valid_extension($extensions, $accepted_ext) && !has_errors($errors)) {
        

        // looping over the combined array to upload multiple files related to the service
        foreach ($combined_ext_with_tmp_file as $tmp_file => $ext) {
            // echo $ext;
            $uniqid = uniqid('', true);
            move_uploaded_file($tmp_file,  '../uploads/' . $uniqid . "." . $ext);
            $final_file_paths[] = '../uploads/' . $uniqid . ".". $ext;
        }


        // create a service instance
        $service             = new Service($_POST, $_SESSION['user_id'], $current_date_and_time, $_POST['service_cat_id']);

        $modified_file_paths = [];
        
        // replace final paths again with [uploads/file_name.ext] format
        foreach ($final_file_paths as $file) {
            $modified_file_paths[] = str_replace('../', '', $file);
        }
        
        $service->images     = implode(",", $modified_file_paths);
        
        // upload a single file
        $service->hero_image = str_replace('../', '', FileUploader::upload($_FILES['hero_image'], '../uploads/'));
        $service->certification_images = $_POST['certification_images'];


        // check to see if the service is created.
        if ($service->create()) {
            $success_msg = 'Service has been sent for verification. Once approved, it will be listed.';
        } else {
            $custom_errors = $service->errors;
            // $errors[] = 'Please make sure you entered unique service by it\'s name.';
        }

    } else {
        $custom_errors[] = 'Please make sure you upload correct file type/size while uploading multiple images';
    }
}

?>

    <!-- div: top-header -->
    <?php include ROOT_PAGE . "/user_panel/includes/top/header.php"; ?>

    <!-- sidebar -->
    <?php include ROOT_PAGE . "/user_panel/includes/sidebar.php"; ?>

    <!-- section: add-product-form -->
    <section id="add-product-form" class="left-margin-container">
        <div class="container add-product-form-container">
            <form action="" class="add-product-form" method="post" enctype="multipart/form-data">
                <div class="product-container">
                    <div class="top-text-container add-product-header">
                        <h1>
                            <span>Add Service</span>
                            <i class="fa fa-dot-circle expand-circle"></i>
                        </h1>
                        <p>Add the service to list on the website!</p>
                        <?php if(isset($success_msg)): ?> <p class="alert-message success-message" style="color: #4caf4f;"><?php echo $success_msg; unset($success_msg); ?></p> <?php endif; ?>
                        <!-- printing errors -->
                        <?php if(isset($custom_errors)): ?>
                            <?php foreach($custom_errors as $error): ?>
                                <p class="alert-message error-message" style='color: red;'><?php echo $error; ?></p>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="line-bar"></div>
                    <!-- hidden class in the product-container-content makes it work as expected -->
                    <div class="product-container-content hidden">
                        <div class="product-and-author">
                            <div class="form-group">
                                <label for="service_name">Service Name</label>
                                <input type="text" name="service_name" id="service_name" placeholder="Service name">
                            </div>
                            <div class="form-group">
                                <label for="is_open">Is Open (in operational mode?)</label>
                                <select name="is_open" id="">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                                <!-- <input type="text" name="is_open" id="is_open" placeholder="author"> -->
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label for="service_image">Service Main Image</label>
                            <input type="file" name="service_image" id="service_image">
                        </div> -->
                        <!-- <div class="category-and-brand">
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" id="category">
                                    <option value="sneaker">Sneaker</option>
                                    <option value="bag">Bag</option>
                                    <option value="tshirt">T-shirt</option>
                                    <option value="pant">Pant</option>
                                    <option value="accessories">Accessories</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="brand">Brand</label>
                                <select name="brand" id="brand">
                                    <option value="nike">Nike</option>
                                    <option value="polo">Polo</option>
                                    <option value="adidas">Adidas</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="style_code">Style code</label>
                                <input type="text" name="style_code" id="style_code" placeholder="style code">
                            </div>
                        </div> -->
                        <div class="price-and-color">
                            <div class="form-group">
                                <label for="address">Address (Full Address)</label>
                                <input type="text" name="address" id="address" placeholder="Address (Full Address)">
                            </div>
                            <div class="form-group">
                                <label for="nearby_destination">Nearby Popular Destination</label>
                                <input type="text" name="nearby_destination" id="nearby_destination" placeholder="Nearby Popular Destination">
                            </div>
                            <div class="form-group">
                                <label for="open_hours">Open Hours</label>
                                <input type="text" name="open_hours" id="open_hours" placeholder="10:00 AM - 5:00 PM">
                                <span>Example: 10:00 AM to 5:00 PM</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="service_description">Service Description</label>
                            <textarea name="description" id="service_description" class="service_description" placeholder="description goes here..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="certification_images">Certification Images (Links)</label>
                            <textarea name="certification_images" id="certification_images"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="primary_address">Primary Address</label>
                            <input type="text" name="primary_address" id="primary_address" placeholder="Primary Address">
                        </div>
                        <div class="form-group">
                            <label for="secondary_address">Secondary Address</label>
                            <input type="text" name="secondary_address" id="secondary_address" placeholder="Secondary Address">
                        </div>
                        <div class="form-group">
                            <label for="mobile_numbers">Mobile Numbers</label>
                            <input type="text" name="mobile_numbers" id="mobile_numbers">
                        </div>
                        <div class="form-group">
                            <label for="landline_numbers">Landline Numbers</label>
                            <input type="text" name="landline_numbers" id="landline_numbers">
                        </div>

                        <!-- to make service active/de-active is upto user -->
                        <div class="form-group">
                            <label for="service_active_status">Active Status</label>
                            <input type="checkbox" name="service_active_status" id="service_active_status" class="flex-start">
                        </div>
                        
                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <input type="text" name="tags" id="tags">
                        </div>
                        <div class="form-group">
                            <label for="hero_image">Hero Image</label>
                            <input type="file" name="hero_image" id="hero_image">
                        </div>
                        <!-- is_verified is a tag given by the admin to indicate that the service is verified -->
                        <!-- <div class="filter-and-stock">
                            <div class="form-group">
                                <label for="product_for">Product for</label>
                                <select name="product_for" id="product_for">
                                    <option value="men">Men</option>
                                    <option value="women">Women</option>
                                    <option value="kids">Kids</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="stock_status">In stock</label>
                                <select name="stock_status" id="stock_status">
                                    <option value="yes">yes</option>
                                    <option value="no">no</option>
                                </select>
                            </div>
                        </div> -->

                        <!-- <div class="tags-and-styles">
                            <div class="form-group">
                                <label for="tags">tags</label>
                                <input type="text" name="tags" id="tags" placeholder="tags">
                                <span class="tag-sample">example: nike,branded shoes</span>
                            </div>
                            <div class="form-group">
                                <label for="styles">Style</label>
                                <select name="style" id="styles">
                                    <option value="skateboard">Skateboard</option>
                                    <option value="preepy">Preepy</option>
                                    <option value="preepy">Tomboy</option>
                                    <option value="preepy">Sporty</option>
                                    <option value="preepy">Casual</option>
                                </select>
                            </div>
                        </div> -->
                        <?php 
                            $sql   = "SELECT id, category_name FROM service_category";
                            $query = $connection->query($sql);
                            
                        ?>
                        <div class="form-group">
                            <label for="service_cat_id">Category</label>
                            <select name="service_cat_id" id="service_cat_id">
                                <?php while($row = $query->fetch_assoc()): ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['category_name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="images-and-save">
                    <div class="form-group">
                        <label for="multiple_images">Images</label>
                        <input type="file" name="multiple_images[]" id="multiple_images" multiple>
                    </div>
                    <!-- <p>Ready to proceed ?</p> -->
                    <div class="submit">
                        <button type="submit" class="save-button" name="save_draft"><span class="lnr lnr-checkmark-circle"></span> Publish</button>
                        <!-- <button type="submit" class="publish-button" name="publish_live"><span class="lnr lnr-pencil"></span> Live</button> -->
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Toggler class -->
    <script src="./assets/js/classes/Toggle.js"></script>

    <!-- script -->
    <script src="./assets/js/script.js"></script>

    <!-- for tiny mce wysiwyg editor -->
    <script>
        // initialization of Tiny MCE editor
        // tinymce.init({
        //     selector: 'textarea',
        //     plugins: 'a11ychecker advcode casechange export formatpainter image editimage linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tableofcontents tinycomments tinymcespellchecker',
        //     toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter image editimage pageembed permanentpen table tableofcontents',
        //     toolbar_mode: 'floating',
        //     tinycomments_mode: 'embedded',
        //     tinycomments_author: 'Author name',
        // });
    </script>
</body>
</html>