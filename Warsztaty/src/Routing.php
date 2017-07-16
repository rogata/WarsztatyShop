<?php


class Routing
{

    static public function start(){

         $cuttedUri = substr(          
            $_SERVER['REQUEST_URI'],           
            strpos($_SERVER['REQUEST_URI'], "index.php/")          
            + 9       
    );       
         
    $parsedRequest = explode('/' , $cuttedUri);
    
    
    $className = ucfirst($parsedRequest['1']);
    
        self::loadClass($className);
        $object = self::createObject($className);

        if (!empty($_GET)) {

            $function = substr(
                $parsedRequest['2'],
                0,
                strrpos($parsedRequest['2'], '?')
            );

            $values = array_values($_GET);
            $object->$function(...$values);
        } else {
            $function = $parsedRequest['2'];
            $object->$function();
        }
    }

    static private function loadClass(string $className){

        include $className .
            DIRECTORY_SEPARATOR . $className . '.php';

    }

    static private function createObject(string $className){
        return new $className;
    }

}