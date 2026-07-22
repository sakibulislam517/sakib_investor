<?php
$db->investment();
$sql = 'select * from investment order by id desc';
$ar = $db->getdata($sql);
?>
<style type="text/css">
  td,th{
    font-size: 14px!important;
  }
</style>
<div class="card datatables border-0 shadow mb-4">
  <div class="card-header">
    <div class="pg_title"><?php echo $db->get_pg_title($url[0]);?></div>
    <button type="button" class="btn btn-success btn-sm create_data" style="float:right;">Create New Investment</button>
    </div>
 

  <div class="card-body table-responsive"> 

  <table id="mytable" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th style="width:20px">SL</th>
        <th>Date</th>
        <th>ID</th>
        <th>Name</th>
        <th>Invest Amount</th>
        <th>Advance</th>
        <th>Payable</th>
        <th>Profit</th>
        <th>Return Amount</th>
        <th>Num of Ins.</th>
        <th>Ins. Amount</th>
        <th style="width:10px">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $s = 1;$total = 0;
      foreach ($ar as $key => $v) {
        $invest_amount = $v['invest_amount'];
        $collection = $v['collection'];
        $return_amount = $v['invest_amount']-$v['collection'];
        $profit = $v['profit_rate'];
        $payable_amount = $return_amount + $profit;
        echo '<tr>
        <td class="text-center">'.$s++.'</td>
        <td class="text-center">'.$db->setdate($v['cdate']).'</td>
        <td class="text-center">'.$v['investor_id'].'</td>
        <td class="text-left">'.$v['title'].'</td>
        <td class="text-center">'.$db->nf($invest_amount).'</td>
        <td class="text-center">'.$db->nf($collection).'</td>
        <td class="text-center">'.$db->nf($return_amount).'</td>
        <td class="text-center">'.$db->nf($profit).'</td>
        <td class="text-center">'.$db->nf($payable_amount).'</td>
        <td class="text-center">'.$v['total_installment'].'</td>
        <td class="text-center">'.$v['installment_amount'].'</td>
        <td class="text-center">
          <a class="btn btn-success btn-sm create_data" data-id="'.$v['id'].'"><i class="fas fa-edit"></i></a>';         

        echo '</td>
      </tr>';
      }
      ?>
      
    </tbody>

  </table>
</div>

</div>

<script>
$(".create_data").click(function(){
  id = $(this).data('id');
  $('#modal_id').modal('toggle')
  ajax_post('<?php echo domain;?>control.php?investment=1',{id:id},'#modal-content')
})

</script>
