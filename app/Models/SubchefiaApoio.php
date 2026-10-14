<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubchefiaApoio extends Model
{
    protected $table = 'subchefia_apoio';
    protected $primaryKey = 'id_sub_apoio';

    protected $fillable = [
        'nome_sub_apoio',
        'sigla_sub_apoio',
    ];
}
