<?php
$db->save_setting();

?>

<div class="card datatables border-0 shadow">
  <div class="card-header">
    <div class="pg_title">Company Settings</div>
  </div>
  <div class="card-body"> 
  <form method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6 form-group">
            <label>Company Name</label>
            <input type="text" name="company_name" value="<?php echo $company_ar['company_name'];?>">
        </div>
        <div class="col-md-6 form-group">
            <label>Address</label>
            <input type="text" name="address" value="<?php echo $company_ar['address'];?>">
        </div>
        <div class="col-md-3 form-group">
            <label>Monthly Fee</label>
            <input type="text" name="monthly_fee" value="<?php echo $company_ar['monthly_fee'];?>">
        </div>
        <div class="col-md-3 form-group">
            <label>Half Yearly Fee</label>
            <input type="text" name="yearly_fee" value="<?php echo $company_ar['yearly_fee'];?>">
        </div>
        <div class="col-md-3 form-group">
            <label>Logo</label>
            <input type="file" name="logo">
        </div>
        <div class="col-md-12 text-center">
            <input type="submit" name="save" class="btn btn-success" style="max-width:250px">
        </div>
    </div>
  </form>
  </div>

</div>
