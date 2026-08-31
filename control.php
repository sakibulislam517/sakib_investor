<?php
require "main.php";



if (isset($_GET['create_investor'])) {
   echo $db->start_modal("Investor", "700px");
   $ar = $db->getAll('investor',' and id ='.$db->rpv('id'));
   echo '<div class="row">';
   echo $db->input(['name'=>'cus_id','col'=>3,'title' =>'ID','value'=>$db->ar2v($ar,'cus_id')]);
   echo $db->input(['name'=>'name','col'=>5,'title' =>'Name','value'=>$db->ar2v($ar,'name')]);
   echo $db->input(['name'=>'number','col'=>4,'title' =>'Contact No.','value'=>$db->ar2v($ar,'number')]);
   echo $db->input(['name'=>'pass','col'=>3,'title' =>'Password']);
   echo $db->input(['name'=>'address','col'=>6,'title' =>'Address','value'=>$db->ar2v($ar,'address')]);

   echo '</div></div>';
   echo $db->modal_footer($db->rpv('id'));
}

if (isset($_GET['create_investment'])) {
   echo $db->start_modal("Investment", "700px");
   $id = $db->rpv('id');
   $ar = $db->getAll('ledger',' and id ='.$id);
   $investors = $db->getFull('investor','*',' order by name asc');
   $amount_value = !empty($ar) && $ar['debit'] > 0 ? $ar['debit'] : (!empty($ar) ? $ar['credit'] : '');
   $date_value = !empty($ar['date']) ? $ar['date'] : $db->cdate('Y-m-d');

   echo '<div class="row">';
   echo '<div class="col-md-12"><div class="form-group"><label>Investor</label><select name="investor_id" class="form-control" required><option value="">Select Investor</option>';
   foreach ($investors as $investor) {
       $selected = (!empty($ar) && $ar['investor_id'] == $investor['id']) ? 'selected' : '';
       echo '<option value="'.$investor['id'].'" '.$selected.'>'.$investor['name'].' ('.$investor['cus_id'].')</option>';
   }
   echo '</select></div></div>';

   echo '<div class="col-md-4"><div class="form-group"><label>Amount</label><input type="number" name="amount" class="form-control" step="0.00001" min="0" value="'.$amount_value.'" required></div></div>';
   echo '<div class="col-md-4"><div class="form-group"><label>Date</label><input type="date" name="date" class="form-control" value="'.$date_value.'" required></div></div>';
   echo '<div class="col-md-4"><div class="form-group"><label>Type</label><select name="type" class="form-control" required>';
   echo '<option value="invest" '.((!empty($ar) && $ar['type'] == 'invest') ? 'selected' : '').'>Invest</option>';
   echo '<option value="invest_withdraw" '.((!empty($ar) && $ar['type'] == 'invest_withdraw') ? 'selected' : '').'>Invest Withdraw</option>';
   echo '</select></div></div>';
   echo '<div class="col-md-12"><div class="form-group"><label>Remarks</label><input type="text" name="remarks" class="form-control" value="'.(@$ar['remarks']).'" placeholder="Optional remarks"></div></div>';
   echo '</div></div>';
   echo '<input type="hidden" name="id" value="'.$id.'">';
   echo $db->modal_footer($id, 'save_invest');
}

if (isset($_GET['create_profit'])) {
   echo $db->start_modal("Generate Profit", "600px");
   echo '<div class="row">';
   echo '<div class="col-md-6"><div class="form-group"><label>Amount</label><input type="number" name="amount" class="form-control" step="0.00001" min="0" required></div></div>';
   echo '<div class="col-md-6"><div class="form-group"><label>Date</label><input type="date" name="date" class="form-control" value="'.$db->cdate('Y-m-d').'" required></div></div>';
   echo '<div class="col-md-12"><div class="form-group"><label>Remarks</label><input type="text" name="remarks" class="form-control" placeholder="Profit distribution remarks"></div></div>';
   echo '</div></div>';
   echo '<input type="hidden" name="type" value="profit_generate">';
   echo '<input type="hidden" name="save_profit" value="1">';
   echo $db->modal_footer('', 'save_profit');
}

