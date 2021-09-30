<?php

namespace App\Controllers;

use App\Models\EmployeeModel;

class Home extends BaseController
{
    public function index()
    {
        $model = new EmployeeModel();
        $data['employees'] = $model->orderBy('id', 'DESC')->findAll();
        var_dump($data['employees']);
        return view('welcome_message');
    }
}
