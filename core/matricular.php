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

?>


<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Corvi</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />

    <!--  Material Dashboard CSS    -->
    <link href="../assets/css/material-dashboard.css" rel="stylesheet"/>

    
    <link href="../assets/css/tabs.css" rel="stylesheet" />
    
    

    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
    
    
    
    <!--AJAX FORM-->  
        <!--<script src="../assets/js/jquery-3.1.0.min.js" type="text/javascript"></script>-->
        <!--<script src="../assets/js/jquery.form.js"></script>-->
        <script src="../assets/js/SimpleAjaxUploader.js"></script>
        <!--<script src="../assets/js/simpleUpload.min.js"></script>-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
	<script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="../assets/js/material.min.js" type="text/javascript"></script>

	<!--  Notifications Plugin    -->
	<script src="../assets/js/bootstrap-notify.js"></script>

	<!-- Material Dashboard javascript methods -->
	<script src="../assets/js/material-dashboard.js"></script>
    
        
        <script>
        
    // prepare the form when the DOM is ready 
    $(document).ready(function() { 
    var options = { 
        //target:        '#errorum',   // target element(s) to be updated with server response
        dataType:  'json',     
        success:       showResponse,  // post-submit callback 
 
        // other available options: 
        //url:       url         // override for form's 'action' attribute 
        //type:      type        // 'get' or 'post', override for form's 'method' attribute 
        //dataType:  json        // 'xml', 'script', or 'json' (expected server response type) 
        //clearForm: true        // clear all form fields after successful submit 
        //resetForm: true        // reset the form after successful submit 
 
        // $.ajax options can be used here too, for example: 
        //timeout:   3000 
    }; 
 
    // bind to the form's submit event 
    $('#vdata').submit(function() { 
        // inside event callbacks 'this' is the DOM element so we first 
        // wrap it in a jQuery object and then invoke ajaxSubmit 
        $(this).ajaxSubmit(options); 
 
        // !!! Important !!! 
        // always return false to prevent standard browser submit and page navigation 
        return false; 
    }); 
}); 
 
// pre-submit callback 
function showRequest(formData, jqForm, options) { 
    // formData is an array; here we use $.param to convert it to a string to display it 
    // but the form plugin does this for you automatically when it submits the data 
    var queryString = $.param(formData); 
 
    // jqForm is a jQuery object encapsulating the form element.  To access the 
    // DOM element for the form do this: 
    // var formElement = jqForm[0]; 
 
    //alert('About to submit: \n\n' + queryString); 
    //CL04
    // here we could return false to prevent the form from being submitted; 
    // returning anything other than false will allow the form submit to continue 
    return false; 
} 
 
