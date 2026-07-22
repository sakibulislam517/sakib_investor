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
   echo $db->input(['name'=>'commission','col'=>3,'title' =>'Commission','value'=>$db->ar2v($ar,'commission')]);
   echo $db->input(['name'=>'address','col'=>6,'title' =>'Address','value'=>$db->ar2v($ar,'address')]);

   echo '</div></div>';
   echo $db->modal_footer($db->rpv('id'));
}




if (isset($_GET['view_member'])) {
    $nominee = false;
	if (isset($_POST['id'])) {
		$ar = $db->getFull('member','*',' and id ='.$_POST['id'])[0];
		$nominee = json_decode($ar['nominee_info'],true);
	}
	$shares = @$ar['shares']>0?@$ar['shares']:1;
    ?>
	<style>
		.modal-dialog {
    	    max-width: 810px;
    	}
    	@media screen {
    	    .dnone {
    	        display: none;
    	    }
    	}
	</style>
    <div class="modal-header">
        <h5 class="modal-title">Member Information</h5>
        <button type="button" class="fas fa-times close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

    <div id="printArea">
      <div class="modal-body">
          
        <?php $settings = $db->getAll('settings'); 
        
        $per_share = $db->share_info()['per_share'];
        $member_fee = $db->share_info()['member_fee'];
        
        ?>
<style>
.member-print {
    max-width: 800px;
    min-height: 95vh;
    margin: auto;
    border: 2px solid #000;
    padding: 20px;
    font-family: 'SolaimanLipi', 'Kalpurush', Arial;
    font-size: 14px;
}
.member-print h4, .member-print h5 {
    text-align: center;
    font-weight: bold;
}
.print-row {
    display: flex;
    margin-bottom: 8px;
}
.print-label {
    width: 220px;
    font-weight: bold;
}
.print-value {
    border-bottom: 1px dotted #000;
    flex: 1;
}
.photo-box {
    width: 120px;
    height: 140px;
    border: 1px solid #000;
    overflow: hidden;
}
.logo-box {
    width: 100px;
    height: 100px;
    overflow: hidden;
    margin-top: 15px;
}
@media print {
    .no-print { display: none; }
}
</style>
<div class="member-print">

  <!-- TOP INFO -->
  <div class="d-flex justify-content-between mb-3">
    <div class="logo-box">
      <!--<img src="<?php echo domain; ?>images/member/<?php echo $ar['img']; ?>" class="img-fluid border" style="width: 100%;height: 100%;object-fit: cover;">-->
    </div>
    <div>
      <div class="text-center mb-3">
        <p class="mb-1">বিসমিল্লাহির রাহমানির রাহিম</p>
        <h4 class="mb-0"><?php echo $settings['company_name']; ?></h4>
        <p><?php echo $settings['address']; ?></p>
        <h5 style="border:2px solid #000;display:inline-block;padding:5px 20px;">
          সদস্য ফরম
        </h5>
        <p>সদস্য নং : <?php echo $ar['cus_id']; ?></p>
      </div>
    </div>
    <div class="photo-box">
      <img src="<?php echo domain; ?>images/member/<?php echo $ar['img']; ?>" class="img-fluid border" style="width: 100%;height: 100%;object-fit: cover;">
    </div>
  </div>

  <!-- MEMBER INFO -->
  <div class="print-row">
    <div class="print-label">কোম্পানি নাম</div>
    <div class="print-value"><?php echo $ar['company_name']; ?></div>
  </div>
  <div class="print-row">
    <div class="print-label">সদস্যের নাম</div>
    <div class="print-value"><?php echo $ar['name']; ?></div>
  </div>
  

  <div class="print-row">
    <div class="print-label">পিতার নাম</div>
    <div class="print-value"><?php echo $ar['father_name']; ?></div>
  </div>

  <div class="print-row">
    <div class="print-label">মাতার নাম</div>
    <div class="print-value"><?php echo $ar['mother_name']; ?></div>
  </div>

  <div class="print-row">
    <div class="print-label">স্থায়ী ঠিকানা</div>
    <div class="print-value"><?php echo $ar['address']; ?></div>
  </div>

  <div class="print-row">
    <div class="print-label">মোবাইল নাম্বার</div>
    <div class="print-value"><?php echo $ar['number']; ?></div>
  </div>

  <div class="print-row">
    <div class="print-label">জাতীয় পরিচয়পত্র / জন্ম সনদ নং</div>
    <div class="print-value"><?php echo $ar['nid_number']; ?></div>
  </div>

  <div class="print-row">
    <div class="print-label">শেয়ার সংখ্যা</div>
    <div class="print-value"><?php echo $shares; ?></div>
  </div>
  <div class="print-row">
    <div class="print-label">শেয়ারের পরিমান</div>
    <div class="print-value"><?php echo $shares*$per_share; ?></div>
  </div>
  <div class="print-row">
    <div class="print-label">অর্ধ-বার্ষিক পরিমাণ</div>
    <div class="print-value"><?php echo $member_fee; ?></div>
  </div>

    <?php
    if ($nominee) {
        echo '<h5 class="mt-4 text-center">নমিনী সংক্রান্ত তথ্য</h5>';
        foreach ($nominee as $nom) {
    ?>

  <div class="print-row">
    <div class="print-label">নমিনীর নাম</div>
    <div class="print-value"><?php echo $nom['name']; ?></div>
  </div>

  <div class="print-row">
    <div class="print-label">নমিনীর মোবাইল</div>
    <div class="print-value"><?php echo $nom['number']; ?></div>
  </div>

  <div class="print-row">
    <div class="print-label">নমিনীর NID/Birth No</div>
    <div class="print-value"><?php echo $nom['nid']; ?></div>
  </div>

  <div class="print-row">
    <div class="print-label">জন্ম তারিখ</div>
    <div class="print-value"><?php echo $nom['birth_date']; ?></div>
  </div>
  
  <hr/>
  
  <?php } } ?>

  <!-- SIGNATURE -->
  <div class="d-flex justify-content-between mt-5">
    <div>
      <p>তারিখঃ .....................</p>
    </div>
    <div class="text-center">
      <p>আবেদনকারীর স্বাক্ষর</p>
      <p><img src="<?php echo domain; ?>images/member/<?php echo $ar['signature']; ?>" class="img-fluid border" style="width: 100%;height: 100%;object-fit: cover;max-width: 80px;max-height: 80px;"></p>
      <p>___________________</p>
    </div>
  </div>

  <!-- OFFICE USE -->
  <hr>
  <p class="text-center"><strong>[ অফিস কর্তৃক পূরণীয় ]</strong></p>

  <div class="d-flex justify-content-between mt-4">
    <div class="text-center">
      <p>পরিচালক / কোষাধ্যক্ষ</p>
      <p>________________</p>
    </div>
    <div class="text-center">
      <p>সভাপতি / সাধারণ সম্পাদক</p>
      <p>________________</p>
    </div>
  </div>

</div>



        <?php if (1 == 1) { ?>
        <div class="no-print others_info">
        <div class="card shadow-sm mb-4  ">
            <div class="card-header bg-light">
                <h6 class="mb-0 text-primary"><i class="bi bi-person-badge me-2"></i>Member Information</h6>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <span class="text-muted d-block small uppercase">Current Status</span>
                            <?php echo $ar['status'] == 1 
                                ? '<span class="badge rounded-pill bg-success px-3">Active</span>' 
                                : '<span class="badge rounded-pill bg-danger px-3">Inactive</span>'; ?>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <p class="mb-1 fw-bold small text-muted">NID/Birth Photo</p>
                        <img src="<?php echo domain; ?>images/member/<?php echo $ar['nid']; ?>" 
                             class="img-fluid rounded border shadow-sm" 
                             style="max-height:120px; width: auto;" 
                             alt="Member NID">
                    </div>
                </div>
            </div>
        </div>
        
        <?php
        if ($nominee) {
            echo '<h5 class="mb-3 mt-4 text-secondary border-bottom pb-2">Nominee Details</h5>';
            foreach ($nominee as $nom) {
        ?>
            <div class="card shadow-sm mb-3 border-start border-primary border-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <small class="text-muted d-block">Full Name</small>
                                    <span class="fw-bold"><?php echo $nom['name']; ?></span>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="text-muted d-block">Contact Number</small>
                                    <span><?php echo $nom['number']; ?></span>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="text-muted d-block">NID/Birth No.</small>
                                    <code class="text-dark"><?php echo $nom['nid']; ?></code>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="text-muted d-block">Date of Birth</small>
                                    <span><?php echo $nom['birth_date']; ?></span>
                                </div>
                            </div>
                        </div>
        
                        <div class="col-md-3 text-center">
                            <small class="text-muted d-block mb-1">Nominee Photo</small>
                            <img src="<?php echo domain; ?>images/nominee/<?php echo $nom['photo']; ?>" 
                                 class="img-thumbnail shadow-sm" 
                                 style="height:100px; width:100px; object-fit: cover;">
                        </div>
                        <div class="col-md-3 text-center">
                            <small class="text-muted d-block mb-1">Document Photo</small>
                            <img src="<?php echo domain; ?>images/nominee/<?php echo $nom['nid_photo']; ?>" 
                                 class="img-thumbnail shadow-sm" 
                                 style="height:100px; width:100px; object-fit: cover;">
                        </div>
                    </div>
                </div>
            </div>
        <?php 
            }
        } ?>
        </div>
        
        <?php }?>

      </div>
     </div>

      <div class="modal-footer">
        <button type="button" class="primary-outline-btn" data-bs-dismiss="modal">Close</button>
        <button type="button" class="primary-btn" onclick="openPrintView()">Print</button>
      </div>
      
<script>
function openPrintView() {

    const printArea = document.getElementById('printArea');
    if (!printArea) {
        alert('Print area not found');
        return;
    }

    const win = window.open('about:blank', '_blank');
    if (!win) {
        alert('Popup blocked! Allow popup.');
        return;
    }

    win.document.open();
    win.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Member Print View</title>
            <link rel="stylesheet"
              href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
            <style>
                body { padding: 20px; }
                img { max-width: 100%; }
                .others_info{display: none;}
                .no-print { margin-bottom: 15px; }
                @media print {
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>

            <div class="no-print text-end">
                <button class="btn btn-primary" onclick="window.print()">Print</button>
                <button class="btn btn-danger" onclick="window.close()">Close</button>
            </div>

            ${printArea.innerHTML}
            
        </body>
        </html>
    `);
    win.document.close();
}
</script>




    <?php 
}





if (isset($_GET['generate_payable'])) {

	echo '
	<style>
		.modal-dialog {
	    max-width: 650px;
	}
	</style>
	<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Generate Payable</h1>
    <button type="button" class="fas fa-times close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <form method="post" class="needs-validation">
  <div class="modal-body">
    <div class="row">
    	<div class="col-md-3">
    		<div class="form-group">
    			<label for="date">Payable Type</label>
    			<select class="payable_type" name="payable_type" onchange="show_typs(this.value)">';
    			foreach ($db->payable_type() as $key => $v) {
    				echo '<option value="'.$v.'">'.ucwords($v).'</option>';
    			}
    			echo '</select>
    		</div>
    	</div>
    	<div class="col-md-3">
    		<div class="form-group show_type_info">
    			
    		</div>
    	</div>
    	<div class="col-md-6 remarks_area" style="display:none;">
    		<div class="form-group">
    			<label for="remarks">Remarks</label>
    			<input type="text" name="remarks" placeholder="Remarks">
    		</div>
    	</div>
    	
    	<div class="col-md-12">
    		<div class="form-group">
    			<table class="table-bordered table">
    				<tr>
    					<th class="text-center"><input type="checkbox" style="width: 25px;height: 25px;margin:0 auto;" onclick="checkall(this)"></th>
    					<th>Member Name</th>
    					<th>Share</th>
    					<th>Amount</th>
    				</tr>
    				<tbody class="show_interest"></tbody>
    			</table>
    		</div>
    	</div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="primary-outline-btn" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="primary-btn" value="" name="save">Save</button>
  </div></form>';
  ?>
  <script type="text/javascript">
  	function show_interests() {
  		bil_month = $('#bil_month').val()
  		payable_type = $('.payable_type').val()
  		ajax_post('<?php echo domain;?>control.php?show_payable_month='+bil_month+'&payable_type='+payable_type,'','.show_interest');
  	}
  	function show_typs(v) {
  		$('.show_type_info').parent().attr('class','col-md-5')
  		$('.remarks_area').fadeOut()
  		if (v == 'monthly') {
  			$('.show_type_info').html(`
  			    <div style="display:flex">
      			    <div>
          				<label for="bil_month">Month</label>
            			<input type="month" id="bil_month" name="bil_month" onchange="show_interests()">
        			</div>
        			<div>
            			<label for="others_amount">Amount</label>
            			<input type="text" id="others_amount" name="others_amount" onchange="show_interests()" style="width:150px" placeholder="0.00" value="" required>
        			</div>
    			</div>
  			`)
  		}else if (v == 'others') {
  			$('.show_type_info').parent().attr('class','col-md-3')
  			$('.remarks_area').fadeIn()
  			$('.show_type_info').html(`
  				<label for="others_amount">Amount</label>
    			<input type="text" id="others_amount" name="others_amount" onchange="show_interests()" value="">
  			`)
  		}else if (v == 'yearly') {
  			$('.show_type_info').html(`
  				<label for="bil_month">Yearly</label>
    			<select onchange="show_interests()" name="bil_month" id="bil_month">
    			<?php
    			echo '<option value="">Select</option>';
    			for ($i=date('Y'); $i < date('Y')+2; $i++) { 
    				echo '<option value="'.$i.'">'.$i.'</option>';
    			}
    			?>
    			</select>
  			`)
  		}
  	}

  	function checkall(e) {
  		if (e.checked) {
  			$('.bill_item').prop('checked',true)
  		}else{
  			$('.bill_item').prop('checked',false)
  		}
  	}
  	$('.payable_type').change()
  </script>
  <?php 
}

if (isset($_GET['show_payable_month'])) {
	$month = $_GET['show_payable_month'];
	$payable_type = $_GET['payable_type'];

	$sql = 'select * from ledger where type = "generate"';
	if ($payable_type == 'monthly') {
		$sql .= " and month = '".$month."' and generate_type = 'monthly'";
	}elseif ($payable_type == 'yearly') {
		$sql .= " and month = '".$month."' and generate_type = 'yearly'";
	}

	if ($payable_type == 'others') {
		$month_data = [];
	}else{
		$month_data = $db->set_key($db->getdata($sql),'member_id');
	}
	



	$per_share = $db->share_info()['per_share'];

	$sql = 'select * from member where status = 1';
		$html = '';
		$sl = 1;
	foreach ($db->getdata($sql) as $key => $v) {
		if (!isset($month_data[$v['id']])) {
			$html .= '<tr>
					<th>
						<input type="checkbox" class="bill_item" name="member_id[]" value="'.$v['id'].'" id="member_id'.$v['id'].'" style="width: 25px;height: 25px;float: left;">
						<label style="padding-top: 3px;" for="member_id'.$v['id'].'">'.($sl++).'</label>
					</th>
					<td class="text-left">'.$v['name'].'</td>	        
					<td class="text-center">'.$v['shares'].'</td>	        
	        <td class="text-center">'.$db->nf($v['shares']*$per_share).'</td>
				</tr>';
		}
	}
	if ($html != '') {
		echo $html;
	}else{
		echo '<tr><th colspan="4" class="text-center">No data found</th></tr>';
	}
	
}



if (isset($_GET['collection'])) {
	$cdate = $db->cdate();
	if (isset($_POST['id'])) {
		$ar = $db->getFull('ledger','*',' and id ='.$_POST['id'])[0];
		$cdate = $ar['cdate'];
	}
	if($db->is_mem_login()){
	    @$ar['member_id'] = $db->mem_id();
	}
	echo '
	<style>
		.modal-dialog {
	    max-width: 700px;
		}
	</style>
	<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">'.($db->is_mem_login()?'Payment':'Collection').'</h1>
    <button type="button" class="fas fa-times close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <form method="post" enctype="multipart/form-data">
  <div class="modal-body">
    <div class="row">
    	<div class="col-md-6">
    		<div class="form-group">
    			<label for="name">Member Name</label>
    			<select name="member_id" required class="form-fcontrol member_id select2" onchange="show_member_info(this.value)">
    				<option value="">Select</option>';
    					foreach ($db->getFull('member','*'," and status = 1".($db->mem_id()>0?' and id ='.$db->mem_id():'')) as $key => $value) {
    						echo '<option value="'.$value['id'].'" ';
    						echo @$ar['member_id']==$value['id']?'selected':'';
    						echo '>'.$value['name'].' ('.$value['cus_id'].')</option>';
    					}

    			  echo '</select>
    		</div>
    	</div>

    	<div class="col-md-6">
    		<div class="form-group">
    			<label for="name">Total Payable (Generate)</label>
    			<input type="text" readonly class="total_gen_payable">
    		</div>
    	</div>
    	<div class="col-md-4">
    		<div class="form-group">
    			<label for="name">Total Paid</label>
    			<input type="text" readonly class="payable_paid">
    		</div>
    	</div>
    	<div class="col-md-4">
    		<div class="form-group">
    			<label for="name">Total Due</label>
    			<input type="text" readonly class="payable_due">
    		</div>
    	</div>

    	
    	<div class="col-md-4">
    		<div class="form-group">
    			<label for="name">Date</label>
    			<input type="date" name="cdate" value="" max="'.$db->cdate().'" required>
    		</div>
    	</div>

    	<div class="col-md-4">
    		<div class="form-group">
    			<label for="name">Bill</label>
    			<select class="billing_month" name="month" id="due_billing_month" required onchange="set_bill_amount()"></select>
    		</div>
    	</div>
    	<div class="col-md-4">
    		<div class="form-group">
    			<label for="name">'.($db->is_mem_login()?'Payment':'Collection').' Method</label>
    			<select name="method_id" required>
    				<option value="">Select</option>
    				'.$db->get_method_option('',' and id != 9').'
    			</select>
    		</div>
    	</div>
    	<div class="col-md-4">
    		<div class="form-group">
    			<label for="name">'.($db->is_mem_login()?'Payment':'Collection').' Amount</label>
    			<input type="text" name="amount" id="due_amount" placeholder="0.00" required>
    		</div>
    	</div>

    	<div class="col-md-7">
    		<div class="form-group">
    			<label for="name">Remark</label>
    			<input type="text" name="remarks">
    		</div>
    	</div>
        <div class="col-md-5">
    		<div class="form-group">
    			<label for="img">Image</label>
    			<input type="file" style="padding: 6px 10px;" name="img" id="img"/>
    		</div>
    	</div>


 
    	</div>
    
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="primary-outline-btn" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="primary-btn form-btn" value="'.$id.'" name="save">Save</button>
  </div></form>';?>
  <script type="text/javascript">
  	setTimeout(function(argument) {
  		$('.select2').select2({dropdownParent: $('#modal_id')});
  	},300)
  	function set_bill_amount() {
  		amount = $('#due_billing_month option:selected').attr('data-amount')
  		$('#due_amount').val(amount)
  	}
  	function show_member_info(v) {
  		$.post('<?php echo domain;?>control.php?show_member_info='+v,'', function (data, status) {
	      json = JSON.parse(data)
	      gen = Number(json.gen);
	      pay = Number(json.pay);
	      due = gen - pay;
	      $('.total_gen_payable').val(nf(gen))
	      $('.payable_paid').val(nf(pay))
	      $('.payable_due').val(nf(due))
	      $('.billing_month').html(json.month)
	      set_bill_amount()
	    });
  	}
  	
    <?php if($db->is_mem_login()){?>
    show_member_info(<?php echo $db->mem_id();?>);
    <?php }?>

  </script>

  <?php 
}

if(isset($_GET['show_member_info'])){
	$member_id = $_GET['show_member_info'];
	$pay = $gen = '';
	foreach ($db->getdata('select sum(if(type="generate",amount,0)) as gen,sum(if(type="collection",amount,0)) as pay from ledger where member_id ='.$member_id) as $key => $v) {
		 $gen = $v['gen'];
		 $pay = $v['pay'];
	}

	$month_data = '';
	foreach ($db->getdata('select *,sum(if(type="generate",amount,-amount)) as b from ledger where member_id ='.$member_id.' group by month having b > 0') as $key => $v) {
		$month = $v['generate_type']=='monthly'?date('Y M',strtotime($v['month'])):$v['month'];
		$month_data .= '<option value="'.$v['month'].'}'.$v['generate_type'].'" data-amount="'.$v['b'].'">'.$month.'</option>';
	}

	echo json_encode(['gen'=>$gen,'pay'=>$pay,'month'=>$month_data]);
}



if (isset($_GET['invest_collection'])) {
	$cdate = $db->cdate();
	if (isset($_POST['id'])) {
		$ar = $db->getFull('ledger','*',' and id ='.$_POST['id'])[0];
		$cdate = $ar['cdate'];
	}
	echo '
	<style>
		.modal-dialog {
	    max-width: 700px;
		}
	</style>
	<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Collection</h1>
    <button type="button" class="fas fa-times close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <form method="post" enctype="multipart/form-data">
  <div class="modal-body">
    <div class="row">
    	<div class="col-md-6">
    		<div class="form-group">
    			<label for="name">Investor</label>
    			<input type="hidden" name="col_type" value="invest">
    			<select name="investor_id" required class="form-fcontrol investor_id select2" onchange="show_investor_info(this.value)">
    				<option value="">Select</option>';
    					foreach ($db->getFull('investment','*'," and status = 1") as $key => $value) {
    						echo '<option value="'.$value['id'].'" ';
    						echo @$ar['investor_id']==$value['id']?'selected':'';
    						echo '>'.$value['title'].' '.$value['investor_id'].'</option>';
    					}

    			  echo '</select>
    		</div>
    	</div>

    	<div class="col-md-6">
    		<div class="form-group">
    			<label for="name">Total Payable (Generate)</label>
    			<input type="text" readonly class="total_gen_payable">
    		</div>
    	</div>
    	<div class="col-md-4">
    		<div class="form-group">
    			<label for="name">Total Paid</label>
    			<input type="text" readonly class="payable_paid">
    		</div>
    	</div>
    	<div class="col-md-4">
    		<div class="form-group">
    			<label for="name">Total Due</label>
    			<input type="text" readonly class="payable_due">
    		</div>
    	</div>

    	
    	<div class="col-md-4">
    		<div class="form-group">
    			<label for="name">Date</label>
    			<input type="date" name="cdate" value="" max="'.$db->cdate().'" min="'.date('Y-m-d',strtotime('-7 days')).'" required>
    		</div>
    	</div>

    	<div class="col-md-4">
    		<div class="form-group">
    			<label for="name">Installment Amount</label>
    			<input type="text" readonly class="installment">
    		</div>
    	</div>

    	
    	<div class="col-md-4">
    		<div class="form-group">
    			<label for="name">Collection Method</label>
    			<select name="method" required>
    				<option value="">Select</option>
    				<option value="Cash">Cash</option>
    				<option value="Bank">Bank</option>
    				<option value="Bkash">Bkash</option>
    			</select>
    		</div>
    	</div>
    	<div class="col-md-4">
    		<div class="form-group">
    			<label for="name">Collection Amount</label>
    			<input type="text" name="amount" id="due_amount" placeholder="0.00" required>
    		</div>
    	</div>

    	<div class="col-md-12">
    		<div class="form-group">
    			<label for="name">Remark</label>
    			<textarea name="remarks"></textarea>
    		</div>
    	</div>



 
    	</div>
    
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="primary-outline-btn" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="primary-btn form-btn" value="'.$id.'" name="save">Save</button>
  </div></form>';?>
  <script type="text/javascript">
  	setTimeout(function(argument) {
  		$('.select2').select2({dropdownParent: $('#modal_id')});
  	},300)
  	function set_bill_amount() {
  		amount = $('#due_billing_month option:selected').attr('data-amount')
  		$('#due_amount').val(amount)
  	}
  	function show_investor_info(v) {
  		$.post('<?php echo domain;?>control.php?show_investor_info='+v,'', function (data, status) {
	      json = JSON.parse(data)
	      gen = Number(json.payable_amount);
	      pay = Number(json.pay);
	      installment = Number(json.installment);
	      due = gen - pay;
	      $('.total_gen_payable').val(nf(gen))
	      $('.payable_paid').val(nf(pay))
	      $('.payable_due').val(nf(due))
	      $('.installment').val(nf(installment))
	      set_bill_amount()
	    });
  	}


  </script>

  <?php 
}

if(isset($_GET['show_investor_info'])){
	$investor_id = $_GET['show_investor_info'];
	foreach ($db->getdata('select * from investment where id ='.$investor_id) as $key => $v) {
		$pay = $db->getdata('select sum(amount) as t from ledger where investor_id ='.$v['id'])[0]['t'];
		echo json_encode(['payable_amount'=>$v['payable_amount']+$v['profit_rate'],'installment'=>$v['installment_amount'],'pay'=>$pay]);
	}
	
}

if (isset($_GET['create_expense_ledger'])) {
	$id = $name = $type = '';
	if (isset($_POST['id'])) {
		foreach ($db->getFull('expense_ledger','*',' and id ='.$_POST['id']) as $key => $v) {
			$id = $v['id'];
			$name = $v['name'];
			$type = $v['type'];
		}
	}
	echo '
	<style>
		.modal-dialog {
	    max-width: 650px;
	}
	</style>
	<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Expense Ledger</h1>
    <button type="button" class="fas fa-times close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <form method="post" class="needs-validation">
  <div class="modal-body">
    <div class="row">
    	<div class="col-md-8">
    		<div class="form-group">
    			<label for="name">Name</label>
    			<input type="text" name="name" id="name" value="'.$name.'" required/>
    		</div>
    	</div>
    	<div class="col-md-4">
    		<div class="form-group">
    			<label for="name">Type</label>
    			<select name="type">
  					<option value="general">General</option>
  					<option value="invest" '.($type == 'invest'?'selected':'').'>Investment</option>
  				</select>
    		</div>
    	</div>
    	
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="primary-outline-btn" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="primary-btn" value="'.$id.'" name="save">Save</button>
  </div></form>';
}

if (isset($_GET['create_payment_acc'])) {
	$id = $name = $number = $payment_method = '';
	if (isset($_POST['id'])) {
		foreach ($db->getFull('payment_account','*',' and id ='.$_POST['id']) as $key => $v) {
			$id = $v['id'];
			$name = $v['name'];
			$payment_method = $v['payment_method'];
		}
	}
	echo '
	<style>
		.modal-dialog {
	    max-width: 650px;
	}
	</style>
	<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Payment Organization</h1>
    <button type="button" class="fas fa-times close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <form method="post" class="needs-validation">
  <div class="modal-body">
    <div class="row">
    	<div class="col-md-6">
    		<div class="form-group">
    			<label for="name">Payment Method</label>
    			<select name="payment_method" required class="form-fcontrol payment_method">
    				<option value="">Select</option>';
    					$address = $contact = '';
    					foreach ($db->method_list() as $key => $value) {
    						echo '<option value="'.$key.'" ';
    						if ($key == $payment_method) {
    							echo 'selected';
    						}
    						echo ' >'.$value.'</option>';
    					}

    			  echo '</select>
    		</div>
    	</div>
    	<div class="col-md-6">
    		<div class="form-group">
    			<label for="name">Organization Name</label>
    			<input type="text" name="name" id="name" value="'.$name.'" required/>
    		</div>
    	</div>

    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="primary-outline-btn" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="primary-btn" value="'.$id.'" name="save">Save</button>
  </div></form>';
}





if (isset($_GET['payment'])) {
	$cdate = $db->cdate();

	echo '
	<style>
		.modal-dialog {
	    max-width: 700px;
		}
	</style>
	<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Payment</h1>
    <button type="button" class="fas fa-times close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <form method="post" enctype="multipart/form-data">
  <div class="modal-body">
    <div class="row">
    	<div class="col-md-4">
    		<div class="form-group">
    			<label for="name">Expense Ledger</label>
    			<select name="expense_ledger_id" required class="form-fcontrol">
    				<option value="">Select</option>';
    					foreach ($db->getFull('expense_ledger','*') as $key => $value) {
    						echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
    					}

    			  echo '</select>
    		</div>
    	</div>


    	<div class="col-md-4">
    		<div class="form-group">
    			<label for="name">Date</label>
    			<input type="date" name="cdate" value="'.$cdate.'" max="'.$db->cdate().'" min="'.date('Y-m-d',strtotime('-5 days')).'" required>
    		</div>
    	</div>

    	<div class="col-md-4">
    		<div class="form-group">
    			<label for="name">Payment Amount</label>
    			<input type="text" name="amount" placeholder="0.00" required>
    		</div>
    	</div>
        <div class="col-md-4">
    		<div class="form-group">
    			<label for="name">Payment Method</label>
    			<select name="method_id" required>
    				<option value="">Select</option>
    				'.$db->get_method_option().'
    			</select>
    		</div>
    	</div>
    	<div class="col-md-8">
    		<div class="form-group">
    			<label for="name">Remark</label>
    			<input type="text" name="remarks">
    		</div>
    	</div>



 
    	</div>
    
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="primary-outline-btn" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="primary-btn form-btn" value="'.$id.'" name="save">Save</button>
  </div></form>';?>
  <script type="text/javascript">
  	function show_member_info(v) {
  		$.post('<?php echo domain;?>control.php?show_member_info='+v,'', function (data, status) {
	      json = JSON.parse(data)
	      gen = Number(json.gen);
	      pay = Number(json.pay);
	      due = gen - pay;
	      $('.total_gen_payable').val(nf(gen))
	      $('.payable_paid').val(nf(pay))
	      $('.payable_due').val(nf(due))
	      $('.billing_month').html(json.month)

	    });
  	}


  </script>

  <?php 
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


if (isset($_GET['view_loan'])) {

	$sql = 'select a.*,
b.name as lessor_name,b.cus_id as less_cus,b.address,b.number,
a.cus_id as loan_id
from loan a
inner join lessor b on b.id = a.lessor_id
where a.type = "loan" and a.id ='.$_GET['view_loan'];
$ar = $db->getdata($sql);
	foreach ($ar as $key => $v) {
		$loan_id = $db->get_loan_id($v);
		$date = $db->setdate($v['cdate']);
$pdf_417 = "
Loand ID : $loan_id
Date : $date
Loan Amount : $v[amount]
Interest : $v[interest]
Lessor : $v[lessor_name]
Contact No : $v[number]

";
	echo '


  <div class="modal-body" id="print_area">
    <div style="width:100%;overflow:hidden;">
    		<style>
					.modal-dialog {
				    max-width: 650px;
				}
				.left{
					float:left !important;
				}
				.right{
					float:right !important;
				}
				.loan_vcontent{
					width:49%;

			    overflow:hidden;
				}
				.border_des{
					border: 1px solid #5f5b5b87;
			    padding: 5px 12px;
			    width: 180px;
			    border-radius: 3px;
				}
				.loan_vcontent p{
					margin-bottom:5px;
					float:left;
				}
				.mr-5{
					margin-right:10px;
				}
				.mt-5{
					margin-top:10px;
				}
				.tit{
					padding-top:5px;
				}
				.text-center{
					text-align:center;
				}
				p{
					margin:5px 0 4px 5px!important;
				}
				</style>
    	<div style="width:100%;overflow:hidden;">
    		<img src="'.domain.'images/logo/logo.png" style="max-height: 70px;margin: 0 auto;display: block;float:left;">
    		<img src="'.domain.'bercode.php?text='.$loan_id.'&size=50&print=true&sizefactor=.8" style="max-height: 70px;margin: 0 auto;display: block;float:right;">
    	</div>
    	<div style="width:100%;overflow:hidden;">
    		<h4 style="margin:15px 0;text-align:center;">Loan Acknowlegdement Slip</h3>
    	</div>



    	<div class="loan_vcontent left">
  			<p class="tit">Lessor Name</p>
  			<p class="border_des right">'.$v['lessor_name'].'</p>
  		</div>
  		<div class="loan_vcontent right">
	  		<p class="border_des right text-center">'.$db->get_cus_id($v['less_cus']).'</p>
	  		<p class="right mr-5 tit">Lessor ID</p>
  		</div>

  		<div class="loan_vcontent right">
	  		<p class="border_des right text-center">'.$db->setdate($v['cdate']).'</p>
	  		<p class="right mr-5 tit">Loan Date</p>
  		</div>

  		<div class="loan_vcontent left">
  			<p class="tit">Address</p>
  			<p class="border_des right" style="padding:6px 13px 25px;min-height:75px;">'.$v['address'].'</p>
  		</div>
  		<div class="loan_vcontent right">
  			<p class="border_des right text-center">'.$db->nf($v['amount']).'</p>
  			<p class="right mr-5 tit">Loan Amount</p>
  		</div>

  		<div class="loan_vcontent right">
  			<p class="border_des right text-center">'.$db->nf($v['interest']).'</p>
  			<p class="right mr-5 tit">Monthly Interest</p>
  		</div>

  		<div style="width: 100%;overflow: hidden;">
	  		<div class="loan_vcontent left">
	  			<p class="tit">Contact No</p>
	  			<p class="border_des right">'.$v['number'].'</p>
	  		</div>
  		</div>
  		<div style="width: 100%;overflow: hidden;">
	  		<div class="loan_vcontent left" style="width: 100%;">
	  			<p class="tit">In Words</p>
	  			<p class="border_des right inword" style="width: 80%;">'.ucwords($db->convertNumberToWord($v['amount'])).' Taka Only</p>
	  		</div>
  		</div>

  		<div style="width:100%;overflow:hidden;">
    		<table class="table table-bordered">
    			<tr>
    				<th>SL</th>
    				<th>Nominee Name</th>
    				<th>Relation</th>
    				<th>Percentage</th>
    				<th>Photo</th>
    			</tr>
    			<tbody class="show_rows">';
    				$relation = $db->relation_list();
    				$sl = 1;
	    					$nominee_info_ar = json_decode($v['nominee_info'],true);
	    					if (isset($nominee_info_ar['nominee_name'])) {
	    						foreach ($nominee_info_ar['nominee_name'] as $key => $v) {
	    							if ($nominee_info_ar['img'][$key] != '') {
	    								$img = '<img src="images/other/'.$nominee_info_ar['img'][$key].'" style="height: 30px;">';
	    							}
		    						echo '<tr>
					  				<td class="text-center">'.$sl++.'</td>
					  				<td>'.$nominee_info_ar['nominee_name'][$key].'</td>
					  				<td style="text-align:center;">'.$nominee_info_ar['relation'][$key].'</td>
					  				<td style="text-align:center;">'.$nominee_info_ar['percentage'][$key].'</td>
					  				<td style="padding: 0!important;text-align: center;">'.$img.'</td>

					  			</tr>';
		    					}
	    					}
	    					
    				echo '</tbody>
    		</table>
    	</div>
    	<div style="width:100%;overflow:hidden;display:flex;justify-content: space-between;align-items: center;margin-top:80px">
    		<div><p style="border-top:1px solid;">Signature of Lessor</p></div>
    		<div><img style="width:240px;height:48px;" src="'.$db->send_post(domain.'417/show_417.php',['content'=>$pdf_417]).'"></div>
    		<div><p style="border-top:1px solid;">Authorized Signature</p></div>
    	</div>

    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="primary-outline-btn" data-bs-dismiss="modal">Close</button>
    <button type="button" class="primary-btn" onclick="print_page(\'print_area\',\'.inword{width:77%!important}\')">Print</button>
  </div>';

	}


}





if (isset($_GET['view_ipay'])) {


$sql = 'select a.*,sum(a.amount) as total,b.name,b.cus_id
from ledger a
inner join member b on b.id = a.member_id
where a.type = "collection" and a.id = '.$_GET['view_ipay'];

$ar = $db->getdata($sql);
	foreach ($ar as $key => $v) {
		$member_id = $db->get_cus_id($v['cus_id']);

		
		if ($v['generate_type'] == 'monthly') {
			$particular  = 'The monthly bill for the month of '.date('M Y',strtotime($v['month'])).' has been collected';
		}elseif ($v['generate_type'] == 'yearly') {
			$particular  = 'The yearly bill for the year of '.$v['month'].' has been collected';
		}else{
			$particular  = 'The '.$v['month'].' bill has been collected';
		}

		


	echo '
  <div class="modal-body" id="print_area">
  <style>
		.modal-dialog {
	    max-width: 750px;
	}
	
	</style>





<div style="overflow:hidden;padding:15px 20px 15px 40px;background:#fff;">
	<div style="overflow:hidden;">
		<div style="overflow:hidden;background:#fff !important;" class="dynamic_header_area">
		  <div style="overflow:hidden;background:#fff !important">
		      <div style="width: 100%;overflow: hidden;margin-bottom: 0;position: relative;">
		          <img class="" src="'.domain.'images/logo/logo.png" style="float:left;max-height: 60px;">
		      </div>
		  </div>
		</div>
	<h1 style="width: 100%;font-weight: bold;font-size: 25px;text-align: center;margin-bottom: 5px;" class="rv_pv_voucher">Money Receipt</h1>
</div>

	<div style="width: 100%;overflow: hidden;background: #fff;">
	  <div style="width: 100%;overflow: hidden;">
	    <p style="float: left;font-weight: 500;font-size: 20px;">MR. No. : RV'.$db->set_digit($v['group_id'],3).'</p>
	    <p style="float: right;font-size: 20px;font-weight: 500;"><span style="float: left;">Date:</span><span style="width: 180px;display: block;border-bottom: 1px dotted black;float: left;padding-left: 10px;font-weight: 500">'.$db->setdate($v['cdate']).'</span></p>
	  </div>

		<div style="width: 100%;overflow: hidden;margin-bottom: 15px;display: flex;">
	    <p style="font-size: 20px;font-weight: 500;margin: 0;width: 270px;">Received with thanks form : </p>
	    <p style="margin: 0;flex: 200px;border-bottom: 1px dotted;font-weight: 500;font-size: 18px;padding-left: 10px">'.$v['name'].' ('.$member_id.')</p>
	  </div>

	  <div style="width: 100%;overflow: hidden;margin-bottom: 15px;display: flex;">
	    <p style="font-size: 20px;font-weight: 500;margin: 0;width: 125px;">Particular : </p>
	    <p style="margin: 0;flex: 200px;border-bottom: 1px dotted;font-weight: 500;font-size: 18px;padding-left: 10px;"> '.$particular.'</p>
	  </div>

		<div style="width: 100%;overflow: hidden;margin-bottom: 15px;display: flex;">
	    <p style="font-size: 20px;font-weight: 500;margin: 0;width: 110px;">By Cash : </p>
	    <p style="margin: 0;width: 133px;border-bottom: 1px dotted;font-weight: 500;font-size: 18px;padding-left: 10px">'.$db->nf($v['total']).'</p>
	    <p style="margin: 0;width: 84px;font-weight: 500;font-size: 18px;margin-left: 10px;">In Word</p>
	    <p style="margin: 0;flex: 200px;border-bottom: 1px dotted;font-weight: 500;font-size: 18px;padding-left: 20px"> '.ucwords($db->convertNumberToWord($v['total'])).' Tk. Only</p>
	  </div>
	</div>
	<div style="width:100%;margin-top:55px;" class="pinfot">
		<p class="pin2" style="text-align: left;float: left;padding-left: 13px;"><span style="border-top:1px solid black;text-align: left;">Received by</span></p>
		<p class="pin3" style="text-align:right;float: right;text-align: center;margin-right: 9px;"><span style="border-top:1px solid black;">Authorized Signature</span></p>
	</div>
</div>



  </div>
  

  <div class="modal-footer">
    <button type="button" class="primary-outline-btn" data-bs-dismiss="modal">Close</button>
    <button type="button" class="primary-btn" onclick="print_page(\'print_area\',\'.inword{width:77%!important}\')">Print</button>
  </div>';

	}


}


















if (isset($_GET['view_payment_voucher'])) {


$sql = 'select a.*,sum(a.amount) as total,b.name
from ledger a
inner join expense_ledger b on b.id = a.expense_ledger_id
where a.type = "payment" and a.id = '.$_GET['view_payment_voucher'];

$ar = $db->getdata($sql);
	foreach ($ar as $key => $v) {
	echo '
  <div class="modal-body" id="print_area">
  <style>
		.modal-dialog {
	    max-width: 750px;
	}
	
	</style>






<div style="padding: 20px 30px;background: #fff;"><div style="overflow:hidden;">
	<div style="overflow:hidden;background:#fff !important;" class="dynamic_header_area">
    <div style="overflow:hidden;background:#fff !important">
        <div style="width: 100%;overflow: hidden;margin-bottom: 0;position: relative;">
            <img class="" src="'.domain.'images/logo/logo.png" style="float:left;max-height: 60px;">
        </div>
    </div>
</div>

</div>



 
<div style="width: 100%;overflow: hidden;background: #fff;">
  


<div style="width: 100%;overflow: hidden;">
  <div style="width: 60%;float: left;">
    <p style="font-weight: bold;font-size: 20px;margin-top: 5px;">Payment Voucher (Cash)</p>
    <div style="width: 100%;overflow: hidden;">
      <p style="width: 95px;float: left;">Ledger Head : </p><p style="float: right;border-bottom: 2px dotted #725e5e;width: calc(100% - 95px);padding-left: 5px;margin-top: -4px;">'.$v['name'].'</p>
    </div>

    <div style="width: 100%;overflow: hidden;">
      <p style="width: 55px;float: left;">Paid to : </p><p style="float: right;border-bottom: 2px dotted #725e5e;width: calc(100% - 55px);margin-top: 15px;"></p>
    </div>
    <div style="width: 100%;overflow: hidden;">
      <p style="width: 88px;float: left;">Cell number : </p><p style="float: right;border-bottom: 2px dotted #725e5e;width: calc(100% - 88px);margin-top: 15px;"></p>
    </div>
  </div>

  <div style="width: 30%;float: right;">
    <div style="width: 100%;overflow: hidden;">
      <p style="width: 86px;float: left;">Voucher no : </p><p style="float: right;border-bottom: 2px dotted #725e5e;width: calc(100% - 86px);padding-left: 5px;margin-top: -4px;">PV'.$db->set_digit($v['group_id'],3).'</p>
    </div>

    <div style="width: 100%;overflow: hidden;">
      <p style="width: 40px;float: left;">Date : </p><p style="float: right;border-bottom: 2px dotted #725e5e;width: calc(100% - 40px);padding-left: 5px;margin-top: -4px;">'.$db->setdate($v['cdate']).'</p>
    </div>

  </div>







</div>



<table class="table table-bordered" style="width:100% !important;margin-bottom: 0">



<thead>
<tr>
  <th style="text-align: center;">PARTICULARS OF EXPENDITURE</th>
    <th style="text-align: center;">TAKA</th>
</tr>
</thead>

<tbody>
  <tr style="background:#fff;">
    <td style="background:#fff;text-align:left!important;">';
    if (!empty($v['remarks'])) {
    	echo $v['remarks'];
    }else{
    	echo $v['name'];
    }
    echo '</td>
    <td style="text-align:right !important;background:#fff;padding-right:10px!important">'.$db->nf($v['amount']).'</td>
  </tr><tr style="background:#fff;"><th>Total</th><th style="text-align:right !important;background:#fff;padding-right:10px!important">'.$db->nf($v['amount']).'</th>
    </tr><tr style="background: #fff;">
    <td colspan="3"><div style="width: 100%;overflow: hidden;margin: 10px 0;">
      <p style="width: 140px;float: left;margin-bottom: 0">Amount (In words) </p><p style="float: right;border-bottom: 2px dotted #725e5e;width: calc(100% - 140px);padding-left: 15px;margin-top: -4px;margin-bottom: 0;text-align: left;"> '.ucwords($db->convertNumberToWord($v['amount'])).' Tk. Only</p>
    </div></td>
  </tr>


</tbody>

</table>

<table class="table table-bordered" style="width:100% !important">

<tbody><tr style="background: #fff;">
  <td style="width: 33%;">
    <div style="text-align: center;margin: 0 0 7px 0;min-height: 20px;">'.$db->getonecol('name','admin','id',$v['created_by']).'</div>
    <div style="width: 113px;margin: 0 auto;text-align: center;font-weight: 500">Prepared by Accounts Officer</div>
  </td>
  <td style="width: 33%;">
    <div style="text-align: center;margin: 0 0 7px 0;min-height: 20px;"></div>
    <div style="width: 122px;margin: 0 auto;text-align: center;font-weight: 500">Verified by Accounts Manager</div>
  </td>
  <td style="width: 33%;">
    <div style="text-align: center;margin: 0 0 7px 0;min-height: 20px;"></div>
    <div style="width: 113px;margin: 0 auto;text-align: center;font-weight: 500">Approved by Director/MD</div>
  </td>
  <td style="width: 33%;">
    <div style="text-align: center;margin: 0 0 7px 0;min-height: 40px;"></div>
    <div style="width: 113px;margin: 0 auto;text-align: center;font-weight: 500">Received by</div>
  </td>
</tr>
</tbody></table>
</div>






















</div>












  </div>
  

  <div class="modal-footer">
    <button type="button" class="primary-outline-btn" data-bs-dismiss="modal">Close</button>
    <button type="button" class="primary-btn" onclick="print_page(\'print_area\',\'.inword{width:77%!important}\')">Print</button>
  </div>';

	}


}





if (isset($_GET['create_sms_tem'])) {
	if (isset($_POST['id'])) {
		$ar = $db->getFull('sms_tem','*',' and id ='.$_POST['id'])[0];
	}
	echo '
	<style>
		.modal-dialog {
	    max-width: 650px;
	}
	</style>
	<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">SMS Template</h1>
    <button type="button" class="fas fa-times close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  ';?>
  <form method="post" enctype="multipart/form-data">
  <div class="modal-body">
    <div class="row">
    	<div class="col-md-12">
    		<div class="form-group">
    			<label for="title">Template Title</label>
    			<input type="text" name="title" id="title" value="<?php echo @$ar['title'];?>" required/>
    		</div>
    	</div>
    	
    	<div class="col-md-12">
      <div class="form-group">
          <label>Messege</label>
          <button type="button" onclick="set_text('{name}','sms_tem_msg')" class="btn btn-success btn-sm" style="padding: 0 8px;">Name</button>
          <button type="button" onclick="set_text('{company}','sms_tem_msg')" class="btn btn-success btn-sm" style="padding: 0 8px;">Company</button>
          <button type="button" onclick="set_text('{month}','sms_tem_msg')" class="btn btn-primary btn-sm" style="padding: 0 8px;">Month</button>
          <button type="button" onclick="set_text('{member_id}','sms_tem_msg')" class="btn btn-primary btn-sm" style="padding: 0 8px;">Member ID</button>
          <button type="button" onclick="set_text('{due}','sms_tem_msg')" class="btn btn-danger btn-sm" style="padding: 0 8px;">Due</button>
          <button type="button" onclick="set_text('{col_amount}','sms_tem_msg')" class="btn btn-warning btn-sm" style="padding: 0 8px;">Collection Amount</button>
          <textarea required="" name="des" class="sms_tem_msg" id="sms_tem_msg" style="min-height:120px;margin-top: 6px;"><?php echo @$ar['des'];?></textarea>
      </div>
    </div>
    	
    

    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="primary-outline-btn" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="primary-btn" value="<?php echo @$ar['id'];?>" name="save">Save</button>
  </div></form>
<script type="text/javascript">
	function set_text(newtext,id) {
  	var curPos =
	    document.getElementById(id).selectionStart;
	  console.log(curPos);
	  let x = $("#"+id).val();
	  let text_to_insert = newtext;
	  $("#"+id).val(
	  x.slice(0, curPos) + text_to_insert + x.slice(curPos));
	}
</script>

  <?php 
}


if (isset($_GET['show_sms_balance'])) {
	$curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://sms.xylub.com/?api=getBalance',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
    "api_key":"'.$db->sms_api().'"
    }',
    CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Cookie: PHPSESSID=4b4d28e2a236181deb132a771fa024a1'
    ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    $response = json_decode($response,true);
    $b = number_format(@$response['balance'],2);
    echo 'SMS Balance : '.$b;
}

if (isset($_GET['show_sms_member'])) {
	$sql = 'select b.name,b.number,sum(if(a.type = "generate",amount,-amount)) as b,a.member_id,b.cus_id from ledger a  
    inner join member b on b.id = a.member_id
    group by a.member_id order by b.cus_id asc';
   $ar = $db->getdata($sql);
	echo '
	<div class="form-group">
		<table class="table table-bordered">
			<tr>
				<th class="text-center" style="padding:0"><input onclick="checkall(this)" type="checkbox" style="width: 26px;height: 36px;margin: 0 auto;"></th>
				<th>Member Name</th>
				<th>Contact Number</th>
				<th>Due</th>
			</tr>';
			$sl = 1;
			foreach($ar as $key=> $v){
				echo '<tr>
	        <td class="text-center"><input type="checkbox" class="member_list_item" name="number_list[]" value="'.$v['number'].'" id="member_id'.$v['member_id'].'" style="width: 25px;height: 25px;float: left;">
						<label style="padding-top: 3px;" for="member_id'.$v['member_id'].'">'.($sl++).'</label></td>                
	        <td class="text-left">'.$v['name'].' ('.$db->get_cus_id($v['cus_id']).')</td>
	        <td class="text-center">'.$v['number'].'</td>
	        <td class="text-right">'.$db->nf($v['b']).'</td>
	      </tr>';
			}
		echo '</table>
	</div>

	';
}


if(isset($_GET['send_sms'])){
	$sms = $_POST['sms'];
	$mobile = $_POST['mobile'];

	$member_ar = $db->getdata("select * from member where number = '$mobile'")[0];
	$member_id = $member_ar['id'];
	$mobile = str_replace(['-',' '],'',$mobile);

	echo $db->send_sms($mobile,$sms,$member_id);



}



if (isset($_GET['investment'])) {
	$ar = [];
	if (isset($_POST['id'])) {
		$ar = $db->getAll('investment',' and id ='.$_POST['id']);
	}
	echo '
	<style>
		.modal-dialog {
	    max-width: 650px;
	}
	</style>
	<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Investment</h1>
    <button type="button" class="fas fa-times close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <form method="post" class="needs-validation">
  <div class="modal-body">
    <div class="row invest_area">
    	<div class="col-md-2">
    		<div class="form-group">
    			<label for="name">Investor ID</label>
    			<input type="text" name="investor_id" id="investor_id" value="'.@$ar['investor_id'].'" required/>
    		</div>
    	</div>
    	<div class="col-md-6">
    		<div class="form-group">
    			<label for="title">Title</label>
    			<input type="text" name="title" id="title" value="'.@$ar['title'].'" required/>
    		</div>
    	</div>
    	<div class="col-md-4">
    		<div class="form-group">
    			<label for="name">Invest Type</label>
    			<select name="invest_type" class="invest_type" onchange="check_invest_type(this.value)">
    			    <option value="return_investment">Return with Investment</option>
    			    <option value="without_return_investment" ';
    			    echo @$ar['invest_type']=='without_return_investment'?'selected':'';
    			    echo '>Return without Investment</option>
    			
    			</select>
    		</div>
    	</div>
    	<div class="col-md-12">
    		<div class="form-group">
    			<label for="name">Description</label>
    			<textarea name="des">'.@$ar['title'].'</textarea>
    		</div>
    	</div>

    	<div class="col-lg-4 form-group">
		    <label>Investment Amount </label>
		    <input class="invest_amount" type="text" name="invest_amount" value="'.$db->ar2v($ar,'invest_amount').'" placeholder="0.00" >
		</div>
		<div class="col-lg-4 form-group invest_op2">
		    <label>Advance Collection </label>
		    <input class="advance_collection" type="text" name="collection" value="'.$db->ar2v($ar,'collection').'" placeholder="0.00">
		</div>
		<div class="col-lg-4 form-group invest_op2">
		    <label>Net Payable Amount </label>
		    <input class="payable_amount" type="text" readonly placeholder="0.00">
		</div>
		<div class="col-lg-4 form-group invest_op2">
		    <label>Profit Amount </label>
		    <input class="profit_rate" required type="text" name="profit_rate" value="'.$db->ar2v($ar,'profit_rate').'" placeholder="0.00">
		</div>
		<div class="col-lg-5 form-group invest_op2">
		    <label>Total Return Amount</label>
		    <input class="total_return_amount" name="total_return_amount" value="'.$db->ar2v($ar,'total_return_amount').'" type="text" readonly value="" placeholder="0.00">
		</div>

		<div class="col-lg-3 form-group invest_op2">
		    <label>Number of Instal. </label>
		    <input class="total_installment" type="number" name="total_installment" value="'.$db->ar2v($ar,'total_installment').'" placeholder="0.00">
		</div>
		<div class="col-lg-4 form-group invest_op2">
		    <label>Start Instal. Date</label>
		    <input class="start_installment_date" type="date" name="start_installment_date" value="'.$db->ar2v($ar,'start_installment_date').'" placeholder="0.00">
		</div>
		<div class="col-lg-4 form-group">
		    <label>Instal. Amount</label>
		    <input class="installment_amount" type="text"  name="installment_amount" value="'.$db->ar2v($ar,'installment_amount').'" placeholder="0.00">
		</div>
		<div class="col-lg-4 form-group invest_op2">
		    <label>Instal. Period</label>
		    <input class="installment_period" type="number" name="installment_period" value="'.$db->ar2v($ar,'installment_period').'" placeholder="0.00" >
		</div>

    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="primary-outline-btn" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="primary-btn" value="'.@$ar['id'].'" name="save">Save</button>
  </div></form>';?>
<script type="text/javascript">
    function check_invest_type(v){
        if(v == 'return'){
            $('.return_investment').fadeIn()
        }else{
            $('.invest_op2').fadeOut()
        }
    }
	function calculation(){
		invest_type = $('.invest_type').val();
		invest_amount = Number($('.invest_amount').val());
		advance_collection = Number($('.advance_collection').val());
		net_payable = invest_amount - advance_collection;
		profit_amount = Number($('.profit_rate').val());
		total_return_amount = net_payable + profit_amount;
		total_installment = Number($('.total_installment').val());
		installment_amount = total_return_amount / total_installment;
		if(invest_type == 'return_investment'){
		    $('.payable_amount').val(net_payable.toFixed(2))
    		$('.total_return_amount').val(total_return_amount.toFixed(2))
    		$('.installment_amount').val(installment_amount.toFixed(2))
		}
		
	}
	$(document).on('keyup','.invest_area input',function() {
		calculation();
	})
	<?php if(@$ar['id']>0){?>
		calculation();
	<?php }?>
</script>
  <?php 
}




if (isset($_GET['create_method'])) {
	$id = $name = $parent_id ='';
	if (isset($_POST['id'])) {
		foreach ($db->getFull('method','*',' and id ='.$_POST['id']) as $key => $v) {
			$id = $v['id'];
			$name = $v['name'];
			$parent_id = $v['parent_id'];
		}
	}
	echo '
	<style>
		.modal-dialog {
	    max-width: 650px;
	}
	</style>
	<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Method Management</h1>
    <button type="button" class="fas fa-times close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <form method="post"  enctype="multipart/form-data">
  <div class="modal-body">
    <div class="row">

    	<div class="col-md-6">
    		<div class="form-group">
    			<label for="name">Method</label>
    			<select name="parent_id">
  					<option value="">Select</option>';
  					foreach ($db->getFull('method','*',' and parent_id = 0') as $key => $value) {
  						echo '<option value="'.$value['id'].'" ';
  						echo $parent_id == $value['id']?'selected':'';
  						echo '>'.$value['name'].'</option>';
  					}
  					echo '</select>
    		</div>
    	</div>

    	<div class="col-md-6">
    		<div class="form-group">
    			<label for="name">Method Name</label>
    			<input type="text" name="name" id="name" value="'.$name.'"/>
    		</div>
    	</div>


    


    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="primary-outline-btn" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="primary-btn" value="'.$id.'" name="save">Save</button>
  </div></form>';
}




if (isset($_GET['create_transfer'])) {
	echo '
	<style>
		.modal-dialog {
	    max-width: 650px;
	}
	</style>
	<div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Balance Transfer</h1>
        <button type="button" class="fas fa-times close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
  <form method="post"  enctype="multipart/form-data">
  <div class="modal-body">
    <div class="row">

    	<div class="col-md-4">
    		<div class="form-group">
    			<label for="name">From</label>
    			<select name="from_method_id">
  					<option value="">Select</option>';
  					echo $db->get_method_option();
  					echo '</select>
    		</div>
    	</div>
    	<div class="col-md-4">
    		<div class="form-group">
    			<label for="name">To</label>
    			<select name="to_method_id">
  					<option value="">Select</option>';
  					echo $db->get_method_option();
  					echo '</select>
    		</div>
    	</div>

    	<div class="col-md-4">
    		<div class="form-group">
    			<label for="name">Amount</label>
    			<input type="text" name="amount"/>
    		</div>
    	</div>


    


    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="primary-outline-btn" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="primary-btn" value="" name="save">Save</button>
  </div></form>';
}



















