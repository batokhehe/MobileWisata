<?php

namespace App\Controllers;

use App\Libraries\BreadcrumbsLib;
use App\Libraries\IonAuth;
use App\Libraries\MenuLib;
use App\Libraries\SecurityLib;

class HeadlineAdmin extends AdminBaseController
{
    public function __construct()
    {
        $this->data['view']     = 'admin/headline';
        $this->data['menu']     = 'Headline';
        $this->data['slug']     = 'Headline';
        $this->data['required'] = '<span style="color:red">* Required</span></br></br>';
        helper('custom');
        middleware(new IonAuth(), $this->data['slug']);

        $this->session             = \Config\Services::session();
        $this->data['session']     = $this->session->get();
        $this->data['securitylib'] = new SecurityLib();
        $this->data['menulib']     = new MenuLib();
        /*
         * Current active menu
         * # Simply copy & paste code below
         * # to every controllers
         */
        $this->data['menulib']->active_menu = $this->data['slug'];

        /*
         * Breadcrumbs
         * # Copy code below to every controllers
         * # Don't forget to add to view html code below
         * # <?php echo $breadcrumbs; ?>
         * # inside <section class="content-header">
         * # on "view/index.php"
         */
        $breadcrumbslib            = new BreadcrumbsLib();
        $menu_id                   = $breadcrumbslib->getMenuId($this->data['slug']);
        $this->data['breadcrumbs'] = $breadcrumbslib->breadcrumbs($menu_id);
    }

    public function index()
    {
        $this->template_admin->views($this->data['view'] . '/index', $this->data, $this->data['view'] . '/scripts');
    }
}
