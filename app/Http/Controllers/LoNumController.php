<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\LoginCheck;
use App\LoNumber;
use App\CatDiv;

class LoNumController extends Controller
{
    protected $userId = null;

    public function fetchMyReservedLOs(Request $request) {
        $this->userId = LoginCheck::isLoggedIn($request);
        $lonum = trim($request->input('crsnum'));
        $loNumModel = new LoNumber();
        $rows = $loNumModel->getMyReservedLOs($this->userId, $lonum);
        return json_encode($rows);
    } //end fetchMyReservedLOs

    public function fetchMyPublishedLOs(Request $request) {
        $this->userId = LoginCheck::isLoggedIn($request);
        $lonum = trim($request->input('crsnum'));
        $loNumModel = new LoNumber();
        $rows = $loNumModel->getMyPublishedLOs($this->userId, $lonum);
        return json_encode($rows);
    } // fetchMyPublishedLOs

    public function fetchOthersReservedLOs(Request $request) {
        $this->userId = LoginCheck::isLoggedIn($request);
        $lonum = trim($request->input('crsnum'));
        $loNumModel = new LoNumber();
        $rows = $loNumModel->getOthersReservedLOs($this->userId, $lonum);
        return json_encode($rows);
    } //end fetchOthersReservedLOs

    public function searchCourseDataForVersioning(Request $request) {
        $this->userId = LoginCheck::isLoggedInHasPermissions($request,['lonumadminedit']);
        $lonum = trim($request->input('crsnum'));
        $loNumModel = new LoNumber();
        $rows = $loNumModel->searchLmsCourseDataRaw($lonum);
        return json_encode($rows);
    } //end searchCourseDataForVersioning

    public function getNextCourseVersion(Request $request) {
        $this->userId = LoginCheck::isLoggedInHasPermissions($request,['lonumadminedit']);
        $lonum = trim($request->input('crsnum'));
        $loNumModel = new LoNumber();
        $rows = $loNumModel->getNextCourseVersionNumber($lonum);
        return json_encode($rows);
    } //end getNextCourseVersion

    public function step1(Request $request) {
        $this->userId = LoginCheck::isLoggedInHasPermissions($request,['lonumadminedit']);
        $msg = trim($request->input('msg'));
        $id = $request->input('id');
        $method = trim($request->input('method','N'));
        $go = trim($request->input('go'));

        if($go == 1 && $method != '') {
            $response = redirect()->route('step2'.urlencode(strtolower(trim($method))),['id'=>$id, 'method'=>$method, 'msg'=>$msg]);
            $response->send();
            exit;
        } //end if

        return view('lonum.step1', compact('msg', 'id', 'method'));
    } //end step1

    public function step2n(Request $request) {
        $this->userId = LoginCheck::isLoggedInHasPermissions($request,['lonumadminedit']);
        $msg = trim($request->input('msg'));
        $id = $request->input('id');
        $method = trim($request->input('method','N'));
        $type = $request->input('type');
        $go = $request->input('go',0);

        if($go == 1 && $method != '' && $type != '') {
            $response = redirect()->route('step3n',['id'=>$id, 'method'=>$method, 'msg'=>$msg, 'type'=>$type]);
            $response->send();
            exit;
        } //end if

        return view('lonum.step2n', compact('msg', 'id', 'method', 'type'));
    } //end step2n

    public function step3n(Request $request) {
        $owner_id = $this->userId = LoginCheck::isLoggedInHasPermissions($request,['lonumadminedit']);
        $msg = trim($request->input('msg'));
        $error = $request->input('error');
        $succmsg = $request->input('succmsg');
        $type = $request->input('type');
        $delv_type = $request->input('delv_type');
        $catdiv_id = $request->input('catdiv_id');
        $id = $request->input('id');
        $method = trim($request->input('method','N'));
        $go = $request->input('go',0);
        $catDivModel = new CatDiv();
        $loNumModel = new LoNumber();
        if(isset($id) && $id > 0) {
            $cdata = $loNumModel->getLmsCourseGenDataById($id);
            if(isset($cdata['id']) && $cdata['id'] > 0) { //reset input with what is in the DB
                $catdiv_id = $cdata['catdiv_id'];
                $delv_type = $cdata['delv_type'];
                $type = $cdata['type'];
                $id = $cdata['id'];
            } //end if
        } //end if

        $catdivs = $catDivModel->getAllCatDivs();
        if(trim($type) == '') {
            $response = redirect()->route('step2n',['id'=>$id, 'method'=>$method, 'msg'=>$msg]);
            $response->send();
            exit;
        } //end if

        if($go == 1 && $catdiv_id > 0) {
            $response = redirect()->route('step4n',['id'=>$id, 'type'=>$type, 'delv_type'=>$delv_type, 'catdiv_id'=>$catdiv_id, 'method'=>$method, 'msg'=>$msg]);
            $response->send();
            exit;
        } //end if

        return view('lonum.step3n', compact('msg', 'id', 'method', 'go', 'type', 'catdivs', 'delv_type', 'catdiv_id', 'owner_id', 'error', 'succmsg'));
    } //end step3n

