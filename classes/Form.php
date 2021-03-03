<?php 
    class Form
    {
        public array $get = array();
        public array $post = array();

        public function __construct(array $get = null, array $post = null){
            if (isset($get)) {
                $this->get = $get;
            }

            if (isset($post)) {
                $this->post = $post;
            }
        }
    }
?>