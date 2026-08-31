 <?php
/**
* Database Class
*/
class Functions extends cn
{
    use operation;
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
		$ar = $this->getdata("select $fields from $table where id > 0".$where);
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

	
	public function adddata($tablename,$data){
		$ok = 1;
		if ($ok == 1) {
			$keys = implode(",", array_keys($data));
			$k = ':'.implode(", :",array_keys($data));

			$sql = "insert into $tablename($keys) values($k)";
			$stmt = $this->db->prepare($sql);
			foreach ($data as $key => $value) {
				$stmt->bindValue($key,$value);
			}
			$cond = $stmt->execute();
			$this->lastid = $this->db->lastInsertId();
			if($cond == 1){
				return true;
			}
			else{
				$this->Error = $stmt->errorInfo();
			}
		}else{
			return false;
		}
	}
	public function qedit($tablename,$array,$idtype,$val,$oqury=''){
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




	public function rpost($value,$rep='')
	{
		$ar = array();
		foreach ($value as $key => $val) {
			if (isset($_POST[$val])) {
				$pkey = $val;
				if ($rep != '') {
					$pkey = str_replace($rep, '', $val);
				}
				$ar[$pkey] = $_POST[$val];
			}
		}
		return $ar;
	}

	public function tokenin($value='')
	{
		if (isset($_SESSION['token'])) {
			$token = $_SESSION['token'];
		}else{
			$token = md5(strtotime(date('d-m-y H:i:s')));
			$_SESSION['token'] = $token;
		}
		return '<input type="hidden" name="token" value="'.$token.'">';
	}

	public function check_token()
	{
		if (isset($_POST['token']) and isset($_SESSION['token'])) {
			if ($_SESSION['token'] == $_POST['token']) {
				return 1;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	public function unset_ses($value)
	{
		if (isset($_SESSION[$value])) {
			unset($_SESSION[$value]);
		}
	}







	public function getm($mname,$url='')
	{
		if ($url == '') {
			$url = $_SERVER['REQUEST_URI'];
		}
		$parts = parse_url($url);
		if (isset($parts['query'])) {
			parse_str($parts['query'], $query);
			if (isset($query[$mname])) {
				return $query[$mname];
			}else{
				return false;
			}
		}else{
			return false;
		}
		
		
	}
	public function getip(){
	    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
	        //ip from share internet
	        $ip = $_SERVER['HTTP_CLIENT_IP'];
	    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	        //ip pass from proxy
	        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    }else{
	        $ip = $_SERVER['REMOTE_ADDR'];
	    }
	    return $ip;
	}




	public function logout()
	{
		if (isset($_SESSION)) {
			session_destroy();
			foreach ($_SESSION as $key => $value) {
				unset($_SESSION[$value]);
			}
		}
	}



	public function render_body($db){
	    $pg = 'dashboard';
	    if(isset($_GET['e'])){
			$url = $_GET['e'];
			$url = rtrim($url,"/");
			$url = explode("/", $url);
			if ($url[0] == 'logout') {
				session_destroy();
				$this->redirect(domain.'login');
			}
	        if(file_exists('pages/'.$url[0].'.php')){
	            $pg = $url[0];
	        }else{
	             $pg = '404';
	        }
	    }
	    if (!$this->is_login()) {
	    	$pg = 'login';
	    }
	    $access = [];$manual = ['login'];
	    if ($this->is_login()) {
	      $access = explode(',',$this->getonecol('access','admin','id',$this->uid()));
	    }
	    if (!in_array($pg, $manual)) {
	    	if (!in_array($pg, $access)) {
	    		$pg = '404';
	    	}
	    }
	    include_once 'pages/header.php';
	    include_once 'pages/'.$pg.'.php';
	    include_once 'pages/footer.php';
	}
	


	public function rpv($value)
	{
		if (isset($_POST[$value])) {
			return $_POST[$value];
		}else{
			return '';
		}
	}


	public function redirect($pg)
	{
	    header("Location:".$pg);
	    exit();
	}

	public function refpg()
	{
	    return $_SERVER['HTTP_REFERER'];
	}
	public function en_bn($num,$dismal=0)
	{
	    $ok = 1;
	    if(($num == 0 or $num == '') and $zero_emt == 0){
	        $ok = 0;
	    }
	    if($ok){
	        return str_replace(['0','1','2','3','4','5','6','7','8','9'],['০','১','২','৩','৪','৫','৬','৭','৮','৯'],$num);
	    }
	    return round($num,$dismal);
	    
	}

	public function setdate($date)
	{
	    return date('d M, Y', strtotime($date));
	}


	public function empty_check($values_ar,$array,$red=true)
	{   
	    if(is_array($values_ar)){
	        foreach($values_ar as $key => $v){
	            if(isset($array[$key])){
	                if(trim($array[$key]) == ''){
	                    $_SESSION['msg'] = $v;
	                    if($red){
	                        $this->redirect($this->refpg());
	                    }
	                    
	                }
	            }
	        }
	    }
	}

	public function getonecol($col, $tbl, $comCol, $comVal) {
	    $sql = "SELECT $col FROM $tbl WHERE $comCol='$comVal'";
	    foreach($this->getdata($sql) as $v){
	        if (isset($v[$col])) {
	          return $v[$col];
	        }
	    }
	}
	public function cdate($date="Y-m-d")
	{
		$dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
	  return $dt->format($date);
	}
	public function now()
	{
	    return $this->cdate('Y-m-d H:i:s');
	}


	public function is_login()
	{
	    if(isset($_SESSION['user_id'])){
	        return true;
	    }else{
	        return false;
	    }
	}
	

	public function uid()
	{
	    if(isset($_SESSION['user_id'])){
	       return $_SESSION['user_id']; 
	    }
	}


public function token()
{
	return '<input type="hidden" name="token" value="'.(isset($_SESSION['token'])?$_SESSION['token']:'').'">';
}
	public function set_key($ar,$set_key)
	{
		$car = [];
		foreach ($ar as $key => $v) {
			if (isset($v[$set_key])) {
				$car[$v[$set_key]] = $v;
			}
		}
		return $car;
	}
	public function get_pg_title($pg_name){
        return @$this->getAll('pages',' and url = "'.$pg_name.'"')['page_title'];
    }
	public function nf($value,$d=2)
	{
		$value = !empty($value)?trim($value):0;
		$value = (float)$value;
		if ($value != '') {
			if (is_numeric($value)) {
				return number_format($value,$d);
			}else{
				return ($value);
			}
			
		}
		
	}
	
	public function ar2v($ar,$index)
	{
		if (is_array($ar)) {
			if (isset($ar[$index])) {
				return $ar[$index];
			}
		}
	}

	public function input($ar)
	{
		/*
		##Using method
		view_type => hr means horizental and defoult vertical

		*/

		$class = @$ar['class'].' ';
		$name = isset($ar['name'])?$ar['name']:'';
		$value = isset($ar['value'])?$ar['value']:'';
		$title = isset($ar['title'])?$ar['title']:ucwords($name);
		$placeholder = isset($ar['placeholder'])?$ar['placeholder']:$title;
		$col = isset($ar['col'])?$ar['col']:'6';
		$type = isset($ar['type'])?$ar['type']:'text';
		$attr = isset($ar['attr'])?$ar['attr']:'';
		$parent_class = isset($ar['parent_class'])?$ar['parent_class']:'';
		$parent_attr = isset($ar['parent_attr'])?$ar['parent_attr']:'';
		$img_folder = isset($ar['img_folder'])?$ar['img_folder']:'';
		$title_status = isset($ar['title_status'])?$ar['title_status']:1;
		$view_type = @$ar['view_type'];
		
		if (strpos(strtolower($attr), 'required')!==false) {
			$req_span = ' <span class="red">*</span>';
		}else{
			$req_span = '';
		}
		
		if (strpos(strtolower($attr), 'multiple')!==false && $type != 'file') {
			$multi_status = 1;
			$value = explode(',',$value);
		}else{
			$multi_status = 0;
		}
		
		
		$no_col = 'col-md-'.$col;
		if(isset($ar['no_col']) && $ar['no_col'] == 'no'){
		    $no_col = 'no_col';
		}
		$data = '<div class="'.$no_col.' '.$parent_class.'" '.$parent_attr.'>';

    		$data .= $view_type == 'hr'?'<div class="form-group row no-gutters">':'<div class="form-group">';
    			$data .= $view_type == 'hr'?'<div class="col-md-4">':'';
    			$data .= $title_status?'<label for="'.$name.'" class="form-label">'.$title.$req_span.'</label>':'';
    			$data .= $view_type == 'hr'?'</div>':'';

    			$data .= $view_type == 'hr'?'<div class="col-md-8">':'';

    		
    			if ($type == 'textarea') {
    				$data .= '<textarea name="'.$name.'" '.$attr.' id="'.$name.'" class="'.$class.'" placeholder="'.$placeholder.'">'.$value.'</textarea>';
    			}elseif ($type == 'select') {
    				$data .= '<select name="'.$name.'" '.$attr.' id="'.str_replace(['[',']'],'',$name).'" class="'.$class.'">';
    				if (isset($ar['blank'])) {
    					$data .= '<option value="">'.(!empty($ar['blank'])?$ar['blank']:'Select').($title_status==0?' '.$title:'').'</option>';
    				}
    				if (isset($ar['blank_value'])) {
    					$data .= '<option value="'.$ar['blank_value'].'">'.ucwords($ar['blank_value']).'</option>';
    				}
    				if (isset($ar['create'])) {
    					$data .= '<option value="new">'.(!empty($ar['create'])?$ar['create']:'Create New').'</option>';
    				}

    				if (isset($ar['select_value_type'])) {
    					foreach ($ar['select_ar'] as $key => $v) {
    						if ($ar['select_value_type'] == 'value') {
    							$data .= '<option value="'.$v.'" ';
		    					
		    					if($multi_status){
    	    					    if(in_array($v, $value)){
    	    					        $data .= 'selected';
    	    					    }
    	    					}else{
    	    					    $data .= $value==$v?'selected':'';
    	    					}
		    					
		    					$data .= '>'.$v.'</option>';
    						}elseif ($ar['select_value_type'] == 'key_value') {
    							$data .= '<option value="'.$key.'" ';
		    					if($multi_status){
    	    					    if(in_array($key, $value)){
    	    					        $data .= 'selected';
    	    					    }
    	    					}else{
    	    					    $data .= $value==$key?'selected':'';
    	    					}
		    					$data .= '>'.$v.'</option>';
    						}
	    				}
    				}else{
    					foreach ($ar['select_ar'] as $key => $v) {
	    					$data .= '<option value="'.$v['id'].'" ';
	    					if($multi_status){
	    					    if(in_array($v['id'], $value)){
	    					        $data .= 'selected';
	    					    }
	    					}else{
	    					    $data .= $value==$v['id']?'selected':'';
	    					}
	    					
	    					
	    					$data .= isset($ar['select_op_add_attr'])?' data-code="'.$v[$ar['select_op_add_attr']].'"':'';
	    					$data .= isset($ar['data-attr'])?' data-'.$ar['data-attr'].'="'.$v[$ar['data-attr']].'"':'';
	    					$data .= '>'.$v['name'].'</option>';
	    				}
    				}

    				$data .= '</select>';
    			}else{
    				if (strlen($placeholder) > 0) {}else{
    					$placeholder = !empty($title)?'Enter '.$title:'';
    				}
    				$data .= '<input type="'.$type.'" '.(isset($ar['datalist'])?'list="list-'.$name.'"':'').' name="'.$name.'" class="'.$class.'" '.$attr.' id="'.$name.'" value="'.$value.'" placeholder="'.$placeholder.'" />';
    				
    				if(isset($ar['datalist'])){
    				    $data .= '<datalist id="list-'.$name.'">';
    				    foreach($ar['datalist'] as $l){
    				        $data .= '<option value="'.$l.'">';
    				    }
    				    $data .= '</datalist>';
    				}
    			}

    			$data .= $view_type == 'hr'?'</div>':'';
    			
    		$data .= '</div>
    	</div>';
    	return $data;
	}

	public function start_modal($title='',$width='650px',$form='<form method="post" enctype="multipart/form-data">',$modal_head=1)
	{
		$html = ' 
		<style>
	        .modal-dialog {
		        max-width: '.$width.';
		    } 
	    </style>';
	    if (!empty($title) && $modal_head == 1) {
	    	$html .= '<div class="modal-header">
		    <h1 class="modal-title fs-5" id="staticBackdropLabel">'.$title.'</h1>
		    <button type="button" class="fa fa-times close" data-dismiss="modal" aria-label="Close"></button>
	  	</div>';
	    }
	  if (!empty($form)) {
	  	$form .= $this->token();	
	  }
	  $html .= $form.'
	  <div class="modal-body">';
	  return $html;
	}
	public function modal_footer($id='',$btn_name='save')
	{
		return ' 
		<div class="modal-footer">
	    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
	    <input type="hidden" value="'.@$id.'" name="'.$btn_name.'">
	    <button type="submit" class="btn btn-success btn-sm" value="'.@$id.'" name="'.$btn_name.'">Save</button>
	  </div>';
	}

	/* ============= MISSING METHODS ADDED ============= */

	/**
	 * Get share info (per_share, member_fee) from settings
	 */
	public function share_info()
	{
		$s = $this->getAll('settings',' and id = 1');
		return [
			'per_share' => isset($s['monthly_fee']) ? $s['monthly_fee'] : 0,
			'member_fee' => isset($s['yearly_fee']) ? $s['yearly_fee'] : 0
		];
	}

	/**
	 * Get payable type options
	 */
	public function payable_type()
	{
		return ['monthly', 'yearly', 'others'];
	}

	/**
	 * Get method dropdown options HTML
	 */
	public function get_method_option($where = '', $add_where = '')
	{
		$html = '';
		foreach ($this->getFull('method', '*', ' and parent_id = 0' . $add_where) as $p) {
			$html .= '<option value="' . $p['id'] . '">' . $p['name'] . '</option>';
			foreach ($this->getFull('method', '*', ' and parent_id = ' . $p['id']) as $c) {
				$html .= '<option value="' . $c['id'] . '">-- ' . $c['name'] . '</option>';
			}
		}
		return $html;
	}

	/**
	 * Get method list as key => value
	 */
	public function method_list()
	{
		$list = [];
		foreach ($this->getFull('method', '*', ' and parent_id = 0') as $p) {
			$list[$p['id']] = $p['name'];
			foreach ($this->getFull('method', '*', ' and parent_id = ' . $p['id']) as $c) {
				$list[$c['id']] = '-- ' . $c['name'];
			}
		}
		return $list;
	}

	/**
	 * Get method balance
	 */
	public function get_method_balance($method_id = 0)
	{
		$where = $method_id > 0 ? ' and method_id = ' . $method_id : '';
		$ar = $this->getdata('
			select
				sum(if(type="collection",amount,0)) as collection,
				sum(if(type="payment",amount,0)) as payment,
				sum(if(type="transfer_in",amount,0)) as ins,
				sum(if(type="transfer_out",amount,0)) as outs
			from ledger where method_id > 0' . $where
		);
		if ($ar && isset($ar[0])) {
			$b = $ar[0]['collection'] - $ar[0]['payment'] - $ar[0]['outs'] + $ar[0]['ins'];
			return ['b' => $b, 'data' => $ar[0]];
		}
		return ['b' => 0, 'data' => []];
	}

	/**
	 * Send SMS
	 */
	public function send_sms($mobile, $sms, $member_id = 0)
	{
		$api = $this->sms_api();
		if (empty($api) || empty($mobile)) return 'SMS configuration missing';
		$mobile = str_replace(['-', ' ', '+'], '', $mobile);
		$url = 'https://sms.xylub.com/?api=sendSMS&sender_id=asb&message=' . urlencode($sms) . '&number=' . $mobile . '&api_key=' . $api;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$res = curl_exec($ch);
		curl_close($ch);
		return $res;
	}

	/**
	 * Get SMS API key from settings
	 */
	public function sms_api()
	{
		return $this->getonecol('sms_api', 'settings', 'id', 1);
	}

	/**
	 * Format customer ID
	 */
	public function get_cus_id($cus_id)
	{
		return 'ASB-' . $this->set_digit($cus_id, 4);
	}

	/**
	 * Format loan ID
	 */
	public function get_loan_id($loan_ar)
	{
		return 'LN-' . $this->set_digit($loan_ar['id'], 4);
	}

	/**
	 * Pad digits
	 */
	public function set_digit($num, $digit = 4)
	{
		return str_pad($num, $digit, '0', STR_PAD_LEFT);
	}

	/**
	 * Get relation list for loan nominees
	 */
	public function relation_list()
	{
		return [
			'father' => 'Father',
			'mother' => 'Mother',
			'brother' => 'Brother',
			'sister' => 'Sister',
			'spouse' => 'Spouse',
			'son' => 'Son',
			'daughter' => 'Daughter',
			'other' => 'Other'
		];
	}

	/**
	 * Convert number to words (BD Taka format)
	 */
	public function convertNumberToWord($num = false)
	{
		$num = str_replace([',', ' '], '', trim($num));
		if (!$num) return 'Zero';
		$num = (float)$num;
		if (!is_numeric($num)) return 'Zero';
		$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
		return $f->format($num);
	}

	/**
	 * Upload image file
	 */
	public function image_upload($file_input, $target_dir, $max_size = 500000, $file_name = '')
	{
		if (!isset($_FILES[$file_input]) || $_FILES[$file_input]['error'] != 0) {
			return isset($_POST[$file_input]) ? $_POST[$file_input] : '';
		}
		if (!is_dir($target_dir)) {
			mkdir($target_dir, 0777, true);
		}
		$file = $_FILES[$file_input];
		$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
		$allowed = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
		if (!in_array($ext, $allowed)) return '';
		if ($file['size'] > $max_size) return '';
		$name = !empty($file_name) ? $file_name : time() . '_' . rand(100, 999) . '.' . $ext;
		$target = $target_dir . $name;
		if (move_uploaded_file($file['tmp_name'], $target)) {
			return $name;
		}
		return '';
	}

	/**
	 * Send HTTP POST request
	 */
	public function send_post($url, $data = [])
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$res = curl_exec($ch);
		curl_close($ch);
		return $res;
	}

	/**
	 * Check if member is logged in (stub — not implemented in this project)
	 */
	public function is_mem_login()
	{
		return false;
	}

	/**
	 * Get member ID from session
	 */
	public function mem_id()
	{
		return isset($_SESSION['member_id']) ? $_SESSION['member_id'] : 0;
	}


}
?>
