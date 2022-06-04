<?php

namespace App\Controllers;

use App\Models\AuditTrialModel;
use App\Models\ConfigModel;
use App\Models\UserModel;
use \Firebase\JWT\JWT;

class User extends BaseController
{
    public $modulName = 'User';

    public function index()
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

        $data    = UserModel::getAll($this->request, $limit, $page, $query);
        $counter = UserModel::getAllCounter();

        foreach ($data as $d) {
            $d->status = $d->deleted_at !== null ? 'In-active' : 'Active';
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

    public function register()
    {
        $rules = [
            'name'     => 'required',
            'email'    => 'required|valid_email|is_unique[user.email]|min_length[6]',
            // 'phone'    => 'required',
            'password' => 'required',
            // 'address'  => 'required',
        ];

        $messages = [
            'name'     => [
                'required' => 'Name is required',
            ],
            'email'    => [
                'required' => 'Email is required',
            ],
            // 'phone'    => [
            //     'required' => 'Phone is required',
            // ],
            'password' => [
                'required' => 'Password is required',
            ],
            // 'address'  => [
            //     'required' => 'Address is required',
            // ],
        ];

        if (!$this->validate($rules, $messages)) {
            $tmp      = $this->validator->getErrors();
            $response = [
                'status'  => 500,
                'error'   => true,
                'message' => reset($tmp),
                'data'    => new \stdClass,
            ];
            return $this->response->setStatusCode(500)->setJSON($response);
        }

        $userModel = new UserModel();

        $data = [
            'name'     => $this->request->getVar('name'),
            'email'    => $this->request->getVar('email'),
            'phone'    => $this->request->getVar('phone'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'address'  => $this->request->getVar('address'),
        ];

        $userModel->insert($data);

        $response = [
            'status'  => 200,
            'error'   => false,
            'message' => 'Successfully, user has been registered',
            'data'    => new \stdClass,
        ];

        return $this->respondCreated($response);
    }

    private function getKey()
    {
        return 'wisata_123';
    }

    public function login()
    {
        $rules = [
            'email'    => 'required|valid_email|min_length[6]',
            'password' => 'required',
        ];

        $messages = [
            'email'    => [
                'required'    => 'Email required',
                'valid_email' => 'Email is not in format',
            ],
            'password' => [
                'required' => 'Password is required',
            ],
        ];

        if (!$this->validate($rules, $messages)) {

            $tmp      = $this->validator->getErrors();
            $response = [
                'status'  => 500,
                'error'   => true,
                'message' => reset($tmp),
                'data'    => new \stdClass,
            ];
            return $this->response->setStatusCode(500)->setJSON($response);

        } else {
            $userModel = new UserModel();

            $userdata = $userModel->where('email', $this->request->getVar('email'))->first();

            if (!empty($userdata)) {

                if (password_verify($this->request->getVar('password'), $userdata['password'])) {

                    $key = $this->getKey();

                    $iat = time(); // current timestamp value
                    $nbf = $iat + 10;
                    $exp = $iat + 3600 * 100000;

                    $payload = array(
                        'iss'  => 'The_claim',
                        'aud'  => 'The_Aud',
                        'iat'  => $iat, // issued at
                        'nbf'  => $nbf, //not before in seconds
                        'exp'  => $exp, // expire time in seconds
                        'data' => $userdata,
                    );

                    $data  = $userdata;
                    $token = JWT::encode($payload, $key);
                    unset($data['password']);

                    $response = [
                        'status'  => 200,
                        'error'   => false,
                        'message' => 'User logged In successfully',
                        'data'    => $data,
                    ];

                    AuditTrialModel::createNew('Masuk ke aplikasi.', 'User', $userdata['id']);

                    return $this->response->setHeader('AuthToken', $token)->setJSON($response);
                } else {

                    $response = [
                        'status'  => 500,
                        'error'   => true,
                        'message' => 'Incorrect details',
                        'data'    => new \stdClass,
                    ];
                    return $this->respondCreated($response);
                }
            } else {
                $response = [
                    'status'  => 500,
                    'error'   => true,
                    'message' => 'User not found',
                    'data'    => new \stdClass,
                ];
                return $this->respondCreated($response);
            }
        }
    }

    public function forgot_password()
    {
        $rules = [
            'email' => 'required|valid_email|min_length[6]',
        ];

        $messages = [
            'email' => [
                'required'    => 'Email required',
                'valid_email' => 'Email is not in format',
            ],
        ];

        if (!$this->validate($rules, $messages)) {

            $tmp      = $this->validator->getErrors();
            $response = [
                'status'  => 500,
                'error'   => true,
                'message' => reset($tmp),
                'data'    => new \stdClass,
            ];
            return $this->response->setStatusCode(500)->setJSON($response);

        }

        $userModel = new UserModel();

        $userdata = $userModel->where('email', $this->request->getVar('email'))->first();

        if (empty($userdata)) {
            $response = [
                'status'  => 500,
                'error'   => true,
                'message' => 'Email not found',
                'data'    => new \stdClass,
            ];
            return $this->response->setStatusCode(500)->setJSON($response);
        }

        $code                            = random_string('alnum', 16);
        $newdata['forgot_password_code'] = $code;
        $result                          = $userModel->update($userdata['id'], $newdata);

        $message = "Please reset password the account " . anchor('reset_password/' . $code, 'Forgot Password', '');
        $email   = \Config\Services::email();
        $email->setFrom('admin@mobilewisata.nlp-geng.com', 'Forgot Password');
        $email->setTo($this->request->getVar('email'));
        $email->setSubject('Forgot Password');
        $email->setMessage(anchor('reset_password/' . $code)); //your message here

        // $email->setCC('another@emailHere'); //CC
        // $email->setBCC('thirdEmail@emialHere'); // and BCC
        // $filename = '/img/yourPhoto.jpg'; //you can use the App patch
        // $email->attach($filename);

        $email->send();
        $email->printDebugger(['headers']);

        $response = [
            'status'  => 200,
            'error'   => false,
            'message' => 'E-mail Reset Password has been sent',
            'data'    => new \stdClass,
        ];
        return $this->response->setStatusCode(200)->setJSON($response);
    }

    public function reset_password()
    {
        $rules = [
            'password' => 'required',
        ];

        $messages = [
            'password' => [
                'required' => 'Password is required',
            ],
        ];

        if (!$this->validate($rules, $messages)) {

            $tmp      = $this->validator->getErrors();
            $response = [
                'status'  => 500,
                'error'   => true,
                'message' => reset($tmp),
                'data'    => new \stdClass,
            ];
            return $this->response->setStatusCode(500)->setJSON($response);
        }

        $userModel = new UserModel();

        $userdata = $userModel->where('forgot_password_code', $this->request->getVar('code'))->first();

        if (!$userdata) {
            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 500,
                'error'   => true,
                'message' => 'Data Not Found',
                'data'    => new \stdClass,
            ]);
        }

        $data = [
            'password'             => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'forgot_password_code' => '',
        ];

        $userModel = new UserModel();
        $userModel->update($userdata['id'], $data);

        $response = [
            'status'  => 200,
            'error'   => false,
            'message' => 'Successfully, user has been updated',
            'data'    => new \stdClass,
        ];

        return $this->respondCreated($response);
    }

