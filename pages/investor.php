<?php
$db->investors();

$ar = $db->getFull('investor','*',' order by cus_id asc');
?>

<div class="card datatables border-0 shadow">
  <div class="card-header">
    <div class="pg_title"><?php echo $db->get_pg_title($url[0]);?></div>
    <button type="button" class="btn btn-success btn-sm create_data" style="float:right;">Create New Member</button>
    </div>
  <div class="card-body table-responsive"> 

  <table id="mytable" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th style="width:40px">SL</th>
        <th>ID</th>
        <th>Name</th>
        <th>Contact No.</th>
        <th>Commission</th>
        <th style="width:100px">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $s = 1;
      foreach ($ar as $key => $v) {
        echo '<tr>
        <td class="text-center">'.$s++.'</td>
        <td class="text-left">'.$v['cus_id'].'</td>
        <td class="text-center">'.$v['name'].'</td>
        <td class="text-center">'.$v['number'].'</td>
        <td class="text-center">'.$v['commission'].'</td>
        <td class="text-center">
          <a class="btn btn-primary create_data btn-sm" data-id="'.$v['id'].'"><i class="fas fa-edit"></i></a>
        </td>
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
    ajax_post('<?php echo domain;?>control.php?create_investor=1',{id:id},'#modal-content')
})

</script>
