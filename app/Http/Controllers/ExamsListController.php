<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models2\Examterms;
use App\Models2\SheduleTerm;


class ExamsListController extends Controller {

	var $data = array();
	var $panelInit ;
	var $layout = 'dashboard';

	public function __construct(){
		if(app('request')->header('Authorization') != "" || \Input::has('token')){
			$this->middleware('jwt.auth');
		}else{
			$this->middleware('authApplication');
		}

		$this->panelInit = new \DashboardInit();
		$this->data['panelInit'] = $this->panelInit;
		$this->data['breadcrumb']['Settings'] = \URL::to('/dashboard/languages');
		$this->data['users'] = $this->panelInit->getAuthUser();
		if(!isset($this->data['users']->id)){
			return \Redirect::to('/');
		}

	}

	public function listAll()
	{

		if(!$this->panelInit->can( array("examsList.list","examsList.View","examsList.addExam","examsList.editExam","examsList.delExam","examsList.examDetailsNot","examsList.showMarks","examsList.controlMarksExam") )){
			exit;
		}

		$toReturn['exams'] = array();
		if($this->data['users']->role == "student"){
			$toReturn['exams'] = \exams_list::where('examAcYear',$this->panelInit->selectAcYear)->where('examClasses','LIKE','%"'.$this->data['users']->studentClass.'"%')->get()->toArray();
		}elseif($this->data['users']->role == "parent"){

			$studentId = array();
			$parentOf = json_decode($this->data['users']->parentOf,true);
			if(is_array($parentOf)){
				foreach($parentOf as $value){
					$studentId[] = $value['id'];
				}
			}

			if( count($studentId) > 0){
				$studentDetails = \User::where('role','student')->whereIn('id',$studentId)->select('studentClass');
				if($studentDetails->count() > 0){
					$studentDetails = $studentDetails->get()->toArray();

					$toReturn['exams'] = \exams_list::where('examAcYear',$this->panelInit->selectAcYear)->where(function($query) use ($studentDetails){
						foreach($studentDetails as $value){
							$query->orWhere('examClasses','LIKE','%"'.$value['studentClass'].'"%');
						}
					})->get()->toArray();
				}
			}

		}else{
			$toReturn['exams'] = \exams_list::where('examAcYear',$this->panelInit->selectAcYear)->get()->toArray();
		}

		if($this->data['users']->role == "teacher"){
			$toReturn['classes'] = \classes::where('classAcademicYear',$this->panelInit->selectAcYear)->where('classTeacher','LIKE','%"'.$this->data['users']->id.'"%')->get()->toArray();
		}else{
			$toReturn['classes'] = \classes::where('classAcademicYear',$this->panelInit->selectAcYear)->get()->toArray();
		}

		foreach($toReturn['exams'] as $key => $value){
			$toReturn['exams'][$key]['examDate'] = $this->panelInit->unix_to_date($toReturn['exams'][$key]['examDate']);
			$toReturn['exams'][$key]['examEndDate'] = $this->panelInit->unix_to_date($toReturn['exams'][$key]['examEndDate']);
		}

		$toReturn['subjects'] = array();
		$subjects = \subject::select('id','subjectTitle')->get()->toArray();
		foreach($subjects as $value){
			$toReturn['subjects'][$value['id']] = $value['subjectTitle'];
		}

		$toReturn['userRole'] = $this->data['users']->role;

		updateSeenNotificationMobHistory(Auth::guard('web')->user()->id, 'exams', null);

		return $toReturn;
	}

	public function delete($id){

		if(!$this->panelInit->can( "examsList.delExam" )){
			exit;
		}

		if ( $postDelete = \exams_list::where('id', $id)->first() ){
    		user_log('Exams', 'delete', $postDelete->examTitle);
        $postDelete->delete();
        return $this->panelInit->apiOutput(true,$this->panelInit->language['delExam'],$this->panelInit->language['exDeleted']);
    }else{
        return $this->panelInit->apiOutput(false,$this->panelInit->language['delExam'],$this->panelInit->language['exNotExist']);
    }
	}