    public function step4n(Request $request) {
        $owner_id = $this->userId = LoginCheck::isLoggedInHasPermissions($request,['lonumadminedit']);
        $msg = trim($request->input('msg'));
        $error = $request->input('error');
        $succmsg = $request->input('succmsg');
        $type = $request->input('type');
        $delv_type = $request->input('delv_type');
        $catdiv_id = $request->input('catdiv_id');
        $act = $request->input('act');
        $id = $request->input('id');
        $course_no = $request->input('course_no',null);
        $course_no_raw = $request->input('course_no_raw',null);
        $version = $request->input('version','1.0');
        $excld = $request->input('excld');
        if(!is_array($excld) && trim($excld) != '') $excld = array($excld);
        if(!is_array($excld)) $excld = array();
        $method = trim($request->input('method','N'));
        $go = $request->input('go',0);
        $loNumModel = new LoNumber();

        if(isset($id) && $id > 0) {
            $cdata = $loNumModel->getLmsCourseGenDataById($id);
            if(isset($cdata['id']) && $cdata['id'] > 0) { //reset input with what is in the DB
                $version = trim(strtoupper($cdata['version']));
                $course_no = trim(strtoupper($cdata['course_no']));
                $course_no_raw = trim(strtoupper($cdata['course_no_raw']));
                $catdiv_id = $cdata['catdiv_id'];
                $delv_type = $cdata['delv_type'];
                $type = $cdata['type'];
                $id = $cdata['id'];
            } //end if
        } //end if

        if(!($catdiv_id > 0)) {
            $response = redirect()->route('step3n',['id'=>$id, 'type'=>$type, 'delv_type'=>$delv_type, 'catdiv_id'=>$catdiv_id, 'method'=>$method, 'msg'=>$msg, 'excld'=>$excld]);
            $response->send();
            exit;
        } //end if

        if($go == 1 && trim($course_no) != '' && trim($course_no_raw) != '' && trim($version) != '' && $act > 0 && $id > 0) {
            if($act == 1) { //save and continue
                $loNumModel->updateLmsCourseCreationStep($id, 4, $owner_id, $request->session()->get('username'));
                $response = redirect()->route('step5',['id'=>$id, 'type'=>$type, 'delv_type'=>$delv_type, 'catdiv_id'=>$catdiv_id, 'method'=>$method, 'msg'=>'Course/LO Number Saved', 'excld'=>$excld]);
                $response->send();
                exit;
            } elseif($act == 2) { //release and try again using same tool, but next number
                $loNumModel->unLockLmsLoNumber($id);
                (is_array($excld)) ? $excld[]=trim($course_no_raw) : $excld=array($course_no_raw);
                $response = redirect()->route('step4n',['id'=>$id, 'type'=>$type, 'delv_type'=>$delv_type, 'catdiv_id'=>$catdiv_id, 'method'=>$method, 'msg'=>'Course/LO Number Released', 'excld'=>$excld]);
                $response->send();
                exit;
            } elseif($act == 3) { //release and try again using manual override
                $loNumModel->unLockLmsLoNumber($id);
                $response = redirect()->route('step2m',['method'=>'M', 'msg'=>'Course/LO Number Released']);
                $response->send();
                exit;
            } else { //release and start over
                $loNumModel->unLockLmsLoNumber($id);
                $response = redirect()->route('step1',['msg'=>'Course/LO Number Released']);
                $response->send();
                exit;
            } //end if
        } elseif (is_null($course_no)) {
            $course_no_raw = $loNumModel->getNextAvailableNewCourseNo($type, $delv_type, $catdiv_id, $owner_id, $request->session()->get('username'), 'N', '1.0', $excld, $id); //id passed by reference
            $version = '1.0';
            $course_no = strtoupper(trim($course_no_raw)) . '_V' . $version;
        }//end if

        return view('lonum.step4n', compact('msg', 'id', 'method', 'go', 'type', 'catdivs', 'delv_type', 'catdiv_id', 'version', 'course_no', 'course_no_raw', 'excld', 'owner_id', 'error', 'succmsg'));
    } //end step4n


