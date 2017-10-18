

<title>  </title>

<?php   
$formatos = array ('.txt');
$directorio='archivos';

if (isset($_POST['boton1'])){
	$nombreArchivo= $_FILES ['archivo']['name'];
	$nombreArchivo= $_FILES ['archivo']['tmp_name'];
	$ext = substr($nombreArchivo, strrpos($nombreArchivo, '.'));
	if (in_array($ext, $formatos)) {
		if (move_uploaded_file($nombreArchivo, "archivo/$nombreArchivo")
			echo "Felicitaciones, archivo :)";
			) {
			 else{ echo "ocurrio un error";}
		}
		
	}else{
		echo "Archivo no permitido";
	}


}


 
/*$dir_subida = 'UpLoad/'; $fichero_subido = $dir_subida . basename($_FILES['fichero_usuario']['name']); 
 
echo '<pre>'; if (move_uploaded_file($_FILES['fichero_usuario']['tmp_name'], $fichero_subido)) 

{     echo "El fichero es válido y se subió con éxito.\n"; }

else {     echo "¡problemas al subir el archivo... no se subió!\n"; }

 echo 'Más información de depuración:'; print_r($_FILES);

 print "</pre>";
*/
 ?> 