	public function create(){

		if(!$this->panelInit->can( "examsList.addExam" )){
			exit;
		}

		$examsList = new \exams_list();
		$examsList->examTitle = \Input::get('examTitle');
		$examsList->examDescription = \Input::get('examDescription');
		$examsList->examDate = $this->panelInit->date_to_unix(\Input::get('examDate'));
		$examsList->examEndDate = $this->panelInit->date_to_unix(\Input::get('examEndDate'));
		$examsList->examAcYear = $this->panelInit->selectAcYear;
		if(\Input::has('examClasses')){
			$examsList->examClasses = json_encode(\Input::get('examClasses'));
		}
		if(\Input::has('examMarksheetColumns')){
			$examsList->examMarksheetColumns = json_encode(\Input::get('examMarksheetColumns'));
		}
		if(\Input::has('examSchedule')){
			$examSchedule = \Input::get('examSchedule');
			foreach($examSchedule as $key => $value){
				$examSchedule[$key]['stDate'] = $this->panelInit->date_to_unix($examSchedule[$key]['stDate'] );
				$examsList->examGrade=$examSchedule[$key]['finalGrade'];
			}
			$examsList->examSchedule = json_encode( $examSchedule );
		}
		$examsList->save();

		user_log('Exams', 'create', $examsList->examTitle);


		//Send Push Notifications
		$tokens_list = array();
		$user_ids = array();
		$user_list_students = \User::where('role','student')
		  ->whereIn('studentClass',\Input::get('examClasses'))
		  ->select('id')->get();
		$student_id = array();
		foreach($user_list_students as $ite){
		$student_id[]="%\"id\":".$ite->id."}%" ;
		}
		$user_list_parents = array();
		foreach($student_id as $itp){
			$res = \User::where('role','parent')
			  ->where('parentOf','like',$itp)
			  ->select('id', 'firebase_token')->first();
			if($res){
				$user_list_parents[] = $res;
			}
		}

		foreach ($user_list_parents as $value) {
			if($value['firebase_token'] != ""){
				if(is_array(json_decode($value['firebase_token']))) {
					foreach (json_decode($value['firebase_token']) as $token) {
						$tokens_list[] = $token;
					}
				} else if ($this->isJson($value['firebase_token'])) {
					foreach (json_decode($value['firebase_token']) as $token) {
						$tokens_list[] = $token;
					}
				} else {
					$tokens_list[] = $value['firebase_token'];
				}
			}
			$user_ids[] = $value['id'];
		}

		if(count($tokens_list) > 0){
			$this->panelInit->send_push_notification(
				$tokens_list,
				$user_ids,
				$this->panelInit->language['newExamNotif']." : ".\Input::get('examTitle'),
				$this->panelInit->language['examsList'],"exams",$examsList->id
			);
		} else {
			$this->panelInit->save_notifications_toDB(
				$tokens_list,
				$user_ids,
				$this->panelInit->language['newExamNotif']." : ".\Input::get('examTitle'),
				$this->panelInit->language['examsList'],"exams",$examsList->id
			);
		}

		$examsList->examDate = \Input::get('examDate');
		$examsList->examEndDate = \Input::get('examEndDate');

		return $this->panelInit->apiOutput(true,$this->panelInit->language['addExam'],$this->panelInit->language['examCreated'],$examsList->toArray() );
	}

	protected function isJson($string) {
    $decoded = json_decode($string); // decode our JSON string
	    if ( !is_object($decoded) && !is_array($decoded) ) {
	        return false;
	    }
	    return (json_last_error() == JSON_ERROR_NONE);
	}

