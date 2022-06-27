<?php
namespace App\Controllers;

use App\Libraries\IonAuth;
use App\Libraries\Template_admin;
use CodeIgniter\Controller;

class AdminBaseController extends Controller
{

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['custom'];

    protected $template_admin;
    protected $ionAuth;
    protected $session;

    /**
     * Constructor.
     */
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->template_admin = new Template_admin();
        $this->ionAuth        = new IonAuth();
        $this->session = \Config\Services::session(); 
    }

}
