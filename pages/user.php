<?php
$db->get_user();
$ar = $db->getFull('admin');
?>

<div class="card datatables border-0 shadow">
  <div class="card-header">
    <div class="pg_title"><?php echo $db->get_pg_title($url[0]);?></div>
    <button type="button" class="btn btn-success btn-sm create_data" style="float:right;">Create New User</button>
    </div>
  <div class="card-body"> 

  <table id="mytable" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th style="width:60px">SL</th>
        <th>Name</th>
        <th>Username</th>
        <th>Number</th>
        <th>Email</th>
        <th>Date</th>
        <th style="width:100px">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $s = 1;
      foreach ($ar as $key => $v) {
        echo '<tr>
        <td class="text-center">'.$s++.'</td>
        <td class="text-center">'.$v['name'].'</td>
        <td class="text-center">'.$v['user_name'].'</td>
        <td class="text-center">'.$v['number'].'</td>
        <td class="text-center">'.$v['email'].'</td>
        <td class="text-center">'.$db->setdate($v['date']).'</td>
        <td class="text-center">
          <a class="btn btn-success create_data btn-sm" data-id="'.$v['id'].'"><i class="fas fa-edit"></i></a>
          <a class="btn btn-danger btn-sm" href="'.domain.$url[0].'&del_id='.$v['id'].'" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-trash"></i></a>
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
    ajax_post('<?php echo domain;?>control.php?create_admin=1',{id:id},'#modal-content')
})

</script>
