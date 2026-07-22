<?php
$db->get_pages();
$ar = $db->getFull('pages','*',' and parent_id = 0 order by sl');
?>

<div class="card datatables border-0 shadow">
  <div class="card-header">
    <div class="pg_title"><?php echo $db->get_pg_title($url[0]);?></div>
    <button type="button" class="btn btn-success btn-sm create_data" style="float:right;">Create New Page</button>
    </div>
  <div class="card-body"> 

  <table  class="table table-bordered table-striped">
    <thead>
      <tr>
        <th style="width:60px">SL</th>
        <th>Page Name</th>
        <th>Sub Page</th>
        <th>URL</th>
        <th>Page Title</th>
        <th>Icon</th>
        <th>Image</th>
        <th style="width:100px">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $sl = 1;
      foreach ($ar as $key => $v) {
        $img = '';
        if (file_exists('images/req/'.$v['img']) and !empty($v['img'])) {
          $img = '<img style="max-height:30px" src="'.domain.'images/req/'.$v['img'].'">';
        }
        echo '<tr>
        <td class="text-center">'.$sl++.'</td>
        <td class="text-left">'.$v['name'].' - '.$v['sl'].'</td>
        <td class="text-left"></td>
        <td class="text-left">'.$v['url'].'</td>
        <td class="text-left">'.$v['page_title'].'</td>
        <td class="text-center">'.$v['icon'].'</td>
        <td class="text-center">'.$img.'</td>
        <td class="text-center">
          <a class="btn btn-success create_data btn-sm" data-id="'.$v['id'].'"><i class="fas fa-edit"></i></a>
          <a class="btn btn-danger btn-sm" href="'.domain.$url[0].'&del_id='.$v['id'].'" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-trash"></i></a>
        </td>
      </tr>';

      foreach ($db->getFull('pages','*',' and parent_id ='.$v['id'].' order by sl') as $key => $s) {
        $img = '';
        if (file_exists('images/req/'.$s['img']) and !empty($s['img'])) {
          $img = '<img style="max-height:30px" src="'.domain.'images/req/'.$s['img'].'">';
        }
        echo '<tr>
            <td class="text-left"></td>
            <td class="text-center"></td>
            <td class="text-left">'.$s['name'].' - '.$s['sl'].'</td>
            <td class="text-left">'.$s['url'].'</td>
            <td class="text-left">'.$s['page_title'].'</td>
            <td class="text-center">'.$s['icon'].'</td>
            <td class="text-center">'.$img.'</td>
            <td class="text-center">
              <a class="btn btn-success create_data btn-sm" data-id="'.$s['id'].'"><i class="fas fa-edit"></i></a>
              <a class="btn btn-danger btn-sm" href="'.domain.$url[0].'&del_id='.$s['id'].'" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-trash"></i></a>
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
    ajax_post('<?php echo domain;?>control.php?create_page=1',{id:id},'#modal-content')
})

</script>
