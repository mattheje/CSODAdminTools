<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tool extends Model
{
    public function getAllTools(){
        return DB::table('lng_tools')->orderBy('name', 'asc')->orderBy('id', 'desc')->get();
    } //end getAllTools

    public function resetUserPermissions($userId, $permissions, $updatedBy) {
        if(!($userId > 0)) return false;
        DB::transaction(function () use ($userId, $permissions, $updatedBy) {
            DB::table('lng_user_permissions')->where('user_id', $userId)->delete();
            foreach($permissions as $permission) {
                DB::table('lng_user_permissions')->insert(
                    ['user_id' => $userId, 'tool_id' => $permission, 'status' => 1, 'updated_by' => $updatedBy, 'inserted_on' => date('Y-m-d H:i:s') ]
                );
            } //end foreach
        }, 3); //end transaction (3 retries)
        return true;
    } //end resetUserPermissions
} //end Tool Class
