<!DOCTYPE HTML>
<html>
    <head>
                <title>Contacts</title>
                    <meta charset="utf-8">
                    <link rel="stylesheet" type="text/css" media="screen" href="css/reset.css">
                    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css">
                    <link rel="stylesheet" type="text/css" media="screen" href="css/grid_12.css">
                    <link href='http://fonts.googleapis.com/css?family=Condiment' rel='stylesheet' type='text/css'>
                    <link href='http://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
                    <script src="js/jquery-1.7.min.js"></script>
                    <script src="js/jquery.easing.1.3.js"></script>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <title>Highcharts Example</title>
                <style type="text/css">
        </style>
    </head>


    <body>
<div class="main">
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
                    <li class="home-page current"><a href="index.html"><span></span></a></li>
                    <li><a href="about.html">NOSOTROS</a></li>
                    <li><a href="services.php">SERVICIOS</a></li>
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
<script src="js/highcharts.js"></script>
<script src="js/exporting.js"></script>




 <div class="container_12">
          <div class="grid_12">
            <div class="pad-0 border-1">
                <?php
    //FUNCION PARA LEER LOS ARCHIVOS DE TEXTTO
     function LEER($carpeta)
    {
        /////////CONTADORES/////////////
                $may=0;
                $a=0;
        /////////////////////// PARA LEER LOS ARCHIVOS DE LA CARPETA//////////////
            while ($lienea=readdir($carpeta)) 
        {
            if ($lienea !='.' && $lienea !='..') 
            {
                ///////////////USAMOS EXPLODE PARA SACAR LA EXTENECION DEL ARCHIVO ///////////
                list($nombre,$extension)=explode(".",$lienea);
                /////////////////////////// SI LA EXTENCION ES TXT ENTRAR EN LA CONDICION////////////
                if ($extension=="txt") 
                {
                    ////////////////// ABRIR LOS FICHEROS EN MODO LECTURA///////////////////////
                $leemos = @fopen("archivos/$lienea","r");
                ///////////////////LEEMOS LINEA POR LINEA DEL ARCHIVO/////////////////////
                while ($line=fgets($leemos)) 
                {
                    
                    ///////////////////////USAMOS el preg_split PARA SEPARAR LOS DATOS
                    
                     list($codigo,$lista,$sede)=preg_split("/[\s,\t]+/", $line);
                    if ($lista!="lista")
                     {
            //////////////////////////ARRAY DE LAS LISTA/////////////////////////////
                    $array[$a]=strtoupper($lista); 
                    $a=$a+1;
                        
                    }
                }

                }else
                {
                    //////////////////////////////LEER EL CONTENIDO PARA FICHEROS XML/////////////
                    if ($extension=="xml") 
                    {
                        $listas=simplexml_load_file("archivos/$lienea");
                        //////////////////SACAMOS EL TOTAL DE LAS LISTA///////////////
                        $total=count($listas->eleccion);
                        
                        for ($i=0; $i <$total ; $i++) { 
                            $array[$a]=$listas->eleccion[$i]->lista;
                            $a=$a+1;
                        }
                    }
                }
            }
                
        }
        return $array;      
    }
///////////////////////////////////// FUNCION PARA ORDENAR /////////////////////////////////
    function BURBUJA($A,$n)
    {
        for($i=1;$i<$n;$i++)
        {
                for($j=0;$j<$n-$i;$j++)
                {
                        if($A[$j]>$A[$j+1])
                        {
                            $k=$A[$j+1];
                             $A[$j+1]=$A[$j];

                              $A[$j]=$k;
                        }
                }
        }
      return $A;
    }
