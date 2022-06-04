<?php

namespace App\Controllers;

use App\Models\BlogModel;
use App\Models\CategoryModel;
use App\Models\HomeModel;
use App\Models\UserModel;

class Home extends WebBaseController
{

    protected $headline;

    public function __construct()
    {
        $this->data['view'] = 'web';
        $this->home         = new HomeModel();
        $this->category     = new CategoryModel();
        $this->blog         = new BlogModel();
        $this->user         = new UserModel();
    }

    public function index()
    {
        $this->data['headline']    = $this->home->getHeadline();
        $this->data['destination'] = $this->home->getDestinationById($this->data['headline']['destination_id']);
        $this->data['media']       = $this->home->getMediaByDestinationId($this->data['destination']['id']);
        $this->data['popular']     = $this->home->getPopular();
        $this->data['blog']        = $this->home->getBlog();
        $this->data['guide']       = $this->home->getGuide();

        $this->template_web->views($this->data['view'] . '/index', $this->data, $this->data['view'] . '/scripts');
    }

    public function location_post($id)
    {
        $this->data['destination'] = $this->home->getPopularById($id);
        $this->data['rate']        = $this->home->getRateByDestinationId($id);
        $this->data['summary']     = $this->home->getReviewSummary($id);
        $this->template_web->views($this->data['view'] . '/location-post', $this->data, $this->data['view'] . '/scripts');
    }

    public function blog_post($id)
    {
        $this->data['blog']     = $this->home->getBlogById($id);
        $this->data['latest']   = $this->blog->getAll(null, '5', '0', '');
        $this->data['category'] = $this->category->getAll(null, '5', '0', '');
        $this->template_web->views($this->data['view'] . '/blog-post', $this->data, $this->data['view'] . '/scripts');
    }

    public function location()
    {
        $this->data['category'] = $this->category->getAll(null, '10', '0', '');
        $this->data['popular']  = $this->home->getPopular();

        $this->template_web->views($this->data['view'] . '/location', $this->data, $this->data['view'] . '/scripts');
    }

    public function blog_list()
    {
        $this->template_web->views($this->data['view'] . '/blog-list', $this->data, $this->data['view'] . '/scripts');
    }

    public function reset_password($id)
    {
        if (!$this->user->getUserByForgotCode($id)) {
            show_404();
        }

        $this->data['headline']    = $this->home->getHeadline();
        $this->data['destination'] = $this->home->getDestinationById($this->data['headline']['destination_id']);
        $this->data['media']       = $this->home->getMediaByDestinationId($this->data['destination']['id']);
        $this->data['popular']     = $this->home->getPopular();
        $this->data['blog']        = $this->home->getBlog();
        $this->data['guide']       = $this->home->getGuide();
        
        $this->data['reset_password'] = "true";
        $this->data['code']           = $id;
        $this->template_web->views($this->data['view'] . '/index', $this->data, $this->data['view'] . '/scripts');
    }
}
