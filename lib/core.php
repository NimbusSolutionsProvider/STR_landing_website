<?php
    session_start();
    require_once 'config.php';   

//check page setting
function check_page($id,$conn)
{
    $sql="select * from services where link='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
       return true;
    else
    {
        header("location:error.php");
        die();
    }
}
 

function uploadImage($files)
{

    $uploadedFile = 'err';
    if(!empty($_FILES['images']["type"]))
    {
        $fileName = time().'_'.$_FILES['images']['name'];
        $valid_extensions = array("jpeg", "jpg", "png","pdf","bmp","JPG");
        $temporary = explode(".", $_FILES['images']["name"]);
        $file_extension = end($temporary);
        if((($_FILES['images']["type"] == "image/png") || ($_FILES['images']["type"] == "application/pdf") || ($_FILES['images']["type"] == "image/bmp") || ($_FILES['images']["type"] == "image/jpg") || ($_FILES['images']["type"] == "image/JPG") || ($_FILES['images']["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions))
        {
            $sourcePath = $_FILES['images']['tmp_name'];
            $targetPath = "../uploads/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath))
            {
                $uploadedFile = $fileName;
                return $uploadedFile;
            }
            else
            {
                $uploadedFile="err";
                if (!is_writeable($targetPath) ){
                    echo "Cannot write to destination file";
                 }
                echo "Not uploaded because of error #".$_FILES["file"]["error"];
                return $uploadedFile;
            }
        }
        else
        {
            $uploadedFile="err";
            return $uploadedFile;
        }
    }
    else
    {
        $uploadedFile="err";
        return $uploadedFile;
    }

}




function convertVideoNsave($vidAddr,$filename)
{
     shell_exec("ffmpeg -i $vidAddr -codec copy uploads/$filename.mp4"); 
     unlink($vidAddr);
     compressVideoNsave("uploads/$filename.mp4",$filename,$filename,0);

}
function compressVideoNsave($vidAddr,$file_name,$newfilename, $mode)
{
    shell_exec("ffmpeg -i $vidAddr -c:v libvpx-vp9 -b:v 0.33M -c:a libopus -b:a 96k  uploads/$newfilename.mp4");
    
    if($file_name!=$newfilename && $mode == 0)
    {
        unlink($vidAddr);
    }
    
}
function sendMail($mail,$altBody,$email,$subject,$isHtml,$body)
{
    $mail->AltBody =$altBody;
    $mail->AddAddress($email);  // set email format to HTML
    $mail->Subject = $subject; 
    $mail->isHtml($isHtml);
    $mail->Body =$body;
    return true;
}
function mergeVideoAudio($video,$audio,$filename)
{
    $cmd = "ffmpeg -i 'uploads/$video' -i 'admin$audio'     -shortest -strict  -filter_complex '[0:a][1:a]amerge,pan=stereo|c0<c0+c2|c1<c1+c3[out]' -map 1:v -map '[out]' -c:v    -2 'uploads/merged$filename'"; 
    exec($cmd,$error); 
    unlink("uploads/$video");  
}
//check user authpage
function user_auth()
{
    if (!isset($_SESSION['signed_in']))
    {
        if($_SERVER['REQUEST_URI']!='/login')
        {
            $_SESSION['page']=$_SERVER['REQUEST_URI'];   
        }
        return false; 
    }
    else
    {
        session_regenerate_id(true);
        return true;
    }
}


//login method
function master_admin_login($email,$password,$conn,$path)
{
    $sql="select id from master_admin where email='$email' and password='$password'";
    $res=$conn->query($sql);
    if($res->num_rows > 0)
    {
        $row=$res->fetch_assoc();  
        $id=$row['id']; 
        header("location: $path");
        $_SESSION['master_admin_signed_in']=$email;
        $_SESSION['id']=$id; 
    }
    else
    {
        return false;

    }
    return true;
}
//user login
   function user_login($email,$password,$conn,$path)
    {
        $sql="select status, name, email from users where email='$email' and password='$password'";
        $res=$conn->query($sql);
        if($res->num_rows > 0)
        {
            $row=$res->fetch_assoc();
            if($row['status']==1)
            {
                $_SESSION['signed_in']=$email;
                $_SESSION['name']=$row['name'];
                setcookie("new",$email, time() + (86400 * 80), "/");   
                setcookie("pass",$password, time() + (86400 * 80), "/");  
                
                if(isset($_SESSION['page']))
                {
                    $page_url=$_SESSION['page'];
                    unset($_SESSION['page']);
                    header("location: home");
                }
                else
                {
                header("location: $path"); 
                return true;
                }
            }
            else
            return false;
        }
        else
        return false;
    }
 
 //check for cookie login
    function cookie_login($conn)
    {
        if (!isset($_SESSION['signed_in']))
        {  
            if(isset($_COOKIE["new"]) && isset($_COOKIE["pass"]))
            {
                $email=$_COOKIE["new"];
                $pass=$_COOKIE["pass"];
                $sql= "select email from users where email='$email' and password='$pass'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) 
                {
	               $_SESSION['signed_in']=$email;
                }
        
            }

        }
    }


//master_admin auth   
    function master_admin_auth()
    {
        if (!isset($_SESSION['master_admin_signed_in']))
        {
            if($_SERVER['REQUEST_URI']!='/login')
            {
                $_SESSION['page']=$_SERVER['REQUEST_URI'];   
            }
            return false; // IMPORTANT: Be sure to exit here!
        }
        else
        {
            session_regenerate_id(true);
            return true;
        }
    }

//if masteradmin already login
    function master_auto_redirect($conn)
    {
        if(isset($_SESSION['master_admin_signed_in']))
        {
            $email=$_SESSION['master_admin_signed_in'];
            $sql="select * from master_admin where email='$email'";
            $res=$conn->query($sql);
            if($res->num_rows > 0)
            {
                $row=$res->fetch_assoc(); 
                header("location: dashboard"); 
            }
        }
    }

    //user login redirect
function user_redirect($path)
{
    if(isset($_SESSION['signed_in']))
    {
        header("location: $path");
    }
}

//check token
function check_token($token)
{
    if(!isset($token))
    {
        header("location:404");
    }
}

//change pass
    function change_pass($pass,$npass,$cpass,$conn)
    {
        $email=$_SESSION['signed_in'];
        $getdata="select password from users where email='$email' and password='$pass'";
        $result=$conn->query($getdata);
        if ($result->num_rows > 0) 
        {
            if($npass==$cpass)
            {
                $ss="update users set password='$npass' where email='$email'";
                if($conn->query($ss)===true)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

//user Registration

function registration($f_name,$l_name,$contact,$email,$pass,$type,$conn)
{
   
        $sql="insert into users (email,password,type) values('$email','$pass',$type)";
        if($conn->query($sql)===true)
        {
            $u_id = $conn->insert_id;
            $sql="insert into user_profiles(u_id,f_name,l_name,contact,profile_pic,status) values($u_id,'$f_name','$l_name','$contact','user.png','Enabled')";
            if($conn->query($sql)===true)
            {
               return true;
            }
            else{
                 
               return false;
            }
        }
        else
        {
             return false;
        }
}

function upload_image($files)
{
     $uploadedFile = 'err';
    if(!empty($_FILES['images']["type"]))
    {
        $fileName = time().'_'.$_FILES['images']['name'];
        $valid_extensions = array("jpeg", "jpg", "png","pdf","bmp","JPG");
        $temporary = explode(".", $_FILES['images']["name"]);
        $file_extension = end($temporary);
        if((($_FILES['images']["type"] == "image/png") || ($_FILES['images']["type"] == "application/pdf") || ($_FILES['images']["type"] == "image/bmp") || ($_FILES['images']["type"] == "image/jpg") || ($_FILES['images']["type"] == "image/JPG") || ($_FILES['images']["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions))
        {
            $sourcePath = $_FILES['images']['tmp_name'];
            $targetPath = "uploads/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath))
            {
                $uploadedFile = $fileName;
                 return $uploadedFile;
            }
            else
            {
                $uploadedFile="err";
                 return $uploadedFile;
            }
        }
        else
        {
            $uploadedFile="err";
            return $uploadedFile;
        }
       
    }
    else
    {
            $uploadedFile="err";
            return $uploadedFile;
    }
}
function upload_image2_cp($files,$nameFileInput)
{
     $uploadedFile = 'err';
    if(!empty($_FILES[$nameFileInput]["type"]))
    {
        $fileName = time().'_'.$_FILES[$nameFileInput]['name'];
        $valid_extensions = array("jpeg", "jpg", "png","pdf","bmp","JPG");
        $temporary = explode(".", $_FILES[$nameFileInput]["name"]);
        $file_extension = end($temporary);
        if((($_FILES[$nameFileInput]["type"] == "image/png") || ($_FILES[$nameFileInput]["type"] == "application/pdf") || ($_FILES[$nameFileInput]["type"] == "image/bmp") || ($_FILES[$nameFileInput]["type"] == "image/jpg") || ($_FILES[$nameFileInput]["type"] == "image/JPG") || ($_FILES[$nameFileInput]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions))
        {
            $sourcePath = $_FILES[$nameFileInput]['tmp_name'];
            $targetPath = "uploads/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath))
            {
                $uploadedFile = $fileName;
                 return $uploadedFile;
            }
            else
            {
                $uploadedFile="err";
                 return $uploadedFile;
            }
        }
        else
        {
            $uploadedFile="err";
            return $uploadedFile;
        }
       
    }
    else
    {
            $uploadedFile="err";
            return $uploadedFile;
    }
}

function upload_image_cp($files,$path)
{
     $uploadedFile = 'err';
    if(!empty($_FILES['images']["type"]))
    {
         
        
        $valid_extensions = array("jpeg", "jpg", "png","pdf","bmp","JPG");
        $temporary = explode(".", $_FILES['images']["name"]);
        $file_extension = end($temporary);
        $fileName = time().'.'.$file_extension;
        if((($_FILES['images']["type"] == "image/png") || ($_FILES['images']["type"] == "application/pdf") || ($_FILES['images']["type"] == "image/bmp") || ($_FILES['images']["type"] == "image/jpg") || ($_FILES['images']["type"] == "image/JPG") || ($_FILES['images']["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions))
        {
            $sourcePath = $_FILES['images']['tmp_name'];
            $targetPath = $path.$fileName;
            if(move_uploaded_file($sourcePath,$targetPath))
            {
                $uploadedFile = $fileName;
                 return $uploadedFile;
            }
            else
            {
                $uploadedFile="err";
                 return $uploadedFile;
            }
        }
        else
        {
            $uploadedFile="err";
            return $uploadedFile;
        }
       
    }
    else
    {
            $uploadedFile="err";
            return $uploadedFile;
    }
}

//upload file 
function upload_file($files,$conn,$r_id)
{
    $uploadedFile = '';
    if(!empty($_FILES["type"]))
    {
        $fileName = time().'_'.str_replace(' ','-',$_FILES['name']);
        $valid_extensions = array("jpeg", "jpg", "png","pdf","bmp","JPG");
        $temporary = explode(".", $_FILES["name"]);
        $file_extension = end($temporary);
        if((($_FILES["type"] == "image/png") || ($_FILES["type"] == "application/pdf") || ($_FILES["type"] == "image/bmp") || ($_FILES["type"] == "image/jpg") || ($_FILES["type"] == "image/JPG") || ($_FILES["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions))
        {
            $sourcePath = $_FILES['tmp_name'];
            $targetPath = "uploads/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath))
            {
				if($_FILES["type"] != "application/pdf")
				{
					$image = imagecreatefromjpeg($targetPath);
            		imagejpeg($image,$targetPath,60);
				}
                $uploadedFile = $fileName;
                $sql="insert into documents_upload(p_id,src) values('$r_id','$uploadedFile')";

                if($conn->query($sql)===true)
                {
                    return "yes";
                }
                else
                {
                    return $conn->error;
                }
            }
        }
    }
}


function upload_imageu($files,$conn,$table,$column,$id) 
{
    $uploadedFile = 'err';
    if(!empty($_FILES['images']["type"]))
    {
        $fileName = time().'_'.str_replace(' ', '',$_FILES['images']['name']);
        $valid_extensions = array("jpeg", "jpg", "png","bmp","JPG");
        $temporary = explode(".", $_FILES['images']["name"]);
        $file_extension = end($temporary);
        if((($_FILES['images']["type"] == "image/png") || ($_FILES['images']["type"] == "image/bmp") || ($_FILES['images']["type"] == "image/jpg") || ($_FILES['images']["type"] == "image/JPG") || ($_FILES['images']["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions))
        {
            $sourcePath = $_FILES['images']['tmp_name'];
            $targetPath = "uploads/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath))
            {
                $uploadedFile = $fileName;
                if(isset($table))
                {
                    $sql="update $table set $column='$targetPath' where id=$id";
                    if($conn->query($sql)===true)
                    {
                        return $uploadedFile;
                    }
                    else
                    {
                        echo $fileName;
                        unlink("uploads/".$fileName);
                        return 'err';
                    }
                }
                return $uploadedFile;
            }
            else
            {
                $uploadedFile="err";
                 return $uploadedFile;
            }
        }
        else
        {
            $uploadedFile="err";
            return $uploadedFile;
        }
       
    }
    else
    {
            $uploadedFile="err";
            return $uploadedFile;
    }
}

function upload_image2($files,$conn,$table,$column,$id,$image)
{
    $uploadedFile = 'err';
    if(!empty($_FILES[$image]["type"]))
    {
        $fileName = time().'_'.str_replace(' ', '',$_FILES[$image]['name']);
        $valid_extensions = array("jpeg", "jpg", "png","bmp","JPG");
        $temporary = explode(".", $_FILES[$image]["name"]);
        $file_extension = end($temporary);
        if((($_FILES[$image]["type"] == "image/png") || ($_FILES[$image]["type"] == "image/bmp") || ($_FILES[$image]["type"] == "image/jpg") || ($_FILES[$image]["type"] == "image/JPG") || ($_FILES[$image]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions))
        {
            $sourcePath = $_FILES[$image]['tmp_name'];
            $targetPath = "uploads/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath))
            {
                $uploadedFile = $fileName;
                if(isset($table))
                {
                    $sql="update $table set $column='$targetPath' where id=$id";
                    if($conn->query($sql)===true)
                    {
                        return $uploadedFile;
                    }
                    else
                    {
                        echo $fileName;
                        unlink("uploads/".$fileName);
                        return 'err';
                    }
                }
                return $uploadedFile;
            }
            else
            {
                $uploadedFile="err";
                 return $uploadedFile;
            }
        }
        else
        {
            $uploadedFile="err";
            return $uploadedFile;
        }
       
    }
    else
    {
            $uploadedFile="err";
            return $uploadedFile;
    }
}

// function the show cart details
 
// function for add user cart value in the cart
 


//function for forget password.

function forget_pass($conn,$contact)
{
    $sql="select email from users where id=(select u_id from user_profiles where contact='$contact')";
    $res=$conn->query($sql);
    if($res->num_rows > 0)
    {
        $row=$res->fetch_assoc();
		$email=$row['email'];
		return $email;
    }
    else
    {
        return false;
    }
}

//function for change the password
function update_pass($conn,$contact,$pass)
{
    $sql="update users set password='$pass' where id=(select u_id from user_profiles where contact='$contact')";
    if($conn->query($sql)===true)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function createDir($path)
{		
	if (!file_exists($path)) 
    {
		$old_mask = umask(0);
		mkdir($path, 0777, TRUE);
		umask($old_mask);
	}
}


 


function createThumb($path1, $path2, $file_type, $new_w, $new_h, $squareSize = ''){
	/* read the source image */
	$source_image = FALSE;
	
	if (preg_match("/jpg|JPG|jpeg|JPEG/", $file_type)) {
		$source_image = imagecreatefromjpeg($path1);
	}
	elseif (preg_match("/png|PNG/", $file_type)) {
		
		if (!$source_image = @imagecreatefrompng($path1)) {
			$source_image = imagecreatefromjpeg($path1);
		}
	}
	elseif (preg_match("/gif|GIF/", $file_type)) {
		$source_image = imagecreatefromgif($path1);
	}		
	if ($source_image == FALSE) {
		$source_image = imagecreatefromjpeg($path1);
	}

	$orig_w = imageSX($source_image);
	$orig_h = imageSY($source_image);
	
	if ($orig_w < $new_w && $orig_h < $new_h) {
		$desired_width = $orig_w;
		$desired_height = $orig_h;
	} else {
		$scale = min($new_w / $orig_w, $new_h / $orig_h);
		$desired_width = ceil($scale * $orig_w);
		$desired_height = ceil($scale * $orig_h);
	}
			
	if ($squareSize != '') {
		$desired_width = $desired_height = $squareSize;
	}

	/* create a new, "virtual" image */
	$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
	// for PNG background white----------->
	$kek = imagecolorallocate($virtual_image, 255, 255, 255);
	imagefill($virtual_image, 0, 0, $kek);
	
	if ($squareSize == '') {
		/* copy source image at a resized size */
		imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $orig_w, $orig_h);
	} else {
		$wm = $orig_w / $squareSize;
		$hm = $orig_h / $squareSize;
		$h_height = $squareSize / 2;
		$w_height = $squareSize / 2;
		
		if ($orig_w > $orig_h) {
			$adjusted_width = $orig_w / $hm;
			$half_width = $adjusted_width / 2;
			$int_width = $half_width - $w_height;
			imagecopyresampled($virtual_image, $source_image, -$int_width, 0, 0, 0, $adjusted_width, $squareSize, $orig_w, $orig_h);
		}

		elseif (($orig_w <= $orig_h)) {
			$adjusted_height = $orig_h / $wm;
			$half_height = $adjusted_height / 2;
			imagecopyresampled($virtual_image, $source_image, 0,0, 0, 0, $squareSize, $adjusted_height, $orig_w, $orig_h);
		} else {
			imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $squareSize, $squareSize, $orig_w, $orig_h);
		}
	}
	
	if (@imagejpeg($virtual_image, $path2, 90)) {
		imagedestroy($virtual_image);
		imagedestroy($source_image);
		return TRUE;
	} else {
		return FALSE;
	}
}	
function number_to_words($num)
{ 
    $ones = array( 
    1 => "one", 
    2 => "two", 
    3 => "three", 
    4 => "four", 
    5 => "five", 
    6 => "six", 
    7 => "seven", 
    8 => "eight", 
    9 => "nine", 
    10 => "ten", 
    11 => "eleven", 
    12 => "twelve", 
    13 => "thirteen", 
    14 => "fourteen", 
    15 => "fifteen", 
    16 => "sixteen", 
    17 => "seventeen", 
    18 => "eighteen", 
    19 => "nineteen" 
    ); 
    $tens = array( 
    1 => "ten",
    2 => "twenty", 
    3 => "thirty", 
    4 => "forty", 
    5 => "fifty", 
    6 => "sixty", 
    7 => "seventy", 
    8 => "eighty", 
    9 => "ninety" 
    ); 
    $hundreds = array( 
    "hundred", 
    "thousand", 
    "million", 
    "billion", 
    "trillion", 
    "quadrillion" 
    ); //limit t quadrillion 
    $num = number_format($num,2,".",","); 
    $num_arr = explode(".",$num); 
    $wholenum = $num_arr[0]; 
    $decnum = $num_arr[1]; 
    $whole_arr = array_reverse(explode(",",$wholenum)); 
    krsort($whole_arr); 
    $rettxt = ""; 
    foreach($whole_arr as $key => $i)
    { 
        if($i < 20)
        { 
            $rettxt .= $ones[$i]; 
        }
        elseif($i < 100)
        { 
            $rettxt .= $tens[substr($i,0,1)]; 
            $rettxt .= " ".$ones[substr($i,1,1)]; 
        }
        else
        { 
            $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
            $rettxt .= " ".$tens[substr($i,1,1)]; 
            $rettxt .= " ".$ones[substr($i,2,1)]; 
        } 
        if($key > 0)
        { 
            $rettxt .= " ".$hundreds[$key]." "; 
        } 
    } 
    if($decnum > 0)
    { 
        $rettxt .= " and "; 
        if($decnum < 20)
        { 
            $rettxt .= $ones[$decnum]; 
        }
        elseif($decnum < 100)
        { 
            $rettxt .= $tens[substr($decnum,0,1)]; 
            $rettxt .= " ".$ones[substr($decnum,1,1)]; 
        } 
    } 
return ucwords($rettxt); 
}

function image_category()
{
    $link = $_SERVER['PHP_SELF'];
    $link_array = explode('/',$link);
    $page = end($link_array);
    switch($page)
    {
        case 'createEditBlog.php':
            return 'Blogs';
    }
     
    
}
 
//ip address 
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

//distance matrix
 

//Upload multiple images 23/04/20
function upload_images($files,$conn,$table,$id_col,$column,$id,$images,$url)
{
  
	if(isset($_FILES[$images]))
    {
        $extension=array("jpeg","jpg","png","gif","pdf","PDF");
        foreach($_FILES[$images]["tmp_name"] as $key=>$tmp_name) 
        {
            $file_name=$_FILES[$images]["name"][$key];
            $file_tmp=$_FILES[$images]["tmp_name"][$key];
            $ext=pathinfo($file_name,PATHINFO_EXTENSION); 
            if(in_array(strtolower($ext),$extension)) 
            {
                $filename=basename($file_name,$ext);
                $newFileName=$filename.time().".".$ext;
                if(move_uploaded_file($file_tmp=$_FILES[$images]["tmp_name"][$key],"uploads/".$newFileName))
                {
                    $sql="insert into $table($id_col, $column) values($id,'$url./$newFileName')";
                    if($conn->query($sql)===true)
                    {
                        $status=true;
                    }
                    else
                    {
                        $status=false;
                        break;
                    }
                }
                else
                {
                    $status=false;
                    break;
                }
            }
            else 
            {
                array_push($error,"$file_name, ");
            }
        }
        return $status;
    }
}
function upload_images2($files,$conn,$table,$id_col,$column,$id,$images,$path)
{
     
	if(isset($_FILES[$images]))
    {
        $extension=array("jpeg","jpg","png","gif","pdf","PDF");
        foreach($_FILES[$images]["tmp_name"] as $key=>$tmp_name) 
        {
            $file_name=$_FILES[$images]["name"][$key];
            $file_tmp=$_FILES[$images]["tmp_name"][$key];
            $ext=pathinfo($file_name,PATHINFO_EXTENSION);
        
            if(in_array($ext,$extension)) 
            {
                $filename=basename($file_name,$ext);
                $newFileName=$filename.time().".".$ext;
                if(move_uploaded_file($file_tmp=$_FILES[$images]["tmp_name"][$key],"uploads/".$newFileName))
                {
                     $sql="update $table set $column='$path/$newFileName' where $id_col=$id";
                    if($conn->query($sql)===true)
                    {
                        $status=true;
                    }
                    else
                    {
                          $conn->error;
                        $status=false;
                        break;
                    }
                }
                else
                {
                    $status=false;
                    break;
                }
            }
            else 
            {
                array_push($error,"$file_name, ");
            }
        }
        return $status;
    }
}
function upload_audio($files,$conn,$table,$id_col,$column,$id,$images,$path)
{  

	if(isset($_FILES[$images]))
    {
        $extension=array("pcm","mp3","wav","gif","aiff","aac", "ogg", "wma", "flac", "alac", "wma");
        foreach($_FILES[$images]["tmp_name"] as $key=>$tmp_name) 
        {
            $file_name=$_FILES[$images]["name"][$key];
              $file_tmp=$_FILES[$images]["tmp_name"][$key];
            $ext=pathinfo($file_name,PATHINFO_EXTENSION);
        
            if(in_array(strtolower($ext),$extension)) 
            {
                  $filename=basename($file_name,$ext);
                $newFileName=$filename.time().".".$ext;
                if(move_uploaded_file($file_tmp=$_FILES[$images]["tmp_name"][$key],"uploads/".$newFileName))
                {
                       $sql="update $table set $column='$path/$newFileName' where $id_col=$id";
                    if($conn->query($sql)===true)
                    {
                        $status=true;
                    }
                    else
                    {
                          $conn->error;
                        $status=false;
                        break;
                    }
                }
                else
                {
                    $status=false;
                    break;
                }
            }
            else 
            {
                array_push($error,"$file_name, ");
            }
        }
        return $status;
    }
}
function upload_videos($files,$conn,$table,$id_col,$column,$id,$images,$url)
{   
    
	if(isset($_FILES[$images]))
    {
        // return pathinfo($_FILES[$images]["name"],PATHINFO_EXTENSION);
        $extension=array("mp4", "mov", "wmv", "avi", "avchd", "flv", "f4v", "swf", "mkv","mp4", "webm");
        foreach($_FILES[$images]["tmp_name"] as $key=>$tmp_name) 
        {
            $file_name=$_FILES[$images]["name"][$key];
            $file_tmp=$_FILES[$images]["tmp_name"][$key];
            $ext=pathinfo($file_name,PATHINFO_EXTENSION); 
            if(in_array(strtolower($ext),$extension)) 
            {
                $filename=basename($file_name,$ext);
                $mp4name  = $filename.time();
                $newFileName=$mp4name.".".$ext;
                $newFileName;

                if(move_uploaded_file($file_tmp=$_FILES[$images]["tmp_name"][$key],"../uploads/".$newFileName))
                {
                     
                        $type = $_FILES[$images]["type"][$key];
                        $sql="update $table set  $column='uploads/$mp4name.mp4',file_type='$type' where $id_col=$id ";
                        if($filename=='recordedandUploaded5am.')
                        {
                            $sql="update $table set  $column='uploads/merged$mp4name.mp4',file_type='$type' where $id_col=$id ";
                        }
                      if($conn->query($sql)===true)
                      {
                          $status=$newFileName;
                      }
                      else
                      {
                            
                          $status=false;
                          break;
                      }
                      if($ext!='mp4')
                     {
                        convertVideoNsave("uploads/$newFileName",$mp4name);
                     }else
                     {
                        compressVideoNsave("uploads/$newFileName",$newFileName,$mp4name, 1);
                     }
                     $status=$newFileName;
                    
                }
                else
                {
                    $status=false;
                    break;
                }
            }
            else 
            {
                array_push($error,"$file_name, ");
            }
        }
        return $status;
    }
}
function upload_single_video($files,$conn,$table,$id_col,$column,$id,$images,$url)
{   
    
	if(isset($_FILES[$images]))
    {
        $extension=array("mp4", "mov", "wmv", "avi", "avchd", "flv", "f4v", "swf", "mkv","mp4", "webm");
        foreach($_FILES[$images]["tmp_name"] as $key=>$tmp_name) 
        {
            $file_name=$_FILES[$images]["name"][$key];
            $file_tmp=$_FILES[$images]["tmp_name"][$key];
            $ext=pathinfo($file_name,PATHINFO_EXTENSION); 
            if(in_array(strtolower($ext),$extension)) 
            {
                echo $filename=basename($file_name,$ext);
                
                $mp4name  = $filename.time();
                $newFileName=$mp4name.".".$ext;
                $newFileName;

                if(move_uploaded_file($file_tmp=$_FILES[$images]["tmp_name"][$key],"uploads/".$newFileName))
                {
                     
                        $type = $_FILES[$images]["type"][$key];
                        $sql="update $table set  $column='uploads/$mp4name.mp4',file_type='$type' where $id_col=$id ";
                        if($filename=='recordedandUploaded5am.')
                        {
                            $sql="update $table set  $column='uploads/merged$mp4name.mp4',file_type='$type' where $id_col=$id ";
                        }
                        
                      if($conn->query($sql)===true)
                      {
                          $status=$newFileName;
                      }
                      else
                      {
                            
                          $status=false;
                          break;
                      }
                      if($ext!='mp4')
                     {
                        convertVideoNsave("uploads/$newFileName",$mp4name);
                     }else
                     {
                        compressVideoNsave("uploads/$newFileName",$newFileName,$mp4name, 1);
                     }
                     $status=$newFileName;
                    
                }
                else
                {
                    $status=false;
                    break;
                }
            }
            else 
            {
                array_push($error,"$file_name, ");
            }
        }
        return $status;
    }
}
						
?>

