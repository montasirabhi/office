<?php
require __DIR__ . '/../login-backend/init.php';
$error = getFlash('error');
$success = getFlash('success');
$email = $_GET['email'] ?? $_POST['email'] ?? '';
if (!$email) {
    header('Location: forgot.php', true, 302);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Verify OTP | MSKS</title>
      <link rel="stylesheet" href="login.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
   </head>
   <body>
      <div class="content">
         <div class="text">
            Verify OTP
         </div>
         <?php if ($error): ?><p class="flash flash-error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
         <?php if ($success): ?><p class="flash flash-success"><?= htmlspecialchars($success) ?></p><?php endif; ?>

         <form action="../login-backend/otp.php" method="post">
            <?php if ($email): ?><input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>"><?php endif; ?>
            <div class="field">
               <input type="text" name="otp" id="otp" required maxlength="6" pattern="[0-9]{6}" placeholder=" " autocomplete="one-time-code">
               <span class="fas fa-key"></span>
               <label>Enter 6-digit OTP</label>
            </div>
            <?php if ($email): ?><p class="hint">Sending OTP to <?= htmlspecialchars($email) ?></p><?php endif; ?>

            <button type="submit">Verify</button>

            <div class="forgot-pass">
               <a href="forgot.php">Resend OTP</a>
               <span style="margin: 0 8px;">|</span>
               <a href="login.php">Back to Login</a>
            </div>
         </form>
      </div>
   </body>
</html>
