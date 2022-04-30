<?php

namespace App\Controllers;

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
                'status'   => 401,
                'error'    => true,
                'messages' => 'Access denied',
                'data'     => [],
            ];
            return $this->respondCreated($response);
        }

        $data = UserModel::getAll();

        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => $this->modulName . ' Data ' . count($data) . ' Found',
            'data'     => $data,
        ];
        return $this->respond($response);
    }

    public function register()
    {
        $rules = [
            'name'     => 'required',
            'email'    => 'required|valid_email|is_unique[user.email]|min_length[6]',
            'phone'    => 'required',
            'password' => 'required',
            'image'    => 'required',
            'address'  => 'required',
        ];

        $messages = [
            'name'     => [
                'required' => 'Name is required',
            ],
            'email'    => [
                'required' => 'Email is required',
            ],
            'phone'    => [
                'required' => 'Phone is required',
            ],
            'password' => [
                'required' => 'Password is required',
            ],
            'address'  => [
                'required' => 'Address is required',
            ],
        ];

        if (!$this->validate($rules, $messages)) {

            $response = [
                'status'  => 500,
                'error'   => true,
                'message' => $this->validator->getErrors(),
                'data'    => [],
            ];
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
            'status'   => 200,
            'error'    => false,
            'messages' => 'Successfully, user has been registered',
            'data'     => [],
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

            $response = [
                'status'  => 500,
                'error'   => true,
                'message' => $this->validator->getErrors(),
                'data'    => [],
            ];

            return $this->respondCreated($response);

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
                        'status'   => 200,
                        'error'    => false,
                        'messages' => 'User logged In successfully',
                        'data'     => $data,
                    ];

                    return $this->response->setHeader('AuthToken', $token)->setJSON($response);
                } else {

                    $response = [
                        'status'   => 500,
                        'error'    => true,
                        'messages' => 'Incorrect details',
                        'data'     => [],
                    ];
                    return $this->respondCreated($response);
                }
            } else {
                $response = [
                    'status'   => 500,
                    'error'    => true,
                    'messages' => 'User not found',
                    'data'     => [],
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

            $response = [
                'status'  => 500,
                'error'   => true,
                'message' => $this->validator->getErrors(),
                'data'    => [],
            ];

            return $this->respondCreated($response);

        }

        $userModel = new UserModel();

        $userdata = $userModel->where('email', $this->request->getVar('email'))->first();

        if (empty($userdata)) {
            $response = [
                'status'   => 500,
                'error'    => true,
                'messages' => 'Email not found',
                'data'     => [],
            ];
            return $this->response->setStatusCode(500)->setJSON($response);
        }

        $response = [
            'status'   => 200,
            'error'    => false,
            'messages' => 'E-mail Reset Password has been sent',
            'data'     => [],
        ];
        return $this->response->setStatusCode(200)->setJSON($response);
    }

    public function details()
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

        $userModel = new UserModel();
        $data      = $userModel->findById($this->user->data->id);
        unset($data['password']);

        $response = [
            'status'   => 200,
            'error'    => false,
            'messages' => 'User details',
            'data'     => $data,
        ];
        return $this->respondCreated($response);

    }

    public function change_profile()
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

        $rules = [
            'name'    => 'required',
            'email'   => 'required',
            'phone'   => 'required',
            'image'   => 'required',
            'address' => 'required',
        ];

        $messages = [
            'name'    => [
                'required' => 'Name is required',
            ],
            'email'   => [
                'required' => 'Email is required',
            ],
            'phone'   => [
                'required' => 'Phone is required',
            ],
            'image'   => [
                'required' => 'Image is required',
            ],
            'address' => [
                'required' => 'Address is required',
            ],
        ];

        if (!$this->validate($rules, $messages)) {

            $response = [
                'status'  => 500,
                'error'   => true,
                'message' => $this->validator->getErrors(),
                'data'    => [],
            ];
        }

        $userModel = new UserModel();

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
                'data'    => [],
            ]);
        }

        $data = [
            'name'    => $this->request->getVar('name'),
            'email'   => $this->request->getVar('email'),
            'phone'   => $this->request->getVar('phone'),
            'image'   => $image,
            'address' => $this->request->getVar('address'),
        ];

        if ($this->request->getVar('password')) {
            $data['password'] = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
        }

        $userModel->update($this->user->data->id, $data);

        $response = [
            'status'   => 200,
            'error'    => false,
            'messages' => 'Successfully, user has been updated',
            'data'     => [],
        ];

        return $this->respondCreated($response);
    }

    public function change_password()
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

            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 500,
                'error'   => true,
                'message' => $this->validator->getErrors(),
                'data'    => [],
            ]);
        }

        $userModel = new UserModel();

        $userdata = $userModel->where('id', $this->user->data->id)->first();

        if (!password_verify($this->request->getVar('old_password'), $userdata['password'])) {
            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 500,
                'error'   => true,
                'message' => 'Wrong Old Password',
                'data'    => [],
            ]);
        }

        $data = [
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ];

        $userModel = new UserModel();
        $userModel->update($this->user->data->id, $data);

        $response = [
            'status'   => 200,
            'error'    => false,
            'messages' => 'Successfully, user has been updated',
            'data'     => [],
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
                'status'   => 401,
                'error'    => true,
                'messages' => 'Access denied',
                'data'     => [],
            ];
            return $this->respondCreated($response);
        }

        // check availability
        if ($model->findById($id) === false) {
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
