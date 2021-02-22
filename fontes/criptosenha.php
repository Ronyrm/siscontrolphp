<?php
    if (isset($_GET["edtsenha"]))
    {
        $edtsenha   = $_GET["edtsenha"];
        
        $array = array('Login' => array('senha' => $edtsenha));
        // write ini file
        write_ini_file($array,'../config.ini');
        
        $output = array();
        exec("C:\\Windows\\system32\\rundll32.exe criptosenha.dll RetornaCriptoSenha", $output);
        
        $readData = parse_ini_file('../config.ini',true);
        $SenhaCripto = array();
        $SenhaCripto['boleano']=true;
        $SenhaCripto['senhacriptografada'] = $readData['Criptografa']['senhacripto'];
        echo json_encode($SenhaCripto);
    }
?>
<?php
function write_ini_file($array, $path) {
    unset($content, $arrayMulti);

    # See if the array input is multidimensional.
    foreach($array AS $arrayTest){
        if(is_array($arrayTest)) {
          $arrayMulti = true;
        }
    }
    $content = "";

    # Use categories in the INI file for multidimensional array OR use basic INI file:
    if ($arrayMulti) {
        foreach ($array AS $key => $elem) {
            $content .= "[" . $key . "]\n";
            foreach ($elem AS $key2 => $elem2) {
                if (is_array($elem2)) {
                    for ($i = 0; $i < count($elem2); $i++) {
                        $content .= $key2 . "[] = \"" . $elem2[$i] . "\"\n";
                    }
                } else if ($elem2 == "") {
                    $content .= $key2 . " = \n";
                } else {
                    $content .= $key2 . " = \"" . $elem2 . "\"\n";
                }
            }
        }
    } else {
        foreach ($array AS $key2 => $elem2) {
            if (is_array($elem2)) {
                for ($i = 0; $i < count($elem2); $i++) {
                    $content .= $key2 . "[] = \"" . $elem2[$i] . "\"\n";
                }
            } else if ($elem2 == "") {
                $content .= $key2 . " = \n";
            } else {
                $content .= $key2 . " = \"" . $elem2 . "\"\n";
            }
        }
    }

    if (!$handle = fopen($path, 'w')) {
        return false;
    }
    if (!fwrite($handle, $content)) {
        return false;
    }
    fclose($handle);
    return true;
}

?>