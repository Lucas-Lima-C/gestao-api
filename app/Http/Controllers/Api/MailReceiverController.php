<?php

namespace App\Http\Controllers\Api;

use App\Services\MailReceiverService;
use App\Http\Requests\MailReceiverRequest;
use LaravelAux\BaseController;

class MailReceiverController extends BaseController
{
    /**
     * UserController constructor.
     *
     * @param MailReceiverService $service
     * @param MailReceiverRequest $request
     */
    public function __construct(MailReceiverService $service)
    {
        parent::__construct($service, new MailReceiverRequest);
    }

    public function changeMailReceiver($id)
    {
        $condition = $this->service->changeMailReceiver($id);
        if ($condition['status'] === '00') {
            return response()->json('Recebedor de e-mail alterado com sucesso', 201);
        }
        return response()->json($condition['message'], 500);
    }
}