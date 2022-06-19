<?php

namespace App\Services;

use App\Models\User;
use LaravelAux\BaseService;
use App\Models\UserRecovery;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Repositories\UserRecoveryRepository;

class UserRecoveryService extends BaseService
{
    /**
     * UserService constructor.
     *
     * @param UserRecoveryRepository $repository
     */
    public function __construct(UserRecoveryRepository $repository)
    {
        parent::__construct($repository);
    }

    public function recovery(array $data)
    {
        DB::beginTransaction();
        $user = User::where('email', $data['email'])->first();
        
        if(empty($user)){
            DB::rollBack();
            return ['status' => '01', 'message' => 'Usuário não encontrado.'];
        }

        if(trim($user->email) == ''){
            DB::rollBack();
            return ['status' => '01', 'message' => 'E-mail não cadastrado. Procure a central de apoio ao colaborador.'];
        }
        
        $new  = $this->repository->create(['user_id' => $user->id, 'token' => md5(uniqid(rand(), true))]);

        if($new){
            $mail = [
                'name' => $user->name,
                'link' => route('user.password.recoveryUser.form', $new->token)
            ];

            $domain = explode('@', $user->email);

            if(isset($domain[1])){
                $domain = $domain[1];
            } else {
                $domain = '';
            }

            $msg = ' E-mail de recuperação de senha enviado para ' . substr($user->email, 0, 3) . '...@' . $domain;
            
            Mail::to($data['email'])->queue(new ForgotPasswordMail($mail));
            DB::commit();
            return ['status' => '00', 'message' => $msg];
        }

        DB::rollBack();
        return ['status' => '01', 'message' => 'Não foi possível solicitar a recuperação de senha.'];
    }

    public function recoveryForm($token)
    {
        $passport = UserRecovery::where('token', $token)->first();

        if(!$passport->expired){
            return ['status' => '00',
                'data' => [
                    'expired' => $passport->expired
                ]
            ];
        }

        return ['status' => '01', 'message' => 'Usuário não encontrado'];
    }

    public function changePassword($token, $data)
    {
        DB::beginTransaction();
        try{
            $request = UserRecovery::where('token', $token)->first();
            $user = User::find($request->user_id);
            
            if($data['password'] == $data['password_confirmation']){
                $user->password = $data['password'];
                if($user->save()){
                    $request->update(['expired' => true]);

                    DB::commit();
                    return ['status' => '00'];
                }
            } else {
                return ['status' => '01', 'message' => 'As senhas não conferem'];
            }
        }catch(\Exception $e){
            DB::rollBack();
            return ['status' => '01', 'message' => $e->getMessage()];
        }
    }
}