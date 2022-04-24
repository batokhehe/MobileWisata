<?php
namespace App\Libraries;

class Template_web
{
    public function views($template = null, $data = null, $scripts = null)
    {
        if ($template != null) {
            # head
            $data['_styles']                            = view('web/layout/styles', $data, array());
            $data['_scripts']                           = view('web/layout/scripts', $data, array());
            $data['_meta']                              = view('web/layout/meta', $data, array());
            $scripts != null ? $data['_custom_scripts'] = view($scripts, $data, array()) : '';

            # main
            $data['_header']  = view('web/layout/header', $data, array());
            // $data['_flash']   = view('web/layout/flash', $data, array());
            // $data['_sidebar'] = view('web/layout/sidebar', $data, array());
            $data['_footer']  = view('web/layout/footer', $data, array());

            # content
            $data['_content'] = view($template, $data, array());

            # modals
            // $data['_modals_action'] = load->view('layout/modals/action', $data, array());
            // $data['_modals_form'] = load->view('layout/modals/form', $data, array());

            echo $data['_app'] = view('web/layout/app', $data, array());
        }
    }
}