    public function details()
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

        $userModel = new UserModel();
        $data      = $userModel->findById($this->user->data->id);
        unset($data['password']);

        $response = [
            'status'  => 200,
            'error'   => false,
            'message' => 'User details',
            'data'    => $data,
        ];
        return $this->respondCreated($response);

    }

    public function change_profile()
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

        $rules = [
            'name' => 'required',
            // 'email' => 'required',
            // 'phone'   => 'required',
            // 'image' => 'required',
            // 'address' => 'required',
        ];

        $messages = [
            'name' => [
                'required' => 'Name is required',
            ],
            // 'email' => [
            //     'required' => 'Email is required',
            // ],
            // 'phone'   => [
            //     'required' => 'Phone is required',
            // ],
            // 'image' => [
            //     'required' => 'Image is required',
            // ],
            // 'address' => [
            //     'required' => 'Address is required',
            // ],
        ];

        if (!$this->validate($rules, $messages)) {

            $tmp      = $this->validator->getErrors();
            $response = [
                'status'  => 500,
                'error'   => true,
                'message' => reset($tmp),
                'data'    => new \stdClass,
            ];
            return $this->response->setStatusCode(500)->setJSON($response);
        }

        $userModel = new UserModel();

        $data = [
            'name'    => $this->request->getVar('name'),
            'email'   => $this->request->getVar('email'),
            'phone'   => $this->request->getVar('phone'),
            'address' => $this->request->getVar('address'),
        ];

        if ($this->request->getFile('image') !== null && $this->request->getFile('image')->isValid()) {
            $config = ConfigModel::findById('image', 'user');
            $path   = ConfigModel::findById('path', 'general');

            $file        = $this->request->getFile('image');
            $tmp_name    = $file->getName();
            $temp        = explode('.', $tmp_name);
            $newfilename = md5(round(microtime(true))) . '.' . strtolower(end($temp));

            $image = "";
            if ($file->move($config['path'], $newfilename)) {
                $image         = $path['path'] . $config['path'] . $newfilename;
                $data['image'] = $image;
            } else {
                return $this->response->setStatusCode(500)->setJSON([
                    'status'  => 500,
                    'error'   => true,
                    'message' => 'Failed to upload image',
                    'data'    => new \stdClass,
                ]);
            }
        }

        if ($this->request->getVar('password')) {
            $data['password'] = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
        }

        $result = $userModel->update($this->user->data->id, $data);
        if ($result) {
            AuditTrialModel::createNew('Profil anda telah dirubah.', 'User', $this->user->data->id);
            $response = [
                'status'  => 200,
                'error'   => false,
                'message' => 'Successfully, user has been updated',
                'data'    => new \stdClass,
            ];

            return $this->respondCreated($response);
        } else {
            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 500,
                'error'   => true,
                'message' => $userModel->errors(),
                'data'    => new \stdClass,
            ]);
        }
    }

    public function change_password()
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

        $rules = [
            'password'     => 'required',
            'old_password' => 'required',
        ];

        $messages = [
            'password'     => [
                'required' => 'Password is required',
            ],
            'old_password' => [
                'required' => 'Old Password is required',
            ],
        ];

        if (!$this->validate($rules, $messages)) {

            $tmp      = $this->validator->getErrors();
            $response = [
                'status'  => 500,
                'error'   => true,
                'message' => reset($tmp),
                'data'    => new \stdClass,
            ];
            return $this->response->setStatusCode(500)->setJSON($response);
        }

        $userModel = new UserModel();

        $userdata = $userModel->where('id', $this->user->data->id)->first();

        if (!password_verify($this->request->getVar('old_password'), $userdata['password'])) {
            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 500,
                'error'   => true,
                'message' => 'Wrong Old Password',
                'data'    => new \stdClass,
            ]);
        }

        $data = [
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ];

        $userModel = new UserModel();
        $userModel->update($this->user->data->id, $data);

        $response = [
            'status'  => 200,
            'error'   => false,
            'message' => 'Successfully, user has been updated',
            'data'    => new \stdClass,
        ];

        return $this->respondCreated($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $model = new UserModel();
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
        if ($model->findById($id) === false) {
            return $this->respondCreated([
                'status'  => 404,
                'error'   => true,
                'message' => 'Designated data to delete not found',
                'data'    => new \stdClass,
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

    public function show($id = null)
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

        $result = UserModel::findById($id);

        if ($result) {
            $response = [
                'status'  => 200,
                'error'   => null,
                'message' => $this->modulName . ' Found',
                'data'    => $result,
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
                'status'  => 401,
                'error'   => true,
                'message' => 'Access denied',
                'data'    => new \stdClass,
            ];
            return $this->response->setStatusCode(401)->setJSON($response);
        }

        $model = new UserModel();

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

        $config = ConfigModel::findById('image', 'user');
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
        $password = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
        if ($model->createNew($model, $this->request, $image, $password, $this->user) === false) {
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
                'status'  => 401,
                'error'   => true,
                'message' => 'Access denied',
                'data'    => new \stdClass,
            ];
            return $this->response->setStatusCode(401)->setJSON($response);
        }

        $model = new UserModel();

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
            $config = ConfigModel::findById('image', 'user');
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
        $password = '';
        if ($this->request->getVar('password')) {
            $password = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
        }

        if ($model->updateData($id, $model, $this->request, $image, $password, $this->user) === false) {
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
                'message' => $this->modulName . ' Berhasil Tersimpan ']);
        }
    }

    public function login_google()
    {
        $rules = [
            'email'   => 'required|min_length[6]',
            'user_id' => 'required',
        ];

        $messages = [
            'email'   => [
                'required' => 'Email is required',
            ],
            'user_id' => [
                'required' => 'User ID is required',
            ],
        ];

        if (!$this->validate($rules, $messages)) {

            $tmp      = $this->validator->getErrors();
            $response = [
                'status'  => 500,
                'error'   => true,
                'message' => reset($tmp),
                'data'    => new \stdClass,
            ];
            return $this->response->setStatusCode(500)->setJSON($response);
        }

        $userModel = new UserModel();

        if (!$userModel->where('email', $this->request->getVar('email'))->first()) {
            $userModel = new UserModel();

            $data = [
                'name'     => $this->request->getVar('email'),
                'email'    => $this->request->getVar('email'),
                'user_id'  => $this->request->getVar('user_id'),
                'phone'    => $this->request->getVar('phone'),
                'password' => password_hash('wisata', PASSWORD_DEFAULT),
                'address'  => $this->request->getVar('address'),
            ];

            $userModel->insert($data);
        }

        $userdata = $userModel->where('email', $this->request->getVar('email'))->first();

        if (!empty($userdata)) {
            if (!empty($userdata['user_id']) && $this->request->getVar('user_id') == $userdata['user_id']) {

                $key = $this->getKey();

                $iat = time(); // current timestamp value
                $nbf = $iat + 10;
                $exp = $iat + 3600 * 100000;

                $payload = array(
                    'iss'  => 'The_claim',
                    'aud'  => 'The_Aud',
                    'iat'  => $iat, // issued at
                    'nbf'  => $nbf, //not before in seconds
                    'exp'  => $exp, // expire time in seconds
                    'data' => $userdata,
                );

                $data  = $userdata;
                $token = JWT::encode($payload, $key);
                unset($data['password']);

                $response = [
                    'status'  => 200,
                    'error'   => false,
                    'message' => 'User logged In successfully',
                    'data'    => $data,
                ];

                return $this->response->setHeader('AuthToken', $token)->setJSON($response);
            } else {

                $response = [
                    'status'  => 500,
                    'error'   => true,
                    'message' => 'Incorrect details',
                    'data'    => new \stdClass,
                ];
                return $this->respondCreated($response);
            }
        } else {

            $response = [
                'status'  => 500,
                'error'   => true,
                'message' => 'Incorrect details',
                'data'    => new \stdClass,
            ];
            return $this->respondCreated($response);
        }
    }

}