if (isset($_GET['create_profit_withdraw'])) {
   echo $db->start_modal("Profit Withdraw", "600px");
   $investors = $db->getFull('investor','*',' order by name asc');
   echo '<div class="row">';
   echo '<div class="col-md-12"><div class="form-group"><label>Investor</label><select name="investor_id" class="form-control" required><option value="">Select Investor</option>';
   foreach ($investors as $investor) {
       echo '<option value="'.$investor['id'].'">'.$investor['name'].' ('.$investor['cus_id'].')</option>';
   }
   echo '</select></div></div>';
   echo '<div class="col-md-6"><div class="form-group"><label>Amount</label><input type="number" name="amount" class="form-control" step="0.00001" min="0" required></div></div>';
   echo '<div class="col-md-6"><div class="form-group"><label>Date</label><input type="date" name="date" class="form-control" value="'.$db->cdate('Y-m-d').'" required></div></div>';
   echo '<div class="col-md-12"><div class="form-group"><label>Remarks</label><input type="text" name="remarks" class="form-control" placeholder="Profit withdraw remarks"></div></div>';
   echo '</div></div>';
   echo '<input type="hidden" name="type" value="profit_withdraw">';
   echo '<input type="hidden" name="save_profit" value="1">';
   echo $db->modal_footer('', 'save_profit');
}