	function fetch($id){

		if(!$this->panelInit->can( array("examsList.View","examsList.editExam") )){
			exit;
		}
		$exams_list = \exams_list::where('id',$id)->first()->toArray();
		$exams_list['examDate'] = $this->panelInit->unix_to_date($exams_list['examDate']);
		$exams_list['examEndDate'] = $this->panelInit->unix_to_date($exams_list['examEndDate']);
		$exams_list['examClasses'] = json_decode($exams_list['examClasses'],true);
		if(is_array($exams_list['examClasses'])){
			$exams_list['examClassesNames'] = \classes::whereIn('id',$exams_list['examClasses'])->select('className')->get()->toArray();
		}
		$exams_list['examMarksheetColumns'] = json_decode($exams_list['examMarksheetColumns'],true);
		if(!is_array($exams_list['examMarksheetColumns'])){
			$exams_list['examMarksheetColumns'] = array();
		}
		$exams_list['examSchedule'] = json_decode($exams_list['examSchedule'],true);
		if(is_array($exams_list['examSchedule'])){
			foreach($exams_list['examSchedule'] as $key => $value){
				$exams_list['examSchedule'][$key]['stDate'] = $this->panelInit->unix_to_date($exams_list['examSchedule'][$key]['stDate'] );
			}
		}else{
			$exams_list['examSchedule'] = array();
		}

		updateSeenNotificationMobHistory(Auth::guard('web')->user()->id, 'exams', $id);

		return $exams_list;
	}

	function edit($id){

		if(!$this->panelInit->can( "examsList.editExam" )){
			exit;
		}
		$examsList = \exams_list::find($id);
		$examsList->examTitle = \Input::get('examTitle');
		$examsList->examDescription = \Input::get('examDescription');
		$examsList->examDate = $this->panelInit->date_to_unix(\Input::get('examDate'));
		$examsList->examEndDate = $this->panelInit->date_to_unix(\Input::get('examEndDate'));
		if(\Input::has('examClasses')){
			$examsList->examClasses = json_encode(\Input::get('examClasses'));
		}
		if(\Input::has('examMarksheetColumns')){
			$examsList->examMarksheetColumns = json_encode(\Input::get('examMarksheetColumns'));
		}
		if(\Input::has('examSchedule')){
			$examSchedule = \Input::get('examSchedule');
			foreach($examSchedule as $key => $value){
				$examSchedule[$key]['stDate'] = $this->panelInit->date_to_unix($examSchedule[$key]['stDate'] );
				$examsList->examGrade=$examSchedule[$key]['finalGrade'];
			}
			$examsList->examSchedule = json_encode( $examSchedule );
		}
		$examsList->save();

		user_log('Exams', 'edit', $examsList->examTitle);

		$examsList->examDate = \Input::get('examDate');
		$examsList->examEndDate = \Input::get('examEndDate');

		return $this->panelInit->apiOutput(true,$this->panelInit->language['editExam'],$this->panelInit->language['examModified'],$examsList->toArray() );
	}

	function fetchMarks(){

		if(!$this->panelInit->can( array("examsList.showMarks","examsList.controlMarksExam") )){
			exit;
		}

		$toReturn = array();

		$toReturn['exam'] = \exams_list::where('id',\Input::get('exam'))->first()->toArray();
		$toReturn['subject'] = \subject::where('id',\Input::get('subjectId'))->first()->toArray();
		$toReturn['class'] = \classes::where('id',\Input::get('classId'))->first()->toArray();

		$toReturn['exam']['examClasses'] = json_decode($toReturn['exam']['examClasses'],true);
		$toReturn['exam']['examMarksheetColumns'] = json_decode($toReturn['exam']['examMarksheetColumns'],true);
		if(!is_array($toReturn['exam']['examMarksheetColumns'])){
			$toReturn['exam']['examMarksheetColumns'] = array();
		}

		$toReturn['students'] = array();
		$studentArray = \User::where('role','student')->where('studentClass',\Input::get('classId'));
		if($this->panelInit->settingsArray['enableSections'] == true){
			$studentArray = $studentArray->where('studentSection',\Input::get('sectionId'));
		}
		if($this->data['panelInit']->settingsArray['studentsSort'] != ""){
			$studentArray = $studentArray->orderByRaw($this->data['panelInit']->settingsArray['studentsSort']);
		}
		$studentArray = $studentArray->get();

		$examMarksArray = array();
		$examMarks = \exam_marks::where('examId',\Input::get('exam'))->where('classId',\Input::get('classId'))->where('subjectId',\Input::get('subjectId'))->get();
		foreach ($examMarks as $stMark) {
			$examMarksArray[$stMark->studentId] = $stMark;
		}

		$i = 0;
		foreach ($studentArray as $stOne) {
			$toReturn['students'][$i] = array('id'=>$stOne->id,'name'=>$stOne->fullName,'studentRollId'=>$stOne->studentRollId,'examMark'=>'','attendanceMark'=>'','markComments'=>'');
			if(isset($examMarksArray[$stOne->id])){
				$toReturn['students'][$i]['examMark'] = json_decode($examMarksArray[$stOne->id]->examMark,true);
				$toReturn['students'][$i]['totalMarks'] = $examMarksArray[$stOne->id]->totalMarks;
				$toReturn['students'][$i]['markComments'] = $examMarksArray[$stOne->id]->markComments;
			}
			$i ++;
		}

		echo json_encode($toReturn);
		exit;
	}

