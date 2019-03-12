<?php
namespace App\Http\Repositories;
use App\Http\Models\Admin;
use Illuminate\Support\Facades\Crypt;
class AdminRepository
{
    protected $model;
    public function __construct(Admin $admin)
    {
        $this->model = $admin;
    }
    public function getAdminInfo($id)
    {
        return $this->model->find($id);
    }
    public function editAdminData($id,$data)
    {
        $result = $this->model->where('id',$id)->update($data);
        return $result;
    }
}