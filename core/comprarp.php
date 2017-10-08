<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
require_once '../classes/UserSessions.php';
require_once '../classes/SearchFindShow.php';
require_once '../classes/MyErrorHandler.php';



/**
 * 
 * @Global Var
 * 
 */

$correo = "";
$errline = new MyErrorHandler();



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

function ValoresComprar(){
    
$comprar = New SearchFindShow();



//echo $comprar->JsonErrorI("Codigo Recibido", $_POST["rolid"]);   
    
$sql = "select * from braiz where rolid=".$_POST["rolid"]; 

$r= $comprar->DisplaySQLResults($sql);

$arr = array('mtscuad' => $r["mtscuad"], 'mtscrd' => $r["mtscrd"], 'comuna' => $r["comuna"], 'dorm' => $r["dorm"], 'banos' => $r["banos"]);

echo json_encode($arr);

}




/// DECLARACION DE VARIABLE PARA PAGINAS






ValoresComprar();


?>