/////////////////////////////////////// PARA LEER EL ARCHIVO////////////////////////
    /////////////////////////ABRIR LA CARPETA ARCHIVO//////////////////////////////
        $abrearchivo=opendir("archivos/.");
        $listaArray=LEER($abrearchivo);
        $VectorB=BURBUJA ($listaArray,sizeof($listaArray));
        $VectorLimp=array_unique($VectorB);
        $m=0;
      $s=1;
      $unica=0;
        $total=count($listaArray);
         foreach ($VectorLimp as $key => $value)
          {
            
            foreach ($VectorB as $keyx => $valuex)
            {
               
                if ($value==$valuex) {
                   
                                       $m=$m+1;

                }
            }
            $unica++;
                
            if ($value=="0") {
                
                echo "Vototo nulos $value : $m<br>";
                $vb=($m*100)/$total;
                   // echo "voto viciado $value : $vb % <br>";
                
            }else
            {
                if ($value=="X") {
                  
                   echo "Votos viciados $value : $m<br>";
                    $vv=($m*100)/$total;
                   // echo "voto viciado $value : $vv % <br>";
                    //$m=0;
                }else
                {
                    echo "Lista $value : $m<br>";
                    $vectorpocentaje[$s]=$m;
                    $s++;
                    //$m=0;
                }
            }
            $m=0;
            
         }
         echo "Total de votates: $total<br>";
 /////////////////CONDICIONES PARA GANAR LAS ELEECIONES///////////////////

                $r=0;
                if ($unica==1) {
                    echo "las elecciones se anulan por ser lista unica<br>";
                }
                else
                {

            for ($i=1; $i <= count($vectorpocentaje); $i++) 
            { 
                //echo $vectorpocentaje[$i]."<br>";
                $porcentaje= ($vectorpocentaje[$i]/$total)*100;
                $MayoPorcentaje[$i]=$porcentaje;

                $porcentaje1=($vectorpocentaje[$i]*100)/$total;
                //echo "Lista $i : $porcentaje1 % <br>";

                if ($porcentaje>=50.1)
                {
                    echo "GANADOR Lista $i : $porcentaje %<br>";
                    $r++;
                }else
                {
                    if ($porcentaje<50.0) {
                        $r++;
                    }
                }
            }   
                    if ($r==0) {
                            echo "habrá segunda vuelta.....<br>";
                        }
                }

                echo " PORCENTAJE DE CADA LISTA <br>";
        for ($i=1; $i <= count($vectorpocentaje); $i++) 
            { 
                 $porcentaje1=($vectorpocentaje[$i]*100)/$total;
                echo "Lista $i : $porcentaje1 % <br>";
            }
             echo "voto viciado 0 : $vb % <br>";
              echo "voto viciado x : $vv % <br>";



///////////////////////////proceso para el examen////////////////
              

                ?>



                <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                <button   class="button" id="botongrafico"> llenar</button>
                <a href="procesarvotos.php" class="button">PROCESAR DATOS</a>
                    <a href="#" class="button" id="botongrafico">llenar</a>
            </div>
          </div>
          <div class="clear"></div>
        </div> 

<script type="text/javascript">

    

function b(){
Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Browser market shares January, 2015 to May, 2015'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.4f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },


    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [ {
            name: 'Chrome',
            y: 10,
            sliced: true,
            selected: true
        }, {
            name: 'Firefox',
            y: 30
        }, {
            name: 'Safari',
            y: 20
        }, {
            name: 'Opera',
            y: 10
        }, {
            name: 'Proprietary or Undetectable',
            y: 10
        }]
    }]
});
}

    b();
        </script>


        </div> 
    </body>

</html>

<!DOCTYPE HTML>
<html>
    <head>
                <title>Contacts</title>
                    <meta charset="utf-8">
                    <link rel="stylesheet" type="text/css" media="screen" href="css/reset.css">
                    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css">
                    <link rel="stylesheet" type="text/css" media="screen" href="css/grid_12.css">
                    <link href='http://fonts.googleapis.com/css?family=Condiment' rel='stylesheet' type='text/css'>
                    <link href='http://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
                    <script src="js/jquery-1.7.min.js"></script>
                    <script src="js/jquery.easing.1.3.js"></script>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <title>Highcharts Example</title>
                <style type="text/css">
        </style>
    </head>


    <body>
<div class="main">
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
                    <li class="home-page current"><a href="index.html"><span></span></a></li>
                    <li><a href="about.html">NOSOTROS</a></li>
                    <li><a href="services.php">SERVICIOS</a></li>
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
<script src="js/highcharts.js"></script>
<script src="js/exporting.js"></script>




 <div class="container_12">
          <div class="grid_12">
            <div class="pad-0 border-1">
                <?php
    //FUNCION PARA LEER LOS ARCHIVOS DE TEXTTO


     function LEER($carpeta)
    {
        /////////CONTADORES/////////////
                $may=0;
                $a=0;

                $alumno= new alumno1();
        /////////////////////// PARA LEER LOS ARCHIVOS DE LA CARPETA//////////////
            while ($lienea=readdir($carpeta)) 
        {
            if ($lienea !='.' && $lienea !='..') 
            {
                ///////////////USAMOS EXPLODE PARA SACAR LA EXTENECION DEL ARCHIVO ///////////
                list($nombre,$extension)=explode(".",$lienea);
                /////////////////////////// SI LA EXTENCION ES TXT ENTRAR EN LA CONDICION////////////
                if ($extension=="txt") 
                {
                    ////////////////// ABRIR LOS FICHEROS EN MODO LECTURA///////////////////////
                $leemos = @fopen("archivos/$lienea","r");
                ///////////////////LEEMOS LINEA POR LINEA DEL ARCHIVO/////////////////////
                while ($line=fgets($leemos)) 
                {
                    ///////////////////////USAMOS el preg_split PARA SEPARAR LOS DATOS
                     list($nombre,$nota)=preg_split("[,]", $line);
            //////////////////////////ARRAY DE LAS LISTA/////////////////////////////
                    $alumno->nombre=$nombre;
                    $alumno->nota=$nota;

                    if($alumno->nombre==$nombre[$a]){
                        $alumno->nombre==$nombre;
                        $alumno->nota= $alumno->nota + $nota[$a];
                         $a=$a+1;
                    }else{
                        $alumno->$nombre;
                        $nota->$nota;
                        $a=$a+1;
                    }

                }

                }
            }
                
        }
           
    }
    /**
    * 
    */
    class alumno1($nombre,$nota)
    {
            $nombre;
            $nota;  
    }
  
    


