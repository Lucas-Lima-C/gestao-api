<?php

namespace App\Repositories;

use App\Models\MailReceiver;
use LaravelAux\BaseRepository;

class MailReceiverRepository extends BaseRepository
{
    /**
     * UserService constructor.
     *
     * @param MailReceiver $model
     */
    public function __construct(MailReceiver $model)
    {
        parent::__construct($model);
    }
}