<?php

namespace App\Services;

use LaravelAux\BaseService;
use App\Models\MailReceiver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\MailReceiverRepository;

class MailReceiverService extends BaseService
{
    /**
     * UserService constructor.
     *
     * @param MailReceiverRepository $repository
     */
    public function __construct(MailReceiverRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Method to finish a Task
     *
     * @param array $data
     * @return array|mixed
     */
    public function change(int $id)
    {
        DB::beginTransaction();
        try {
            if($receiver = MailReceiver::first()){
                $receiver->user_id = $id;
                $receiver->save();
                DB::commit();
                return ['status' => '00'];
            };
            DB::rollback();
            return ['status' => '01', 'message' => 'Ocorreu um erro durante a conclusão da tarefa'];
        } catch (\Exception $e) {
            DB::rollback();
            Log::debug($e->getMessage());
            return ['status' => '01', 'message' => $e->getMessage()];
        }
    }
}