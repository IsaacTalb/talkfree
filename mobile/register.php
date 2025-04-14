<?php
// mobile/register.php
session_start();

// If already logged in, redirect to index
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Process registration form
$error = '';
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../api/config.php';
    
    $username = sanitizeInput($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $public_key = $_POST['public_key'] ?? '';
    
    // Validate inputs
    if (empty($username) || empty($password) || empty($confirm_password) || empty($public_key)) {
        $error = 'All fields are required.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters long.';
    } else {
        try {
            $db = getDb();
            
            // Check if username already exists
            $stmt = $db->prepare('SELECT id FROM users WHERE username = :username');
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            
            if ($stmt->fetch()) {
                $error = 'Username already exists.';
            } else {
                // Hash password
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert new user
                $stmt = $db->prepare('
                    INSERT INTO users (username, password_hash, public_key)
                    VALUES (:username, :password_hash, :public_key)
                ');
                $stmt->bindValue(':username', $username, PDO::PARAM_STR);
                $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
                $stmt->bindValue(':public_key', $public_key, PDO::PARAM_STR);
                $stmt->execute();
                
                $success = true;
            }
        } catch (Exception $e) {
            $error = 'An error occurred: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Register - TalkFree</title>
    <link rel="icon" href="../assets/talkfree/favicon.ico" type="image/x-icon">
    <meta name="description" content="TalkFree is a secure messaging platform offering end-to-end encrypted communication.">
    <meta name="keywords" content="Secure Messaging, Encryption, Privacy, TalkFree, RSA-2048, AES-256">
    <meta name="robots" content="index, follow">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/mobile-style.css">
</head>
<body class="auth-page">
    <div class="auth-wrapper">
        <div class="auth-header">
            <div class="logo-container">
                <i class="fas fa-lock"></i>
            </div>
            <h1>TalkFree</h1>
            <p>Create a new account</p>
        </div>
        
        <div class="auth-form-container">
            <?php if ($error): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo htmlspecialchars($error); ?></span>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    <span>Registration successful! You can now <a href="login.php">login</a>.</span>
                </div>
                <div class="key-export-reminder">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p>IMPORTANT: Don't forget to export your private key. You'll need it to decrypt messages.</p>
                    <button id="export-key-after-register" class="btn-primary btn-block">
                        <i class="fas fa-download"></i> Export Private Key
                    </button>
                </div>
            <?php else: ?>
                <form method="POST" action="register.php" id="register-form" class="auth-form">
                    <div class="form-group">
                        <div class="input-icon-wrapper">
                            <i class="fas fa-user"></i>
                            <input type="text" id="username" name="username" placeholder="Username" autocomplete="username" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-icon-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="password" name="password" placeholder="Password" autocomplete="new-password" required>
                        </div>
                        <div class="password-strength-meter">
                            <div class="strength-bar" id="password-strength-bar"></div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-icon-wrapper">
                            <i class="fas fa-check-circle"></i>
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" autocomplete="new-password" required>
                        </div>
                    </div>
                    
                    <input type="hidden" id="public_key" name="public_key">
                    
                    <div class="key-status" id="key-status">
                        <div class="key-status-icon">
                            <i class="fas fa-key"></i>
                        </div>
                        <div class="key-status-message">
                            <p>Encryption keys required for secure communication</p>
                        </div>
                    </div>
                    
                    <button type="button" id="generate-keys" class="btn-secondary btn-block">
                        <i class="fas fa-key"></i> Generate Encryption Keys
                    </button>
                    
                    <button type="submit" id="submit-btn" class="btn-primary btn-block" disabled>
                        <i class="fas fa-user-plus"></i> Create Account
                    </button>
                </form>
                
                <div class="auth-links">
                    <p>Already have an account? <a href="login.php">Login</a></p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="auth-footer">
            <p>End-to-end encrypted messaging</p>
        </div>
    </div>
    
    <script src="../js/crypto.js"></script>
    <script>
    // JavaScript remains unchanged
    </script>
</body>
</html>