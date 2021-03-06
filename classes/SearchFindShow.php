<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SearchFindShow
 *
 * @author lukasalarcon
 */
//error_reporting(E_ERROR | E_PARSE);
require_once '../classes/MyErrorHandler.php';

$err = New MyErrorHandler();


class SearchFindShow {
    
    private $conn = null;
    private $errconn = null;
    
    
    
function __construct() {
      
    
    $this->conn = mysqli_connect("localhost","admin","Corvi1.","mydb");

// Check connection
    if (mysqli_connect_errno())
    {
        return $this->JsonErrorI("Failed to connect to MySQL: " . mysqli_connect_error(),"500");
    }
    
    return $this->conn;
    
   }
   
public function GetMailFromRolId($rolid){
    
    
    //SELECT email from (( braizperuser
                                    //inner join usuario on usuario.rut = braizperuser.fk_rut)
                                    //) where braizperuser.fk_rolid = 2424
    
    
    
    
}

public function DelFavorite($rolid,$email){
    
    
    $myrolid = $rolid;   
    
  global $err;

    $sql = "DELETE FROM favoritos where rolid=".$myrolid." and email='".$email."'";
    
    $err->ErrorFile($sql);
    
    $result = $this->conn->query($sql);
    
    if ( $result == false) {
 
                return $this->JsonErrorI("Error al eliminar Favorito",500);
            
        } else {
                return $this->JsonErrorI("Favorito Eliminado",302);;     
                } 
    
    
    
    
    
    
}



public function GetFavorite($rolid,$email){
    
 $myrolid = $rolid;   
    
  global $err;

    $sql = "SELECT rolid FROM favoritos where rolid=".$myrolid." and email='".$email."' limit 0,1";
    
    $err->ErrorFile($sql);
    
    $result = $this->conn->query($sql);
    
    if ( $result->num_rows > 0) {
 
                return true;
            
        } else {
                return false;     
                }  
    
    
    
}


public function InsertintoFav($correo,$rolid){
    
    $lcorreo = $correo;
    $lrolid = $rolid;
    
    global $err;
    // Obtiene el Rut en base al correo
    $errcd = $this->GetRutID($lcorreo);
    //Decodifica el error Json
    $errfinal = json_decode($errcd);
    //retorna error 500 en caso de no encontrar asociasion
  if ((int)$errfinal->{'code'}==500){
          $this->errconn = $this->conn->error;
          $this->conn->close();     
          return $this->JsonErrorI($this->errconn,500);   
  }
  else
      $rutID = $errfinal->{'message'};
      
      
   if (!$this->GetFavorite($lrolid, $lcorreo)){   
      
    
  $sql = "INSERT INTO `favoritos`
(
rolid,
`rut`,
`email`)
VALUES
(".
$lrolid.",'".
 $rutID."','".
 $correo."')";  
    
   $err->ErrorFile("SearhFindShow()-InsertintoFav " .$sql);  
  
   if ($this->conn->query($sql) > 0) {
                $this->conn->close();
                return $this->JsonErrorI("Agregado a Favoritos",200);
            
        } else {
                $this->errconn = $this->conn->error;
                $this->conn->close();     
                return $this->JsonErrorI($this->errconn,500);     
                }
    
    
   }
   else
       echo $this->DelFavorite ($lrolid, $lcorreo);
    
    
}   

public function GetFavoriteComboOption($email){
    
   
    
  global $err;
  $selected = '';

    $sql = "SELECT rolid FROM favoritos where email='".$email."'";
    
    $err->ErrorFile($sql);
    
    $result = $this->conn->query($sql);
    
    $selected =  '</select>';

    
    if ( $result->num_rows > 0) {
        
        
        //$err->ErrorFile("GetFavorite Combo - Ingresar");
        
        
        while ($fila = $result->fetch_assoc()) {
            
          
 
        
        $selected =  '<option value="'.$fila["rolid"].'">'.$fila["rolid"].'</option>' . $selected;
        
        
        //$err->ErrorFile("GetFavorite Combo - While -$selected");  
        
        
        }    
        } else {
                
            return 'No hay propiedades en favoritos';
            
                }  
    
    return $selected = '<select id="rolid">'.$selected; 
    
}

   
   
public function CountAllRows($sql){
    
    global $err;

    $err->ErrorFile("SearchFindShow->CountAllRows() ".$sql);
    
    $result = $this->conn->query($sql);
    
    if ( $result->num_rows > 0) {
        
        return $result->num_rows;
        
    }
 else {
    
        return 0;
    }
    
    
    
}   
   

public function DisplayPageResults($max){
    
    //https://www.thoughtco.com/pagination-of-mysql-query-results-2694115
    
    global $err;

    $sql = "SELECT * FROM `braiz` ".$max;
    
    $err->ErrorFile("SearchFindShow->DisplayPageResults() ".$sql);
    
    $data_p = $this->conn->query($sql);
    
    return $data_p->fetch_array(MYSQLI_ASSOC);
    
    
    //retorna arreglo  
}


public function DisplayPageResultswithMax($sql,$max){
    
    
    global $err;

    $sql = $sql." ".$max;
    
    $err->ErrorFile("SearchFindShow->DisplayPageResultswithMax() ".$sql);
    
    $data_p = $this->conn->query($sql);
    
    return $data_p->fetch_array(MYSQLI_ASSOC);
    
    
    
}



public function DisplaySQLResults($sql){
    
    //Genera un retorno de cualquier consulta SQL en formato ASOCIATIVO
    
    global $err;

    $err->ErrorFile("SearchFindShow->DisplaySQLResults() ".$sql);
    
    $data_p = $this->conn->query($sql);
    
    return $data_p->fetch_array(MYSQLI_ASSOC);
   
}



   
public function CreateVirtualFolder($folder){
    
    global $err;
    
    $myNewFolderPath = "../virtual/".$folder;
   if ( $e = mkdir($myNewFolderPath, 0700) ) {
      $err->ErrorFile($e."crea directorio");
   } else {
      // something went wrong
       $err->ErrorFile($e. "no crea directorio");
   }
    
    
    
}   

public function GetRutID($correo){
    
    
    global $err;

    $sql = "SELECT `usuario`.`rut` FROM `usuario` where `email`='".$correo."'";
    
    $err->ErrorFile($sql);
    
    $result = $this->conn->query($sql);
    
    if ( $result->num_rows > 0) {
        
               
        
                $row = $result->fetch_assoc();
                
                $rut = $row["rut"];

                return $this->JsonErrorI($rut,200);
            
        } else {
                $this->errconn = $this->conn->error;
                $this->conn->close();     
                return $this->JsonErrorI($this->errconn,500);     
                }
    
    
}

public function ActualizaBienRaiz($rol,$mtscuad,$mtscrd,$direccion,$comuna,$dorm,$banos,$piscina,$gstcmn,$impuesto,$ufprecio,$ref,$lat,$lon,$ctcan,$correo){
    
    global $err;
    // Obtiene el Rut en base al correo
    $errcd = $this->GetRutID($correo);
    //Decodifica el error Json
    $errfinal = json_decode($errcd);
    //retorna error 500 en caso de no encontrar asociasion
  if ($errfinal->{'code'}=="500"){
          $this->errconn = $this->conn->error;
          $this->conn->close();     
          return $this->JsonErrorI($this->errconn,500);   
  }
  else
      $rutID = $errfinal->{'message'};
    
  $sql = "UPDATE `braiz`
SET
`rolid` = ".$rol.",
`mtscuad` = ".$mtscuad." ,
`mtscrd` = ".$mtscuad.",
`direccion` = '".$direccion."',
`comuna` = ".$comuna.",
`dorm` = ".$dorm.",
`banos` = ".$banos.",
`piscina` = ".$piscina.",
`gstocmn` = ".$gstcmn.",
`impuesto` = ".$impuesto.",
`ufprecio` = ".$ufprecio.",
`ref` = '".$ref."',
`lat` = ".$lat.",
`lon` = ".$lon.",
`ctcan` = ".$ctcan."
  WHERE `rolid` = ".$rol;  
    
   $err->ErrorFile("SearhFindShow()-ActualizaBienRaiz " .$sql);  
  
   if ($this->conn->query($sql) > 0) {
                $this->conn->close();
                return $this->JsonErrorI("Actualizacion realizada",200);
            
        } else {
                $this->errconn = $this->conn->error;
                $this->conn->close();     
                return $this->JsonErrorI($this->errconn,500);     
                }
     
    
    
}


   
public function InsertaBienRaiz($rol,$mtscuad,$mtscrd,$direccion,$comuna,$dorm,$banos,$piscina,$gstcmn,$impuesto,$ufprecio,$ref,$lat,$lon,$ctcan,$correo){
    
    global $err;
 
    $errcd = $this->GetRutID($correo);
    
    $errfinal = json_decode($errcd);
    
  if ($errfinal->{'code'}=="500"){
          $this->errconn = $this->conn->error;
          $this->conn->close();     
          return $this->JsonErrorI($this->errconn,500);   
  }
  else
      $rutID = $errfinal->{'message'};
  
  
  $sql = "INSERT INTO `braiz`
(
`rolid`,
`mtscuad`,
`mtscrd`,
`direccion`,
`comuna`,
`dorm`,
`banos`,
`piscina`,
`gstocmn`,
`impuesto`,
`ufprecio`,
`ref`,
`lat`,
`lon`,
`ctcan`
)
VALUES
(
".$rol.",".
$mtscuad.",".
$mtscrd.",'".
$direccion."',".
$comuna.",".
$dorm.",".
$banos.",".
$piscina.",".
$gstcmn.",".
$impuesto.",".
$ufprecio.",'".
$ref."',".
$lat.",".
$lon.",".
$ctcan."); ";

$sql2="INSERT INTO braizperuser (fk_rut,fk_rolid) VALUES('".$rutID."',".$rol.")";  
  
 $err->ErrorFile("SearchFindShow()->Insertabienraiz ".$sql.$sql2);  
  
   if ($this->conn->query($sql) > 0 && $this->conn->query($sql2) > 0) {
                $this->conn->close();
                return $this->JsonErrorI("Insersión realizada",200);
            
        } else {
                $this->errconn = $this->conn->error;
                $this->conn->close();     
                return $this->JsonErrorI($this->errconn,500);     
                }
    
    
    
    
}    
    
public function JsonErrorI($error,$coderr){
    /* Version Mejorada de JsonError para incluir codigo de error */
    
    $error = '{ "message": "' . $error . '", "code":"'.$coderr.'"}';
    
    return $error;
    
    
}
    

public function SearchEngine($comuna,$desde,$hasta,$dorm,$banos){
    
    
    global $err;
    $lcomuna = trim($comuna);
    $ldesde = trim($desde);
    $lhasta = trim($hasta);
    $ldorm = trim($dorm);
    $lbanos = trim($banos);
    
    
    
    $i = -1;
    
    
    $err->ErrorFile("SearchEngine Data Comuna: $lcomuna Desde :$ldesde Hasta: $lhasta Dorm: $ldorm  Banos: $lbanos");
    $err->ErrorFile(" Evaluacion comuna: ". (bool)empty($lcomuna) ." desde: ". (bool)empty($ldesde)  ." hasta ". (bool)empty($lhasta) ." banos ". (bool)empty($lbanos)." Dorm ".(bool)empty($ldorm));
    
    //SOLO BAÑOS
     if ( $lcomuna === "" && $ldesde === ""  && $lhasta === "" &&  $ldesde === "" && $lbanos !== "" ){
        
        $i = 0;
    }
    
    //SOLO DORMITORIOS
    if ( $lcomuna === "" && $ldesde === ""  && $lhasta === "" && $lbanos === "" && $ldorm !== "" ){
        
        $i = 1;
    }
    
    //SOLO COMUNA
    if ( $lcomuna ==! "" && $ldesde === ""  && $lhasta === "" && $lbanos === "" && $ldorm === "" ){
        
        $i = 2;
    }
    
    //SOLO DESDE
     if ( $lcomuna === "" && $ldesde ==! ""  && $lhasta === "" && $lbanos === "" && $ldorm === "" ){
        
        $i = 3;
    }
    
    //SOLO DESDE & HASTA
     if ( $lcomuna==="" && $ldesde!=="" && $lhasta!==""  && $lbanos=== "" && $ldorm === "" ){
        
        $i = 4;
    }
    
    //SOLO COMUNA & DESDE & HASTA
     if ( $lcomuna!==""  && $ldesde!=="" && $lhasta!==1 && $lbanos==="" && $ldorm===""){
        
        $i = 5;
    }
    
    //SOLO COMUNA & DESDE & HASTA & DORMITORIOS
      if ( $lcomuna !== "" && $ldesde ==! ""  && $lhasta !== "" && $lbanos === "" && $ldorm !== "" ){
        
        $i = 6;
    }
    
    if ( $lcomuna !== "" && $ldesde ==! ""  && $lhasta !== "" && $lbanos !== "" && $ldorm !== "" ){
        
        $i = 7;
    }
    
    $err->ErrorFile("Seleccion de Search Engine: $i");
    
    if ($lcomuna==="" && $ldesde==="" && $lhasta==="" && $ldorm==="" && $lbanos===""){
        
        return $this->JsonErrorI("Debe colocar una opcion", 500);
        
    }
    
    
    
    
    
    switch ($i) {
        
    case 0:
        $sql = "SELECT * FROM braiz where banos=".$lbanos;
    break;           
    case 1:
        $sql = "SELECT * FROM braiz where dorm=".$ldorm;
    break;
    case 2:
        $sql = "SELECT * FROM braiz where comuna=".$lcomuna;
        break;       
    case 3:
        $sql = "SELECT * FROM braiz where ufprecio >= ".$ldesde;
        break;            
    case 4:
        $sql = "SELECT * FROM braiz where ufprecio >= ".$ldesde." and ufprecio <= ".$lhasta." ";
        break;          
    case 5:
        $sql = "SELECT * FROM braiz where comuna=".$lcomuna." and ufprecio >= ".$ldesde." and ufprecio <= ".$lhasta."";
        break;   
    case 6:
        $sql = "SELECT * FROM braiz where comuna=".$lcomuna." and ufprecio >= ".$ldesde." and ufprecio <= ".$lhasta." and dorm=".$ldorm."";
        break;
    case 7:
        $sql = "SELECT * FROM braiz where comuna=".$lcomuna." and ufprecio >= ".$ldesde." and ufprecio <= ".$lhasta." and dorm=".$ldorm." and banos=".$lbanos."";
        break;
}
    
    
    $err->ErrorFile("SearchEngine Final Query: $sql");
    return $sql;
    
}

public function InsertDocIntoDB($NDoc,$TypeDoc,$rol){

$TDoc = $TypeDoc;
$NameDoc = $NDoc;
$rolid = $rol;
$Er = New MyErrorHandler();

    switch ($TDoc) {
        case "cert_hipoteca":

            $sql="INSERT INTO `docperbraiz` (`rolid`,`docid`,`nombre_doc`,`ready`) VALUES ('$rolid',1,'$NameDoc',1)";     

            break;
        case "inscri_dominio":

            $sql="INSERT INTO `docperbraiz` (`rolid`,`docid`,`nombre_doc`,`ready`) VALUES ('$rolid',2,'$NameDoc',1)";

            break;
        case "titulos_dominio":

            $sql="INSERT INTO `docperbraiz` (`rolid`,`docid`,`nombre_doc`,`ready`) VALUES ('$rolid',3,'$NameDoc',1)";
            
            break;
        case "inscri_dominio":

            $sql="INSERT INTO `docperbraiz` (`rolid`,`docid`,`nombre_doc`,`ready`) VALUES ('$rolid',4,'$NameDoc',1)";

            break;
        case "titulos_dominio":

            $sql="INSERT INTO `docperbraiz` (`rolid`,`docid`,`nombre_doc`,`ready`) VALUES ('$rolid',5,'$NameDoc',1)";

            break;
        case "cert_avaluo":

            $sql="INSERT INTO `docperbraiz` (`rolid`,`docid`,`nombre_doc`,`ready`) VALUES ('$rolid',6,'$NameDoc',1)";

            break;
        case "cert_deuda":

            $sql="INSERT INTO `docperbraiz` (`rolid`,`docid`,`nombre_doc`,`ready`) VALUES ('$rolid',7,'$NameDoc',1)";

            break;
        case "cert_expro_muni":

            $sql="INSERT INTO `docperbraiz` (`rolid`,`docid`,`nombre_doc`,`ready`) VALUES ('$rolid',8,'$NameDoc',1)";
            
            break;
        case "cert_expro_fisc":

            $sql="INSERT INTO `docperbraiz` (`rolid`,`docid`,`nombre_doc`,`ready`) VALUES ('$rolid',9,'$NameDoc',1)";
            
            break;
        case "foto_planos":

            $sql="INSERT INTO `docperbraiz` (`rolid`,`docid`,`nombre_doc`,`ready`) VALUES ('$rolid',10,'$NameDoc',1)";
            
            break;
        case "cuen_basicas":

            $sql="INSERT INTO `docperbraiz` (`rolid`,`docid`,`nombre_doc`,`ready`) VALUES ('$rolid',11,'$NameDoc',1)";
            
            break;
  
        default:
            break;
    }
    
    $Er->ErrorFile($sql);
 
  
   if ($this->conn->query($sql) > 0) {
                $this->conn->close();
                return $this->JsonErrorI("Insersión realizada",302);
            
        } else {
                $this->errconn = $this->conn->error;
                $this->conn->close();     
                return $this->JsonErrorI($this->errconn,500);     
                }
    
    
    
    
    
}    
    
public function DocumentoListo($docx,$rolx){
    
    $docid = $docx;
    $rolid = $rolx;
    
    global $err;
    
    //$sql = "SELECT ready FROM docperbraiz where rolid='$rolid' and docid=$docid";
    $sql ="(SELECT ready FROM docperbraiz INNER JOIN  tipos_docs ON tipos_docs.iddocs = docperbraiz.docid where tipos_docs.nom_doc='$docid' and rolid=$rolid)";
    
    $err->ErrorFile("Documento Listo ".$sql);
    
    $results = $this->conn->query($sql);
    
   if (mysqli_num_rows($results)==0)
    {
        
        return 0;    
    }
    

    if (($results->num_rows !== 0) ) {
                
                return 1;
            
        } else {
                   
                return 0;    
                }
    
    
    
    
    
    
    
}    
    
private function EliminaDocDisco($docx,$rolx,$correo){
    
    $sess = new UserSessions();
    
    $lcorreo = $correo;
    $df = $docx;
    $rolid=$rolx;
    $fold = $sess->GetIDforFolder($lcorreo);
    
    global $err;
    
    
    
    
 
    $sql ="SELECT nombre_doc FROM docperbraiz INNER JOIN  tipos_docs ON tipos_docs.iddocs = docperbraiz.docid where tipos_docs.nom_doc='$df' and rolid=$rolid";
    
    $err->ErrorFile($sql);
    
    
   if ($res = $this->conn->query($sql)) {
               
                //return $this->JsonErrorI("Insersión realizada",302);
       
                $nom_doc = $res->fetch_assoc();

                $file_to_delete = trim($nom_doc["nombre_doc"]);
                
                
                
                $finalf = "../virtual/".$fold."/docs/$file_to_delete";
                
                $err->ErrorFile("Archivo para Borrar... $finalf");
                
                if (is_file($finalf)){
                    return (unlink($finalf)?$this->JsonErrorI("Archivo Borrado",302):$this->JsonErrorI("No se puede borrar archivo",500));
                }
                    else { return $this->JsonErrorI("Problema ubicacion de archivo $finalf",500); }
            
        } else {
                $this->errconn = $this->conn->error;
                   
                return $this->JsonErrorI($this->errconn,500);     
                }
                
                
}



public function EliminaDocDB($docx,$rolx,$correo){
    
    //*****************
    // a) Intenta eliminar archivo de disco
    // b) Si es exitoso,
    // c) Procede a eliminar registro de la base de datos
    //*****************
    
    
    $doc = $docx;
    $rolid = $rolx;
    $lcorreo = $correo;
    
      
    
  global $err;
  
  $errJson = json_decode($this->EliminaDocDisco($docx,$rolx,$lcorreo));
  
  if ((int)$errJson->{'code'}!=500){

    $sql = "DELETE docperbraiz FROM docperbraiz INNER JOIN  tipos_docs ON tipos_docs.iddocs = docperbraiz.docid where tipos_docs.nom_doc='$doc' and rolid=$rolid";
    
    $err->ErrorFile($sql);
    
    $result = $this->conn->query($sql);
    
    $err->ErrorFile("EliminaDocDb->resultado Eliminacion $result");
    
    if ( $result == false) {
 
                return $this->JsonErrorI("Error al eliminar Documento $doc de Base de Datos",500);
            
        } else {
                return $this->JsonErrorI("Documento $doc Eliminado",302);;     
                } 
    
  }
  
  return $this->JsonErrorI($errJson->{'message'}, 500);
    
    
}
    
    
    
    
    
    
    
    
    
}
