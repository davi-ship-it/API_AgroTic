<?php
    class ActiController extends Controllers{

        public function __construct()
        {
            parent::__construct();
        }

       
    public function hola(){
        $_POST = json_decode(file_get_contents("php://input"), true);
        $nom = $_POST["act_nombre"];
        echo "hola " . $nom;
    }


    }

?>