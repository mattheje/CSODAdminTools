<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoNumber extends Model
{
    public function insertLoNumber($courseData) {
        return DB::table('lo_numgen')->insertGetId($courseData);
    } //end insertLoNumber

} //end class
