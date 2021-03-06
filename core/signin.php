

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Login In</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />

    <!--  Material Dashboard CSS    -->
    <link href="../assets/css/material-dashboard.css" rel="stylesheet"/>

   

    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
    
   <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> -->
    <!--AJAX -->  
      <script src="../assets/js/jquery-3.1.0.min.js" type="text/javascript"></script>
      <script src="../assets/js/jquery.form.js"></script>
        
        <script>
        
    // prepare the form when the DOM is ready 
$(document).ready(function() { 
    var options = { 
        //target:        '#signin',   // target element(s) to be updated with server response
        dataType:  'json',
        //beforeSubmit:  showRequest,  // pre-submit callback 
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
    $('#signin').submit(function() { 
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
    //var formUser = jqForm[0].value;
    //var formPass = jqForm[1].value;
    
    //if (formUser == "" || formPass == "") {
        
    //   $('#errorum_row').show();
    //   $('#errorum').text("Valor vacío");
    //   return false;
   //}
 
    //alert('About to submit: \n\n' + queryString); 
    //CL03
    // here we could return false to prevent the form from being submitted; 
    // returning anything other than false will allow the form submit to continue 
    return true; 
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
 
    //alert('code: ' + data.code + '\n\nresponseText: \n' + data.message );
      //  '\n\nThe output div should have already been updated with the responseText.'); 
       var code;
       code = data.code;
       
       if ( code.localeCompare("201") && code.localeCompare("200")) {
            $('#errorum_row').show(data.code);
            $('#errorum').text(data.message);
        }
        else{
            //alert('code: ' + data.code + '\n\nresponseText: \n' + data.message );;
            <?php
            echo "$(location).attr('href', 'https://".$_SERVER['SERVER_NAME']."/corvi/core/vitrina.php')";
            
             ?>       
            
        }
        
        
        
        
        
        
        
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
				<a href="signup.php" class="simple-text">
					CORVI
				</a>
			</div>

	    	<div class="sidebar-wrapper">
				<ul class="nav">
	               <li class="active">
	                    <a href="signin.php" >
	                        <i class="material-icons">person</i>
	                        <p>Inicio</p>
	                    </a>
	                </li>                      
	                
	                <li>
                            <a href="registrarse.php">
	                        <i class="material-icons">person_add</i>
	                        <p>Registrarse</p>
	                    </a>
	                </li>
	                
	            </ul>
	    	</div>
	    </div>

            
            
                
     
	    <div class="main-panel">
                
                
                
	        <div class="content">
                    
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
                
                
                
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-md-8">
	                        <div class="card">
	                            <div class="card-header" data-background-color="green">
	                                <h4 class="title">Log In</h4>
									<p class="category">Ingrese sus datos</p>
	                            </div>
	                            <div class="card-content">
                                        <form id="signin" action="signinp.php" method="post">
	                                    <div class="row">
	                                        <div class="col-md-4">
												<div class="form-group label-floating">
													<label class="control-label">Correo Electrónico</label>
													<input name="email" type="email" class="form-control" >
												</div>
	                                        </div>
	                                    </div>

	                                    <div class="row">
	                                        <div class="col-md-4">
												<div class="form-group label-floating">
													<label class="control-label">Contraseña</label>
													<input name="password" type="Password" class="form-control" >
												</div>
	                                        </div>
	                                    </div>




	                                    <button type="submit" class="btn btn-primary pull-right">Ingresar</button>
	                                    <div class="clearfix"></div>
                                            
	                                </form>
					<div class="row">
                                                <div class="col-md-6">
                                                    <form id="lost" action="signinp.php" method="post">
                                                        <div class="alert alert-info">
                                                                <button type="button" aria-hidden="true" class="close"><i class="material-icons">vpn_key</i></button>
                                                                <span>Perdí mi Contraseña!</span>
                                                        </div>
                                                    </form>
                                                </div>
                                        </div>
	                            </div>
	                        </div>
	                    </div>


						<div class="col-md-4">
    						<div class="card card-profile">
    							<div class="card-avatar">
    								<a href="#pablo">
    									<img class="img" src="../assets/img/corvi.png" />
    								</a>
    							</div>

    							<div class="content">
    								<h6 class="category text-gray">CORVI</h6>
    								<h4 class="card-title">CORVI</h4>
    								<p class="card-content">
    									Esta opcion te permitirá reducir significativamente el costo por vender tu propiedad. Paga justo lo necesario por tu vivienda, no pagues demás!	
    								</p>
    								
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
	                            <a href="#">
	                                Inicio
	                            </a>
	                        </li>
	                        
	                    </ul>
	                </nav>
	                
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
