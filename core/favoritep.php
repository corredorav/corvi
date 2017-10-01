
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

    
function addfavorite() {
    
$err = New MyErrorHandler();

$err->ErrorFile("Ingresando a Funcion de Favorito");
    
$userdata = New SearchFindShow();

$myrolid = $_POST['rolid'];

$errcodes = $userdata->InsertintoFav($_SESSION['myemail'],$myrolid);
    
echo $errcodes;    
    
    
    
    
    
    
}
    
    
    
    
 //Calling the function Add Favorite   
addfavorite();
?>
