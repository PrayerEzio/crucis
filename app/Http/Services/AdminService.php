<?php
namespace App\Http\Services;
use App\Http\Repositories\AdminRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AdminService
{
    protected $repository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->repository = $adminRepository;
    }

    public function get()
    {
        
    }

    public function edit($id,Request $request,QiniuService $qiniuService)
    {
        $data = $request->only('nickname','email','password','position','status');
        if ($request->file('avatar'))
        {
            $data['avatar'] = $qiniuService->upload($request->file('avatar'),'','avatar');
        }else {
            unset($data['avatar']);
        }
        if ($data['password'])
        {
            $data['password'] = Crypt::encrypt($data['password']);
        }else {
            unset($data['password']);
        }
        $data['status'] = $data['status'] == 'on' ? 1 : 0;
        return $this->repository->editAdminData($id,$data);
    }
}