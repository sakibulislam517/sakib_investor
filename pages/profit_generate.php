<?php
$db->profit_generate();
$investors = $db->getFull('investor','*',' order by name asc');
$rows = $db->getdata("select l.*, i.name as investor_name, i.cus_id from ledger l left join investor i on i.id = l.investor_id where l.type in ('profit_generate','profit_withdraw') order by l.id desc");
?>



<div class="card datatables border-0 shadow">
  <div class="card-header">
    <h5 class="mb-0"><?php echo $db->get_pg_title($url[0]);?></h5>
    <div style="float:right;">
      <button type="button" class="btn btn-success btn-sm create_profit">Generate Profit</button>
      <button type="button" class="btn btn-warning btn-sm create_profit_withdraw">Profit Withdraw</button>
    </div>
  </div>
  <div class="card-body table-responsive">
    <table id="mytable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th style="width:40px">SL</th>
          <th>Voucher</th>
          <th>Investor</th>
          <th>Debit</th>
          <th>Credit</th>
          <th>Remarks</th>
          <th>Date</th>
          <th style="width:80px">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $s = 1;
        foreach ($rows as $row) {
          echo '<tr>
            <td class="text-center">'.$s++.'</td>
            <td class="text-center">'.$row['group_id'].'</td>
            <td class="text-left">'.($row['investor_name'] ? $row['investor_name'] : 'N/A').'</td>
            <td class="text-right">'.$db->nf($row['debit']).'</td>
            <td class="text-right">'.$db->nf($row['credit']).'</td>
            <td class="text-left">'.($row['remarks'] ?: '').'</td>
            <td class="text-center">'.$db->setdate($row['date']).'</td>
            <td class="text-center">
              <a class="btn btn-danger btn-sm" href="'.domain.$url[0].'&del_profit='.$row['id'].'" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-trash"></i></a>
            </td>
          </tr>';
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<script>
$(document).ready(function(){
  $(".create_profit").click(function(){
    $('#modal_id').modal('toggle');
    ajax_post('<?php echo domain;?>control.php?create_profit=1','','#modal-content');
  });

  $(".create_profit_withdraw").click(function(){
    $('#modal_id').modal('toggle');
    ajax_post('<?php echo domain;?>control.php?create_profit_withdraw=1','','#modal-content');
  });


});
</script>