	function saveMarks($exam,$class,$subject){

		if(!$this->panelInit->can( "examsList.controlMarksExam" )){
			exit;
		}

		$studentList = array();
		$studentArray = \User::where('role','student')->where('studentClass',$class)->get();
		foreach ($studentArray as $stOne) {
			$studentList[] = $stOne->id;
		}

		$examMarksList = array();
		$examMarks = \exam_marks::where('examId',$exam)->where('classId',$class)->where('subjectId',$subject)->get();
		foreach ($examMarks as $stMark) {
			$examMarksList[$stMark->studentId] = array("examMark"=>$stMark->examMark,"attendanceMark"=>$stMark->attendanceMark,"markComments"=>$stMark->markComments);
		}

		$stMarks = \Input::get('respStudents');
		foreach($stMarks as $key => $value){
			if(!isset($examMarksList[$value['id']])){
				$examMarks = new \exam_marks();
				$examMarks->examId = $exam;
				$examMarks->classId = $class;
				$examMarks->subjectId = $subject;
				$examMarks->studentId = $value['id'];
				if(isset($value['examMark'])){
					$examMarks->examMark = json_encode($value['examMark']);
				}
				if(isset($value['totalMarks'])){
					$examMarks->totalMarks = $value['totalMarks'];
				}
				if(isset($value['markComments'])){
					$examMarks->markComments = $value['markComments'];
				}
				$examMarks->save();
			}else{
				$examMarks = \exam_marks::where('examId',$exam)->where('classId',$class)->where('subjectId',$subject)->where('studentId',$value['id'])->first();
				if(isset($value['examMark'])){
					$examMarks->examMark = json_encode($value['examMark']);
				}
				if(isset($value['totalMarks'])){
					$examMarks->totalMarks = $value['totalMarks'];
				}
				if(isset($value['markComments'])){
					$examMarks->markComments = $value['markComments'];
				}
				$examMarks->save();
			}
		}

		user_log('Exams', 'take_marks');

		return $this->panelInit->apiOutput(true,$this->panelInit->language['editExam'],$this->panelInit->language['examModified'] );
	}

