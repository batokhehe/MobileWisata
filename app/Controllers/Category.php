<?php

namespace App\Controllers;

use App\Models\CategoryModel;

class Category extends BaseController
{

    public $modulName = 'Category';

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        // if (empty($this->user)) {
        //     $response = [
        //         'status'   => 401,
        //         'error'    => true,
        //         'messages' => 'Access denied',
        //         'data'     => new \stdClass,
        //     ];
        //     return $this->respondCreated($response);
        // }

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

        $data    = CategoryModel::getAll($this->request, $limit, $page, $query);
        $counter = CategoryModel::getAllCounter();

        $response = [
            'status'          => 200,
            'error'           => null,
            'messages'        => $this->modulName . ' Data ' . count($data) . ' Found',
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
                'messages' => 'Access denied',
                'data'     => new \stdClass,
            ];
            return $this->response->setStatusCode(401)->setJSON($response);
        }

        $result = CategoryModel::findById($id);

        if ($result) {
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => $this->modulName . ' Found',
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
                'messages' => 'Access denied',
                'data'     => new \stdClass,
            ];
            return $this->response->setStatusCode(401)->setJSON($response);
        }

        $model = new CategoryModel();

        if (!$this->validate($model->validationRules, $model->validationMessages)) {
            $response = [
                'status'  => 500,
                'error'   => true,
                'message' => $this->validator->getErrors(),
                'data'    => new \stdClass,
            ];
            return $this->response->setStatusCode(500)->setJSON($response);
        }

        if ($model->createNew($model, $this->request, $this->user) === false) {
            $response = [
                'status'   => 500,
                'error'    => true,
                'messages' => $this->modulName . ' Gagal Tersimpan',
                'params'   => $model->errors(),
            ];
        } else {
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => $this->modulName . ' Berhasil Tersimpan '];
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
                'messages' => 'Access denied',
                'data'     => new \stdClass,
            ];
            return $this->response->setStatusCode(401)->setJSON($response);
        }

        $model = new CategoryModel();

        if (!$this->validate($model->validationRules, $model->validationMessages)) {

            $response = [
                'status'  => 500,
                'error'   => true,
                'message' => $this->validator->getErrors(),
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

        if ($model->updateData($id, $model, $this->request, $this->user) === false) {
            return $this->response->setStatusCode(500)->setJSON([
                'status'   => 500,
                'error'    => true,
                'messages' => $this->modulName . ' Gagal Tersimpan',
                'params'   => $model->errors(),
            ]);
        } else {
            return $this->response->setStatusCode(200)->setJSON([
                'status'   => 200,
                'error'    => null,
                'messages' => $this->modulName . ' Berhasil Tersimpan ']);
        }
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $model = new CategoryModel();
        if (empty($this->user)) {
            $response = [
                'status'   => 401,
                'error'    => true,
                'messages' => 'Access denied',
                'data'     => new \stdClass,
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
                'messages' => 'Data Failed to Deleted',
            ]);
        } else {
            return $this->response->setStatusCode(200)->setJSON([
                'status'   => 200,
                'error'    => null,
                'messages' => 'Data Deleted',
            ]);
        }
    }
}
