<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\CatDiv;

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
        $params = [$ownerId];
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

    public function searchLmsCourseDataRaw($lonum) {
        $lonum = str_replace('*', '%', $lonum);
        $crsnumsrch = trim($lonum).'%';
        $titlesrch = '%'.trim($lonum).'%';

        $sql = <<<ENDSQLTEXT
        SELECT    'Here' AS place,
                  TRIM(UPPER(g.course_no_raw)) AS course_no,
                  IFNULL(NULLIF(TRIM(UPPER(g.`version`)),''),'1.0') AS version,
                  CONCAT(TRIM(UPPER(g.course_no_raw)),'_V',IFNULL(NULLIF(TRIM(UPPER(g.`version`)),''),'1.0')) AS combined,
                  TRIM(g.course_title) AS course_title,
                  CONCAT(u.fname,' ',u.lname) AS owner,
                  IFNULL(g.inserted_on,'Unknown') AS cdate
        FROM      `lng_lonum` g
        LEFT JOIN `lng_users` u
        ON        (g.owner_id=u.id)
        WHERE     NULLIF(TRIM(g.course_no_raw),'') IS NOT NULL
        AND       (g.course_no_raw LIKE ?
                   OR
                   g.course_title LIKE ?)
        UNION
        SELECT    'CSOD' AS place,
                  SUBSTRING_INDEX(UPPER(TRIM(lmsc.course_no)),'_V',1) AS course_no,
                  IFNULL(NULLIF(TRIM(UPPER(lmsc.`version`)),''),'1.0') AS version,
                  CONCAT(SUBSTRING_INDEX(UPPER(TRIM(lmsc.course_no)),'_V',1),'_V',IFNULL(NULLIF(TRIM(UPPER(lmsc.`version`)),''),'1.0')) AS combined,
                  TRIM(lmsc.course_title) AS course_title,
                  IFNULL(lmsc.lms_created_by,lmsc.lms_updated_by) AS owner,
                  IFNULL(lmsc.lms_updated_on,'Unknown') AS cdate
        FROM      `lms_los` lmsc
        WHERE     NULLIF(TRIM(lmsc.course_no),'') IS NOT NULL
        AND       (SUBSTRING_INDEX(UPPER(TRIM(lmsc.course_no)),'_V',1) LIKE ?
                   OR
                   lmsc.course_title LIKE ?)
        ORDER BY   place DESC, course_no ASC, INET_ATON(SUBSTRING_INDEX(CONCAT(version,'.0.0.0'),'.',4)) ASC, cdate ASC
ENDSQLTEXT;
        $db = DB::connection()->getPdo();
        $sth = $db->prepare($sql);
        $sth->execute([$crsnumsrch,$titlesrch,$crsnumsrch,$titlesrch]);
        $rows = $sth->fetchAll();
        $unique=array();
        foreach($rows as $row) {
            $unique[$row['combined']]=$row;
        } //end foreach
        $returnary=array();
        foreach($unique as $result) $returnary[]=$result;
        return $returnary;
    } //end searchLmsCourseDataRaw

    public function getNextCourseVersionNumber($lonum) {
        $lonum = trim(strtoupper($lonum));
        $sql = <<<ENDSQLTEXT
        SELECT    IFNULL(MAX(T.version),'1.0') AS max_version FROM (
          SELECT    TRIM(UPPER(g.course_no_raw)) AS course_no,
                    IFNULL(NULLIF(TRIM(UPPER(g.`version`)),''),'1.0') AS version
          FROM      `lng_lonum` g
          WHERE     NULLIF(TRIM(g.course_no_raw),'') IS NOT NULL
          AND       g.course_no_raw=?
          UNION
          SELECT    SUBSTRING_INDEX(UPPER(TRIM(lmsc.course_no)),'_V',1) AS course_no,
                    IFNULL(NULLIF(TRIM(UPPER(lmsc.`version`)),''),'1.0') AS version
          FROM      `lms_los` lmsc
          WHERE     NULLIF(TRIM(lmsc.course_no),'') IS NOT NULL
          AND       SUBSTRING_INDEX(UPPER(TRIM(lmsc.course_no)),'_V',1)=?
          ) T
ENDSQLTEXT;
        $db = DB::connection()->getPdo();
        $sth = $db->prepare($sql);
        $sth->execute([$lonum, $lonum]);
        $val = $sth->fetchColumn();

        if(is_numeric($val)) {
            return array('nextversion'=>($val+0.1));
        } else {
            return array('nextversion'=>'');
        } //end if
    } //end getNextCourseVersionNumber

    public function getLmsCourseGenDataById($id) {
        $sql = <<<ENDSQLTXT
        SELECT    gen.*, CONCAT(u.fname,' ',u.lname) as name, u.email,
                  catdiv.code, catdiv.division_name, catdiv.pl_name,
                  catdiv.custom1, catdiv.custom2, catdiv.custom3
        FROM      `lng_lonum` gen
        LEFT JOIN `lng_lonum_catdiv` catdiv
        ON        (gen.catdiv_id=catdiv.id)
        LEFT JOIN `lng_users` u
        ON        (gen.owner_id=u.id)
        WHERE     gen.id=?
        ORDER BY  gen.course_no DESC, gen.`version` DESC
        LIMIT 1
ENDSQLTXT;
        $db = DB::connection()->getPdo();
        $sth = $db->prepare($sql);
        $sth->execute([$id]);
        return $sth->fetch();
    } //end getLmsCourseGenDataById

    public function checkManuallyEnteredCourseNumber($rcourse_no, $owner_id) {
        $delv_type_stripped = preg_replace('/[a-z\-\_ ]+$/i', '', $rcourse_no) . '%';
        $sql = <<<ENDSQLTEXT
        SELECT    'E' AS type, 'M' AS place,
                  TRIM(UPPER(g.course_no_raw)) AS course_no,
                  IFNULL(NULLIF(TRIM(UPPER(g.`version`)),''),'1.0') AS version,
                  CONCAT(u.fname,' ',u.lname) AS owner,
                  IFNULL(g.inserted_on,'Unknown') AS cdate
        FROM      `lng_lonum` g
        LEFT JOIN `lng_users` u
        ON        (g.owner_id=u.id)
        WHERE     NULLIF(TRIM(g.course_no_raw),'') IS NOT NULL
        AND       g.course_no_raw LIKE ?
        AND       g.step >= 4
        UNION
        SELECT    'E' AS type, 'C' AS place,
                  SUBSTRING_INDEX(UPPER(TRIM(lmsc.course_no)),'_V',1) AS course_no,
                  IFNULL(NULLIF(TRIM(UPPER(lmsc.`version`)),''),'1.0') AS version,
                  IFNULL(lmsc.lms_created_by,lmsc.lms_updated_by) AS owner,
                  IFNULL(lmsc.lms_updated_on,'Unknown') AS cdate
        FROM      `lms_los` lmsc
        WHERE     NULLIF(TRIM(lmsc.course_no),'') IS NOT NULL
        AND       SUBSTRING_INDEX(UPPER(TRIM(lmsc.course_no)),'_V',1) LIKE ?
        UNION
        SELECT    'E' AS type, 'M' AS place,
                  r.course_no,
                  IFNULL(NULLIF(TRIM(UPPER(r.`version`)),''),'1.0') AS version,
                  r.owner,
                  IFNULL(r.inserted_on,'Unknown') AS cdate
        FROM      `lng_lonum_resv` r
        WHERE     r.course_no IS NOT NULL
        AND       r.course_no=?
        UNION
        SELECT    'W' AS type, 'M' AS place,
                  TRIM(UPPER(g.course_no_raw)) AS course_no,
                  IFNULL(NULLIF(TRIM(UPPER(g.`version`)),''),'1.0') AS version,
                  CONCAT(u.fname,' ',u.lname) AS owner,
                  IFNULL(g.inserted_on,'Unknown') AS cdate
        FROM      `lng_lonum` g
        LEFT JOIN `lng_users` u
        ON        (g.owner_id=u.id)
        WHERE     NULLIF(TRIM(g.course_no_raw),'') IS NOT NULL
        AND       g.course_no_raw LIKE ?
        AND       g.owner_id <> ?
        UNION
        SELECT    'W' AS type, 'C' AS place,
                  SUBSTRING_INDEX(UPPER(TRIM(lmsc.course_no)),'_V',1) AS course_no,
                  IFNULL(NULLIF(TRIM(UPPER(lmsc.`version`)),''),'1.0') AS version,
                  IFNULL(lmsc.lms_created_by,lmsc.lms_updated_by) AS owner,
                  IFNULL(lmsc.lms_updated_on,'Unknown') AS cdate
        FROM      `lms_los` lmsc
        WHERE     NULLIF(TRIM(lmsc.course_no),'') IS NOT NULL
        AND       SUBSTRING_INDEX(UPPER(TRIM(lmsc.course_no)),'_V',1) LIKE ?
        UNION
        SELECT    'W' AS type, 'M' AS place,
                  r.course_no,
                  IFNULL(NULLIF(TRIM(UPPER(r.`version`)),''),'1.0') AS version,
                  r.owner,
                  IFNULL(r.inserted_on,'Unknown') AS cdate
        FROM      `lng_lonum_resv` r
        WHERE     r.course_no IS NOT NULL
        AND       r.course_no=?
        ORDER BY  type ASC, place ASC, course_no ASC, INET_ATON(SUBSTRING_INDEX(CONCAT(version,'.0.0.0'),'.',4)) ASC, cdate ASC
ENDSQLTEXT;
        $db = DB::connection()->getPdo();
        $sth = $db->prepare($sql);
        $sth->execute([$rcourse_no,$rcourse_no,$rcourse_no,$delv_type_stripped,$owner_id,$delv_type_stripped,$delv_type_stripped]);
        return $sth->fetchAll();
    } //end checkManuallyEnteredCourseNumber

    public function lookupLmsCatDivIdByCode($code) {
        $sql = <<<ENDSQLTXT
        SELECT    cd.id
        FROM      `lng_lonum_catdiv` cd
        WHERE     cd.code=?
        ORDER BY  cd.id DESC
        LIMIT 1
ENDSQLTXT;
        $db = DB::connection()->getPdo();
        $sth = $db->prepare($sql);
        $sth->execute([trim(strtoupper($code))]);
        $val = $sth->fetchColumn();
        return ($val > 0) ? $val : null;
    } //end lookupLmsCatDivIdByCode

    public function lockLmsCourseNo($step, $course_no, $type, $delv_type, $catdiv_id, $userid, $username, $method='N', $version='1.0') {
        $this->unLockLmsCourseNumbers();
        $id = null;
        $sql = <<<ENDSQLTXT
        SELECT    g.id
        FROM      `lng_lonum` g
        WHERE     NULLIF(TRIM(g.course_no_raw),'') IS NOT NULL
        AND       g.course_no_raw = ?
        AND       IFNULL(NULLIF(TRIM(g.`version`),''),'1.0') = ?
        ORDER BY  g.`version` DESC, g.id DESC
        LIMIT 1
ENDSQLTXT;
        $db = DB::connection()->getPdo();
        $sth = $db->prepare($sql);
        $sth->execute([strtoupper(trim($course_no)), trim(strtoupper($version))]);
        $row = $sth->fetch();

        if(isset($row['id']) && $row['id'] > 0) {
            //update
            $update_ary = array('step' => 3,
                'method' => trim(strtoupper($method)),
                'type' => trim(strtoupper($type)),
                'delv_type' => trim(strtoupper($delv_type)),
                'catdiv_id' => $catdiv_id,
                'owner_id' => $userid,
                'course_no' => $course_no . '_V' . trim(strtoupper($version)),
                'course_no_raw' => trim(strtoupper($course_no)),
                'version' => trim(strtoupper($version)),
                'updated_by' => trim($username));
            DB::table('lng_lonum')->where('id', $row['id'])->update($update_ary);
            $id = $row['id'];
        } else {
            //insert
            $insert_ary = array('step' => 3,
                'method' => trim(strtoupper($method)),
                'type' => trim(strtoupper($type)),
                'delv_type' => trim(strtoupper($delv_type)),
                'catdiv_id' => $catdiv_id,
                'owner_id' => $userid,
                'course_no' => $course_no . '_V' . trim(strtoupper($version)),
                'course_no_raw' => trim(strtoupper($course_no)),
                'version' => trim(strtoupper($version)),
                'updated_by' => trim($username),
                'inserted_on' => date("Y-m-d H:i:s"));
            $id = DB::table('lng_lonum')->insertGetId($insert_ary);
        } //end if
        return $id;
    } //end lockLmsCourseNo

    public function unLockLmsCourseNumbers() {
        $sql = <<<ENDSQLTXT
        DELETE
        FROM      `lng_lonum`
        WHERE     step=3
        AND       DATEDIFF(NOW(), inserted_on) > 2
ENDSQLTXT;
        //clean out old locked records older than 2 days
        $db = DB::connection()->getPdo();
        $db->query($sql);
    } //end unLockLmsCourseNumbers

    public function updateLmsCourseCreationStep($id, $completed_step, $userid, $username) {
        $update_ary = array('step' => $completed_step,
            'owner_id' => $userid,
            'updated_by' => trim($username));
        DB::table('lng_lonum')->where('id', $id)->update($update_ary);
    } //end updateLmsCourseCreationStep

    public function checkNewVersionNumber($course_no, $version, $owner_id) {
        $course_no = trim(strtoupper($course_no));
        $version = trim(strtoupper($version));
        $sql = <<<ENDSQLTEXT
        SELECT    'E' AS type, 'M' AS place,
                  TRIM(UPPER(g.course_no_raw)) AS course_no,
                  IFNULL(NULLIF(TRIM(UPPER(g.`version`)),''),'1.0') AS version,
                  CONCAT(u.fname,' ',u.lname) AS owner,
                  IFNULL(g.inserted_on,'Unknown') AS cdate
        FROM      `lng_lonum` g
        LEFT JOIN `lng_users` u
        ON        (g.owner_id=u.id)
        WHERE     NULLIF(TRIM(g.course_no_raw),'') IS NOT NULL
        AND       g.course_no_raw=?
        AND       IFNULL(NULLIF(TRIM(UPPER(g.`version`)),''),'1.0')=?
        AND       g.step >= 4
        UNION
        SELECT    'E' AS type, 'C' AS place,
                  SUBSTRING_INDEX(UPPER(TRIM(lmsc.course_no)),'_V',1) AS course_no,
                  IFNULL(NULLIF(TRIM(UPPER(lmsc.`version`)),''),'1.0') AS version,
                  IFNULL(lmsc.lms_created_by,lmsc.lms_updated_by) AS owner,
                  IFNULL(lmsc.lms_updated_on,'Unknown') AS cdate
        FROM      `lms_los` lmsc
        WHERE     NULLIF(TRIM(lmsc.course_no),'') IS NOT NULL
        AND       SUBSTRING_INDEX(UPPER(TRIM(lmsc.course_no)),'_V',1)=?
        AND       IFNULL(NULLIF(TRIM(UPPER(lmsc.`version`)),''),'1.0')=?
        UNION
        SELECT    'E' AS type, 'M' AS place,
                  r.course_no,
                  IFNULL(NULLIF(TRIM(UPPER(r.`version`)),''),'1.0') AS version,
                  r.owner,
                  IFNULL(r.inserted_on,'Unknown') AS cdate
        FROM      `lng_lonum_resv` r
        WHERE     r.course_no IS NOT NULL
        AND       r.course_no=?
        AND       IFNULL(NULLIF(TRIM(UPPER(r.`version`)),''),'1.0')=?
        UNION
        SELECT    'W' AS type, 'M' AS place,
                  TRIM(UPPER(g.course_no_raw)) AS course_no,
                  IFNULL(NULLIF(TRIM(UPPER(g.`version`)),''),'1.0') AS version,
                  CONCAT(u.fname,' ',u.lname) AS owner,
                  IFNULL(g.inserted_on,'Unknown') AS cdate
        FROM      `lng_lonum` g
        LEFT JOIN `lng_users` u
        ON        (g.owner_id=u.id)
        WHERE     NULLIF(TRIM(g.course_no_raw),'') IS NOT NULL
        AND       g.course_no_raw=?
        AND       IFNULL(NULLIF(TRIM(UPPER(g.`version`)),''),'1.0')=?
        AND       g.owner_id <> ?
        ORDER BY  type ASC, place ASC, course_no ASC, INET_ATON(SUBSTRING_INDEX(CONCAT(version,'.0.0.0'),'.',4)) ASC, cdate ASC
ENDSQLTEXT;
        $db = DB::connection()->getPdo();
        $sth = $db->prepare($sql);
        $sth->execute([$course_no,$version,$course_no,$version,$course_no,$version,$course_no,$version,$owner_id]);
        return $sth->fetchAll();
    } //end checkNewVersionNumber

    public function getNextAvailableNewCourseNo($type, $delv_type, $catdiv_id, $userid, $username, $method='N', $version='1.0', $excld=array(), &$id) {
        $course_no = null;
        $catDivModel = new CatDiv();
        $catdiv = $catDivModel->getCatDivById($catdiv_id);
        if(!isset($catdiv->code) || !(strlen(trim($catdiv->code)) > 1) || !($catdiv->start_number >= 0) ) return null;

        $allSimilarCourses = $this->getAllUsedLmsCourseNumbers($catdiv->code, 'T');
        $coursesinfo = array();
        foreach($allSimilarCourses as $similarCourse) {
            $match=$crsnumbase=null;
            if(preg_match('~[a-z\-\_]~i', $similarCourse['course_no'], $match, PREG_OFFSET_CAPTURE, 3)) {
                $crsnumbase = is_array($match) ? substr($similarCourse['course_no'],0,$match[0][1]) : $similarCourse['course_no'];
            } else {
                $crsnumbase = $similarCourse['course_no'];
            } //end if
            $coursesinfo[$crsnumbase]=$similarCourse;
        } //end foreach

        $uniquekeys = array_keys($coursesinfo);

        for($i=$catdiv->start_number; $i <= 99999; $i++) {
            $crsnumbase = 'T' . trim(strtoupper($catdiv->code)) . str_pad($i, 5, '0', STR_PAD_LEFT);
            if(in_array($crsnumbase, $uniquekeys) || in_array($crsnumbase . trim(strtoupper($delv_type)), $excld))
                continue;
            $course_no = $crsnumbase . trim(strtoupper($delv_type));
            break;
        } //end for

        if(!is_null($course_no))
            $id=$this->lockLmsCourseNo(3, $course_no, $type, $delv_type, $catdiv_id, $userid, $username, $method, $version);

        return $course_no;
    } //end getNextAvailableNewCourseNo

    public function getAllUsedLmsCourseNumbers($code, $prefix='T') {
        $this->unLockLmsCourseNumbers();
        $likestr = trim(strtoupper($prefix)) . trim(strtoupper($code)) . '%';
        $sql = <<<ENDSQLTXT
        SELECT    TRIM(UPPER(g.course_no_raw)) AS course_no,
                  IFNULL(NULLIF(TRIM(UPPER(g.`version`)),''),'1.0') AS version,
                  CONCAT(u.fname,' ',u.lname) AS owner,
                  IFNULL(g.inserted_on,'Unknown') AS cdate
        FROM      `lng_lonum` g
        LEFT JOIN `lng_users` u
        ON        (g.owner_id=u.id)
        WHERE     NULLIF(TRIM(g.course_no_raw),'') IS NOT NULL
        AND       g.course_no_raw LIKE ?
        UNION
        SELECT    SUBSTRING_INDEX(UPPER(TRIM(lmsc.course_no)),'_V',1) AS course_no,
                  IFNULL(NULLIF(TRIM(UPPER(lmsc.`version`)),''),'1.0') AS version,
                  IFNULL(lmsc.lms_created_by,lmsc.lms_updated_by) AS owner,
                  IFNULL(lmsc.lms_updated_on,'Unknown') AS cdate
        FROM      `lms_los` lmsc
        WHERE     NULLIF(TRIM(lmsc.course_no),'') IS NOT NULL
        AND       SUBSTRING_INDEX(UPPER(TRIM(lmsc.course_no)),'_V',1) LIKE ?
        UNION
        SELECT    r.course_no,
                  IFNULL(NULLIF(TRIM(UPPER(r.`version`)),''),'1.0') AS version,
                  r.owner,
                  IFNULL(r.inserted_on,'Unknown') AS cdate
        FROM      `lng_lonum_resv` r
        WHERE     r.course_no IS NOT NULL
        AND       r.course_no LIKE ?
        ORDER BY  course_no ASC, INET_ATON(SUBSTRING_INDEX(CONCAT(version,'.0.0.0'),'.',4)) ASC, cdate ASC
ENDSQLTXT;
        $db = DB::connection()->getPdo();
        $sth = $db->prepare($sql);
        $sth->execute([$likestr,$likestr,$likestr]);
        return $sth->fetchAll();
    } //end getAllUsedLmsCourseNumbers

} //end class
