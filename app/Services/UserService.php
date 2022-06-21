<?php

namespace App\Services;

use App\Models\User;
use LaravelAux\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;
use App\Models\MailReceiver;
use App\Mail\SendNotificationMail;
use Illuminate\Support\Facades\Storage;

class UserService extends BaseService
{
    /**
     * UserService constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $file = $data['photo'];
            unset($data['photo']);

            if ($new = $this->repository->create($data)) {
                if($file){
                    Storage::disk('local')->put('user/' . $new->id . '/perfil.png', file_get_contents($file));
                    $new->photo = 'user/' . $new->id . '/perfil.png';
                }
                $new->save();
                DB::commit();
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
            $previousData = [];

            $file = $data['photo'];
            unset($data['photo']);
            unset($data['_method']);

            $user = $this->repository->find($id);

            if (empty($user)) {
                DB::rollback();
                return ['status' => '01', 'message' => 'Usuário não encontrado'];
            }

            foreach($data as $field => $item){
                if($user->$field != $item){
                    $previousData[$field] = $user->$field;
                }
            }

            $user->update($data);

            if($file){
                $previousData['changedPhoto'] = true;
                Storage::disk('local')->put('user/' . $user->id . '/perfil.png', file_get_contents($file));
                $user->photo = 'user/' . $user->id . '/perfil.png';
                $user->save();
            }

            DB::commit();
            if($previousData != []){
                $this->sendNotificationMail($user, "Edit", $previousData);
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
            $user = User::find($id);
            $user->delete();
            DB::commit();
            $this->sendNotificationMail($user, "Delete");
            return ['status' => '00'];
        } catch (\Exception $e) {
            DB::rollback();
            Log::debug($e->getMessage());
            return ['status' => '01', 'message' => $e->getMessage()];
        }
    }

    public function sendNotificationMail($user, $operation, $previousData = null)
    {
        try {
            $receiver = User::find(MailReceiver::first()->value('user_id'));

            $data = [
                "name" => $receiver->name,
                "register" => $user,
                "operation" => $operation, 
                "previousData" => $previousData,
                "model" => "usuário"
            ];

            Mail::to($receiver->email)->queue(new SendNotificationMail($data));
            return ['status' => '00'];
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return ['status' => '01', 'message' => $e->getMessage()];
        }
    }
}