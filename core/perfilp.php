<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once '../classes/SearchFindShow.php';
require_once '../classes/MyErrorHandler.php';
require_once '../classes/UserSessions.php';

session_start();

/**
 * @input: Obtiene los datos de Actualizacion de Usuario
 * @return Jcode
 */

//**
//Variables Globales
$email ="";
$password="";
$rut="";
$nombre="";
$apellido="";
$direccion="";
$comuna="";
$tcredito="";
$fvenc="";
$vali="";



function GetData(){
    
    //return
    //404: No encontrado
    
    $inerr = new MyErrorHandler();
    
    $inerr->ErrorFile("CAPTURA DE POSTS ". $_POST['password']." ".$_POST['direccion']." ".$_POST['rut']." ".$_POST['nombre']. " ". $_POST['apellido']." ".$_POST['comuna']);
    
    if(!isset($_POST['password'])){
        $error = '{ "message": "Password no se encuentra", "code":"404"}';
        return $error;
    }
    else
        $GLOBALS['password'] = $_POST['password'];
    
    if(!isset($_POST['rut'])){
        $error = '{ "message": "Rut no se encuentra", "code":"404"}';
        return $error;
    }
    else
        $GLOBALS['rut'] = $_POST['rut'];
    
    
    
    
    if(!isset($_POST['nombre'])){
        $error = '{ "message": "Nombre no se encuentra", "code":"404"}';
        return $error;
    }
    else
         $GLOBALS['nombre'] = $_POST['nombre'];
    
    
    
    if(!isset($_POST['apellido'])){
        $error = '{ "message": "Apellido no se encuentra", "code":"404"}';
        return $error;
    }
    else
         $GLOBALS['apellido'] = $_POST['apellido'];
    
    if(!isset($_POST['direccion'])){
        $error = '{ "message": "Direccion no se encuentra", "code":"404"}';
        return $error;
    }
    else
        $GLOBALS['direccion'] = $_POST['direccion'];
    
    if(!isset($_POST['comuna'])){
        $error = '{ "message": "Comuna no se encuentra", "code":"404"}';
        return $error;
    }
    else
        $GLOBALS['comuna'] = $_POST['comuna'];
    
    

    return $error = '{ "message": "Datos Correctos", "code":"302"}';
    
}


function Updater(){
    
    $errcd = GetData();
    $updater = new UserSessions();
    $myerror = new MyErrorHandler();
    $interrcode = "";
    
    $errfinal = json_decode($errcd);
    //retorna error 500 en caso de no encontrar asociasion
    $interrcode = (int)$errfinal->{'code'};
    
    $myerror->ErrorFile("Codigo error-> ".$interrcode.$errfinal->{'message'});
    
    if ($interrcode==404){
        echo $error = '{ "message": "Faltan Datos", "code":"404"}';    
    }
    else
        $errupd = $updater->UpdateUserData($GLOBALS['rut'], $GLOBALS['password'], $GLOBALS['nombre'], $GLOBALS['apellido'], 0000, $GLOBALS['direccion'], $GLOBALS['comuna'], 1, 0, 0);
    
      
    $errfinal = json_decode($errupd);
      
      if ((int)$errfinal->{'code'}!=500){
          
          echo $error = '{"message":"Datos Actualizados","code":"302"}';
          //echo utf8_encode(json_encode($error));
          
          
      }else
      {
          
          echo $error = '{"message":"Error en la actualizacion","code":"302"}';
          
          
      }
    
    
    
    
  
   
}


// PROGRAMA PRINCIPAL

Updater();