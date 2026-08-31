<?php
$db->investment();
$ledger_rows = $db->getdata("select l.*, i.name as investor_name, i.cus_id from ledger l left join investor i on i.id = l.investor_id where l.type in ('invest', 'invest_withdraw') order by l.id desc");
?>

<div class="card datatables border-0 shadow">
  <div class="card-header">
    <div class="pg_title"><?php echo $db->get_pg_title($url[0]);?></div>
    <button type="button" class="btn btn-success btn-sm create_data" style="float:right;">Create New Investment</button>
  </div>
  <div class="card-body table-responsive">
    <table id="mytable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th style="width:40px">SL</th>
          <th>Investor</th>
          <th>Debit</th>
          <th>Credit</th>
          <th>Remarks</th>
          <th>Type</th>
          <th>Date</th>
          <th style="width:90px">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $s = 1;
        foreach ($ledger_rows as $row) {
          echo '<tr>
            <td class="text-center">'.$s++.'</td>
            <td class="text-left">'.($row['investor_name'] ? $row['investor_name'] : 'N/A').'</td>
            <td class="text-right">'.$db->nf($row['debit']).'</td>
            <td class="text-right">'.$db->nf($row['credit']).'</td>
            <td class="text-left">'.($row['remarks'] ?: '').'</td>
            <td class="text-center">'.$row['type'].'</td>
            <td class="text-center">'.$db->setdate($row['date']).'</td>
            <td class="text-center">
              <a class="btn btn-primary btn-sm create_data" data-id="'.$row['id'].'"><i class="fas fa-edit"></i></a>
              <a class="btn btn-danger btn-sm" href="'.domain.$url[0].'&del_id='.$row['id'].'" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-trash"></i></a>
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
  $(".create_data").click(function(){
    id = $(this).data('id');
    $('#modal_id').modal('toggle');
    ajax_post('<?php echo domain;?>control.php?create_investment=1',{id:id},'#modal-content')
  })
})
</script>
