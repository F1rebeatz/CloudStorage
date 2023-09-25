<?php

namespace Kernel\Container;

use Kernel\Auth\Auth;
use Kernel\Auth\AuthInterface;
use Kernel\Config\Config;
use Kernel\Config\ConfigInterface;
use Kernel\Database\Database;
use Kernel\Database\DatabaseInterface;
use Kernel\Http\Redirect;
use Kernel\Http\RedirectInterface;
use Kernel\Http\Request;
use Kernel\Http\RequestInterface;
use Kernel\Router\Router;
use Kernel\Router\RouterInterface;
use Kernel\Session\Session;
use Kernel\Session\SessionInterface;
use Kernel\Validator\Validator;
use Kernel\Validator\ValidatorInterface;
use Kernel\View\View;
use Kernel\View\ViewInterface;

class Container
{
    public readonly RequestInterface $request;
    public readonly RouterInterface $router;
    public readonly ViewInterface $view;
    public readonly ValidatorInterface $validator;
    public readonly RedirectInterface $redirect;
    public readonly SessionInterface $session;
    public readonly ConfigInterface $config;
    public readonly DatabaseInterface $database;
    public readonly AuthInterface $auth;

    public function __construct()
    {
        $this->registerServices();
    }

    public function registerServices(): void
    {
        $this->request = Request::createFromGlobals();
        $this->validator = new Validator();
        $this->request->setValidator($this->validator);
        $this->redirect = new Redirect();
        $this->session = new Session();
        $this->config = new Config();
        $this->database = new Database($this->config);
        $this->auth = new Auth($this->database, $this->session, $this->config);
        $this->view = new View($this->session, $this->auth);
        $this->router = new Router($this->view, $this->request, $this->redirect, $this->session, $this->database, $this->auth);
    }
}