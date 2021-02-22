<?php

function utf8_converter($array)
{
    array_walk_recursive($array, function(&$item, $key){
        if(!mb_detect_encoding($item, 'utf-8', true)){
                $item = utf8_encode($item);
        }
    });
 
    return $array;
}
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