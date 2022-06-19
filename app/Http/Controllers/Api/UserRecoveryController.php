<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use LaravelAux\BaseController;
use App\Services\UserRecoveryService;
use App\Http\Requests\UserRecoveryRequest;

class UserRecoveryController extends BaseController
{
    /**
     * UserController constructor.
     *
     * @param UserRecoveryService $service
     * @param UserRecoveryRequest $request
     */
    public function __construct(UserRecoveryService $service)
    {
        parent::__construct($service, new UserRecoveryRequest);
    }

    public function recovery(Request $request)
    {
        $condition = $this->service->recovery($request->all());

        if($condition['status'] === '00'){
            return response()->json($condition['message'], 200);
        }

        return response()->json($condition['message'], 500);
    }

    public function recoveryForm($token)
    {
        $condition = $this->service->recoveryForm($token);
        if($condition['status'] === '00'){
            return view('recovery.recovery', [
                'expired' => $condition['data']['expired'],
                'token' => $token
            ]);
        }

        return abort(500);
    }

    public function changePassword(UserRecoveryRequest $request, $token)
    {
        $condition = $this->service->changePassword($token, $request->all());
        
        if($condition['status'] === '00'){
            return view('recovery.success');
        } else {
            return view('recovery.error', [
                'error' => $condition['message']
            ]);
        }
    }
}