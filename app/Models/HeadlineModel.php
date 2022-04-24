<?php

namespace App\Models;

use CodeIgniter\Model;

class HeadlineModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'headline';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'destination_id',
        'altitude',
        'temperature',
        'tourist',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'altitude'       => 'required',
        'temperature'    => 'required',
        'destination_id' => 'required|is_destination_exists[destination_id]',
        'tourist'        => 'required',
    ];
    protected $validationMessages = [
        'altitude'       => [
            'required' => 'Altitude is required',
        ],
        'temperature'    => [
            'required' => 'Temperature is required',
        ],
        'destination_id' => [
            'required'              => 'Destination is required',
            'is_destination_exists' => 'Destination is not exists',
        ],
        'tourist'        => [
            'required' => 'Tourist per year is required',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public static function findById($id)
    {
        $model = new HeadlineModel();
        return $model->where([$model->primaryKey => '1'])->first();
    }

    public static function updateData($id, $model, $request, $user)
    {
        return $model->update('1', [
            'altitude'       => $request->getVar('altitude'),
            'temperature'    => $request->getVar('temperature'),
            'destination_id' => $request->getVar('destination_id'),
            'tourist'        => $request->getVar('tourist'),

            'updated_at'     => date('Y-m-d H:i:s'),
        ]);
    }
}
