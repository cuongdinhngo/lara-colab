<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use App\Repositories\User\UserInterface;

class UserRepository extends BaseRepository implements UserInterface
{
    public function getModel()
    {
        return \App\Models\User::class;
    }
}
