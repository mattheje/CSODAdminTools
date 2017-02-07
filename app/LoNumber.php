<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoNumber extends Model
{
    public function insertLoNumber($courseData) {
        return DB::table('lng_lonum')->insertGetId($courseData);
    } //end insertLoNumber

    public function unLockLmsLoNumber($loId) {
        return DB::table('lng_lonum')->where('id', $loId)->delete();
    } //end unLockLmsLoNumber

    public function getMyReservedLOs($ownerId, $lonum) {
        $lonum = str_replace('*', '%', $lonum);
        $where='';
        $params = array($ownerId);
        if(trim($lonum) != '') {
            $where = " AND       (g.course_no LIKE ? OR g.course_title LIKE ?)";
            $params[] = '%' . $lonum . '%';
            $params[] = '%' . $lonum . '%';
        } //end if
        $sql = <<<ENDSQLTEXT
        SELECT    g.*, CASE step WHEN 6 THEN 'Published' WHEN 5 THEN 'Reserved' WHEN 4 THEN 'In-Progress' ELSE 'In-Progress' END AS stepname
        FROM      `lng_lonum` g
        WHERE     g.owner_id=?
        AND       g.step < 6
        {$where}
        ORDER BY  g.id DESC
ENDSQLTEXT;
        $db = DB::connection()->getPdo();
        $sth = $db->prepare($sql);
        $sth->execute($params);
        return $sth->fetchAll();
    } //end getMyReservedLOs

    public function getMyPublishedLOs($ownerId, $lonum) {
        $lonum = str_replace('*', '%', $lonum);
        $where='';
        $params = array($ownerId);
        if(trim($lonum) != '') {
            $where = " AND       (g.course_no LIKE ? OR g.course_title LIKE ?)";
            $params[] = '%' . $lonum . '%';
            $params[] = '%' . $lonum . '%';
        } //end if
        $sql = <<<ENDSQLTEXT
        SELECT    g.*, CASE step WHEN 6 THEN 'Published' WHEN 5 THEN 'Reserved' WHEN 4 THEN 'In-Progress' ELSE 'In-Progress' END AS stepname
        FROM      `lng_lonum` g
        WHERE     g.owner_id=?
        AND       g.step = 6
        {$where}
        ORDER BY  g.id DESC
ENDSQLTEXT;
        $db = DB::connection()->getPdo();
        $sth = $db->prepare($sql);
        $sth->execute($params);
        return $sth->fetchAll();
    } //end getMyPublishedLOs

    public function getOthersReservedLOs($ownerId, $lonum) {
        $lonum = str_replace('*', '%', $lonum);
        $where='';
        $params = array($ownerId);
        if(trim($lonum) != '') {
            $where = " AND       (g.course_no LIKE ? OR g.course_title LIKE ?)";
            $params[] = '%' . $lonum . '%';
            $params[] = '%' . $lonum . '%';
        } //end if
        $sql = <<<ENDSQLTEXT
        SELECT    g.*, CONCAT(u.fname, ' ', u.lname) as ownername, CASE step WHEN 6 THEN 'Published' WHEN 5 THEN 'Reserved' WHEN 4 THEN 'In-Progress' ELSE 'In-Progress' END AS stepname
        FROM      `lng_lonum` g
        JOIN      `lng_users` u ON (g.owner_id=u.id)
        WHERE     g.owner_id <> ?
        AND       g.step < 6
        {$where}
        ORDER BY  g.id DESC
ENDSQLTEXT;
        $db = DB::connection()->getPdo();
        $sth = $db->prepare($sql);
        $sth->execute($params);
        return $sth->fetchAll();
    } //end getOthersReservedLOs

} //end class
