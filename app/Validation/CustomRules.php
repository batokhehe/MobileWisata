<?php
namespace App\Validation;

use App\Models\CategoryModel;
use App\Models\DestinationModel;
use App\Models\UserModel;

class CustomRules
{
    public function is_category_exists($id)
    {
        $model = new CategoryModel();
        $data  = $model->where([$model->primaryKey => $id, 'deleted_at' => null])->findAll();
        if (count($data) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function is_destination_exists($id)
    {
        $model = new DestinationModel();
        $data  = $model->where([$model->primaryKey => $id, 'deleted_at' => null])->findAll();
        if (count($data) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function is_user_exists($id)
    {
        $model = new UserModel();
        $data  = $model->where([$model->primaryKey => $id, 'deleted_at' => null])->findAll();
        if (count($data) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
