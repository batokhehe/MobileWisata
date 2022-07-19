<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ConfigModel;
use App\Models\DestinationModel;
use App\Models\FavoriteModel;
use App\Models\MediaModel;
use App\Models\RateReviewModel;

class Destination extends BaseController
{

    public $modulName = 'Destination';

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
        //         'message' => 'Access denied',
        //          'data'    => new \stdClass,
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

        $data    = DestinationModel::getAll($this->request, $limit, $page, $query, $this->request->getGet('lat'), $this->request->getGet('long'));
        $counter = DestinationModel::getAllCounter();
        $client  = \Config\Services::curlrequest();

        foreach ($data as $d) {
            $d->rate = RateReviewModel::findAverageByDestinationId($d->id);

            if ($this->request->getGet('lat') & $this->request->getGet('long')) {
                $origin      = [$this->request->getGet('lat'), $this->request->getGet('long')];
                $destination = [$d->lat, $d->long];
                $url         = 'https://maps.googleapis.com/maps/api/directions/json?language=id&mode=driving&sensor=false&destination='
                    . $destination[0] . ',' . $destination[1] .
                    '&origin='
                    . $origin[0] . ',' . $origin[1] .
                    '&key=AIzaSyBbzLLqcMjbMIiBdB3I0b_khv79IfZG5Ls';
                $response = json_decode($client->request('GET', $url, [])->getBody());
                // return $this->response->setStatusCode(200)->setJSON($response);
                $d->distance = $response->routes[0]->legs[0]->distance->text;
            }
            $d->category = CategoryModel::findById($d->category_id)['name'];
        }

