<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use LaravelAux\BaseService;

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
            $file = $data['photo'];
            unset($data['photo']);

            if ($new = $this->repository->create($data)) {
                if($file){
                    Storage::disk('local')->put('user/' . $new->id . '/perfil.png', file_get_contents($file));
                    $new->photo = 'user/' . $new->id . '/perfil.png';
                }
                if ($new->save()) {
                    DB::commit();
                    return ['status' => '00'];
                }
        }
            DB::rollback();
            return ['status' => '01', 'message' => 'Ocorreu um erro durante a criação do registro'];
        } catch (\Exception $e) {
            DB::rollback();
            Log::debug($e->getMessage());
            return ['status' => '01', 'message' => $e->getMessage()];
        }
    }

    /**
     * Method to update User Information
     *
     * @param array $data
     * @param int $id
     * @return array|mixed
     */
    public function update(array $data, int $id)
    {
        DB::beginTransaction();
        try {
            $photo = (!empty($data['photo'])) ? $data['photo'] : null;
            $user = $this->repository->find($id);

            if (empty($user)) {
                DB::rollback();
                return ['status' => '01', 'message' => 'Usuário não encontrado'];
            }

            unset($data['photo']);

            if ($user->update($data)) {
                if (!empty($photo)) {
                    Storage::disk('local')->put('user/' . $user->id . '/perfil.png', base64_decode($photo));
                    $user->update(['photo' => 'user/' . $user->id . '/perfil.png']);
                }
            }

            DB::commit();
            return ['status' => '00'];
        } catch (\Exception $e) {
            DB::rollback();
            Log::debug($e->getMessage());
            return ['status' => '01', 'message' => $e->getMessage()];
        }
    }

    /**
     * Method to update User Profile Image
     *
     * @param array $data
     * @param integer $id
     * @return array
     */
    public function updateImage(array $data, $id)
    {
        DB::beginTransaction();
        try {
            $user = $this->repository->find($id);
            if ($user->update(['photo' => 'user/' . $user->id . '/perfil.png'])) {
                Storage::disk('local')->put('user/' . $user->id . '/perfil.png', file_get_contents($data['photo']));
                DB::commit();
                return ['status' => '00'];
            }
            DB::rollback();
            return ['status' => '01', 'Ocorreu um erro ao realizar o upload da Imagem'];
        } catch (\Exception $e) {
            DB::rollback();
            Log::debug($e->getMessage());
            return ['status' => '01', 'message' => $e->getMessage()];
        }
    }
}