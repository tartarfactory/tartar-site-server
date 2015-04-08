<?php
/**
 * Created by IntelliJ IDEA.
 * User: HJ
 * Date: 2015-03-31
 * Time: ¿ÀÈÄ 2:19
 */

namespace App\Library;


class query {
    public static function redefinitionQuery($database, $get) {
        if(count($get)>0) {
            $database = $database->where(array_keys($get)[0],substr(array_values($get)[0],0,1),substr(array_values($get)[0],1));
            for($i=1;$i<count($get);$i++){
                if(array_keys($get)[$i] != 'or') {
                    if(array_key_exists("or",$get)) {
                        if(substr(array_values($get)[$i],0,1) == '%')
                            $database = $database->orwhere(array_keys($get)[$i],'like',substr(array_values($get)[$i],1));
                        else
                            $database = $database->orwhere(array_keys($get)[$i],substr(array_values($get)[$i],0,1),substr(array_values($get)[$i],1));

                    }
                    else {
                        if(substr(array_values($get)[$i],0,1) == '%')
                            $database = $database->where(array_keys($get)[$i],'like',substr(array_values($get)[$i],1));
                        else
                            $database = $database->where(array_keys($get)[$i],substr(array_values($get)[$i],0,1),substr(array_values($get)[$i],1));

                    }
                }
            }
        }
        return $database;
    }


}