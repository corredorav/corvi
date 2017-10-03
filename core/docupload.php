<?php
require_once '../classes/SearchFindShow.php';
require_once '../classes/UserSessions.php';
require_once '../classes/MyErrorHandler.php';

session_start();

/**
 * 
 * @Global Var
 * 
 */

$correo = "";



function SanityCheck(){
    
    global $correo;
    
if (isset($_SESSION['myemail'])){
//desde sigin.php
    
    //echo "En sanity...";
    
    $correo = $_SESSION['myemail'];

    return 1;

    }
        return 0;
    }

function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
}


//****
//Valida la session contra Base de Datos

function ShieldSession(){
    
    global $correo;
        
    //echo "Shield..";
    
      
            $sess = new UserSessions(); 
            //Echo "After Sanity...";
            $Ecode =  $sess->CheckSessionInDb(session_id(),$correo);
            //echo $Ecode;
            
        if ($Ecode!="302"){
            
            redirect("https://".$_SERVER['SERVER_NAME']."/corvi/core/acceso.php");
            
        
        }
      
           
      
    
    
    
}

/**
 * Valida si la variablle correo esta seteada como
 * parte de la sesion global
 * 
 */
if (SanityCheck()){
    ShieldSession();
    }
else{
    redirect("https://".$_SERVER['SERVER_NAME']."/corvi/core/acceso.php"); 
}


function CreateDocDir(){
    
    
    
    $hcorreo = hash('ripemd160', $_SESSION['myemail']);
    
    $foldername = substr($hcorreo, 0, 5) ."/docs/";

    if (!file_exists("../virtual/".$foldername)) {
        mkdir("../virtual/".$foldername, 0700);
        //0777
        return $foldername;
    exit;
} else {
       return $foldername ;
}
   
    
}

function UploadDocs(){
    
    
$JsonH = new UserSessions();
$Myerr = New MyErrorHandler();

if ($_POST["label"]) {
    $label = $_POST["label"];
    $Myerr->ErrorFile("Valor de label: $label");
    if ($label === "undefined" || empty($label)){
        echo $JsonH->JsonErrorI("Debe seleccionar un tipo de Documento", 500);
        return 0;
    }
    
    
}
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 200000)
&& in_array($extension, $allowedExts)) {
    if ($_FILES["file"]["error"] > 0) {
        
        echo $JsonH->JsonErrorI($_FILES["file"]["error"], 500);
        //echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    } else {
        $filename = CreateDocDir().$_FILES["file"]["name"];
        //$JsonH->JsonErrorI($_FILES["file"]["name"]." - $label subido exitosamente", 302);
        //echo "Upload: " . $_FILES["file"]["name"] . "<br>";
        //echo "Type: " . $_FILES["file"]["type"] . "<br>";
        //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
        //echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
        //echo "DocName: ". $label;

        if (file_exists("../virtual/" . $filename)) {
            echo $JsonH->JsonErrorI($filename . " ya existe.",500);
            //echo $filename . " already exists. ";
            
        } else {
            move_uploaded_file($_FILES["file"]["tmp_name"],
            "../virtual/" . $filename);
            //echo "Stored in: " . "../virtual/" . $filename;
            echo $JsonH->JsonErrorI($_FILES["file"]["name"]." - $label subido exitosamente", 302);
        }
    }
} else {
    echo $JsonH->JsonErrorI("Archivo Inválido", 500);
    //echo "Invalid file";
}
}
//FIN UPLOAD DOCS

UploadDocs();



?>

