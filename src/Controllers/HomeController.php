<?php


namespace Src\Controllers;


use Src\Services\View;

class HomeController extends BaseController
{
    /**
     * Load home page of application
     * @param $params
     * @throws \Exception
     */
    public function index()
    {
        View::render('home');
    }
}