///////////////////////////////////////////////////////////////////////////////////
        $abrearchivo=opendir("archivos/.");
        $listaArray=LEER($abrearchivo);
        foreach ($listaArray as $key => $value) {
            echo "listaArray";
        }

/////////////////////////////////////////////////////////
/*    $abrearchivo=opendir("archivos/.");
        $listaArray=LEER($abrearchivo);
        $s=1;
        $suma=0;
        $arnom=$listaArray;
        $arnot=$listaArray;

        $total=count($listaArray);
        foreach ($arnom as $key => $value) {
            # code...
            foreach ($arnot as $key => $valuex) {
                # code...
                if($value==$valuex){
                echo "value <br>";
                echo "valuex";
                }
            }
        }
        echo "prueba";*/
    /*/////////////////////////ABRIR LA CARPETA ARCHIVO//////////////////////////////
        $abrearchivo=opendir("archivos/.");
        $listaArray=LEER($abrearchivo);
        $VectorB=BURBUJA ($listaArray,sizeof($listaArray));
        $VectorLimp=array_unique($VectorB);
        $m=0;
      $s=1;
      $unica=0;
        $total=count($listaArray);
         foreach ($VectorLimp as $key => $value)
          {
            
            foreach ($VectorB as $keyx => $valuex)
            {
               
                if ($value==$valuex) {
                   
                                       $m=$m+1;
            echo "$value    y  $valuex";

                }
            }
            $unica++;
                
            if ($value=="0") {
                
                echo "Vototo nulos $value : $m<br>";
                $vb=($m*100)/$total;
                   // echo "voto viciado $value : $vb % <br>";
                
            }else
            {
                if ($value=="X") {
                  
                   echo "Votos viciados $value : $m<br>";
                    $vv=($m*100)/$total;
                   // echo "voto viciado $value : $vv % <br>";
                    //$m=0;
                }else
                {
                    echo "Lista $value : $m<br>";
                    $vectorpocentaje[$s]=$m;
                    $s++;
                    //$m=0;
                }
            }
            $m=0;
            
         }
         echo "Total de votates: $total<br>";
 /////////////////CONDICIONES PARA GANAR LAS ELEECIONES///////////////////

                $r=0;
                if ($unica==1) {
                    echo "las elecciones se anulan por ser lista unica<br>";
                }
                else
                {

            for ($i=1; $i <= count($vectorpocentaje); $i++) 
            { 
                //echo $vectorpocentaje[$i]."<br>";
                $porcentaje= ($vectorpocentaje[$i]/$total)*100;
                $MayoPorcentaje[$i]=$porcentaje;

                $porcentaje1=($vectorpocentaje[$i]*100)/$total;
                //echo "Lista $i : $porcentaje1 % <br>";

                if ($porcentaje>=50.1)
                {
                    echo "GANADOR Lista $i : $porcentaje %<br>";
                    $r++;
                }else
                {
                    if ($porcentaje<50.0) {
                        $r++;
                    }
                }
            }   
                    if ($r==0) {
                            echo "habrá segunda vuelta.....<br>";
                        }
                }

                echo " PORCENTAJE DE CADA LISTA <br>";
        for ($i=1; $i <= count($vectorpocentaje); $i++) 
            { 
                 $porcentaje1=($vectorpocentaje[$i]*100)/$total;
                echo "Lista $i : $porcentaje1 % <br>";
            }
             echo "voto viciado 0 : $vb % <br>";
              echo "voto viciado x : $vv % <br>";
*/


///////////////////////////proceso para el examen////////////////


                ?>



                <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                <button   class="button" id="botongrafico"> llenar</button>
                <a href="procesarvotos.php" class="button">PROCESAR DATOS</a>
                    <a href="#" class="button" id="botongrafico">llenar</a>
            </div>
          </div>
          <div class="clear"></div>
        </div> 

<script type="text/javascript">

    

function b(){
Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Browser market shares January, 2015 to May, 2015'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.4f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },


    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [ {
            name: 'Chrome',
            y: 10,
            sliced: true,
            selected: true
        }, {
            name: 'Firefox',
            y: 30
        }, {
            name: 'Safari',
            y: 20
        }, {
            name: 'Opera',
            y: 10
        }, {
            name: 'Proprietary or Undetectable',
            y: 10
        }]
    }]
});
}

    b();
        </script>


        </div> 
    </body>

</html>

