<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\UserRequest;
use LaravelAux\BaseController;

class UserController extends BaseController
{
    /**
     * UserController constructor.
     *
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        parent::__construct($service, new UserRequest());
    }

    /**
     * Method to create User
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store(Request $request)
    {
        $this->validation();
        $condition = $this->service->create($request->all());
        if ($condition['status'] === '00') {
            return response()->json('Registro criado com sucesso', 201);
        }
        return response()->json($condition['message'], 500);
    }

    /**
     * Method to update User Information
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update(Request $request, int $id)
    {
        $this->validation();
        $condition = $this->service->update($request->all(), $id);
        if ($condition['status'] === '00') {
            return response()->json('Registro criado com sucesso', 201);
        }
        return response()->json($condition['message'], 500);
    }

    /**
     * Method to get User Profile Image
     *
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function image($id)
    {
        $user = $this->service->find($id);
        $path = storage_path('app/');
        if(file_exists($path . $user->photo_raw)){
            $path .= $user->photo_raw;
        } else {
            $path .= 'patterns\\user.png';
        }
        return response(file_get_contents($path))
            ->header('Content-Type', 'image/png');
    }
}