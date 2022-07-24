<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFuncaoCdc extends Model
{
    use SoftDeletes;

    protected $table = 'user_funcao_cdc';

    protected $fillable = [
        'id_user', 'id_funcao', 'id_cdc'
    ];

    protected $dates = ['deleted_at'];
    //
}
