<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use LaravelAux\BaseService;
use App\Models\MailReceiver;
use App\Mail\SendNotificationMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\TaskRepository;
use Illuminate\Support\Facades\Mail;

class TaskService extends BaseService
{
    /**
     * TaskService constructor.
     *
     * @param TaskRepository $repository
     */
    public function __construct(TaskRepository $repository)
    {
        parent::__construct($repository);
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            if ($new = $this->repository->create($data)) {
            DB::commit();
            $new->date_of_conclusion = Carbon::parse($new->date_of_conclusion)->format('d/m/Y');
            $this->sendNotificationMail($new, "Add");
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

    public function update(array $data, int $id)
    {
        DB::beginTransaction();
        try {
            $changedDate = false;
            $previousData = [];
            $task = $this->repository->find($id);

            if (empty($task)) {
                DB::rollback();
                return ['status' => '01', 'message' => 'Usuário não encontrado'];
            }

            unset($data['_method']);
            foreach($data as $field => $item){
                if($task->$field != $item){
                    if($field == 'date_of_conclusion'){
                        $previousData[$field] = Carbon::parse($task->$field)->format('d/m/Y');
                        $changedDate = true;
                    } else {
                        $previousData[$field] = $task->$field;
                    }
                }
            }

            $task->update($data);
            if($changedDate){
                $task->date_of_conclusion = Carbon::parse($task->date_of_conclusion)->format('d/m/Y');
            }
            DB::commit();
            if($previousData != []){
                $this->sendNotificationMail($task, "Edit", $previousData);
            }
            return ['status' => '00'];
        } catch (\Exception $e) {
            DB::rollback();
            Log::debug($e->getMessage());
            return ['status' => '01', 'message' => $e->getMessage()];
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $task = Task::find($id);
            $task->delete();
            DB::commit();
            $this->sendNotificationMail($task, "Delete");
            return ['status' => '00'];
        } catch (\Exception $e) {
            DB::rollback();
            Log::debug($e->getMessage());
            return ['status' => '01', 'message' => $e->getMessage()];
        }
    }

    public function finishTask(int $id)
    {
        DB::beginTransaction();
        try {
            if($task = Task::find($id)){
                $task->status = 'Concluido';
                $task->save();
                $this->sendNotificationMail($task, "Concluir");
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

    public function indicators()
    {
        try {
            $pendingTasks = Task::where('status', 'Pendente')->whereDate('date_of_conclusion', '>=', Carbon::now())->count();
            $lateTasks = Task::where('status', 'Pendente')->whereDate('date_of_conclusion', '<', Carbon::now())->count();
            $finishedTasks = Task::where('status', 'Concluido')->count();

            return ['status' => '00', 'data' => [
                'pendingTasks' => $pendingTasks,
                'lateTasks' => $lateTasks,
                'finishedTasks' => $finishedTasks,
            ]];
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return ['status' => '01', 'message' => $e->getMessage()];
        }
    }

    public function sendNotificationMail($task, $operation, $previousData = null)
    {
        try {
            $receiver = User::find(MailReceiver::first()->value('user_id'));
            
            $data = [
                "name" => $receiver->name,
                "register" => $task,
                "operation" => $operation, 
                "previousData" => $previousData,
                "model" => "tarefa"
            ];

            Mail::to($receiver->email)->queue(new SendNotificationMail($data));
            return ['status' => '00'];
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return ['status' => '01', 'message' => $e->getMessage()];
        }
    }
}