        $response = [
            'status'          => 200,
            'error'           => null,
            'message'         => $this->modulName . ' Data ' . count($data) . ' Found',
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
        // if (empty($this->user)) {
        //     $response = [
        //         'status'  => 401,
        //         'error'   => true,
        //         'message' => 'Access denied',
        //         'data'    => new \stdClass,
        //     ];
        //     return $this->respondCreated($response);
        // }

        $result = DestinationModel::findById($id);

        $result['favorite'] = FavoriteModel::findByIdWithUser($id, $this->user->data->id);
        $result['rate']     = RateReviewModel::findAverageByDestinationId($id);
        $result['category'] = CategoryModel::findById($result['category_id'])['name'];
        $result['media']    = MediaModel::findByDestinationId($id);

        $client = \Config\Services::curlrequest();

        if ($this->request->getGet('lat') && $this->request->getGet('long')) {
            $origin      = [$this->request->getGet('lat'), $this->request->getGet('long')];
            $destination = [$result['lat'], $result['long']];
            $url         = 'https://maps.googleapis.com/maps/api/directions/json?language=id&mode=driving&sensor=false&destination='
                . $destination[0] . ',' . $destination[1] .
                '&origin='
                . $origin[0] . ',' . $origin[1] .
                '&key=AIzaSyBbzLLqcMjbMIiBdB3I0b_khv79IfZG5Ls';
            $response            = json_decode($client->request('GET', $url, [])->getBody());
            $distance            = $response->routes[0]->legs[0];
            $result['distance']  = $distance->distance->text;
            $result['step']      = $distance->steps;
            $result['direction'] = 'https://www.google.com/maps?saddr='
                . $origin[0] . ',' . $origin[1] .
                '&daddr=' . $destination[0] . ',' . $destination[1];
        }
        if ($result) {
            $response = [
                'status'  => 200,
                'error'   => null,
                'message' => $this->modulName . ' Found',
                'data'    => $result,
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
                'status'  => 401,
                'error'   => true,
                'message' => 'Access denied',
                'data'    => new \stdClass,
            ];
            return $this->response->setStatusCode(401)->setJSON($response);
        }

        $model = new DestinationModel();

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

        if (!$this->request->getFile('image_portrait') || !$this->request->getFile('image_landscape')) {
            return $this->respondCreated([
                'status'  => 500,
                'error'   => true,
                'message' => 'Image field is required',
                'data'    => [],
            ]);
        }

        if (empty($this->request->getFile('image_portrait')) || empty($this->request->getFile('image_landscape'))) {
            return $this->respondCreated([
                'status'  => 500,
                'error'   => true,
                'message' => 'Image field is required',
                'data'    => [],
            ]);
        }

        $config = ConfigModel::findById('image', 'destination');
        $path   = ConfigModel::findById('path', 'general');

        $file_1        = $this->request->getFile('image_portrait');
        $tmp_name_1    = $file_1->getName();
        $temp_1        = explode('.', $tmp_name_1);
        $newfilename_1 = md5(round(microtime(true))) . '.' . strtolower(end($temp_1));

        $file_2        = $this->request->getFile('image_landscape');
        $tmp_name_2    = $file_2->getName();
        $temp_2        = explode('.', $tmp_name_2);
        $newfilename_2 = md5(round(microtime(true))) . '_21.' . strtolower(end($temp_2));

        $image_portrait  = "";
        $image_landscape = "";
        if ($file_1->move($config['path'], $newfilename_1) && $file_2->move($config['path'], $newfilename_2)) {
            $image_portrait  = $path['path'] . $config['path'] . $newfilename_1;
            $image_landscape = $path['path'] . $config['path'] . $newfilename_2;
        } else {
            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 500,
                'error'   => true,
                'message' => 'Failed to upload image',
                'data'    => [],
            ]);
        }
        if ($model->createNew($model, $this->request, $image_portrait, $image_landscape, $this->user) === false) {
            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 500,
                'error'   => true,
                'message' => $this->modulName . ' Gagal Tersimpan',
                'params'  => $model->errors(),
            ]);
        } else {
            return $this->response->setStatusCode(200)->setJSON([
                'status'  => 200,
                'error'   => null,
                'message' => $this->modulName . ' Berhasil Tersimpan ',
            ]);
        }

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
                'status'  => 401,
                'error'   => true,
                'message' => 'Access denied',
                'data'    => new \stdClass,
            ];
            return $this->respondCreated($response);
        }

        $model = new DestinationModel();

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

        $image_portrait  = "";
        $image_landscape = "";

        $config = ConfigModel::findById('image', 'destination');
        $path   = ConfigModel::findById('path', 'general');

        if ($this->request->getFile('image_portrait') !== null && $this->request->getFile('image_portrait')->isValid()) {
            $file_1        = $this->request->getFile('image_portrait');
            $tmp_name_1    = $file_1->getName();
            $temp_1        = explode('.', $tmp_name_1);
            $newfilename_1 = md5(round(microtime(true))) . '.' . strtolower(end($temp_1));

            $file_1->move($config['path'], $newfilename_1);
            $image_portrait = $path['path'] . $config['path'] . $newfilename_1;
        }

        if ($this->request->getFile('image_landscape') !== null && $this->request->getFile('image_landscape')->isValid()) {
            $file_2        = $this->request->getFile('image_landscape');
            $tmp_name_2    = $file_2->getName();
            $temp_2        = explode('.', $tmp_name_2);
            $newfilename_2 = md5(round(microtime(true))) . '_21.' . strtolower(end($temp_2));

            $file_2->move($config['path'], $newfilename_2);

            $image_landscape = $path['path'] . $config['path'] . $newfilename_2;
        }

        if ($model->updateData($id, $model, $image_portrait, $image_landscape, $this->request, $this->user) === false) {
            $response = [
                'status'  => 500,
                'error'   => true,
                'message' => $this->modulName . ' Gagal Tersimpan',
                'params'  => $model->errors(),
            ];
        } else {
            $response = [
                'status'  => 200,
                'error'   => null,
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
        $model = new DestinationModel();
        if (empty($this->user)) {
            $response = [
                'status'  => 401,
                'error'   => true,
                'message' => 'Access denied',
                'data'    => new \stdClass,
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
                'status'  => 500,
                'error'   => true,
                'message' => 'Data Failed to Deleted',
            ];
        } else {
            $response = [
                'status'  => 200,
                'error'   => null,
                'message' => 'Data Deleted',
            ];
        }
        return $this->respond($response);
    }
}
