<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Seo extends CI_Controller {

    function sitemap()
    {

        $data = "";//select urls from DB to Array
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view("sitemap",$data);
    }

    function robots()
    {

        $this->load->view("robots");
    }
}