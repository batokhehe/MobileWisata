<?php
namespace App\Libraries;

class Template_admin
{
    public function views($template = null, $data = null, $scripts = null)
    {
        if ($template != null) {
            # head
            $data['_styles']                            = view('admin/layout/styles', $data, array());
            $data['_scripts']                           = view('admin/layout/scripts', $data, array());
            $data['_meta']                              = view('admin/layout/meta', $data, array());
            $scripts != null ? $data['_custom_scripts'] = view($scripts, $data, array()) : '';

            # main
            $data['_header']  = view('admin/layout/header', $data, array());
            $data['_flash']   = view('admin/layout/flash', $data, array());
            $data['_sidebar'] = view('admin/layout/sidebar', $data, array());
            $data['_footer']  = view('admin/layout/footer', $data, array());

            # content
            $data['_content'] = view($template, $data, array());

            # modals
            // $data['_modals_action'] = view('admin/layout/modals/action', $data, array());
            // $data['_modals_form'] = view('admin/layout/modals/form', $data, array());

            echo $data['_app'] = view('admin/layout/app', $data, array());
        }
    }
}
