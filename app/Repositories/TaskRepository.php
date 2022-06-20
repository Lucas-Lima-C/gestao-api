<?php

namespace App\Repositories;

use App\Models\Task;
use LaravelAux\BaseRepository;

class TaskRepository extends BaseRepository
{
    /**
     * UserService constructor.
     *
     * @param Task $model
     */
    public function __construct(Task $model)
    {
        parent::__construct($model);
    }
}