if (isset($_GET['create_admin'])) {
	$id = $name = $user_name = $number = $email = $img = '';$access = [];
	if (isset($_POST['id'])) {
		foreach ($db->getFull('admin','*',' and id ='.$_POST['id']) as $key => $v) {
			$id = $v['id'];
			$name = $v['name'];
			$number = $v['number'];
			$user_name = $v['user_name'];
			$email = $v['email'];
			$img = $v['img'];
			$access = explode(',', $v['access']);
		}
	}
	echo '
	<style>
		.modal-dialog {
	    max-width: 650px;
	}
	.acc_view{
		background:#19875414!important;
	}
	.acc_add{
		background:#5a5ae84d!important;
	}
	.acc_edit{
		background:#ff727252!important;
	}
	.acc_delete{
		background:#e61a4463!important;
	}
	.checkall{
		width: 15px;position: absolute;top: -11px;right: 2px;
	}
	</style>
	<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">User Management</h1>
    <button type="button" class="fas fa-times close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <form method="post" enctype="multipart/form-data">
  <div class="modal-body">
    <div class="row">
    	<div class="col-md-6">
    		<div class="form-group">
    			<label for="name">Name</label>
    			<input type="text" name="name" id="name" value="'.$name.'" required/>
    		</div>
    	</div>
    	<div class="col-md-6">
    		<div class="form-group">
    			<label for="number">Number</label>
    			<input type="text" name="number" id="number" value="'.$number.'"/>
    		</div>
    	</div>
    	<div class="col-md-6">
    		<div class="form-group">
    			<label for="user_name">Username</label>
    			<input type="text" name="user_name" id="user_name" value="'.$user_name.'" required/>
    		</div>
    	</div>

    	
    	<div class="col-md-6">
    		<div class="form-group">
    			<label for="email">E-mail</label>
    			<input type="email" name="email" id="email" value="'.$email.'"/>
    		</div>
    	</div>
    	<div class="col-md-6">
    		<div class="form-group">
    			<label for="pass">Password</label>
    			<input type="password" name="pass" id="pass" autocomplete="one-time-code"/>
    		</div>
    	</div>

    	<div class="col-md-6">
    		<div class="form-group">
    			<label for="img">Image</label>
    			<input type="file" style="padding: 6px 10px;" name="img" id="img"/>
    			<input type="hidden" name="img" value="'.$img.'"/>
    		</div>
    	</div>
    	<div class="col-md-12">
    		<div class="form-group">
    			<table class="table-bordered table access">
    				<tr><th colspan="5">Pages Permission</th></tr>
    				<tr class="text-white" style="background:#198754;">
    					<th>Name</th>
    					<th style="position: relative;cursor:pointer;">
    						<label for="view" style="cursor:pointer;">View</label>
    						<input id="view" type="checkbox" class="checkall" onclick="check_all(this,\'acc_view\')">
    					</th>
    					<th style="position: relative;cursor:pointer;">
    						<label for="add" style="cursor:pointer;">Add</label>
    						<input id="add" type="checkbox" class="checkall" onclick="check_all(this,\'acc_add\')">
    					</th>
    					<th style="position: relative;cursor:pointer;">
    						<label for="edit" style="cursor:pointer;">Edit</label>
    						<input id="edit" type="checkbox" class="checkall" onclick="check_all(this,\'acc_edit\')">
    					</th>
    					<th style="position: relative;cursor:pointer;">
    						<label for="delete" style="cursor:pointer;">Delete</label>
    						<input id="delete" type="checkbox" class="checkall" onclick="check_all(this,\'acc_delete\')">
    					</th>
    				</tr>
    				';
    				foreach ($db->getFull('pages','*',' and parent_id = 0 order by sl') as $key => $v) {
    					$option = explode(',',!empty($v['option'])?$v['option']:'');
			        echo '<tr>
						        <td class="text-left">'.$v['name'].'</td>
						        <td class="text-center acc_view">
						        	<div class="checkbox-wrapper">
										    <input class="checkbox_des_v1" type="checkbox" id="pg-'.$v['id'].'" value="'.$v['url'].'" name="access[]"';
										    echo in_array($v['url'], $access)?'checked':'';
										    echo '>
										    <label for="pg-'.$v['id'].'" class="checkbox-label"></label>
										  </div>
						        </td>
						        <td class="text-center acc_add">';
						        if(in_array('add', $option)){
						        	echo '<div class="checkbox-wrapper">
										    <input class="checkbox_des_v1" type="checkbox" id="pga-'.$v['id'].'" value="'.$v['url'].'_add" name="access[]"';
										    echo in_array($v['url'].'_add', $access)?'checked':'';
										    echo '>
										    <label for="pga-'.$v['id'].'" class="checkbox-label"></label>
										  </div>';
										}
						        echo '</td>
						        <td class="text-center acc_edit">';
						        if(in_array('edit', $option)){
						        	echo '<div class="checkbox-wrapper">
										    <input class="checkbox_des_v1" type="checkbox" id="pge-'.$v['id'].'" value="'.$v['url'].'_edit" name="access[]"';
										    echo in_array($v['url'].'_edit', $access)?'checked':'';
										    echo '>
										    <label for="pge-'.$v['id'].'" class="checkbox-label"></label>
										  </div>';
										 }
						        echo '</td>
						        <td class="text-center acc_delete">';
						        if(in_array('delete', $option)){
						        	echo '<div class="checkbox-wrapper">
										    <input class="checkbox_des_v1" type="checkbox" id="pgd-'.$v['id'].'" value="'.$v['url'].'_delete" name="access[]"';
										    echo in_array($v['url'].'_delete', $access)?'checked':'';
										    echo '>
										    <label for="pgd-'.$v['id'].'" class="checkbox-label"></label>
										  </div>';
										 }
						        echo '</td>
						      </tr>';
					      foreach ($db->getFull('pages','*',' and parent_id ='.$v['id'].' order by sl') as $key => $s) {
					      	$option = explode(',',!empty($s['option'])?$s['option']:'');
					        echo '<tr>
					            <td class="text-left" style="padding-left:30px !important">'.$s['name'].'</td>
					            <td class="text-center acc_view">
							        	<div class="checkbox-wrapper">
											    <input class="checkbox_des_v1" type="checkbox" id="spg-'.$s['id'].'" value="'.$s['url'].'" name="access[]"';
											    echo in_array($s['url'], $access)?'checked':'';
											    echo '>
											    <label for="spg-'.$s['id'].'" class="checkbox-label"></label>
											  </div>
							        </td>
					            <td class="text-center acc_add">';
					            if(in_array('add', $option)){
							        	echo '<div class="checkbox-wrapper">
											    <input class="checkbox_des_v1" type="checkbox" id="spga-'.$s['id'].'" value="'.$s['url'].'_add" name="access[]"';
											    echo in_array($s['url'].'_add', $access)?'checked':'';
											    echo '>
											    <label for="spga-'.$s['id'].'" class="checkbox-label"></label>
											  </div>';
											 }
							        echo '</td>
					            <td class="text-center acc_edit">';
					            if(in_array('edit', $option)){
							        	echo '<div class="checkbox-wrapper">
											    <input class="checkbox_des_v1" type="checkbox" id="spge-'.$s['id'].'" value="'.$s['url'].'_edit" name="access[]"';
											    echo in_array($s['url'].'_edit', $access)?'checked':'';
											    echo '>
											    <label for="spge-'.$s['id'].'" class="checkbox-label"></label>
											  </div>';
											 }
							        echo '</td>
					            <td class="text-center acc_delete">';
					            if(in_array('delete', $option)){
							        	echo '<div class="checkbox-wrapper">
											    <input class="checkbox_des_v1" type="checkbox" id="spgd-'.$s['id'].'" value="'.$s['url'].'_delete" name="access[]"';
											    echo in_array($s['url'].'_delete', $access)?'checked':'';
											    echo '>
											    <label for="spgd-'.$s['id'].'" class="checkbox-label"></label>
											  </div>';
											}
							        echo '</td>
					          </tr>';
					      }
			      }

    			echo '</table>
    		</div>
    	</div>

  
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="primary-outline-btn" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="primary-btn" value="'.$id.'" name="save">Save</button>
  </div></form>';?>
  <script type="text/javascript">
  	function check_all(e,cls) {
  		if (e.checked) {
  			$('.'+cls+' input').prop('checked',true)
  		}else{
  			$('.'+cls+' input').prop('checked',false)
  		}
  		console.log(cls)
  	}
  </script>

  <?php 
}


