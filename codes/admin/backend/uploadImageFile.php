<?php
function uploadImage(){
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == 0) {
        $target_dir = "/var/www/html/images/game-images/";
        $target_filename = basename($_FILES["fileToUpload"]["name"]);
        $target_file = $target_dir . $target_filename;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $file_name = $_FILES['fileToUpload']['name'];
        $file_type = $_FILES['fileToUpload']['type'];
        $file_size = $_FILES['fileToUpload']['size'];


        // Verify file extension 
        $ext = pathinfo($file_name, PATHINFO_EXTENSION); 
        $allowed_ext = array("jpg" => "image/jpg", 
                            "jpeg" => "image/jpeg", 
                            "gif" => "image/gif", 
                            "png" => "image/png"); 

  
        if (!array_key_exists($ext, $allowed_ext)) { 
            die("Error: Please select a valid file format."); 
            return false;
        }     
              
        // Verify file size - 2MB max 
        $maxsize = 2 * 1024 * 1024; 
          
        if ($file_size > $maxsize) { 
            die("Error: File size is larger than the allowed limit."); 
            return false;
        }
        // Verify MYME type of the file 
        if (in_array($file_type, $allowed_ext)) 
        { 
            // Check whether file exists before uploading it 
            if (file_exists("upload/" . $_FILES["fileToUpload"]["name"])) { 
                return false;
            }         
            else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],  
                $target_file)) { 
                echo "The file ".  $_FILES["fileToUpload"]["name"].  
                    " has been uploaded."; 
                return $_FILES["fileToUpload"]["name"];
                }  
                else { 
                return false; 
                } 
            } 
        } else { 
            return false;
        } 
    } else {
        return false;
    }
}


?>