	function notifications($id){

		if(!$this->panelInit->can( "examsList.examDetailsNot" )){
			exit;
		}

		if($this->panelInit->settingsArray['examDetailsNotif'] == "0"){
			return json_encode(array("jsTitle"=>$this->panelInit->language['examDetailsNot'],"jsMessage"=>$this->panelInit->language['adjustExamNot'] ));
		}

		$examsList = \exams_list::where('id',$id)->first()->toArray();
		$examsList['examMarksheetColumns'] = json_decode($examsList['examMarksheetColumns'],true);

		$subjectArray = array();
		$subject = \subject::get();
		foreach ($subject as $value) {
			$subjectArray[$value->id] = $value->subjectTitle;
		}

		$usersArray = array();
		if($this->data['panelInit']->settingsArray['examDetailsNotifTo'] == "parent" || $this->data['panelInit']->settingsArray['examDetailsNotifTo'] == "both"){
			$users = \User::where('role','student')->orWhere('role','parent')->get();
		}else{
			$users = \User::where('role','student')->get();
		}
		foreach ($users as $value) {
			if($value->parentOf == "" AND $value->role == "parent") continue;
			if(!isset($usersArray[$value->id])){
				$usersArray[$value->id] = array();
			}
			if($value->parentOf != ""){
				$value->parentOf = json_decode($value->parentOf);
				if(!is_array($value->parentOf)){
					continue;
				}
				if(count($value->parentOf) > 0){
					$usersArray[$value->id]['parents'] = array();
				}
				foreach ($value->parentOf as $parentOf) {
					$usersArray[$parentOf->id]['parents'][$value->id] = array(
						'id'=>$value->id,
						'username'=>$value->username,
						"email"=>$value->email,
						"fullName"=>$value->fullName,
						"mobileNo"=>$value->mobileNo,
						"firebase_token"=>$value->firebase_token,
						"comVia"=>$value->comVia
					);
				}
			}
			$usersArray[$value->id]['student'] = array(
				'id'=>$value->id,
				'username'=>$value->username,
				"studentRollId"=>$value->studentRollId,
				"mobileNo"=>$value->mobileNo,
				"email"=>$value->email,
				"fullName"=>$value->fullName,
				"firebase_token"=>$value->firebase_token,
				"comVia"=>$value->comVia
			);
		}

		$return['marks'] = array();
		$examMarks = \exam_marks::where('examId',$id)->get();
		foreach ($examMarks as $value) {
			if(!isset($return['marks'][$value->studentId])){
				$return['marks'][$value->studentId] = array();
			}
			if(isset($subjectArray[$value->subjectId])){
				$value->examMark = json_decode($value->examMark,true);
				$return['marks'][$value->studentId][ $subjectArray[$value->subjectId] ] = array("examMark"=>$value->examMark,"totalMarks"=>$value->totalMarks,"markComments"=>$value->markComments);
			}
		}

		$mailTemplate = \mailsms_templates::where('templateTitle','Exam Details mini')->first();

		if($this->panelInit->settingsArray['examDetailsNotif'] == "mail" || $this->panelInit->settingsArray['examDetailsNotif'] == "mailsms"){
			$mail = true;
		}
		if($this->panelInit->settingsArray['examDetailsNotif'] == "sms" || $this->panelInit->settingsArray['examDetailsNotif'] == "mailsms"){
			$sms = true;
		}
		$sms = true;

		$MailSmsHandler = new \MailSmsHandler();

		foreach($return['marks'] as $key => $value){
			if(!isset($usersArray[$key])) continue;
			if(isset($mail)){
				$studentTemplate = $mailTemplate->templateMail;
				$examGradesTable = "";
				$totalMarks = 0;

				foreach($value as $keyG => $valueG){
					if( (!is_array($valueG['examMark']) || (is_array($valueG['examMark']) AND count($valueG['examMark']) == 0) ) AND $valueG['totalMarks'] == ""){
						continue;
					}
					$examGradesTable .= $keyG . " => ";

					if(is_array($examsList['examMarksheetColumns'])){
						reset($examsList['examMarksheetColumns']);
						foreach ($examsList['examMarksheetColumns'] as $key_ => $value_) {
							if(isset($valueG['examMark'][$value_['id']])){
								$examGradesTable .= $value_['title']." : ".$valueG['examMark'][$value_['id']]. " - ";
							}
						}
					}

					$totalMarks += $valueG['totalMarks'];
					$examGradesTable .= " - Total Marks : ".$valueG['totalMarks']." - Comments : ".$valueG['markComments']."<br/>";
				}

				if($examGradesTable == ""){
					continue;
				}
				$searchArray = array(
					"{studentName}",
					"{studentRoll}",
					"{studentEmail}","{studentUsername}",
					"{examTitle}","{examDescription}",
					"{examDate}","{schoolTitle}",
					"{examGradesTable}","{totalMarks}"
				);
				$replaceArray = array(
					$usersArray[$key]['student']['fullName'],
					$usersArray[$key]['student']['studentRollId'],
					$usersArray[$key]['student']['email'],
					$usersArray[$key]['student']['username'],
					$examsList['examTitle'],
					$examsList['examDescription'],
					$this->panelInit->unix_to_date($examsList['examDate']),
					$this->panelInit->settingsArray['siteTitle'],
					$examGradesTable,
					$totalMarks,
				);
				$studentTemplate = str_replace($searchArray, $replaceArray, $studentTemplate);

				if (strpos($usersArray[$key]['student']['comVia'], 'mail') !== false) {
					$MailSmsHandler->mail($usersArray[$key]['student']['email'],"Exam grade details",$studentTemplate,$usersArray[$key]['student']['fullName']);
				}
				if(isset($usersArray[$key]['parents'])){
					foreach($usersArray[$key]['parents'] as $keyP => $valueP){
						if (strpos($valueP['comVia'], 'mail') !== false) {
							$MailSmsHandler->mail($valueP['email'],"Exam grade details",$studentTemplate,$usersArray[$key]['student']['fullName']);
						}
					}
				}
			}

			$studentTemplate = $mailTemplate->templateSMS;
			$examGradesTable = "";
			$totalMarks = 0;
			reset($value);
			foreach($value as $keyG => $valueG){
				if( (!is_array($valueG['examMark']) || (is_array($valueG['examMark']) AND count($valueG['examMark']) == 0) ) AND $valueG['totalMarks'] == ""){
						continue;
					}
					$examGradesTable .= $keyG . " => ";

					if(is_array($examsList['examMarksheetColumns'])){
						reset($examsList['examMarksheetColumns']);
						foreach ($examsList['examMarksheetColumns'] as $key_ => $value_) {
							if(isset($valueG['examMark'][$value_['id']])){
								$examGradesTable .= $value_['title']." : ".$valueG['examMark'][$value_['id']]. " - ";
							}
						}
					}

					$totalMarks += $valueG['totalMarks'];
					$examGradesTable .= " - Total Marks : ".$valueG['totalMarks']." - Comments : ".$valueG['markComments']."<br/>";
			}
			if($examGradesTable == ""){
				continue;
			}
			$searchArray = array("{studentName}","{studentRoll}",
				"{studentEmail}","{studentUsername}",
				"{examTitle}","{examDescription}",
				"{examDate}","{schoolTitle}",
				"{examGradesTable}",'{totalMarks}');
			$replaceArray = array($usersArray[$key]['student']['fullName'],$usersArray[$key]['student']['studentRollId'],
				$usersArray[$key]['student']['email'],$usersArray[$key]['student']['username'],
				$examsList['examTitle'],$examsList['examDescription'],
				$this->panelInit->unix_to_date($examsList['examDate']),
				$this->panelInit->settingsArray['siteTitle'],
				$examGradesTable, $totalMarks);
			$studentTemplate = str_replace($searchArray, $replaceArray, $studentTemplate);

			if(isset($sms) AND $usersArray[$key]['student']['mobileNo'] != "" AND strpos($usersArray[$key]['student']['comVia'], 'sms') !== false){
				$MailSmsHandler->sms($usersArray[$key]['student']['mobileNo'],$studentTemplate);
			}

			if(isset($usersArray[$key]['parents'])){
				reset($usersArray[$key]['parents']);
				foreach($usersArray[$key]['parents'] as $keyP => $valueP){
					if(isset($sms) AND trim($valueP['mobileNo']) != "" AND strpos($valueP['comVia'], 'sms') !== false){
						$MailSmsHandler->sms($valueP['mobileNo'],$studentTemplate);
					}

					$firebase_token = $usersArray[$key]['student']['firebase_token'];
					if($firebase_token != ""){
						if(is_array(json_decode($firebase_token))) {
							$token = json_decode($firebase_token);
						} else if ($this->isJson($firebase_token)) {
							$token = json_decode($firebase_token);
						} else {
							$token[] = $firebase_token;
						}
						$this->panelInit->send_push_notification(
							$token,
							$valueP['id'],
							$studentTemplate,
							"Exam grade details","marksheet",$usersArray[$key]['student']['id']
						);
					} else {
						$this->panelInit->save_notifications_toDB(
							$token,
							$valueP['id'],
							$studentTemplate,
							"Exam grade details","marksheet",$usersArray[$key]['student']['id']
						);
					}

				}
			}
		}

		return $this->panelInit->apiOutput(true,$this->panelInit->language['examDetailsNot'],$this->panelInit->language['examNotSent'] );
	}

