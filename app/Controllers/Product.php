<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProductModel;

class Product extends Controller
{
    public function index()
    {
        $model = new ProductModel();

        $data['products_detail'] = $model->orderBy('id', 'DESC')->findAll();

        return view('list', $data);
    }
    public function store()
    {
        helper(['form', 'url']);

        $model = new ProductModel();

        $data = [
            'name' => $this->request->getVar('txtName'),
            'text'  => $this->request->getVar('txtText'),
            'price'  => $this->request->getVar('txtPrice'),
        ];
        $save = $model->insert_data($data);
        if ($save != false) {
            $data = $model->where('id', $save)->first();
            echo json_encode(array("status" => true, 'data' => $data));
        } else {
            echo json_encode(array("status" => false, 'data' => $data));
        }
    }

    public function edit($id = null)
    {

        $model = new ProductModel();

        $data = $model->where('id', $id)->first();

        if ($data) {
            echo json_encode(array("status" => true, 'data' => $data));
        } else {
            echo json_encode(array("status" => false));
        }
    }

    public function update()
    {

        helper(['form', 'url']);

        $model = new ProductModel();

        $id = $this->request->getVar('hdnProductId');

        $data = [
            'name' => $this->request->getVar('txtName'),
            'text'  => $this->request->getVar('txtText'),
            'price'  => $this->request->getVar('txtPrice'),
        ];

        $update = $model->update($id, $data);
        if ($update != false) {
            $data = $model->where('id', $id)->first();
            echo json_encode(array("status" => true, 'data' => $data));
        } else {
            echo json_encode(array("status" => false, 'data' => $data));
        }
    }

    public function delete($id = null)
    {
        $model = new ProductModel();
        $delete = $model->where('id', $id)->delete();
        if ($delete) {
            echo json_encode(array("status" => true));
        } else {
            echo json_encode(array("status" => false));
        }
    }
}
