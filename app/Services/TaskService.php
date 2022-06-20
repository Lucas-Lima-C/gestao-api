<?php

namespace App\Services;

use LaravelAux\BaseService;
use Illuminate\Support\Facades\DB;
use App\Repositories\TaskRepository;

class TaskService extends BaseService
{
    /**
     * UserService constructor.
     *
     * @param TaskRepository $repository
     */
    public function __construct(TaskRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Method to create an User
     *
     * @param array $data
     * @return array|mixed
     */
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            if ($new = $this->repository->create($data)) {
            DB::commit();

            //Envia e-mail
                
            return ['status' => '00'];
        }
            DB::rollback();
            return ['status' => '01', 'message' => 'Ocorreu um erro durante a criação do registro'];
        } catch (\Exception $e) {
            DB::rollback();
            Log::debug($e->getMessage());
            return ['status' => '01', 'message' => $e->getMessage()];
        }
    }
}