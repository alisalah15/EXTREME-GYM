<?php
function uploadImage($file, $target_dir,$errors=[]) {
    $file = $_FILES['IMG'];

    $fileName = $_FILES['IMG']['name'];
    $fileTmpName = $_FILES['IMG']['tmp_name'];
    $fileSize = $_FILES['IMG']['size'];
    $fileError = $_FILES['IMG']['error'];
    $fileType = $_FILES['IMG']['type'];
    $allowformats= ['jpg','PNG','jpeg'];

    if(file_exists($target_dir)){
        if($fileError==0){
            $fileInfo=pathinfo($fileName);

            $fileExt=$fileInfo['extension'];
            if(in_array($fileExt,$allowformats)){
                if($fileSize<5000000){
                    $newName=uniqid('',true).".".$fileExt;
                    $dest=$target_dir.$newName;
                    if(move_uploaded_file($fileTmpName,$dest)){
                        $_SESSION['Done']=['uploaded'];
                        $_SESSION['IMG']=$newName;

                    }else{
                        $errors[]= "Sorry, your file is not uploaded";
                    }
                }else{
                    $errors[]= "Sorry, your file is too large.";
                }
            }else{
                $errors[]= "Sorry, only JPG, JPEG, PNG  files are allowed.";
            }
        }else{
            $errors[]="Error";
        }

    }else{
        $errors[]="Sorry, path not founded";
    }
    if(empty($errors)){

    }else{
        $_SESSION['errors']=$errors;
    }

}

?>