    public function step2m(Request $request) {
        $owner_id = $this->userId = LoginCheck::isLoggedInHasPermissions($request,['lonumadminedit']);
        $error = trim($request->input('error'));
        $succmsg = trim($request->input('succmsg'));
        $msg = trim($request->input('msg'));
        $id = $request->input('id');
        $method = trim($request->input('method','M'));
        $rcourse_no = implode('_V', array_slice(explode('_V', strtoupper(trim($request->input('rcourse_no')))), 0, 1));
        $act = $request->input('act',0);
        $go = $request->input('go',0);
        $course_no_raw = $request->input('course_no_raw',null);
        $valid = null;
        $messages = array();
        $loNumModel = new LoNumber();

        if(isset($id) && $id > 0) {
            $cdata = $loNumModel->getLmsCourseGenDataById($id);
            if(isset($cdata['id']) && $cdata['id'] > 0) { //reset input with what is in the DB
                $rcourse_no = $cdata['course_no_raw'];
                $id = $cdata['id'];
            } //end if
        } //end if

        if($go == 1 && $rcourse_no != '' && strlen($rcourse_no) > 3 && $act == 0) {
            $results = $loNumModel->checkManuallyEnteredCourseNumber($rcourse_no, $owner_id);
            if($results !== false && is_array($results) && count($results) > 0) {
                $warnings=0;
                foreach($results as $result) {
                    if($result['type']=='E') {
                        $place = ($result['place'] == 'C') ? 'used in the CSOD LMS' : 'reserved in the course numbering tool';
                        $messages[] = "The course '". $result['course_no'] ."' (Version '" . $result['version'] . "') has already been ". $place ." by '" . $result['owner'] . "' (Created on '" . $result['cdate'] . "'). ";
                        $valid = false;
                        break;
                    } else {
                        if($result['place'] == 'C') {
                            $messages[] = "The course '". $result['course_no'] ."' (Version '" . $result['version'] . "') has already been used in the CSOD LMS by '" . $result['owner'] . "' (Created on '" . $result['cdate'] . "').  Please make sure that this course is in the same \"family\" as this course and it is just a variation of this existing course's delivery type before continuing. ";
                            $valid = (is_null($valid) || $valid===true) ? true : false;
                            $warnings++;
                        } else {
                            if($result['course_no']==$rcourse_no) {
                                $messages[] = "The course '". $result['course_no'] ."' (Version '" . $result['version'] . "') has already been requested in the course numbering tool by '" . $result['owner'] . "' (Created on '" . $result['cdate'] . "'), but it was not reserved.  Please make sure that you are not duplicating this course number with this user before continuing. ";
                            } else {
                                $messages[] = "The course '". $result['course_no'] ."' (Version '" . $result['version'] . "') has already been requested/reserved in the course numbering tool by '" . $result['owner'] . "' (Created on '" . $result['cdate'] . "').  Please make sure that this course is in the same \"family\" as this course and it is just a variation of this existing course's delivery type before continuing. ";
                            } //end if
                            $valid = (is_null($valid) || $valid===true) ? true : false;
                            $warnings++;
                        } //end if
                    } //end if
                } //end foreach
            } else {
                $valid = true;
            } //end if
            if($valid) {
                $course_no_raw = $rcourse_no;
                $delv_types = array('V','W','T','E','A','S','K','D','M');  //I know, these belong in a look-up table
                $delv_type = null;
                $last_char = strtoupper(substr(trim($course_no_raw),-1));
                if(in_array($last_char, $delv_types)) $delv_type = $last_char;
                $type = ($delv_type == '' || $delv_type == 'V') ? 'C' : 'P';
                $catdiv_id = $loNumModel->lookupLmsCatDivIdByCode(substr(trim($course_no_raw),1,2));
                $id = $loNumModel->lockLmsCourseNo('3', $course_no_raw, $type, $delv_type, $catdiv_id, $owner_id, $request->session()->get('username'), 'M', '1.0');
            } //end if
        } elseif($go == 1 && $course_no_raw != '' && strlen($course_no_raw) > 3 && $id > 0 && $act > 0) {
            if($act == 1) { //save and continue
                $loNumModel->updateLmsCourseCreationStep($id, 4, $owner_id, $request->session()->get('username'));
                $response = redirect()->route('step5',['id'=>$id, 'method'=>trim($method), 'msg'=>'Course/LO Number Saved']);
                $response->send();
                exit;
            } elseif($act == 2) { //release and try again using course number generator
                $loNumModel->unLockLmsLoNumber($id);
                $response = redirect()->route('step2n',['msg'=>'Course/LO Number Released']);
                $response->send();
                exit;
            } elseif($act == 3) { //release and start over
                $loNumModel->unLockLmsLoNumber($id);
                $response = redirect()->route('step1',['msg'=>'Course/LO Number Released']);
                $response->send();
                exit;
            } else { //release and re-check another course number
                $loNumModel->unLockLmsLoNumber($id);
                $rcourse_no = implode('_V', array_slice(explode('_V', strtoupper(trim($this->_request->getParam('rcourse_no')))), 0, 1));
                $response = redirect()->route('step2'.urlencode(strtolower(trim($method))),['go'=>1, 'act'=>0, 'rcourse_no'=>$rcourse_no, 'msg'=>'Course/LO Number Released']);
                $response->send();
                exit;
            } //end if
        }//end if

        return view('lonum.step2m', compact('msg', 'id', 'method', 'act', 'go', 'rcourse_no', 'valid', 'messages', 'course_no_raw', 'owner_id', 'error', 'succmsg'));
    } //end step2m

