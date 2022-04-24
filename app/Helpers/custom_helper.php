<?php

function timestamp()
{
    return date('Y-m-d H:i:s');
}

function middleware($context, $slug)
{
    if (!$context->loggedIn()) {
        return redirect()->to('/admin/auth/login');
    }
    //     if (!$_ci->securitylib->check_access('index', $slug)) {
    //         // show_404();
    //         redirect(base_url()."dashboard");
    //     }
    // }
}

if (!function_exists('breadcrumbs')) {
    function breadcrumbs($slug)
    {
        $_ci    = &get_instance();
        $return = $_ci->breadcrumbslib->generateBreadcrumbs($slug);
    }
}

if (!function_exists('print_icon')) {
    function print_icon($icon)
    {
        if (strpos($icon, 'fa ') !== false) {
            return '<i class="' . $icon . '"></i>';
        } elseif (strpos($icon, 'fa-') !== false) {
            return '<i class="fa ' . $icon . '"></i>';
        }
    }
}
