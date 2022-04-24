<?php

namespace App\Controllers;

use App\Models\FavoriteModel;

class Favorite extends BaseController
{

    public $modulName = 'Favorite';

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
                'messages' => 'Access denied',
                'data'     => [],
            ];
            return $this->respondCreated($response);
        }

        $data = FavoriteModel::getAll($this->user, $this->request, $this->request->getGet('limit'), $this->request->getGet('page'));

        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => $this->modulName . ' Data ' . count($data) . ' Found',
            'data'     => $data,
        ];
        return $this->respond($response);
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
                'data'     => [],
            ];
            return $this->respondCreated($response);
        }

        $result = FavoriteModel::findById($id);

        if ($result) {
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => $this->modulName . ' Found',
                'data'     => $result,
            ];
            return $this->respond($response);
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
                'data'     => [],
            ];
            return $this->respondCreated($response);
        }

        $model = new FavoriteModel();

        if (!$this->validate($model->validationRules, $model->validationMessages)) {
            $response = [
                'status'  => 500,
                'error'   => true,
                'message' => $this->validator->getErrors(),
                'data'    => [],
            ];
            return $this->respondCreated($response);
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

        return $this->respondCreated($response);
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
                'data'     => [],
            ];
            return $this->respondCreated($response);
        }

        return $this->respondCreated([
            'status'  => 404,
            'error'   => true,
            'message' => 'Designated data to update not found',
            'data'    => [],
        ]);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $model = new FavoriteModel();
        if (empty($this->user)) {
            $response = [
                'status'   => 401,
                'error'    => true,
                'messages' => 'Access denied',
                'data'     => [],
            ];
            return $this->respondCreated($response);
        }

        // check availability
        if (!$model->findById($id)) {
            return $this->respondCreated([
                'status'  => 404,
                'error'   => true,
                'message' => 'Designated data to delete not found',
                'data'    => [],
            ]);
        }

        $result = $model->softDelete($id, $model);

        if ($result === false) {
            $response = [
                'status'   => 500,
                'error'    => true,
                'messages' => 'Data Failed to Deleted',
            ];
        } else {
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => 'Data Deleted',
            ];
        }
        return $this->respond($response);
    }
}
