<?php
if (isset($_POST['login'])) {
  $db->login();
}
if ($db->is_login()) {
  $db->redirect('dashboard');
}
?>
<style>
  .container, .container-fluid{
    max-width: 700px;
  }
</style>
<div class="card datatables border-0 shadow">
  <div class="card-header">
    <div class="pg_title">Login with your Username and password</div>
  </div>
  <div class="card-body">
    <form method="post">
      <div class="row">
        <div class="col-md-12 mt-1">
          <?php if (isset($_SESSION['lmsg'])) {?>
          <p style="margin:0;text-align: center;color: red;font-weight: bold;"><?php echo $_SESSION['lmsg'];?></p>
          <?php unset($_SESSION['lmsg']);}?>
        </div>
        <div class="col-md-12 mb-3 mt-2">
          <label>User Name</label>
          <div class="form-group">
            <input type="text" name="username" placeholder="Login User Name" required>
          </div>
        </div>

        <div class="col-md-12 mb-3">
          <label>Password</label>
          <div class="form-group">
            <input type="password" name="pass" placeholder="Login Password" required>
          </div>
        </div>

        <div class="col-md-12 mb-3 text-center">
          <div class="form-group">
            <button class="btn btn-success" type="submit" name="login">Login</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