if (isset($_GET['create_page'])) {
	$id = $name = $parent_id = $url = $page_title = $img = $icon = $sl ='';$option = [];
	if (isset($_POST['id'])) {
		foreach ($db->getFull('pages','*',' and id ='.$_POST['id']) as $key => $v) {
			$id = $v['id'];
			$name = $v['name'];
			$parent_id = $v['parent_id'];
			$url = $v['url'];
			$page_title = $v['page_title'];
			$img = $v['img'];
			$icon = $v['icon'];
			$sl = $v['sl'];
			$option = explode(',',$v['option']);
		}
	}
	echo '
	<style>
		.modal-dialog {
	    max-width: 650px;
	}
	</style>
	<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Page Management</h1>
    <button type="button" class="fas fa-times close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <form method="post"  enctype="multipart/form-data">
  <div class="modal-body">
    <div class="row">

    	<div class="col-md-6">
    		<div class="form-group">
    			<label for="name">Parent Page</label>
    			<select name="parent_id">
  					<option value="">Select</option>';
  					foreach ($db->getFull('pages','*',' and parent_id = 0') as $key => $value) {
  						echo '<option value="'.$value['id'].'" ';
  						echo $parent_id == $value['id']?'selected':'';
  						echo '>'.$value['name'].'</option>';
  					}
  					echo '</select>
    		</div>
    	</div>

    	<div class="col-md-6">
    		<div class="form-group">
    			<label for="name">Name</label>
    			<input type="text" name="name" id="name" value="'.$name.'"/>
    		</div>
    	</div>

    	<div class="col-md-6">
    		<div class="form-group">
    			<label for="url">URL</label>
    			<input type="text" name="url" id="url" value="'.$url.'"/>
    		</div>
    	</div>

    	<div class="col-md-6">
    		<div class="form-group">
    			<label for="page_title">Page Title</label>
    			<input type="text" name="page_title" id="page_title" value="'.$page_title.'"/>
    		</div>
    	</div>
    	<div class="col-md-6">
    		<div class="form-group">
    			<label for="icon">Icon Class</label>
    			<input type="text" name="icon" id="icon" value="'.$icon.'" />
    		</div>
    	</div>
    	<div class="col-md-6">
    		<div class="form-group">
    			<label for="img">Photo</label>
    			<input type="hidden" name="img" value="'.$img.'">
	    		<input type="file" name="img" style="padding: 6px 10px;">
    		</div>
    	</div>
    	<div class="col-md-2">
    		<div class="form-group">
    			<label for="sl">Serial</label>
    			<input type="text" name="sl" id="sl" value="'.$sl.'"/>
    		</div>
    	</div>
    	<div class="col-md-2">
    		<div class="form-group" style="margin-top: 30px;">
    			<div class="checkbox-wrapper" style="width: 138px;">
				    <input class="checkbox_des_v1" type="checkbox" id="add" value="add" name="option[]" ';
				    echo in_array('add', $option)?"checked":'';
				    echo '>
				    <label for="add" class="checkbox-label" style="float: left;"></label>
				    <span class="checkbox-label" style="padding-left:15px">Add</span>
				  </div>
    		</div>
    	</div>

    	<div class="col-md-2">
    		<div class="form-group" style="margin-top: 30px;">
    			<div class="checkbox-wrapper" style="width: 138px;">
				    <input class="checkbox_des_v1" type="checkbox" id="edit" value="edit" name="option[]" ';
				    echo in_array('edit', $option)?"checked":'';
				    echo '>
				    <label for="edit" class="checkbox-label" style="float: left;"></label>
				    <span class="checkbox-label" style="padding-left:15px">Edit</span>
				  </div>
    		</div>
    	</div>


    	<div class="col-md-2">
    		<div class="form-group" style="margin-top: 30px;">
    			<div class="checkbox-wrapper" style="width: 138px;">
				    <input class="checkbox_des_v1" type="checkbox" id="delete" value="delete" name="option[]" ';
				    echo in_array('delete', $option)?"checked":'';
				    echo '>
				    <label for="delete" class="checkbox-label" style="float: left;"></label>
				    <span class="checkbox-label" style="padding-left:15px">Delete</span>
				  </div>
    		</div>
    	</div>


    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="primary-outline-btn" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="primary-btn" value="'.$id.'" name="save">Save</button>
  </div></form>';
}















