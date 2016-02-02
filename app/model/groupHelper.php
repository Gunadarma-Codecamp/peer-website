<?php
class groupHelper extends Database {
	
	function getGroup($id=null)
	{

		$sql = "SELECT id_group, nm_group FROM peerkalbar_group";
		if($id!=null){
			$sql=$sql." where id_group = $id";	
		}
		$res = $this->fetch($sql,1);	
        return $res;
		
	}
	function getRules($id=null)
	{

		$sql = "SELECT id_group, nm_group,rules FROM peerkalbar_group";
		if($id!=null){
			$sql=$sql." where id_group = $id";	
		}
		$res = $this->fetch($sql,1);
		//pr($this);exit;
        return $res;
		
	}
	function setRule($rules="",$idgroup=""){
		$sql = "UPDATE peerkalbar_group SET rules='$rules' where id_group = '$idgroup'";
		
		$res = $this->query($sql,0);
		return $res;
	}
}
?>