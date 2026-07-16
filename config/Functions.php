 <?php
 /**
* Database Class
*/
class Functions extends cn
{
	public $lastid;
	public $rowcount;
	public $secured;
	function __construct()
	{
		parent:: __construct();
	}
	public function insert($sql)
	{
		$ok = 1;
		if ($ok == 1) {
			$stmt = $this->db->prepare($sql);
			$cond =  $stmt->execute();
			$this->lastid = $this->db->lastInsertid();
			if($cond == 1){
				return true;
			}
			return false;
		}else{
			return false;
		}
		
	}
	public function edit($sql)
	{
		$stmt= $this->db->prepare($sql);
		return $stmt->execute();
	}

	public function getdata($sql,$rowcount=false)
	{
		$stmt= $this->db->prepare($sql);
	    $stmt->execute();
	    if ($rowcount) {
	    	return $stmt->rowCount();
	    }else{
	    	return $stmt->fetchAll();
	    }
		
		
	}
	public function getAll($table,$where='',$fields = '*')
	{
		$sql = "select $fields from $table where id > 0".$where;
		// echo $sql;
		$ar = $this->getdata($sql);
		if ($ar) {
			return $ar[0];
		}
	}


	public function getFull($table, $fields = '*', $where = '',$rowcount=false)
    {
        $ar = $this->getdata("select $fields from $table where id > 0".$where,$rowcount);
		return $ar;
    }


	public function row_count($sql)
	{
		$stmt= $this->db->prepare($sql);
	    $stmt->execute();
		return $stmt->rowCount();
	}
	public function qgetdata($sql,$col="",$value=0,$value_return = '')
	{

		$sql = "select * from $sql";
		if ($col != "") {
			$sql .= "  where $col = $value";
		}
		
		
		$stmt= $this->db->prepare($sql);
	    $stmt->execute();
		$this->rowcount = $stmt->rowCount();
		if ($value_return != '') {
			$d = $stmt->fetchAll();

			if (isset($d[0])) {
				return $d[0][$value_return];
			}


		}else{
			return $stmt->fetchAll();
		}
		
	}



	public function delete($sql)
	{
		$stmt= $this->db->prepare($sql);
		return $stmt->execute();
	}
	public function aut($sql,$value="")
	{
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		if ($value == "") {
			return $stmt->rowCount();
		}
		else
		{
			return true;
		}
	}
	public function qaut($table,$colm,$value)
	{
		$sql = 'select * from $table where $colm ='.$value;
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		return $stmt->rowCount();

	}

	public function insert_ar($tablename,$array,$idtype,$val,$oqury=''){
		$keys = null;
		if (!is_numeric($val)) {
			$val = '"'.$val.'"';
		}
		foreach ($array as $key=>$value) {
			$keys .= ", $key = :$key";
		}
		$keyss = ltrim($keys, ",");
		$sql = "update $tablename set $keyss where ".$idtype." =".$val;
		if ($oqury != '') {
			$sql .= $oqury;
		}
		$stmt = $this->db->prepare($sql);
		foreach ($array as $key => $value) {
			$stmt->bindValue($key,$value);
		}
		return $stmt->execute();
	}


}
?>
