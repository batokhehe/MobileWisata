<?php

namespace App\Controllers;

use App\Models\HeadlineModel;

class Headline extends BaseController
{

    public $modulName = 'Headline';

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        return null;
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
                'data'     => new \stdClass,
            ];
            return $this->respondCreated($response);
        }

        $result = HeadlineModel::findById($id);

        if ($result) {
            $response = [
                'status'   => 200,
                'error'    => null,
                'message' => $this->modulName . ' Found',
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
        return null;
        return null;
        return null;
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
                'data'     => new \stdClass,
            ];
            return $this->respondCreated($response);
        }

        $model = new HeadlineModel();

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
            return $this->respondCreated([
                'status'  => 404,
                'error'   => true,
                'message' => 'Designated data to update not found',
                'data'    => [],
            ]);
        }

        if ($model->updateData($id, $model, $this->request, $this->user) === false) {
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

        return $this->respondCreated($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        return null;

    }
}
