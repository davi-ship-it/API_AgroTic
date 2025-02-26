<?php
    class Home extends Controllers{

        public function __construct()
        {
            parent::__construct();
        }

        public function home($params)
        {
            $data['page_tag'] = "Home por que asi se llama el controlador";
            $data['page_title'] = "Página principal - Diego Calderon en Home yeii";
            $data['page_name'] = "home";
            $this->views->getView($this,"home",$data);//Para poder mostrar algo en las vistas
        }

    }

?>