// post-submit callback 
function showResponse(data)  { 
    // for normal html responses, the first argument to the success callback 
    // is the XMLHttpRequest object's responseText property 
 
    // if the ajaxSubmit method was passed an Options Object with the dataType 
    // property set to 'xml' then the first argument to the success callback 
    // is the XMLHttpRequest object's responseXML property 
 
    // if the ajaxSubmit method was passed an Options Object with the dataType 
    // property set to 'json' then the first argument to the success callback 
    // is the json data object returned by the server 
 
    //alert('status: ' + statusText + '\n\nresponseText: \n' + responseText + 
     //  '\n\nThe output div should have already been updated with the responseText.'); 
        
       $('#errorum_row').show();
       $('#errorum').text(data.message);
} 
    
    
    
    </script>
    
    <script>
    function escapeTags( str ) {
    return String( str )
           .replace( /&/g, '&amp;' )
           .replace( /"/g, '&quot;' )
           .replace( /'/g, '&#39;' )
           .replace( /</g, '&lt;' )
           .replace( />/g, '&gt;' );
}
window.onload = function() {
  var btn = document.getElementById('uploadBtn'),
      progressBar = document.getElementById('progressBar'),
      progressOuter = document.getElementById('progressOuter'),
      msgBox = document.getElementById('msgBox');
  var uploader = new ss.SimpleUpload({
        button: btn,
        url: 'file_upload.php',
        name: 'uploadfile',
        multipart: true,
        hoverClass: 'hover',
        focusClass: 'focus',
        responseType: 'json',
        startXHR: function() {
            progressOuter.style.display = 'block'; // make progress bar visible
            this.setProgressBar( progressBar );
        },
        onSubmit: function() {
            msgBox.innerHTML = ''; // empty the message box
            btn.innerHTML = 'Subiendo...'; // change button text to "Uploading..."
          },
        onComplete: function( filename, response ) {
            btn.innerHTML = 'Escoja otro archivo';
            progressOuter.style.display = 'none'; // hide progress bar when upload is completed
            if ( !response ) {
                msgBox.innerHTML = 'Unable to upload file ';
                return;
            }
            if ( response.success === true ) {
                msgBox.innerHTML = '<strong>' + escapeTags( filename ) + '</strong>' + ' successfully uploaded.';
            } else {
                if ( response.msg )  {
                    msgBox.innerHTML = escapeTags( response.msg );
                } else {
                    msgBox.innerHTML = 'An error occurred and the upload failed.';
                }
            }
          },
        onError: function(response) {
            progressOuter.style.display = 'none';
            msgBox.innerHTML = 'Unable to upload file';
          }
	});
};
</script>
<script>
function submitForm() {
            console.log("submit event");
            var fd = new FormData(document.getElementById("fileinfo"));
            var ch = $(".DocSelect:checked").val();
            fd.append("label", $(".DocSelect:checked").val());
            $.ajax({
              url: "docupload.php",
              type: "POST",
              data: fd,
              processData: false,  // tell jQuery not to process the data
              contentType: false,   // tell jQuery not to set contentType
              dataType: 'json'
            }).done(function( data ) {
                console.log("PHP Output:");
                console.log( data );
                $('#errorum_row').show(data.code);
                $('#errorum').text(data.message);
            });
            return false;
        }
    
    
     

</script>
    
    
   
    
    
    
    
    
    
</head>

<body>

	<div class="wrapper">

	    <div class="sidebar" data-color="green" data-image="../assets/img/sidebar-1.jpg">
			<!--
		        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

		        Tip 2: you can also add an image using data-image tag
		    -->

			<div class="logo">
				<a href="signin.php" class="simple-text">
					Corvi
				</a>
			</div>

	    	<div class="sidebar-wrapper">
	            <ul class="nav">
                                               
	                <li>
	                    <a href="vitrina.php">
	                        <i class="material-icons">dashboard</i>
	                        <p>Vitrina</p>
	                    </a>
	                </li>
	                <li>
                            <a href="perfil.php">
	                        <i class="material-icons">person</i>
	                        <p>Perfil de Usuario</p>
	                    </a>
	                </li>
	                <li class="active">
	                    <a href="matricular.php">
	                        <i class="material-icons">add_to_queue</i>
	                        <p>Matricular</p>
	                    </a>
	                </li>
                        <li>
	                    <a href="comprar.php">
	                        <i class="material-icons">add_shopping_cart</i>
	                        <p>Comprar</p>
	                    </a>
	                </li>
                        <li>
	                    <a href="agenda.php">
	                        <i class="material-icons">schedule</i>
	                        <p>Agenda</p>
	                    </a>
	                </li>
                        <li>
	                    <a href="admin.php">
	                        <i class="material-icons">build</i>
	                        <p>Admin</p>
	                    </a>
	                </li>
	               
			
	            </ul>
	    	</div>
	    </div>

	    <div class="main-panel">
                
			<nav class="navbar navbar-transparent navbar-absolute">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">Propiedades</a>
					</div>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">
							<li>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="material-icons">dashboard</i>
									<p class="hidden-lg hidden-md">Dashboard</p>
								</a>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="material-icons">notifications</i>
									<span class="notification">2</span>
									<p class="hidden-lg hidden-md">Notifications</p>
								</a>
								<ul class="dropdown-menu">
									<li><a href="#">Tiene 2 nuevas solicitudes</a></li>
                                                                        <li><a href="#">Aún falta documentación</a></li>
									
								</ul>
							</li>
							<li>
                                                            <?php
                                                                
								echo '<a href="#" onclick="document.getElementById(\'logout\').submit()" class="dropdown-toggle" data-toggle="dropdown">';	 	                                                 
                                                                echo '<i class="material-icons">exit_to_app</i></a>';
	 							echo '<p class="hidden-lg hidden-md">Salir</p>';
                                                                echo '<form id="logout" action="logout.php" method="post">';
                                                                echo '<input type="hidden" name="email" value="'.$correo.'">';
                                                                echo '</form>';
                                                            ?>       
                                                                   
		 						
							</li>
                                                        
                                                        
                                                        
                                                        
						</ul>

						
					</div>
				</div>
			</nav>
                
                
                
                
                
                <div class="content">
                    
                    <div class="container-fluid">
                <div id="errorum_row" style="display: none;" class="row">
                        <div class="col-lg-7">
                                <div class="container-fluid">
                                    <div class="alert alert-danger">
                                            <div  class="container-fluid">
                                                <div class="alert-icon">
                                                <i class="material-icons">error_outline</i>
                                                </div>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true"><i class="material-icons">clear</i></span>
                                                </button>
                                                <div id="errorum">
                                                    <b>Error Alert:</b> Panel de Errores
                                                </div>
                                                
                                            </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                    
                    
                    
                    <div class="card card-nav-tabs">
	<div class="card-header" data-background-color="purple">
		<div class="nav-tabs-navigation">
			<div class="nav-tabs-wrapper">
				<span class="nav-tabs-title">Tareas:</span>
				<ul class="nav nav-tabs" data-tabs="tabs">
					<li class="active">
						<a href="#profile" data-toggle="tab">
							<i class="material-icons">web_asset</i>
							Datos Generales
						<div class="ripple-container"></div></a>
					</li>
					<li class="">
						<a href="#messages" data-toggle="tab">
							<i class="material-icons">add_a_photo</i>
							Imágenes
						<div class="ripple-container"></div></a>
					</li>
					<li class="">
						<a href="#settings" data-toggle="tab">
							<i class="material-icons">description</i>
							Documentos
						<div class="ripple-container"></div></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
                        <?php
                        $no_value = 0;
                        $updater = new SearchFindShow();
                        $errl = new MyErrorHandler();
                        $sql = "
                            SELECT braiz.rolid,braiz.mtscuad,braiz.mtscrd,braiz.direccion,braiz.comuna,braiz.dorm,braiz.banos,braiz.piscina,braiz.gstocmn,braiz.ufprecio,braiz.ref,braiz.ctcan
                            FROM ((braiz
                            INNER JOIN braizperuser ON braizperuser.fk_rolid = braiz.rolid)
                            INNER JOIN usuario ON usuario.rut = braizperuser.fk_rut) 
                            where usuario.email='".$_SESSION['myemail']."'";
              
                        $r = $updater->DisplaySQLResults($sql);
                        $errl->ErrorFile($sql);
                        if(!empty($r)){
                            $no_value = 1;    
                            }
                        ?>
	<div class="card-content">
		<div class="tab-content">
			<div class="tab-pane active" id="profile">
				<div class="card-content">
                                    <form id="vdata" action="matricularp.php" method="post">
	                                    <div class="row">
                                                <div class="col-md-3">
												<div class="form-group label-floating">
													<label class="control-label">Rol</label>
													<input type="text" name="rol" class="form-control" value="<?php $eprint = ($no_value == 1)?$r["rolid"]:""; echo $eprint;?>">
												</div>
	                                        </div>
                                                
                                                
	                                        <div class="col-md-5">
												<div class="form-group label-floating">
													<label class="control-label">Dormitorios</label>
													<input type="text" name="dorm" class="form-control" value="<?php $eprint = ($no_value == 1)?$r["dorm"]:""; echo $eprint;?>">
												</div>
	                                        </div>
	                                        
	                                        <div class="col-md-4">
												<div class="form-group label-floating">
													<label class="control-label">Baños</label>
													<input type="text" name="banos" class="form-control" value="<?php $eprint = ($no_value == 1)?$r["banos"]:""; echo $eprint;?>">
												</div>
	                                        </div>
	                                    </div>

	                                    <div class="row">
	                                        <div class="col-md-6">
												<div class="form-group label-floating">
													<label class="control-label">Mts Superficie</label>
													<input type="text" name="mtscuad" class="form-control" value="<?php $eprint = ($no_value == 1)?$r["mtscuad"]:""; echo $eprint;?>">
												</div>
	                                        </div>
	                                        <div class="col-md-6">
												<div class="form-group label-floating">
													<label class="control-label">Mts Construida</label>
													<input type="text" name="mtscrd" class="form-control" value="<?php $eprint = ($no_value == 1)?$r["mtscrd"]:""; echo $eprint;?>">
												</div>
	                                        </div>
	                                    </div>

	                                    <div class="row">
	                                        <div class="col-md-6">
												<div class="form-group label-floating">
													<label class="control-label">Valor UF</label>
													<input type="text" name="ufprecio" class="form-control" value="<?php $eprint = ($no_value == 1)?$r["ufprecio"]:""; echo $eprint;?>">
												</div>
	                                        </div>
                                                <div class="col-md-6">
												<div class="form-group label-floating">
													<label class="control-label">Piscina</label>
													<input type="text" name="piscina" class="form-control" value="<?php $eprint = ($no_value == 1)?$r["piscina"]:""; echo $eprint;?>">
												</div>
	                                        </div>
	                                    </div>

	                                    <div class="row">
	                                        <div class="col-md-4">
												<div class="form-group label-floating">
													<label class="control-label">Gasto Común</label>
													<input type="text" name="gstcmn" class="form-control" value="<?php $eprint = ($no_value == 1)?$r["gstocmn"]:""; echo $eprint;?>">
												</div>
	                                        </div>
	                                        <div class="col-md-4">
												<div class="form-group label-floating">
													<label class="control-label">Contribución Anual</label>
													<input type="text" name="ctcan" class="form-control" value="<?php $eprint = ($no_value == 1)?$r["ctcan"]:""; echo $eprint;?>">
												</div>
	                                        </div>
	                                        <div class="col-md-4">
												<div class="form-group label-floating">
													<label class="control-label">Dirección</label>
													<input type="text" name="direccion" class="form-control" value="<?php $eprint = ($no_value == 1)?$r["direccion"]:""; echo $eprint;?>">
												</div>
	                                        </div>
	                                    </div>
                                            <div class="row">
                                                <div class="col-md-4">
												<div class="form-group label-floating">
													<label class="control-label">Comuna</label>
													<input type="text" name="comuna" class="form-control" value="<?php $eprint = ($no_value == 1)?$r["comuna"]:""; echo $eprint;?>">
												</div>
	                                        </div>
                                                <div class="col-md-4">
												<div class="form-group label-floating">
													<label class="control-label">Referencia</label>
													<input type="text" name="ref" class="form-control" value="<?php $eprint = ($no_value == 1)?$r["ref"]:""; echo $eprint;?>">
                                                                                                        <input type="hidden" name="id" value="0">
                                                                                                        <input type="hidden" name="upd" value="<?php $upd = ($no_value == 1)?"1":"0"; echo $upd;?>">
												</div>
	                                        </div>                                                
                                                </div>
	                                    <button type="submit" class="btn btn-primary pull-right"><?php $eprint = ($no_value == 1)?"Actualizar":"Ingresar"; echo $eprint;?></button>
	                                    <div class="clearfix"></div>
	                                </form>
	                            </div>
			</div>
                    <!-- TAB -->
                    
                    <div class="tab-pane" id="messages">
                            
                                <?php    
                                
                                    $FolderId = New UserSessions();
                                    
                                    $virtualF = '../virtual/'.$FolderId->GetIDforFolder($correo);
                                    
                                    
                                    if (file_exists($virtualF)){
                                    
                                    if ($handle = opendir($virtualF)) {

                                        while (false !== ($entry = readdir($handle))) { 

                                            if ($entry != "." && $entry != "..") {

                                                echo '<div class="card card-stats ">';
                                                    echo '<div class="card-header" data-background-color="orange">';                                 
                                                            echo '<img src="../virtual/'.$FolderId->GetIDforFolder($correo)."/".$entry.'" alt="Casa" height="42" width="42">';
                                                    echo '</div>';
                                                echo '<div class="card-content">';
                                                    echo '<p class="category">Espacio Usado</p>';
                                                    echo '<h3 class="title">49/50<small>GB</small></h3>';
                                                echo '</div>';
					echo '</div>';
                                            }						
                                        }
                                    }
                                    }

                            closedir($handle);
                                       
                                ?>
                          
                                <div class="container">
                                
                                <div class="row" style="padding-top:10px;">
                                <div class="col-xs-2">
                                <button id="uploadBtn" class="btn btn-large btn-primary">Subir Foto</button>
                                </div>
                                <div class="col-xs-10">
                                    <div id="progressOuter" class="progress progress-striped active" style="display:none;">
                                       <div id="progressBar" class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <div class="row" style="padding-top:10px;">
                                    <div class="col-xs-10">
                                        <div id="msgBox">
                                        </div>
                                    </div>
                                </div>
                                </div>    
                                </div>
			
         
                    
                    <!-- SIGUIENTE TAB -->
                    
                    
                    
			<div class="tab-pane" id="settings">
                                <div class="card-content table-responsive table-full-width">
                                    <div class="container">
                                        
                                        
                                        <form method="post" id="fileinfo" name="fileinfo" onsubmit="return submitForm();">
                                        <label>Seleccione Archivo:</label><br>
                                        <input type="file" name="file" required class="btn btn-default"/>
                                        <input type="submit" value="Subir Archivo" />
                                        
                                        
                                        <div id="output"></div>
                                        <div class="card">
	
                                        <div class="card-content table-responsive table-full-width">
                                                <table class="table">
                                                <thead class="text-danger">
                                                <th>Archivo</th>
                                                <th>Eliminar</th>
                                                </thead>
                                           <tbody>
				<tr>
					<td>
                                        <div class="radio">
                                        <label>
                                        <input type="radio" name="optionsRadios" class="DocSelect" value="cert_hipoteca">
                                        Certificado Hipoteca
                                        </label>
                                        </div></td>
					<td><i class="material-icons">check_circle</i><i class="material-icons">delete</i></td>
				</tr>
				<tr>
				<td>
                                        <div class="radio">
                                        <label>
                                        <input type="radio" name="optionsRadios" class="DocSelect" value="inscri_dominio">
                                        Inscripcion Dominio
                                        </label>
                                        </div>
                                </td>
					<td><i class="material-icons">delete</i></td>	
					
				</tr>
				<tr>
				<td>
                                        <div class="radio">
                                        <label>
                                        <input type="radio" name="optionsRadios" class="DocSelect" value="titulos_dominio">
                                        Titulo de Dominio
                                        </label>
                                        </div>
                                </td>
					<td><i class="material-icons">delete</i></td>	
					
				</tr>
                                <tr>
				<td>
                                        <div class="radio">
                                        <label>
                                        <input type="radio" name="optionsRadios" class="DocSelect" value="cert_avaluo">
                                        Certificado Avaluo
                                        </label>
                                        </div>
                                </td>
					<td><i class="material-icons">delete</i></td>	
					
				</tr>
                                <tr>
				<td>
                                        <div class="radio">
                                        <label>
                                        <input type="radio" name="optionsRadios" class="DocSelect" value="cert_deuda">
                                        Certificado de Deuda
                                        </label>
                                        </div>
                                </td>
					<td><i class="material-icons">delete</i></td>	
					
				</tr>
                                <tr>
				<td>
                                        <div class="radio">
                                        <label>
                                        <input type="radio" name="optionsRadios" class="DocSelect" value="cert_expro_muni">
                                        Certificado de Expropiacion Mun.
                                        </label>
                                        </div>
                                </td>
					<td><i class="material-icons">delete</i></td>	
					
				</tr>
                                <tr>
				<td>
                                        <div class="radio">
                                        <label>
                                        <input type="radio" name="optionsRadios" class="DocSelect" value="cert_expro_fisc">
                                        Certificado de Expropiacion Fiscal.
                                        </label>
                                        </div>
                                </td>
					<td><i class="material-icons">delete</i></td>	
					
				</tr>
                                <tr>
				<td>
                                        <div class="radio">
                                        <label>
                                        <input type="radio" name="optionsRadios" class="DocSelect" value="foto_planos">
                                        Fotografías Plano
                                        </label>
                                        </div>
                                </td>
					<td><i class="material-icons">delete</i></td>	
					
				</tr>
                                <tr>
				<td>
                                        <div class="radio">
                                        <label>
                                        <input type="radio" name="optionsRadios" class="DocSelect" value="cuen_basicas">
                                        Cuentas Básicas
                                        </label>
                                        </div>
                                </td>
					<td><i class="material-icons">delete</i></td>	
					
				</tr>
			</tbody>
		</table>
                                            
	</div>
</div>
                                        </form>                       
                                    </div>       
                                
                                </div>
				
			</div>
		</div>
	</div>

</div>
                    
                    
                    
                    
                </div>

                
                
                

 

			





			<footer class="footer">
				<div class="container-fluid">
					<nav class="pull-left">
						<ul>
							<li>
								<a href="signin.php">
									Inicio
								</a>
							</li>
							<li>
                                                            <a href="perfil.php">
									Registro
								</a>
							</li>
                                                        <li>
								<a href="matricular.php">
									Matricular
								</a>
							</li>
                                                        <li>
								<a href="comprar.php">
									Comprar
								</a>
							</li>
                                                        <li>
								<a href="vitrina.php">
									Vitrina
								</a>
							</li>
                                                        <li>
								<a href="agenda.php">
									Agenda
								</a>
							</li>
                                                        						
						</ul>
					</nav>
					<p class="copyright pull-right">
						&copy; <script>document.write(new Date().getFullYear())</script> 
					</p>
				</div>
			</footer>
		</div>
	</div>

</body>

	<!--   Core JS Files   -->
	
        
       
    

</html>