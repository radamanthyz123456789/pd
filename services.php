<?php   

///////////////////////////////////////////////////////////////////////////
///////////////CODIGO PARA LEER UN ARCHIVO //////////////////////////////
$formatos = array('.txt');
$directorio='archivos';

$con =count(isset($_FILES['archivo']['name'])?$_FILES['archivo']['name']:0);

if (isset($_POST['boton'])){
  

  $nombreArchivo= $_FILES ['archivo']['name'];
  $nombreTmpArchivo= $_FILES ['archivo']['tmp_name'];
  $ext = substr($nombreArchivo, strrpos($nombreArchivo, '.'));
  if (in_array($ext, $formatos)) {
    if (move_uploaded_file($nombreTmpArchivo, "archivos/$nombreArchivo"))
    
       {echo "<script language='JavaScript'>alert('Grabacion Correcta +$con');</script>"; 
       }
       else{ echo "<script language='JavaScript'>alert('error al subir archivo +$con');</script>"; }
    
    
  }else{
    echo "<script language='JavaScript'>alert('formato incorrecto +$con');</script>"; 
  }
////////////////////////////////////////////////////////////////////////////////
}





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Services</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" media="screen" href="css/reset.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/grid_12.css">
    <link href='http://fonts.googleapis.com/css?family=Condiment' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
    <script src="js/jquery-1.7.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
</head>
<!--//////////////////////////////////////CUERPO///////////////////////////////////-->
<body>
  <div class="main">

<!--//////////////////////////DROPZONE///////////////////////////////////////-->
<!--/////////////ESTILOS Y EL ESXRIP DEL DROPZONE///////////////////////////-->
  <link rel="stylesheet" type="text/css" href="css/dropzone.css">
  <script type="text/javascript" src="js/dropzone.js"></script>
     
  <!--==============================header=================================-->
    <header>
        <h1><a href="index.html"><img src="images/logo.png" alt=""></a></h1>
        <div class="form-search">
            <form id="form-search" method="post">
              <input type="text" value="Type here..." onBlur="if(this.value=='') this.value='Type here...'" onFocus="if(this.value =='Type here...' ) this.value=''"  />
              <a href="#" onClick="document.getElementById('form-search').submit()" class="search_button"></a>
            </form>
        </div>
        <div class="clear"></div>
        <nav class="box-shadow">
            <div>
                <ul class="menu">
                    <li class="home-page"><a href="index.html"><span></span></a></li>
                    <li><a href="about.html">NOSOTROS</a></li>
                    <li class="current"><a href="services.html">SERVICIOS</a></li>
                     <li><a href="procesarvotos.php">VOTOS</a></li>
                </ul>
                <div class="social-icons">
                    <span>Follow us:</span>
                    <a href="#" class="icon-3"></a>
                    <a href="#" class="icon-2"></a>
                    <a href="#" class="icon-1"></a>
                </div>
                <div class="clear"></div>
            </div>
        </nav>
    </header>
  <!--==============================content================================-->
    <section id="content"><div class="ic"></div>
        <div class="container_12">
          <div class="grid_12">
            <div class="wrap pad-3">
                <div class="block-5">
                    <h3>lista de votantes</h3>
                     <ul class="list-1">
                    	<li><a href="#">lista 1</a></li>
                        <li><a href="#">lista 2</a></li>
                    </ul>
                </div>
                <div class="block-6">
                    <h3 class="p6"> LISTA DE LOS VOTANTES <strong> ARCHIVOS QUE ESTAN EN ELSERVIDOR</strong></h3>
                    <div class="caja">
                      <?php
                      /////////////////MOSTRAR LA LISTA DE LOS ARCHIVOS DEL SERVISDOR//////////////
                      if ($dir= opendir($directorio)) {
                        while ($archivo=readdir($dir)) {
                          if ($archivo !='.' && $archivo!='..') {
                          echo "Archivo: <strong>$archivo </strong> </br>";
                          }
                        }
                      }
                      ?>

                    </div>
                    <a href="procesarvotos.php" class="button">PROCESAR DATOS</a>
                     <div class="grid_12">
                    <form class="grid_12">
                      <li><a href="procesarvotos.php">procesar</a></li><br>
                    </form>
                  </div>
                </div >
                  <div class="grid_12">
                  <form  class="example" method="post" action="" enctype="multipart/form-data">
                    <div class="blok-6">
                    <input type="file" name="archivo" multiple="true"/></br> 
                    <input type="submit" value="Subir archivo" name="boton">
                  </div>
                  </form>
                </div>
                
                  <div class="grid_12">
                    <form class="grid_12">
                      .

                    </form>
                  </div>
                   <!--=======================contenido del dropzone=================================-->

        </br>
        <div class="grid_12">
          
        <div  class="example">

        <form action="subir.php" class="dropzone" id="drop_zone">
     <div class="fallback">
      <input type="file" name="file" multiple id="archivos">
    </div>
      </form>
       
        </div>
        </div>
        <!-- SCRIP PARA LEER EL ARCHIVO CON DROPZONE-->
        <script type="text/javascript">
              var drop_zone = new Dropzone("#archivos", {
                url: 'subir.php'
              });
              </script>
        <!--     OOOOOOOOOOOOOOOOOOOOOOOO    -->
            </div>
          </div>
          <div class="clear"></div>
        </div>
       
    </section>
  </div>
<!--==============================footer=================================-->
    <footer>
        <p>Docente : ING. Manuel Ibarra</p>
        <p> © Michi </p>
        <p>Desarrollo de Sotware</p>
    </footer>
</body>
</html>