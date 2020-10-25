<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class authenticationCode extends Model
{
    public $timestamps = false;
    protected $fillable=[
      'Code'
    ];
    protected $primaryKey='auth_id';
    protected $table='tbl_code';
}
