<?php
require __DIR__ . '/../login-backend/init.php';
$error = getFlash('error');
$success = getFlash('success');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Login | MSKS</title>
      <link rel="stylesheet" href="login.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
   </head>
   <body>
      <div class="content">
         <div class="text">
            MSKS
         </div>
         <?php if ($error): ?><p class="flash flash-error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
         <?php if ($success): ?><p class="flash flash-success"><?= htmlspecialchars($success) ?></p><?php endif; ?>

         <form action="../login-backend/login.php" method="post">
            <div class="field">
               <input type="text" name="username" id="username" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
               <span class="fas fa-user"></span>
               <label>Username or Email</label>
            </div>
            <div class="field">
               <input type="password" name="password" id="password" required>
               <span class="fas fa-lock"></span>
               <label>Password</label>
            </div>
            <div class="forgot-pass">
               <a href="forgot.php">Forgot Password?</a>
            </div>
            <button type="submit">Sign in</button>
         </form>
      </div>
   </body>
</html>
