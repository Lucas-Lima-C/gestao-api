<?php

namespace App\Http\Controllers\Api;

use App\Services\TaskService;
use App\Http\Requests\TaskRequest;
use LaravelAux\BaseController;
use Illuminate\Http\Request;

class TaskController extends BaseController
{
    /**
     * UserController constructor.
     *
     * @param TaskService $service
     * @param TaskRequest $request
     */
    public function __construct(TaskService $service)
    {
        parent::__construct($service, new TaskRequest);
    }

    /**
     * Method to create Task
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
}