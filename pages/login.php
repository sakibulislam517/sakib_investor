<?php
if (isset($_POST['login'])) {
  $db->login();
}
if ($db->is_login()) {
  $db->redirect('dashboard');
}
?>
<style>
.login-wrapper {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
  padding: 20px;
  position: relative;
  overflow: hidden;
}
.login-wrapper::before {
  content: '';
  position: absolute;
  width: 600px;
  height: 600px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(99,102,241,.15) 0%, transparent 70%);
  top: -200px;
  right: -100px;
}
.login-wrapper::after {
  content: '';
  position: absolute;
  width: 400px;
  height: 400px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(14,165,233,.1) 0%, transparent 70%);
  bottom: -100px;
  left: -100px;
}
.login-card {
  background: rgba(255,255,255,.06);
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  border: 1px solid rgba(255,255,255,.1);
  border-radius: 20px;
  padding: 40px;
  width: 100%;
  max-width: 420px;
  position: relative;
  z-index: 1;
  box-shadow: 0 25px 60px rgba(0,0,0,.5);
}
.login-card .logo-area {
  text-align: center;
  margin-bottom: 32px;
}
.login-card .logo-area img {
  max-height: 60px;
  margin-bottom: 8px;
}
.login-card .logo-area h2 {
  color: #fff;
  font-size: 22px;
  font-weight: 700;
  margin: 0;
}
.login-card .logo-area p {
  color: rgba(255,255,255,.5);
  font-size: 13px;
  margin-top: 4px;
}
.login-card .form-group { margin-bottom: 18px; }
.login-card label {
  color: rgba(255,255,255,.7);
  font-size: 11px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: .06em;
  margin-bottom: 6px;
  display: block;
}
.login-card input {
  width: 100%;
  background: rgba(255,255,255,.08);
  border: 1.5px solid rgba(255,255,255,.12);
  border-radius: 12px;
  padding: 13px 16px;
  font-size: 14px;
  color: #fff;
  transition: all .25s;
  outline: none;
}
.login-card input::placeholder { color: rgba(255,255,255,.3); }
.login-card input:focus {
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(99,102,241,.2);
  background: rgba(255,255,255,.12);
}
.login-card .login-btn {
  width: 100%;
  padding: 14px;
  background: linear-gradient(135deg, #6366f1, #4f46e5);
  color: #fff;
  border: 0;
  border-radius: 12px;
  font-size: 15px;
  font-weight: 700;
  cursor: pointer;
  transition: all .25s;
  font-family: 'Inter', sans-serif;
  margin-top: 8px;
  box-shadow: 0 4px 16px rgba(99,102,241,.35);
}
.login-card .login-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(99,102,241,.45);
}
.login-card .error-msg {
  background: rgba(239,68,68,.15);
  border: 1px solid rgba(239,68,68,.3);
  color: #fca5a5;
  padding: 10px 14px;
  border-radius: 10px;
  font-size: 13px;
  text-align: center;
  margin-bottom: 16px;
}
</style>
<div class="login-wrapper">
  <div class="login-card">
    <div class="logo-area">
      <img src="images/logo/logo.png" alt="Logo">
      <h2>Welcome Back</h2>
      <p>Sign in to your account</p>
    </div>
    <form method="post">
      <?php if (isset($_SESSION['lmsg'])) {?>
        <div class="error-msg"><?php echo $_SESSION['lmsg'];?></div>
      <?php unset($_SESSION['lmsg']);}?>
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" placeholder="Enter your username" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="pass" placeholder="Enter your password" required>
      </div>
      <button class="login-btn" type="submit" name="login">Sign In</button>
    </form>
  </div>
</div>
