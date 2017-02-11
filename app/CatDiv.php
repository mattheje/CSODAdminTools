<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CatDiv extends Model
{
    public function getAllCatDivs(){
        return DB::table('lng_lonum_catdiv')->orderBy('division_name', 'asc')->orderBy('id', 'desc')->get();
    } //end getAllCatDivs

    public function getCatDivById($id) {
        return DB::table('lng_lonum_catdiv')->where('id', $id)->orderBy('code', 'desc')->orderBy('id', 'desc')->first();
    } //end getVatDivById

} //end class
