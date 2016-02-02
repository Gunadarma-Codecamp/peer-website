<?php

class group_admin extends Controller {
	
	var $models = FALSE;
	var $view;
	var $user;
	
    public function __construct()
	{
        global $basedomain;
		$this->loadmodule();
        $this->view = $this->setSmarty();
        $this->view->assign('basedomain',$basedomain);
        $this->user = $this->isUserOnline();
        if (!$this->isUserOnline()){ redirect($basedomain); exit;}
        // pr($this->user['login']['group']);exit;
        if ($this->user['login']['group'] != "5"){redirect($basedomain);exit;}
	}
	
    public function loadmodule()
	{
		$this->groupHelper = $this->loadModel('groupHelper');
		$this->collectionHelper = $this->loadModel('collectionHelper');
        $this->excelHelper = $this->loadModel('excelHelper');
        $this->activityHelper = $this->loadModel('activityHelper');
        $this->loginHelper = $this->loadModel('loginHelper');
        $this->userHelper = $this->loadModel('userHelper');
    }
	
	public function index(){
    }
    public function chooseGroup(){
        $username = $this->user['login']['username'];
        $listGroup = $this->groupHelper->getGroup();
        $this->view->assign('listGroup', $listGroup);
		return $this->loadView('group_admin/index');
    }

    public function choosePrivileges($group=null){
        
    }

    public function actGroup(){

        global $basedomain;

        $data = $_POST;
        $idGroup=$data['group-id'];
        $group = $this->groupHelper->getGroup($idGroup);
        // pr($group);exit;
        $rules = $this->groupHelper->getRules($idGroup);
        // pr($rules[0]['rules']);exit;
        $arr_rules = explode(",", $rules[0]['rules']);
        for($i=1;$i<=20;$i++){
            if(in_array($i,$arr_rules)){
                $input[$i]="checked";
            } else {
                $input[$i]="";
            }
        }
        
        $this->view->assign('input', $input);

        if($group!=null){
        	$this->view->assign('idGroup', $group[0]['id_group']);
        	$this->view->assign('nmGroup', $group[0]['nm_group']);
        }
		return $this->loadView('group_admin/choosePrivileges');
        
    }
    public function insertPrivileges(){

        global $basedomain;

        $data = $_POST;

        $rules="";
        foreach ($data['inp'] as $val){
        	if($rules==""){
        		$rules=$rules.$val;
        	}else{
        		$rules=$rules.",".$val;
        	}
        	
        }
        
        $rs = $this->groupHelper->setRule($rules,$data['idGroup']);
        
		if ($rs == 0){
			//logFile('====groupAdmin: failed insert data rules to group====');
			header("Refresh:0");
		}else{
			redirect($basedomain.'group_admin/chooseGroup'); exit;
		}
		
        
    }
}

?>
