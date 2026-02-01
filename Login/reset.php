<?php
require __DIR__ . '/../login-backend/init.php';
$error = getFlash('error');
$success = getFlash('success');
$email = $_SESSION['reset_email'] ?? '';
if (!$email) {
    header('Location: login.php', true, 302);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Reset Password | MSKS</title>
      <link rel="stylesheet" href="login.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
   </head>
   <body>
      <div class="content">
         <div class="text">
            Reset Password
         </div>
         <?php if ($error): ?><p class="flash flash-error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
         <?php if ($success): ?><p class="flash flash-success"><?= htmlspecialchars($success) ?></p><?php endif; ?>

         <form action="../login-backend/reset.php" method="post">
            <div class="field">
               <input type="password" name="new_password" id="new_password" required minlength="6">
               <span class="fas fa-lock"></span>
               <label>New Password</label>
            </div>
            <div class="field">
               <input type="password" name="confirm_password" id="confirm_password" required minlength="6">
               <span class="fas fa-lock"></span>
               <label>Confirm Password</label>
            </div>

            <button type="submit">Reset Password</button>

            <div class="forgot-pass">
               <a href="login.php">Back to Login</a>
            </div>
         </form>
      </div>
   </body>
</html>
