<?php

namespace App\Controllers;

use App\Models\HomeModel;

class Home extends WebBaseController
{

    protected $headline;

    public function __construct()
    {
    	$this->data['view'] = 'web';
        $this->home = new HomeModel();
    }

    public function index()
    {
        $this->data['headline'] = $this->home->getHeadline();
        $this->data['destination'] = $this->home->getDestinationById($this->data['headline']['destination_id']);
        $this->data['media'] = $this->home->getMediaByDestinationId($this->data['destination']['id']);
        $this->data['popular'] = $this->home->getPopular();

    	$this->template_web->views($this->data['view'] . '/index', $this->data, $this->data['view'] . '/scripts');    	
    }

    public function location_post($id)
    {
    	$this->template_web->views($this->data['view'] . '/location-post', $this->data, $this->data['view'] . '/scripts');    	
    }

    public function blog_post($id)
    {
    	$this->template_web->views($this->data['view'] . '/blog-post', $this->data, $this->data['view'] . '/scripts');    	
    }

    public function location()
    {
    	$this->template_web->views($this->data['view'] . '/location', $this->data, $this->data['view'] . '/scripts');    	
    }

    public function blog_list()
    {
    	$this->template_web->views($this->data['view'] . '/blog-list', $this->data, $this->data['view'] . '/scripts');    	
    }
}
