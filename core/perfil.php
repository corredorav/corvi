<?php

require_once '../classes/UserSessions.php';
require_once '../classes/SearchFindShow.php';
require_once '../classes/MyErrorHandler.php';

session_start();

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

/**
 * Llamada a UserSession para Obtener los datos del perfil
 */

$up = new UserSessions();
$data_perfil = $up->GetUserData();


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

    

    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
 
    
     <!--AJAX -->  
      <script src="../assets/js/jquery-3.1.0.min.js" type="text/javascript"></script>-->
      <script src="../assets/js/jquery.form.js"></script>
        

        <script>
        $(document).ready(function() {

    // process the form
    $('#update').submit(function(event) {

        // get the form data
        // there are many ways to get this data using jQuery (you can use the class or id also)
        var formData = {
        'email' : $('input[name=email]').val(),
        'password' : $('input[name=password]').val(),
        'rut' : $('input[name=rut]').val(),
        'nombre' : $('input[name=nombre]').val(),
        'apellido' : $('input[name=apellido]').val(),
        'direccion' : $('input[name=direccion]').val(),
        'comuna' : $('#comuna').val(),
        'tcredito' : $('input[name=tcredito]').val(),
        'fvenc' : $('input[name=fvenc]').val(),
        'vali' : $('input[name=vali]').val()
        };

        // process the form
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'perfilp.php', // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
                        encode          : true
        })
            // using the done promise callback
            .done(function(data) {

                // log data to the console so we can see
                console.log(data);
                $('#errorum_row').show(data.code);
                $('#errorum').text(data.message);

                // here we will handle errors and validation messages
            });

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
    });

});

       

        
        
       
         
     


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
				<a href=".." class="simple-text">
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
	                <li class="active">
                            <a href="perfil.php">
	                        <i class="material-icons">person</i>
	                        <p>Perfil de Usuario</p>
	                    </a>
	                </li>
	                <li>
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
						<a class="navbar-brand" href="#">Perfil de Usuario</a>
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
									<span class="notification">5</span>
									<p class="hidden-lg hidden-md">Notifications</p>
								</a>
								<ul class="dropdown-menu">
									<li><a href="#">Tiene 5 nuevas solicitudes</a></li>
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
                    <div id="errorum_row" style="display: none;" class="row">
                        <div class="col-lg-7">
                                <div class="container-fluid">
                                    <div class="alert alert-danger">
                                            <div class="container-fluid">
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
                
                
                    
	        <div class="content">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-md-8">
	                        <div class="card">
	                            <div class="card-header" data-background-color="green">
	                                <h4 class="title">Edite perfil</h4>
									<p class="category">Complete su perfil</p>
	                            </div>
	                            <div class="card-content">
                                        <form id="update" method="post" action="perfilp.php">
                                            <div class="row">
                                                <div class="col-md-4">
												<div class="form-group label-floating">
													<label class="control-label">Correo Electrónico</label>
													<input name="email" type="email" class="form-control" value="<?php echo $data_perfil["email"];?>" disabled>
												</div>
	                                        </div>
                                                <div class="col-md-4">
												<div class="form-group label-floating">
													<label class="control-label">Contraseña</label>
													<input name="password" type="password" class="form-control" value="<?php echo $data_perfil["pass"];?>">
												</div>
	                                        </div>
                                                
                                                
                                            </div>
                                            
                                            
	                                    <div class="row">
	                                        <div class="col-md-5">
												<div class="form-group label-floating">
													<label class="control-label">Rut</label>
													<input name="rut" type="text" class="form-control" value="<?php echo $data_perfil["rut"];?>">
												</div>
	                                        </div>
	                                        
	                                        
	                                    </div>

	                                    <div class="row">
	                                        <div class="col-md-6">
												<div class="form-group label-floating">
													<label class="control-label">Nombre</label>
													<input name="nombre" type="text" class="form-control" value="<?php echo $data_perfil["nombre"];?>">
												</div>
	                                        </div>
	                                        <div class="col-md-6">
												<div class="form-group label-floating">
													<label class="control-label">Apellido</label>
													<input name="apellido" type="text" class="form-control" value="<?php echo $data_perfil["apellido"];?>">
												</div>
	                                        </div>
	                                    </div>

	                                    <div class="row">
	                                        <div class="col-md-12">
												<div class="form-group label-floating">
													<label class="control-label">Dirección</label>
													<input name="direccion" type="text" class="form-control" value="<?php echo $data_perfil["direccion"];?>">
												</div>
	                                        </div>
	                                    </div>

	                                    <div class="row">
	                                        <div class="col-md-4">
												<div class="form-group label-floating">
													<label class="control-label">Comuna</label>
												<?php	
                                                                                                        
                                                                                                        //$errline->ErrorFile("Comuna ->".$data_perfil["comuna"]);
                                                                                                        echo '<select id="comuna" name="comuna">';
                                                                                                            if ((int)$data_perfil["comuna"]==1){echo '<option value="1" selected>Cerrillos</option>';}else{echo '<option value="1">Cerrillos</option>';};                                                                     
                                                                                                            if ((int)$data_perfil["comuna"]==2){echo '<option value="2" selected>Cerro Navia</option>';}else{echo '<option value="2">Cerro Navia</option>';};
                                                                                                            if ((int)$data_perfil["comuna"]==3){echo '<option value="3" selected>Conchalí</option>';}else{echo '<option value="3">Conchalí</option>';};
                                                                                                            if ((int)$data_perfil["comuna"]==4){echo '<option value="4" selected>El Bosque</option>';}else{echo '<option value="4">El Bosque</option>';};
                                                                                                            if ((int)$data_perfil["comuna"]==5){echo '<option value="5" selected>Estación Central</option>';}else{echo '<option value="5">Estacion Central</option>';};
                                                                                                            if ((int)$data_perfil["comuna"]==6){echo '<option value="6" selected>Huechuraba</option>';}else{echo '<option value="6">Huechuraba</option>';};
                                                                                                            if ((int)$data_perfil["comuna"]==7){echo '<option value="7" selected>Independencia</option>';}else{echo '<option value="7">Independencia</option>';};
                                                                                                            if ((int)$data_perfil["comuna"]==8){echo '<option value="8" selected>La Cistena</option>';}else{echo '<option value="8">La Cisterna</option>';};
                                                                                                            if ((int)$data_perfil["comuna"]==9){echo '<option value="9" selected>La Florida</option>';}else{echo '<option value="9">La Florida</option>';};
                                                                                                            if ((int)$data_perfil["comuna"]==10){echo '<option value="10" selected>La Pintana</option>';}else{echo '<option value="10">La Pintana</option>';};
                                                                                                            if ((int)$data_perfil["comuna"]==11){echo '<option value="11" selected>La Granja</option>';}else{echo '<option value="11">La Granja</option>';};
                                                                                                            if ((int)$data_perfil["comuna"]==12){echo '<option value="12" selected>La Reina</option>';}else{echo '<option value="11">La Reina</option>';};
                                                                                                            if ((int)$data_perfil["comuna"]==13){echo '<option value="13" selected>Las Condes</option>';}else{echo '<option value="13">Las Condes</option>';};
                                                                                                            if ((int)$data_perfil["comuna"]==14){echo '<option value="14" selected>Lo Barnenechea</option>';}else{echo '<option value="14">Lo Barnechea</option>';};
                                                                                                          
                                                                                                   echo '</select>';
                                                                                                        
                                                                                                ?>        
												</div>
	                                        </div>
	                                        
	                                        
	                                    </div>
                                            <div class="row">
                                                <div class="col-md-4">
												<div class="input-group">
													<span class="input-group-addon">
                                                                                                        <i class="material-icons">credit_card</i>
                                                                                                        </span>
                                                                                                        <input name="tcredito" type="text" class="form-control" placeholder="Tarjeta Credito">
												</div>
	                                        </div>
                                                <div class="col-md-4">
												<div class="form-group label-floating">
													<label class="control-label">Fecha Vencimiento</label>
                                                                                                        <input name="fvenc" type="month" class="form-control" >
												</div>
	                                        </div>
                                                <div class="row">
                                                <div class="col-md-2">
												<div class="form-group label-floating">
													<label class="control-label">Validador</label>
													<input name="vali" type="text" class="form-control" >
                                                                                                </div>						
                                                </div>
	                                        </div>
                                                
                                                </div>

	                                    

	                                    <button type="submit" class="btn btn-primary pull-right">Actualizar</button>
	                                    <div class="clearfix"></div>
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
                                                            <a href="registrarse.php">
									Registrarse
								</a>
							</li>
                                                        
                                                        
	                    </ul>
	                </nav>
	                <p class="copyright pull-right">
	                    &copy; <script>document.write(new Date().getFullYear())</script> <a href="http://www.creative-tim.com"></a>
	                </p>
	            </div>
	        </footer>
	    </div>
	</div>

</body>

	<!--   Core JS Files   -->
	
	<script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="../assets/js/material.min.js" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="../assets/js/chartist.min.js"></script>

	<!--  Notifications Plugin    -->
	<script src="../assets/js/bootstrap-notify.js"></script>



	<!-- Material Dashboard javascript methods -->
	<script src="../assets/js/material-dashboard.js"></script>

	

</html>