    public function step2v(Request $request) {
        $owner_id = $this->userId = LoginCheck::isLoggedInHasPermissions($request,['lonumadminedit']);
        $error = trim($request->input('error'));
        $succmsg = trim($request->input('succmsg'));
        $msg = trim($request->input('msg'));
        $id = $request->input('id');
        $method = trim($request->input('method','V'));
        $act = $request->input('act',0);
        $go = $request->input('go',0);
        $scourse_no = implode('_V', array_slice(explode('_V', strtoupper(trim($request->input('scourse_no')))), 0, 1));
        $course_no_selected = implode('_V', array_slice(explode('_V', strtoupper(trim($request->input('course_no_selected',null)))), 0, 1));
        $version_selected = $request->input('version_selected',null);
        $version_requested = $request->input('version_requested',null);
        $valid = null;
        $messages = array();
        $loNumModel = new LoNumber();

        if(isset($id) && $id > 0) {
            $cdata = $loNumModel->getLmsCourseGenDataById($id);
            if(isset($cdata['id']) && $cdata['id'] > 0) { //reset input with what is in the DB
                $course_no_selected = $cdata['course_no_raw'];
                $version_selected = $cdata['version'];
                $version_requested = $cdata['version'];
                $id = $cdata['id'];
            } //end if
        } //end if

        if($go == 1 && trim($course_no_selected) != '' && strlen($course_no_selected) > 3 && trim($version_requested) != '' && $act == 0) {
            $version_requested = (is_numeric($version_requested)) ? sprintf("%.01f",(float)$version_requested) : $version_requested; //Clean this up and format 1 to 1.0, etc.
            $results = $loNumModel->checkNewVersionNumber($course_no_selected, $version_requested, $owner_id);
            if($results !== false && is_array($results) && count($results) > 0) {
                $warnings=0;
                foreach($results as $result) {
                    if($result['type']=='E') {
                        $place = ($result['place'] == 'C') ? 'used in the CSOD LMS' : 'reserved in the course numbering tool';
                        $messages[] = "The course number '" . $result['course_no'] . "' and version '" . $result['version'] . "' have already been ". $place ." by '" . $result['owner'] . "' (Created on '" . $result['cdate'] . "'). ";
                        $valid = false;
                        break;
                    } else {
                        $messages[] = "The course '". $result['course_no'] ."' and version '" . $result['version'] . "' have already been requested in the LO/Course Numbering tool by '" . $result['owner'] . "' (Created on '" . $result['cdate'] . "'), but it was not reserved.  Please make sure that you are not duplicating this course number with this user before continuing. ";
                        $valid = (is_null($valid) || $valid===true) ? true : false;
                        $warnings++;
                    } //end if
                } //end foreach-
            } else {
                $valid = true;
            } //end if
            if($valid) {
                $delv_types = array('V','W','T','E','A','S','K','D','M');  //I know, these belong in a look-up table
                $delv_type = null;
                $last_char = strtoupper(substr(trim($course_no_selected),-1));
                if(in_array($last_char, $delv_types)) $delv_type = $last_char;
                $type = ($delv_type == '' || $delv_type == 'V') ? 'C' : 'P';
                $catdiv_id = $loNumModel->lookupLmsCatDivIdByCode(substr(trim($course_no_selected),1,2));
                $id = $loNumModel->lockLmsCourseNo('3', $course_no_selected, $type, $delv_type, $catdiv_id, $owner_id, $request->session()->get('username'), 'V', $version_requested);
            } //end if
        } elseif($go == 1 && trim($course_no_selected) != '' && strlen($course_no_selected) > 3 && $id > 0 && trim($version_requested) != '' && $act > 0) {
            if($act == 1) { //save and continue
                $loNumModel->updateLmsCourseCreationStep($id, 4, $owner_id, $request->session()->get('username'));
                $response = redirect()->route('step5',['id'=>$id, 'msg'=>'New Version Created', 'method'=>'V']);
                $response->send();
                exit;
            } elseif($act == 2) { //release and start over
                $loNumModel->unLockLmsLoNumber($id);
                $response = redirect()->route('step1',['msg'=>'New Version Released', 'method'=>'V']);
                $response->send();
                exit;
            } else { //release and re-check another course number
                $loNumModel->unLockLmsLoNumber($id);
                $course_no_selected = implode('_V', array_slice(explode('_V', strtoupper(trim($request->input('course_no_selected')))), 0, 1));
                $version_requested = $request->input('version_requested',null);
                $response = redirect()->route('step2v',['msg'=>'New Version Released', 'method'=>'V', 'go'=>1, 'act'=>0, 'scourse_no'=>$course_no_selected, 'version_requested'=>$version_requested]);
                $response->send();
                exit;
            } //end if
        }//end if

        return view('lonum.step2v', compact('msg', 'id', 'method', 'act', 'go', 'scourse_no', 'valid', 'messages', 'course_no_selected', 'version_selected', 'version_requested', 'course_no_selected', 'error', 'succmsg'));
    } //end step2v

