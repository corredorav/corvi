<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();
require_once '../classes/SearchFindShow.php';
require_once '../classes/UserSessions.php';
require_once '../classes/MyErrorHandler.php';



function DeleteMyDoc(){
    
    $docname = $_POST["namedoc"];
    $delDoc = new SearchFindShow();
    
    //$errj = json_decode( $delDoc->EliminaDocDB($docname, $_SESSION['rolid']));
    
    //echo $delDoc->JsonErrorI($errj->{'message'},$errj->{'code'});
    
    echo $delDoc->EliminaDocDB($docname, $_SESSION['rolid'],$_SESSION['myemail']);
}


DeleteMyDoc();
