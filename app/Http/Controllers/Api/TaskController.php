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

    public function store(Request $request)
    {
        $this->validation();
        $condition = $this->service->create($request->all());
        if ($condition['status'] === '00') {
            return response()->json('Registro criado com sucesso', 201);
        }
        return response()->json($condition['message'], 500);
    }

    public function update(Request $request, int $id)
    {
        $this->validation();
        $condition = $this->service->update($request->all(), $id);
        if ($condition['status'] === '00') {
            return response()->json('Registro atualizado com sucesso', 201);
        }
        return response()->json($condition['message'], 500);
    }

    public function destroy($id)
    {
        $condition = $this->service->delete($id);
        if ($condition['status'] === '00') {
            return response()->json('Registro deletado com sucesso', 201);
        }
        return response()->json($condition['message'], 500);
    }

    public function finishTask($id)
    {
        $condition = $this->service->finishTask($id);
        if ($condition['status'] === '00') {
            return response()->json('Tarefa concluída com sucesso', 201);
        }
        return response()->json($condition['message'], 500);
    }

    public function indicators()
    {
        $data = $this->service->indicators();
        if ($data['status'] === '00') {
            return response()->json($data['data'], 201);
        }
        return response()->json($data['condition']['message'], 500);
    }
}