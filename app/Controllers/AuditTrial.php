<?php

namespace App\Controllers;

use App\Models\AuditTrialModel;

class AuditTrial extends BaseController
{

    public $modulName = 'AuditTrial';

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

        $data    = AuditTrialModel::getAll($this->request, $limit, $page, $query, $this->user);
        $counter = AuditTrialModel::getAllCounter($this->user);

        $response = [
            'status'          => 200,
            'error'           => null,
            'message'        => $this->modulName . ' Data ' . count($data) . ' Found',
            'data'            => $data,
            'recordsTotal'    => $counter,
            'recordsFiltered' => $counter,
        ];

        AuditTrialModel::updateData($this->user->data->id);

        return $this->response->setStatusCode(200)->setJSON($response);
    }
}