	function classSheduleLists($id)
	{
		$classId=json_encode($id,true);
		$sheduleLists=\exams_list::where('examClasses', 'like', '%' . $classId . '%')->get();
		echo json_encode($sheduleLists);
	}

	function subjectSheduleLists($id)
	{
		$data=\Input::get();	
		$classId=json_encode($data['classId'],true);
		$subjectId=json_encode($id,true);
		$returnDatas = DB::table('exams_list')
			->leftJoin('shedule_terms', 'exams_list.id', '=', 'shedule_terms.examId')
			->where('examClasses', 'like', '%' . $classId . '%')
			->where('examSchedule', 'like', '%' . $subjectId . '%')
            ->select('exams_list.*', 'shedule_terms.allow')
			->get();
			echo json_encode($returnDatas);
		// $data=\Input::get();	
		// $classId=json_encode($data['classId'],true);
		// $subjectId=json_encode($id,true);
		// $sheduleLists=\exams_list::where('examClasses', 'like', '%' . $classId . '%')->where('examSchedule', 'like', '%' . $subjectId . '%')->get();
		// if($data['term']==0){
		// 	echo json_encode(array('examLists'=>$sheduleLists,'termLists'=>null));
		// }
		// else{
		// 	$returnDatas=$this->termSelect($data['term'],"ren",$data['classId'],$id);
		// 	echo json_encode(array('examLists'=>$sheduleLists,'termLists'=>$returnDatas));

		// }
	}
	// sdf
	function sheduleTerms($exam_id){
		$data=\Input::get();
		$getData=SheduleTerm::where('classId',$data['classId'])->where('subjectId',$data['subjectId'])->where('examId',$exam_id)->get();
		$data['examId']=$exam_id;
		$data['year']=date('Y');
		if(count($getData)==0)
		{
			SheduleTerm::create($data);
		}
		else{
			SheduleTerm::where('classId',$data['classId'])->where('subjectId',$data['subjectId'])->where('examId',$exam_id)->update($data);
		}
		$classId=json_encode($data['classId'],true);
		$subjectId=json_encode($data['subjectId'],true);
		$returnDatas = DB::table('shedule_terms')
			->join('exams_list', 'shedule_terms.examId', '=', 'exams_list.id')
			->where('shedule_terms.allow',1)
			->where('shedule_terms.term',$data['term'])
            ->select('exams_list.*', 'shedule_terms.allow')
			->get();
			echo json_encode($returnDatas);
	}

	function termSave(){
		$data=\Input::get();
		// $data['unitId']=json_encode($data['unitId'],true);
		foreach($data['examId'] as $item){
			$data['examId']=$item['id'];
			$getData=Examterms::where('classId',$data['classId'])->where('subjectId',$data['subjectId'])->where('examId',$data['examId'])->get();
			if(count($getData)==0){

				Examterms::create($data);
			}
			else{
				Examterms::where('classId',$data['classId'])->where('subjectId',$data['subjectId'])->where('examId',$data['examId'])->update($data);
			}
		}
		echo 'success';
	}

	function termSelect($term){
		$returnDatas = DB::table('exams_list')
		->join('shedule_terms', 'exams_list.id', '=', 'shedule_terms.examId')
		->join('examterms', 'exams_list.id', '=', 'examterms.examId')
		->where('shedule_terms.allow',1)
		->where('examterms.term',$term)
		->select('exams_list.*', 'shedule_terms.allow')
		->get();
		echo json_encode($returnDatas);
	}
	
}
