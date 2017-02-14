<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    protected $userId = null;
    protected $userData = [];

    public function authenticate($username, $password) {
        $userId = $this->ldapFAluAuthenticate($username, $password);
        if(!($userId > 0)) $userId = $this->ldapFNokiaAuthenticate($username, $password);

        $logid = DB::table('lng_login_log')->insertGetId(['username' => $username,
                                                          'successful' => ($userId > 0) ? 1 : 0,
                                                          'attempted_on' => date('Y-m-d H:i:s'),
                                                          'remote_addr' => $_SERVER["REMOTE_ADDR"],
                                                          'referer' => $_SERVER["HTTP_REFERER"],
                                                          'user_agent' => $_SERVER["HTTP_USER_AGENT"]]);

        return $userId;
    } //end authenticate function


    private function ldapFAluAuthenticate($username, $password) {
        $userId=0;
        $ldap = ldap_connect(env('ALU_LDAP_HOST'), env('ALU_LDAP_PORT'));
        if (!($ldap)) return -1;

        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);

        $res = ldap_bind($ldap, env('ALU_LDAP_USERNAME'), env('ALU_LDAP_PASSWORD')); // login to server
        if (!($res)) return -1;
        $filter = "uid=" . $username; //should be f-ALU CSL value
        $attributes = ["cn", "uid", "givenname", "sn", "mail", "country", "nokiaid"];
        $results = @ldap_search($ldap, env('ALU_LDAP_BASE'), $filter, $attributes);
        $number_of_results = @ldap_count_entries($ldap, $results);
        switch ($number_of_results) {
            case 0: // no match...
                break;
            case 1:
                $result = ldap_get_entries($ldap, $results);
                $dn_user = isset($result[0]["dn"]) ? $result[0]["dn"] : null;
                if(is_null($dn_user)) break;
                $is_valid_password = @ldap_bind($ldap, $dn_user, $password);
                $this->userData['country'] = isset($result[0]['country'][0]) ? trim($result[0]['country'][0]) : null; //set this here since the other LDAP method does not have this attribute
                if ($is_valid_password && isset($result[0]['nokiaid'][0]) && trim($result[0]['nokiaid'][0]) != '') {
                    //hurray ... correct password
                    $this->userData['csod_userid'] = trim($result[0]['nokiaid'][0]);
                    $this->userData['username'] = $username;
                    $this->userData['fname'] = isset($result[0]['givenname'][0]) ? trim($result[0]['givenname'][0]) : null;
                    $this->userData['lname'] = isset($result[0]['sn'][0]) ? strtoupper(trim($result[0]['sn'][0])) : null;
                    $this->userData['email'] = isset($result[0]['mail'][0]) ? trim($result[0]['mail'][0]) : null;
                    //$this->userData['country'] = isset($result[0]['country'][0]) ? trim($result[0]['country'][0]) : null;
                    $this->userData['source'] = 'A';
                    $this->userData['inserted_on'] = date('Y-m-d H:i:s');
                    $this->userData['last_login_on'] = date('Y-m-d H:i:s');
                    $this->userData['updated_by'] = 'login';
                    $userId = $this->addOrUpdateUser();
                    $this->userId = $userId;
                    $this->setUserPermission($userId, 'lonumadmin', 'login');
                } //end if
                break;
            default: // more than 1 match -> ambiguous
                break;
        } //end switch
        @ldap_unbind($ldap);

        return $userId;
    } //end ldapFAluAuthenticate function


    private function ldapFNokiaAuthenticate($username, $password) {
        $userId=0;
        $ldap = ldap_connect(env('NOKIA_LDAP_HOST'), env('NOKIA_LDAP_PORT'));
        if (!($ldap)) return -1;

        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);

        $res = ldap_bind($ldap); // anonymous bind
        if (!($res)) return -1;
        //$filter = "employeeNumber=" . $username;
        $filter = "uid=" . $username;
        $attributes = ["cn", "gecos", "mail", "nsnprimaryemailaddress", "uid", "employeenumber"];
        $results = @ldap_search($ldap, env('NOKIA_LDAP_BASE'), $filter, $attributes);
        $number_of_results = @ldap_count_entries($ldap, $results);
        switch ($number_of_results) {
            case 0: // no match...
                break;
            case 1:
                $result = ldap_get_entries($ldap, $results);
                $dn_user = isset($result[0]["dn"]) ? $result[0]["dn"] : null;
                if(is_null($dn_user)) break;
                $is_valid_password = @ldap_bind($ldap, $dn_user, $password);
                if ($is_valid_password && isset($result[0]['employeenumber'][0]) && trim($result[0]['employeenumber'][0]) != '') {
                    if(isset($result[0]['cn'][0])) {
                        $parts = explode(' ', $result[0]['cn'][0]);
                        $this->userData['lname'] = strtoupper(trim(array_shift($parts)));
                        $this->userData['fname'] = trim(implode(' ', $parts));
                    } //end if
                    $this->userData['csod_userid'] = trim($result[0]['employeenumber'][0]);
                    $this->userData['username'] = $username;
                    $this->userData['email'] = isset($result[0]['mail'][0]) ? $result[0]['mail'][0] : $this->userData['email'];
                    $this->userData['source'] = 'N';
                    $this->userData['country'] = isset($this->userData['country']) ? $this->userData['country'] : null; //This LDAP Does Not Have This Attribute, so user the other LDAP's info here
                    $this->userData['inserted_on'] = date('Y-m-d H:i:s');
                    $this->userData['last_login_on'] = date('Y-m-d H:i:s');
                    $this->userData['updated_by'] = 'login';
                    $userId = $this->addOrUpdateUser();
                    $this->userId = $userId;
                    $this->setUserPermission($userId, 'lonumadmin', 'login');  //Grant Lo Number Generator Tool Permission By Default Upon First Login
                } //end if
                break;
            default: // more than 1 match -> ambiguous
                break;
        } //end switch
        @ldap_unbind($ldap);

        return $userId;
    } //end ldapFNokiaAuthenticate function


    public function addOrUpdateUser() {
        $sqltxt = <<<ENDSQLTEXT
        INSERT INTO `lng_users`
        (`csod_userid`, `username`,
         `fname`, `lname`, `email`,
         `country`, `source`, `updated_by`,
         `inserted_on`, `last_login_on`)
        VALUES
        (:csod_userid, :username,
         :fname, :lname, :email,
         :country, :source, :updated_by,
         :inserted_on, :last_login_on)
        ON DUPLICATE KEY
        UPDATE `id`=LAST_INSERT_ID(`id`),
               `username`=IF(NULLIF(TRIM(VALUES(`username`)),'') IS NULL,`username`,VALUES(`username`)),
               `fname`=IF(NULLIF(TRIM(VALUES(`fname`)),'') IS NULL,`fname`,VALUES(`fname`)),
               `lname`=IF(NULLIF(TRIM(VALUES(`lname`)),'') IS NULL,`lname`,VALUES(`lname`)),
               `email`=IF(NULLIF(TRIM(VALUES(`email`)),'') IS NULL,`email`,VALUES(`email`)),
               `country`=IF(NULLIF(TRIM(VALUES(`country`)),'') IS NULL,`country`,VALUES(`country`)),
               `source`=IF(NULLIF(TRIM(VALUES(`source`)),'') IS NULL,`source`,VALUES(`source`)),
               `updated_by`=VALUES(`updated_by`),
               `last_login_on`=VALUES(`last_login_on`)
ENDSQLTEXT;
        $pdo = DB::connection()->getPdo();
        $stmt = $pdo->prepare($sqltxt);
        $stmt->execute($this->userData);
        $userId = $pdo->lastInsertId();
        return $userId;
    } //end addOrUpdateUser


    public function setUserPermission($userId, $permissionShortName, $updatedBy) {
        if(!($userId > 0 && trim($permissionShortName) != '')) return false;
        $sqltxt = <<<ENDSQLTEXT
        INSERT INTO `lng_user_permissions`
        (`user_id`, `tool_id`,
         `updated_by`, `inserted_on`)
        VALUES
        (:user_id, (SELECT `id` FROM `lng_tools` WHERE `shortname`=:shortname ORDER BY `id` DESC LIMIT 1),
         :updated_by, :inserted_on)
        ON DUPLICATE KEY
        UPDATE `id`=LAST_INSERT_ID(`id`),
               `updated_by`='login'
ENDSQLTEXT;
        $pdo = DB::connection()->getPdo();
        $stmt = $pdo->prepare($sqltxt);
        $stmt->execute(['user_id' => $userId, 'shortname' => $permissionShortName,
                        'updated_by' => $updatedBy, 'inserted_on' => date('Y-m-d H:i:s')]);
        $permissionId = $pdo->lastInsertId();
        return $permissionId;
    } //end setUserPermission


    public function getUserById($id) {
        return DB::table('lng_users')->where('id', $id)->orderBy('updated_on', 'desc')->first();
    } //end getUser

    public function getAllUsers() {
        return DB::table('lng_users')->orderBy('lname', 'asc')->orderBy('id', 'desc')->get();
    } //end getAllUsers

    public function getUsersByNameOrCsl($srchName, $srchCsl) {
        $srchName = str_replace('%', '\\%', $srchName);
        $srchName = str_replace('*', '\\%', $srchName);
        $srchCsl = str_replace('%', '\\%', $srchCsl);
        $srchCsl = str_replace('*', '\\%', $srchCsl);

        $query = DB::table('lng_users AS u')->leftJoin('lng_user_permissions AS p', 'u.id', '=', 'p.user_id')
                                       ->select(DB::raw('u.id, u.csod_userid, u.username, u.fname, u.lname, u.email, u.country, u.status, count(p.id) as permissions'));
        if(trim($srchName) != '') $query->where('lname', 'LIKE', '%' . $srchName . '%');
        if(trim($srchCsl) != '') $query->where('username', 'LIKE', '%' . $srchCsl . '%');

        return $query->groupBy('u.id', 'u.csod_userid', 'u.username', 'u.fname', 'u.lname', 'u.email', 'u.country', 'u.status')
                     ->orderBy('lname', 'asc')
                     ->orderBy('id', 'desc')
                     ->get()->toArray();

    } //end getUsersByNameOrCsl

    public function searchFAluLdapForUser($srchName, $srchCsl, $srchImprt, $usersData) {
        $srchName = str_replace('%', '*', $srchName);
        $srchCsl = str_replace('%', '*', $srchCsl);
        if((trim($srchName) == '' && trim($srchCsl) == '') || ($srchImprt == 1)) return array();

        $ldap = ldap_connect(env('ALU_LDAP_HOST'), env('ALU_LDAP_PORT'));
        if (!($ldap)) return -1;

        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);

        $res = ldap_bind($ldap, env('ALU_LDAP_USERNAME'), env('ALU_LDAP_PASSWORD')); // login to server
        if (!($res)) return -1;
        $filter = (trim($srchName) != '') ? "sn=" . $srchName . '*' : ''; //last name
        $filter = (trim($srchCsl) != '') ? "uid=" . $srchCsl . '*' : $filter; //should be f-ALU CSL value
        $attributes = ["cn", "uid", "givenname", "sn", "mail", "country", "nokiaid"];
        $results = @ldap_search($ldap, env('ALU_LDAP_BASE'), $filter, $attributes);
        $number_of_results = @ldap_count_entries($ldap, $results);
        $returnAry = [];
        if($number_of_results > 0) {
            $existingUsers = array();
            foreach($usersData as $existingUser) $existingUsers[]=$existingUser->csod_userid;
            $resultsObj = ldap_get_entries($ldap, $results);
            for($i=0; $i <= $number_of_results; $i++) {
                if(isset($resultsObj[$i]['nokiaid'][0]) && isset($resultsObj[$i]['uid'][0]) && !in_array($resultsObj[$i]['nokiaid'][0],$existingUsers)) {
                    $returnAry[] =
                        ['id' => '',
                         'csod_userid' => isset($resultsObj[$i]['nokiaid'][0]) ? trim($resultsObj[$i]['nokiaid'][0]) : null,
                         'username' => isset($resultsObj[$i]['uid'][0]) ? trim($resultsObj[$i]['uid'][0]) : null, trim($resultsObj[$i]['uid'][0]),
                         'status' => 0,
                         'fname' => isset($resultsObj[$i]['givenname'][0]) ? trim($resultsObj[$i]['givenname'][0]) : null,
                         'lname' => isset($resultsObj[$i]['sn'][0]) ? strtoupper(trim($resultsObj[$i]['sn'][0])) : null,
                         'email' => isset($resultsObj[$i]['mail'][0]) ? trim($resultsObj[$i]['mail'][0]) : null,
                         'country' => isset($resultsObj[$i]['country'][0]) ? trim($resultsObj[$i]['country'][0]) : null,
                         'source' => 'A',
                         'permissions' => 0,
                         'updated_by' => ''];
                } //end if
            } //end for
        } //end if
        @ldap_unbind($ldap);
        return $returnAry;
    } //end searchFAluLdapForUser

    public function getAllUsersPermissions($srchName, $srchCsl) {
        $srchName = str_replace('%', '\\%', $srchName);
        $srchName = str_replace('*', '\\%', $srchName);
        $srchCsl = str_replace('%', '\\%', $srchCsl);
        $srchCsl = str_replace('*', '\\%', $srchCsl);

        /*
        SELECT   up.user_id, GROUP_CONCAT(up.tool_id) as tool_ids
        FROM     lng_user_permissions up
        JOIN     lng_users u ON up.user_id=u.id
        WHERE    u.status=1
        ...
        AND      up.status=1
        GROUP BY up.user_id
        ORDER BY u.id ASC
         */

        $query = DB::table('lng_user_permissions AS up')->join('lng_users AS u', 'up.user_id', '=', 'u.id')
                     ->select(DB::raw('up.user_id, GROUP_CONCAT(up.tool_id) as tool_ids'))->where('u.status',1)->where('up.status',1);
        if(trim($srchName) != '') $query->where('u.lname', 'LIKE', '%' . $srchName . '%');
        if(trim($srchCsl) != '') $query->where('u.username', 'LIKE', '%' . $srchCsl . '%');

        $userPermissions = $query->groupBy('up.user_id')
                                 ->orderBy('up.user_id', 'asc')
                                 ->get();
        $associativeUsersPermissions = [];
        foreach ($userPermissions as $userPermission) {
            $associativeUsersPermissions[$userPermission->user_id]=explode(',', $userPermission->tool_ids);
        } //end foreach

        return $associativeUsersPermissions;
    } //end getAllUsersPermissions

    public function importUserFromLdap($userId, $updatedBy) {
        $ldap = ldap_connect(env('ALU_LDAP_HOST'), env('ALU_LDAP_PORT'));
        if (!($ldap)) return -1;

        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);

        $res = ldap_bind($ldap, env('ALU_LDAP_USERNAME'), env('ALU_LDAP_PASSWORD')); // login to server
        if (!($res)) return -1;
        $filter = "uid=" . $userId; //should be f-ALU CSL value
        $attributes = ["cn", "uid", "givenname", "sn", "mail", "country", "nokiaid"];
        $results = @ldap_search($ldap, env('ALU_LDAP_BASE'), $filter, $attributes);
        $number_of_results = @ldap_count_entries($ldap, $results);
        switch ($number_of_results) {
            case 0: // no match...
                return false;
                break;
            case 1:
                $result = ldap_get_entries($ldap, $results);
                $dn_user = isset($result[0]["dn"]) ? $result[0]["dn"] : null;
                if(is_null($dn_user) || !isset($result[0]['nokiaid'][0])) { return false; break; }
                $this->userData['country'] = isset($result[0]['country'][0]) ? trim($result[0]['country'][0]) : null; //set this here since the other LDAP method does not have this attribute
                $this->userData['csod_userid'] = trim($result[0]['nokiaid'][0]);
                $this->userData['username'] = $userId;
                $this->userData['fname'] = isset($result[0]['givenname'][0]) ? trim($result[0]['givenname'][0]) : null;
                $this->userData['lname'] = isset($result[0]['sn'][0]) ? strtoupper(trim($result[0]['sn'][0])) : null;
                $this->userData['email'] = isset($result[0]['mail'][0]) ? trim($result[0]['mail'][0]) : null;
                //$this->userData['country'] = isset($result[0]['country'][0]) ? trim($result[0]['country'][0]) : null;
                $this->userData['source'] = 'A';
                $this->userData['inserted_on'] = date('Y-m-d H:i:s');
                $this->userData['last_login_on'] = date('Y-m-d H:i:s');
                $this->userData['updated_by'] = $updatedBy;
                $userId = $this->addOrUpdateUser();
                $this->userId = $userId;
                $this->setUserPermission($userId, 'lonumadmin', $updatedBy);
                break;
            default: // more than 1 match -> ambiguous
                return false;
                break;
        } //end switch
        @ldap_unbind($ldap);
        return $this->userId;
    } //end importUserFromLdap

    public function deactivateUser($userId, $updatedBy) {
        return ($userId > 0) ? DB::table('lng_users')->where('id', $userId)->update(['status' => 0, 'updated_by' => $updatedBy]) : false;
    } //end deactivateUser

    public function reactivateUser($userId, $updatedBy) {
        return ($userId > 0) ? DB::table('lng_users')->where('id', $userId)->update(['status' => 1, 'updated_by' => $updatedBy]) : false;
    } //end reactivateUser

    public function getPermissions($userId) {
        if (!($userId > 0)) return [];
        $data = DB::table('lng_user_permissions AS up')
                    ->join('lng_users AS u', 'up.user_id', '=', 'u.id')
                    ->join('lng_tools AS t', 'up.tool_id', '=', 't.id')
                    ->select('t.shortname')
                    ->where('u.id',$userId)
                    ->where('up.status',1)
                    ->where('u.status',1)
                    ->where('t.status',1)
                    ->orderBy('t.shortname', 'asc')
                    ->distinct()->get();
        $returnAry = [];
        foreach($data as $item) {
            $returnAry[]=trim($item->shortname);
        } //end foreach
        return $returnAry;
    } //end getPermissions

    public function migrateUser() {

    } //end migrateUsers


} //end User class
