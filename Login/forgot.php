<?php
require __DIR__ . '/../login-backend/init.php';
$error = getFlash('error');
$info = getFlash('info');
$email = $_GET['email'] ?? $_POST['email'] ?? '';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Forgot Password | MSKS</title>
      <link rel="stylesheet" href="login.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
   </head>
   <body>
      <div class="content">
         <div class="text">
            Forgot Password
         </div>
         <?php if ($error): ?><p class="flash flash-error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
         <?php if ($info): ?><p class="flash flash-info"><?= htmlspecialchars($info) ?></p><?php endif; ?>

         <form action="../login-backend/forgot.php" method="post">
            <div class="field">
               <input type="email" name="email" id="email" required value="<?= htmlspecialchars($email) ?>">
               <span class="fas fa-envelope"></span>
               <label>Email Address</label>
            </div>

            <button type="submit">Send OTP</button>

            <div class="forgot-pass">
               <a href="login.php">Back to Login</a>
            </div>
         </form>
      </div>
   </body>
</html>
