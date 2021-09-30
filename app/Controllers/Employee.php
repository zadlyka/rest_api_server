<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EmployeeModel;

class Employee extends ResourceController
{
    use ResponseTrait;
    // all users
    public function index()
    {
        $model = new EmployeeModel();
        $data['response'] = 'true';
        $data['employees'] = $model->orderBy('id', 'DESC')->findAll();
        return $this->respond($data);
    }

    // single user
    public function show($id = null)
    {
        $model = new EmployeeModel();
        $data['response'] = 'true';
        $data['employees'] = $model->where('id', $id)->first();
        if ($data) {
            return $this->respond($data);
        }
    }

    // create
    public function create()
    {
        $model = new EmployeeModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email')
        ];

        $model->insert($data);
        $response = [
            'status' => 201,
            'error'  => null,
            'messages' => [
                'success' => 'Employee created successfully'
            ]
        ];
        return $this->respondCreated($response);
    }

    // update
    public function update($id = null)
    {
        $model = new EmployeeModel();
        $input = $this->request->getRawInput();
        $data = [
            'name' => $input['name'],
            'email' => $input['email'],
        ];

        $model->update($id, $data);
        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Employee updated successfully'
            ]
        ];
        return $this->respond($response);
    }

    public function delete($id = null)
    {
        $model = new EmployeeModel();
        if ($model->find($id)) {
            $model->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Employee successfully deleted'
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('No employee found');
        }
    }
}
