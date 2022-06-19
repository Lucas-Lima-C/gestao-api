<?php

namespace App\Repositories;

use App\Models\UserRecovery;
use LaravelAux\BaseRepository;

class UserRecoveryRepository extends BaseRepository
{
    /**
     * UserService constructor.
     *
     * @param UserRecovery $model
     */
    public function __construct(UserRecovery $model)
    {
        parent::__construct($model);
    }
}