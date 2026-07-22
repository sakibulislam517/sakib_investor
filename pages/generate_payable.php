<?php
$db->generate_payable();


$month = !empty($db->getm('month'))?$db->getm('month'):date('Y-m');
$sql = 'select a.*,b.name from ledger a
inner join member b on b.id = a.member_id
 where a.type = "generate"';
$sql .= ' and a.month = "'.$month.'"';
 
$ar = $db->getdata($sql);
?>

<div class="card datatables border-0 shadow mb-4">
  <div class="card-header">
    <div class="pg_title"><?php echo $db->get_pg_title($url[0]);?></div>
    <button type="button" class="btn btn-success btn-sm create_data" style="float:right;">Generate Payable</button>
    </div>
  <div class="card-body table-responsive"> 
  <form method="get">
    <div class="row">
      <div class="col-md-3">
        <select class="form-control form-control-sm select2" name="month">
          <option value="0">Select Billing</option>
          <?php
          foreach ($db->getdata('select * from ledger where month != "" group by month') as $key => $value) {
            echo '<option value="'.$value['month'].'" ';
            echo $month==$value['month']?'selected':'';
            echo '>'.($value['generate_type'] == 'monthly'?date('M y',strtotime($value['month'])):$value['month']).'</option>';
          }
          ?>
        </select>
      </div>
      <div class="col-md-3">
        <button class="btn btn-success">Search</button>
      </div>
    </div>
  </form>
</div>
</div>
<div class="card datatables border-0 shadow">
  <div class="card-body table-responsive">
  <table id="mytable" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th style="width:60px">SL</th>
        <th>Date</th>
        <th>Month</th>
        <th>Name</th>
        <th>Amount</th>
        <th>Remarks</th>
        <th style="width:100px">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $s = 1;$total = 0;
      foreach ($ar as $key => $v) {
        $total += $v['amount'];
        if ($v['generate_type'] == 'monthly') {
          $month = date('F Y',strtotime($v['month']));
        }elseif ($v['generate_type'] == 'yearly') {
          $month = $v['month'];
        }else{
          $month = '';
        }
        echo '<tr>
        <td class="text-center">'.$s++.'</td>
        <td class="text-center">'.$db->setdate($v['cdate']).'</td>
        <td class="text-center">'.$month.'</td>
        <td class="text-left">'.$v['name'].'</td>
        <td class="text-right">'.$v['amount'].'</td>
        <td class="text-left">'.$v['remarks'].'</td>
        <td class="text-center">
          <a class="btn btn-danger btn-sm" href="'.domain.$url[0].'&del_id='.$v['id'].'" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-trash"></i></a>
        </td>
      </tr>';
      }
      ?>
      
    </tbody>
    <tfoot>
      <tr>
        <th class="text-center" colspan="4">Sub-Total</th>
        <th class="text-right"><?php echo $db->nf($total);?></th>
        <th></th>
        <th></th>
      </tr>
    </tfoot>
  </table>
</div>

</div>

<script>
$(".create_data").click(function(){
    $('#modal_id').modal('toggle')
    ajax_post('<?php echo domain;?>control.php?generate_payable=1','','#modal-content')
})

</script>
