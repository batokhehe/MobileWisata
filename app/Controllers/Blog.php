<?php

namespace App\Controllers;

use App\Models\BlogModel;
use App\Models\ConfigModel;

class Blog extends BaseController
{

    public $modulName = 'Blog';

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        if (empty($this->user)) {
            $response = [
                'status'   => 401,
                'error'    => true,
                'message' => 'Access denied',
                'data'     => [],
            ];
            return $this->respondCreated($response);
        }

        $limit = 0;
        $page  = 0;
        $query = '';

        if ($this->request->getGet('limit') || $this->request->getGet('page')) {
            $limit = $this->request->getGet('limit');
            $page  = $limit * $this->request->getGet('page');
        }
        if ($this->request->getGet('query')) {
            $query = $this->request->getGet('query');
        }

        if ($this->request->getGet('length') || $this->request->getGet('start')) {
            $limit = $this->request->getGet('length');
            $page  = $this->request->getGet('start');
        }
        if ($this->request->getGet('search')) {
            $query = $this->request->getGet('search')['value'];
        }

        $data    = BlogModel::getAll($this->request, $limit, $page, $query);
        $counter = BlogModel::getAllCounter();

        $response = [
            'status'          => 200,
            'error'           => null,
            'message'        => $this->modulName . ' Data ' . count($data) . ' Found',
            'data'            => $data,
            'recordsTotal'    => $counter,
            'recordsFiltered' => $counter,
        ];
        return $this->response->setStatusCode(200)->setJSON($response);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        if (empty($this->user)) {
            $response = [
                'status'   => 401,
                'error'    => true,
                'message' => 'Access denied',
                'data'     => [],
            ];
            return $this->response->setStatusCode(401)->setJSON($response);
        }

        $result = BlogModel::findById($id);

        if ($result) {
            $response = [
                'status'   => 200,
                'error'    => null,
                'message' => $this->modulName . ' Found',
                'data'     => $result,
            ];
            return $this->response->setStatusCode(200)->setJSON($response);
        } else {
            return $this->failNotFound('No ' . $this->modulName . ' Found with id ' . $id);
        }
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    function new () {
        //
    }

    /**
     * Create a new resource object, from 'posted' parameters
     *
     * @return mixed
     */
    public function create()
    {
        if (empty($this->user)) {
            $response = [
                'status'   => 401,
                'error'    => true,
                'message' => 'Access denied',
                'data'     => [],
            ];
            return $this->response->setStatusCode(401)->setJSON($response);
        }

        $model = new BlogModel();

        if (!$this->validate($model->validationRules, $model->validationMessages)) {
            $tmp      = $this->validator->getErrors();
            $response = [
                'status'  => 500,
                'error'   => true,
                'message' => reset($tmp),
                'data'    => new \stdClass,
            ];
            return $this->response->setStatusCode(500)->setJSON($response);
        }

        $config = ConfigModel::findById('image', 'blog');
        $path   = ConfigModel::findById('path', 'general');

        $file        = $this->request->getFile('image');
        $tmp_name    = $file->getName();
        $temp        = explode('.', $tmp_name);
        $newfilename = md5(round(microtime(true))) . '.' . strtolower(end($temp));

        $image = "";
        if ($file->move($config['path'], $newfilename)) {
            $image = $path['path'] . $config['path'] . $newfilename;
        } else {
            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 500,
                'error'   => true,
                'message' => 'Failed to upload image',
                'data'    => new \stdClass,
            ]);
        }

        if ($model->createNew($model, $this->request, $image, $this->user) === false) {
            $response = [
                'status'   => 500,
                'error'    => true,
                'message' => $this->modulName . ' Gagal Tersimpan',
                'params'   => $model->errors(),
            ];
        } else {
            $response = [
                'status'   => 200,
                'error'    => null,
                'message' => $this->modulName . ' Berhasil Tersimpan '];
        }

        return $this->response->setStatusCode($response['status'])->setJSON($response);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from 'posted' properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        if (empty($this->user)) {
            $response = [
                'status'   => 401,
                'error'    => true,
                'message' => 'Access denied',
                'data'     => [],
            ];
            return $this->response->setStatusCode(401)->setJSON($response);
        }

        $model = new BlogModel();

        if (!$this->validate($model->validationRules, $model->validationMessages)) {

            $tmp      = $this->validator->getErrors();
            $response = [
                'status'  => 500,
                'error'   => true,
                'message' => reset($tmp),
                'data'    => new \stdClass,
            ];
            return $this->response->setStatusCode(500)->setJSON($response);
        }

        if (!$model->findById($id)) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => 404,
                'error'   => true,
                'message' => 'Designated data to update not found',
                'data'    => new \stdClass,
            ]);
        }

        $image = '';
        if ($this->request->getFile('image')) {
            $config = ConfigModel::findById('image', 'blog');
            $path   = ConfigModel::findById('path', 'general');

            $file        = $this->request->getFile('image');
            $tmp_name    = $file->getName();
            $temp        = explode('.', $tmp_name);
            $newfilename = md5(round(microtime(true))) . '.' . strtolower(end($temp));

            if ($file->move($config['path'], $newfilename)) {
                $image = $path['path'] . $config['path'] . $newfilename;
            } else {
                return $this->response->setStatusCode(500)->setJSON([
                    'status'  => 500,
                    'error'   => true,
                    'message' => 'Failed to upload image',
                    'data'    => new \stdClass,
                ]);
            }
        }

        if ($model->updateData($id, $model, $this->request, $image, $this->user) === false) {
            return $this->response->setStatusCode(500)->setJSON([
                'status'   => 500,
                'error'    => true,
                'message' => $this->modulName . ' Gagal Tersimpan',
                'params'   => $model->errors(),
            ]);
        } else {
            return $this->response->setStatusCode(200)->setJSON([
                'status'   => 200,
                'error'    => null,
                'message' => $this->modulName . ' Berhasil Tersimpan ']);
        }
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $model = new BlogModel();
        if (empty($this->user)) {
            $response = [
                'status'   => 401,
                'error'    => true,
                'message' => 'Access denied',
                'data'     => [],
            ];
            return $this->response->setStatusCode(401)->setJSON($response);
        }

        // check availability
        if (!$model->findById($id)) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => 404,
                'error'   => true,
                'message' => 'Designated data to delete not found',
                'data'    => new \stdClass,
            ]);
        }

        $result = $model->softDelete($id, $model, $this->user);

        if ($result === false) {
            return $this->response->setStatusCode(500)->setJSON([
                'status'   => 500,
                'error'    => true,
                'message' => 'Data Failed to Deleted',
            ]);
        } else {
            return $this->response->setStatusCode(200)->setJSON([
                'status'   => 200,
                'error'    => null,
                'message' => 'Data Deleted',
            ]);
        }
    }
}
