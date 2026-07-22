<?php
$db->save_method();
$ar = $db->getFull('method','*',' and parent_id = 0');
?>

<div class="card datatables border-0 shadow">
  <div class="card-header">
    <div class="pg_title"><?php echo $db->get_pg_title($url[0]);?></div>
    <button type="button" class="btn btn-success btn-sm create_data" style="float:right;">Create New</button>
    </div>
  <div class="card-body"> 

  <table  class="table table-bordered table-striped">
    <thead>
      <tr>
        <th style="width:60px">SL</th>
        <th>Method Name</th>
        <th style="width:100px">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $sl = 1;
      foreach ($ar as $key => $v) {

        echo '<tr>
        <td class="text-center">'.$sl++.'</td>
        <td class="text-left">'.$v['name'].'</td>
        <td class="text-center">
          <a class="btn btn-success create_data btn-sm" data-id="'.$v['id'].'"><i class="fas fa-edit"></i></a>
        </td>
      </tr>';

      foreach ($db->getFull('method','*',' and parent_id ='.$v['id']) as $key => $s) {
        echo '<tr>
            <td class="text-left"></td>
            <td class="text-left" style="padding-left:25px!important">'.$s['name'].'</td>
            <td class="text-center">
              <a class="btn btn-success create_data btn-sm" data-id="'.$s['id'].'"><i class="fas fa-edit"></i></a>
            </td>
          </tr>';
      }
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
    ajax_post('<?php echo domain;?>control.php?create_method=1',{id:id},'#modal-content')
})

</script>
