<?php

namespace App\Repositories\Staff;

use App\Repositories\BaseRepository;
use App\Repositories\Staff\StaffInterface;

class StaffRepository extends BaseRepository implements StaffInterface
{
    public function getModel()
    {
        return \App\Models\Staff::class;
    }
}