    public function step5(Request $request) {
        $owner_id = $this->userId = LoginCheck::isLoggedInHasPermissions($request,['lonumadminedit']);
        $msg = trim($request->input('msg'));
        $error = $request->input('error');
        $succmsg = $request->input('succmsg');
        $method = trim($request->input('method'));
        $act = $request->input('act','E');
        $id = $request->input('id');
        $go = $request->input('go',0);
        $complete = false;
        $loNumModel = new LoNumber();
        $catDivModel = new CatDiv();


        if(!(isset($id) && $id > 0)) { //We have to have a valid ID by now, or start over
            $response = redirect()->route('step1',['method'=>$method, 'msg'=>'Invalid Parameters, Starting Over...']);
            $response->send();
            exit;
        } //end if

        $cdata = $loNumModel->getLmsCourseGenDataById($id);
        $catdivs = $catDivModel->getAllCatDivs();
        if(!(isset($cdata['id']) && $cdata['id'] > 0)) { //invalid id, start over
            $response = redirect()->route('step1',['method'=>$method, 'msg'=>'Could Not Find ID in Database, Starting Over...']);
            $response->send();
            exit;
        } //end if

        if($act=='E' && $go=='1' && $id > 0) { //read in values from submitted form and update database
            $method = $request->input('method');
            $type = $request->input('type');
            $delv_type = $request->input('delv_type');
            $catdiv_id = $request->input('catdiv_id');
            $course_no = $request->input('course_no');
            $course_no_raw = $request->input('course_no_raw');
            $course_title = trim(preg_replace('/' . $course_no . '\s*:\s*' . '/i', '', trim($request->input('course_title')), 1));
            $course_title = trim(preg_replace('/\s*\|\s*' . $course_no . '/i','',$course_title,1));
            $course_title = trim(preg_replace('/' . $course_no_raw . '\s*:\s*' . '/i','',$course_title,1));
            $course_title = trim(preg_replace('/\s*\|\s*' . $course_no_raw . '/i','',$course_title,1));
            $course_title .=  '| ' . $course_no;
            $product_relnum = $request->input('product_relnum');
            $course_duration = $request->input('course_duration');
            $course_level = $request->input('course_level','N');
            $available = $request->input('available','N');
            $update_data = array('step' => 5,
                'type' => (stripos('WTEASKDM',$delv_type) !== false && stripos('WTEASKDM',$delv_type) >= 0) ? 'P' : 'C',
                'delv_type' => trim(strtoupper($delv_type)),
                'catdiv_id' => trim($catdiv_id),
                'owner_id' => $owner_id,
                'course_title' => $course_title,
                'product_relnum' => trim($product_relnum),
                'course_duration' => $course_duration,
                'course_level' => trim($course_level),
                'available' => trim($available),
                'updated_by' => $request->session()->get('username'));
            $act = 'E';
            $loNumModel->saveLmsCourseData($id, $update_data);
            $cdata = $loNumModel->getLmsCourseGenDataById($id);
            $complete = true;
        } //end if

        $disable_all = ($act != 'E' || $complete == true) ? "disabled='disabled'" : '';

        return view('lonum.step5', array_merge(compact('msg', 'id', 'method', 'act', 'go', 'error', 'succmsg', 'catdivs', 'complete', 'disable_all'),$cdata));

    } //end step5

} //end class
