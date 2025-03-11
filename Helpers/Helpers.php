<?php
//Encontrar directorio



function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}



function findFile($controllerName, $baseDir) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($baseDir, RecursiveDirectoryIterator::SKIP_DOTS)
    );
    
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getFilename() === $controllerName . ".php") {
            return $file->getPathname();
        }
    }
    return false;
}
//verificar contra

function verificarCS($contraseña) {
    if (strlen($contraseña) < 8) {
        return "La contraseña debe tener al menos 8 caracteres.";
    }

    if (!preg_match('/[A-Z]/', $contraseña)) {
        return "La contraseña debe contener al menos una letra mayúscula.";
    }

    if (!preg_match('/[0-9]/', $contraseña)) {
        return "La contraseña debe contener al menos un número.";
    }

    if (!preg_match('/[\W_]/', $contraseña)) {
        return "La contraseña debe contener al menos un carácter especial (por ejemplo, !, @, #, $, etc.).";
    }

    return true;
}

function encriptarContraseña($contraseña) {
    return password_hash($contraseña, PASSWORD_DEFAULT);
}

function rol($rol){
    $rolesPermitidos = ['aprendiz', 'instru', 'admin'];
            if (!in_array($rol, $rolesPermitidos)) {
                return "Rol no válido.";
            }
}

function t_EPA($EPA){
    $EPAPermitidos = ['Plaga', 'Enfermedad', 'Arvence'];
            if (!in_array($EPA, $EPAPermitidos)) {
                return "EPA no válido.";
            }
}



    //Retorla la url del proyecto
	function base_url()
	{
		return BASE_URL;
	}

    function media()
    {
        return BASE_URL."Assets";
    }

    //Muestra información formateada
	function dep($data)
    {
        $format  = print_r('<pre>');
        $format .= print_r($data);
        $format .= print_r('</pre>');
        return $format;
    }

    //Elimina exceso de espacios entre palabras
    function strClean($strCadena){
        $string = preg_replace(['/\s+/','/^\s|\s$/'],[' ',''], $strCadena);
        $string = trim($string); //Elimina espacios en blanco al inicio y al final
        $string = stripslashes($string); // Elimina las \ invertidas
        $string = str_ireplace("<script>","",$string);
        $string = str_ireplace("</script>","",$string);
        $string = str_ireplace("<script src>","",$string);
        $string = str_ireplace("<script type=>","",$string);
        $string = str_ireplace("SELECT * FROM","",$string);
        $string = str_ireplace("DELETE FROM","",$string);
        $string = str_ireplace("INSERT INTO","",$string);
        $string = str_ireplace("SELECT COUNT(*) FROM","",$string);
        $string = str_ireplace("DROP TABLE","",$string);
        $string = str_ireplace("OR '1'='1","",$string);
        $string = str_ireplace('OR "1"="1"',"",$string);
        $string = str_ireplace('OR ´1´=´1´',"",$string);
        $string = str_ireplace("is NULL; --","",$string);
        $string = str_ireplace("is NULL; --","",$string);
        $string = str_ireplace("LIKE '","",$string);
        $string = str_ireplace('LIKE "',"",$string);
        $string = str_ireplace("LIKE ´","",$string);
        $string = str_ireplace("OR 'a'='a","",$string);
        $string = str_ireplace('OR "a"="a',"",$string);
        $string = str_ireplace("OR ´a´=´a","",$string);
        $string = str_ireplace("OR ´a´=´a","",$string);
        $string = str_ireplace("--","",$string);
        $string = str_ireplace("^","",$string);
        $string = str_ireplace("[","",$string);
        $string = str_ireplace("]","",$string);
        $string = str_ireplace("==","",$string);
        return $string;
    }

    function jsonResponse(array $arrData, int $code){

        header("HTTP/1.1 $code");
        header("Content-Type: application/json");
        echo json_encode($arrData);
    }

    function testString(string $data){
        $re = '/[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/m';
        if(preg_match($re,$data)){
            return true;
        }else{
            return false;
        }
    }
function testEntero(int $numero){
    $re = '/[0-9]+$/m';
    if(preg_match($re,$numero)){
        return true;
    }else{
        return false;
    }
}
function testEmail(string $email){
    $re = '/[a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/m';
    if(preg_match($re,$email)){
        return true;
    }else{
        return false;
    }
}

 function procesarImg($imagen) {
    // Verifica que la imagen se haya subido sin errores
    if ($imagen['error'] !== UPLOAD_ERR_OK) {
         throw new Exception("Error al subir la imagen.");
    }
    
    // Verifica que el archivo sea una imagen válida
    $info = getimagesize($imagen['tmp_name']);
    if ($info === false) {
         throw new Exception("El archivo no es una imagen válida.");
    }
    
    // Verifica que el tamaño de la imagen no exceda 5MB
    if ($imagen['size'] > 5 * 1024 * 1024) {
         throw new Exception("El tamaño de la imagen excede el límite permitido (5MB).");
    }
    
    // Define el directorio de destino para las imágenes
    $directorio = "uploads/";
    // Genera un nombre único para el archivo
    $extension = pathinfo($imagen['name'], PATHINFO_EXTENSION);
    $nombreArchivo = uniqid("img_", true) . "." . $extension;
    $rutaDestino = $directorio . $nombreArchivo;
    
    // Mueve el archivo a la carpeta de destino
    if (!move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
         throw new Exception("Error al mover la imagen al directorio de destino.");
    }
    
    // Retorna la ruta donde se guardó la imagen
    return $rutaDestino;
}

?>