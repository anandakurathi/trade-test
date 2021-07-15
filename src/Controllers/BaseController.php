<?php


namespace Src\Controllers;


use Src\Config\Session;
use Src\Model\User;
use Src\Services\View;

class BaseController
{
    protected $session;

    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->session = Session::getInstance();
        $this->autoUserLogin();
    }

    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     * @param string $name Method name
     * @param array $args Arguments passed to the method
     *
     * @return void
     * @throws \Exception
     */
    public function __call(string $name, array $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            $this->pageNotFound();
        }
    }

    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before()
    {
    }

    /**
     * After filter - called after an action method.
     *
     * @return void
     */
    protected function after()
    {
    }

    /**
     * not Found Response
     * @throws \Exception
     */
    public function pageNotFound()
    {
        View::render('404');
        exit;
    }

    /**
     * Login an user by default
     * @return bool
     */
    protected function autoUserLogin(): bool
    {
        if (!isset($this->session) || !isset($this->session->user_id)) {
            $user = new User();
            $userInfo = $user->getUserById(1);
            if (!$userInfo) {
                View::render(500);
                exit;
            }

            $this->session->user_id = $userInfo['user_id'];
            $this->session->name = $userInfo['user_name'];
            $this->session->email = $userInfo['email'];
        }
        return true;
    }

}
