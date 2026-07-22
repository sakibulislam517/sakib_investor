<?php
$db->payment();
$sql = 'select a.*,b.name from ledger a
inner join expense_ledger b on b.id = a.expense_ledger_id
where a.type = "payment" order by a.id desc';
$ar = $db->getdata($sql);
?>

<div class="card datatables border-0 shadow">
  <div class="card-header">
    <div class="pg_title"><?php echo $db->get_pg_title($url[0]);?></div>
    <button type="button" class="btn btn-success btn-sm create_data" style="float:right;">Create New Payment</button>
    </div>
  <div class="card-body table-responsive"> 

  <table id="mytable" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th style="width:60px">SL</th>
        <th>Date</th>
        <th>ID</th>
        <th>Ledger</th>
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
        echo '<tr>
        <td class="text-center">'.$s++.'</td>
        <td class="text-center">'.$db->setdate($v['cdate']).'</td>
        <td class="text-center">PV'.$db->set_digit($v['group_id'],3).'</td>
        <td class="text-left">'.$v['name'].'</td>
        <td class="text-right">'.$db->nf($v['amount']).'</td>
        <td class="text-left">'.$v['remarks'].'</td>
        <td class="text-center">
          <a class="btn btn-success btn-sm" onclick="view_payment_voucher('.$v['id'].')"><i class="fas fa-eye"></i></a>';
          if ($v['cdate'] == date('Y-m-d') or $v['cdate'] == date('Y-m-d',strtotime('-1 days'))) {
            echo '<a style="margin-left:5px;" class="btn btn-danger btn-sm" href="'.domain.$url[0].'&del_id='.$v['id'].'" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-trash"></i></a>';
          }
        echo '</div>
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
  id = $(this).data('id');
  $('#modal_id').modal('toggle')
  ajax_post('<?php echo domain;?>control.php?payment=1',{id:id},'#modal-content')
})

</script>
