<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Penugasan petugas ke bidang / sub bidang. */
class UserBidangAccess extends Model
{
    protected $table = 'user_bidang_access';

    protected $fillable = ['user_id', 'bidang', 'sub_bidang'];
}
