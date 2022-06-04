<?php

namespace App\Controllers;

use App\Models\ConfigModel;
use App\Models\MediaModel;

class Media extends BaseController
{

    public $modulName = 'Media';

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
                'data'     => new \stdClass,
            ];
            return $this->respondCreated($response);
        }

        $data = MediaModel::getAll($this->request);

        $response = [
            'status'          => 200,
            'error'           => null,
            'message'        => $this->modulName . ' Data ' . count($data) . ' Found',
            'data'            => $data,
            'recordsTotal'    => count($data),
            'recordsFiltered' => count($data),
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
                'data'     => new \stdClass,
            ];
            return $this->respondCreated($response);
        }

        $result = MediaModel::findById($id);

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
        if (empty($this->user)) {
            $response = [
                'status'   => 401,
                'error'    => true,
                'message' => 'Access denied',
                'data'     => new \stdClass,
            ];
            return $this->respondCreated($response);
        }

        $model = new MediaModel();

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

        $media_type = $this->request->getVar('media_type');
        if ($media_type != 'youtube' && $media_type != 'video' && $media_type != 'image') {
            $response = [
                'status'  => 500,
                'error'   => true,
                'message' => 'Not Supported Media Type',
                'data'    => [],
            ];
            return $this->respondCreated($response);
        }

        // Renaming file before upload
        if ($media_type != 'youtube') {
            if (!$this->request->getFile('media')) {
                return $this->respondCreated([
                    'status'  => 500,
                    'error'   => true,
                    'message' => 'Media field is required',
                    'data'    => [],
                ]);
            }
            $config        = ConfigModel::findById($media_type, 'destination');
            $path          = ConfigModel::findById('path', 'general');
            $file          = $this->request->getFile('media');
            $profile_image = $file->getName();
            $temp          = explode('.', $profile_image);
            $newfilename   = round(microtime(true)) . '.' . end($temp);

            if ($file->move($config['path'], $newfilename)) {
                $file_name = $newfilename;
                $file_path = $path['path'] . $config['path'] . $file_name;
            } else {
                return $this->respondCreated([
                    'status'  => 500,
                    'error'   => true,
                    'message' => 'Failed to upload image',
                    'data'    => [],
                ]);
            }
        } else {
            if (!$this->request->getVar('link')) {
                return $this->respondCreated([
                    'status'  => 500,
                    'error'   => true,
                    'message' => 'Youtube Link field is required',
                    'data'    => [],
                ]);
            }
            $file_name = $this->request->getVar('link');
            $file_path = $this->request->getVar('link');
        }

        if ($model->createNew($model, $this->request, $file_name, $file_path, $this->user) === false) {
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

        $model = new MediaModel();

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

        $media_type = $this->request->getVar('media_type');
        if ($media_type != 'youtube' && $media_type != 'video' && $media_type != 'image') {
            $response = [
                'status'  => 500,
                'error'   => true,
                'message' => 'Not Supported Media Type',
                'data'    => [],
            ];
            return $this->respondCreated($response);
        }

        // Renaming file before upload
        if ($media_type != 'youtube') {
            if (!$this->request->getFile('media')) {
                return $this->respondCreated([
                    'status'  => 500,
                    'error'   => true,
                    'message' => 'Media field is required',
                    'data'    => [],
                ]);
            }
            $config        = ConfigModel::findById($media_type, 'destination');
            $path          = ConfigModel::findById('path', 'general');
            $file          = $this->request->getFile('media');
            $profile_image = $file->getName();
            $temp          = explode('.', $profile_image);
            $newfilename   = round(microtime(true)) . '.' . end($temp);

            if ($file->move($config['path'], $newfilename)) {
                $file_name = $newfilename;
                $file_path = $path['path'] . $config['path'] . $file_name;
            } else {
                return $this->respondCreated([
                    'status'  => 500,
                    'error'   => true,
                    'message' => 'Failed to upload image',
                    'data'    => [],
                ]);
            }
        } else {
            if (!$this->request->getVar('link')) {
                return $this->respondCreated([
                    'status'  => 500,
                    'error'   => true,
                    'message' => 'Youtube Link field is required',
                    'data'    => [],
                ]);
            }
            $file_name = $this->request->getVar('link');
            $file_path = '';
        }

        if ($model->updateData($id, $model, $this->request, $file_name, $file_path, $this->user) === false) {
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
        $model = new MediaModel();
        if (empty($this->user)) {
            $response = [
                'status'   => 401,
                'error'    => true,
                'message' => 'Access denied',
                'data'     => new \stdClass,
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

        $result = $model->softDelete($id, $model, $this->user);

        if ($result === false) {
            $response = [
                'status'   => 500,
                'error'    => true,
                'message' => 'Data Failed to Deleted',
            ];
        } else {
            $response = [
                'status'   => 200,
                'error'    => null,
                'message' => 'Data Deleted',
            ];
        }
        return $this->respond($response);
    }
}
