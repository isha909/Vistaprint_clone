<?php
require_once __DIR__ . '/functions.php';

// Redirect if already logged in
if (is_logged_in()) {
    header("Location: index.php");
    exit;
}

$error = '';
$redirect = isset($_GET['redirect']) ? sanitize($_GET['redirect']) : 'index.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? sanitize($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitize($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'All registration fields are required.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match. Please verify.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long.';
    } else {
        // Attempt to register
        if (register_user($name, $email, $password)) {
            header("Location: " . $redirect);
            exit;
        } else {
            $error = 'The email address is already registered. Try signing in.';
        }
    }
}

$page_title = "Create Account";
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/navbar.php';
?>

<div class="container py-5 px-4 d-flex justify-content-center">
    <div class="w-100 max-width-600 my-4" style="max-width: 440px;">
        <div class="custom-card p-4 p-sm-5 bg-white">
            <div class="text-center mb-4">
                <a href="index.php" class="d-inline-flex align-items-center text-decoration-none logo-container mb-3">
                    <svg width="35" height="35" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="me-2">
                        <path d="M12 28.5L20 12.5L28 28.5" stroke="#0079C1" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="20" cy="9.5" r="3.5" fill="#4BC3E6"/>
                    </svg>
                    <span class="logo-text-vista" style="font-size: 20px;">vista</span><span class="logo-text-print" style="font-size: 20px;">print</span>
                </a>
                <h4 class="fw-bold font-outfit text-dark">Create your account</h4>
                <p class="text-muted" style="font-size: 13px;">Join to design, save projects, and track order histories.</p>
            </div>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger py-2 px-3 mb-4 rounded-3" style="font-size: 13px;" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-1"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form action="register.php?redirect=<?php echo urlencode($redirect); ?>" method="POST" id="registerForm">
                <div class="mb-3">
                    <label for="name" class="form-label text-secondary fw-semibold" style="font-size: 13px;">Full Name</label>
                    <input type="text" class="form-control py-2 px-3" id="name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" placeholder="John Doe" style="border-radius: 6px; font-size: 14px;" required>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label text-secondary fw-semibold" style="font-size: 13px;">Email Address</label>
                    <input type="email" class="form-control py-2 px-3" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" placeholder="name@domain.com" style="border-radius: 6px; font-size: 14px;" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label text-secondary fw-semibold" style="font-size: 13px;">Password</label>
                    <input type="password" class="form-control py-2 px-3" id="password" name="password" placeholder="Min. 6 characters" style="border-radius: 6px; font-size: 14px;" required>
                </div>
                
                <div class="mb-4">
                    <label for="confirm_password" class="form-label text-secondary fw-semibold" style="font-size: 13px;">Confirm Password</label>
                    <input type="password" class="form-control py-2 px-3" id="confirm_password" name="confirm_password" style="border-radius: 6px; font-size: 14px;" required>
                </div>
                
                <button type="submit" class="btn btn-vp-dark w-100 py-2 fw-semibold mb-3" style="border-radius: 6px; font-size: 14px;">
                    Create Account
                </button>
            </form>
            
            <hr class="my-4">
            
            <div class="text-center" style="font-size: 13px;">
                <span class="text-secondary">Already have an account?</span>
                <a href="login.php?redirect=<?php echo urlencode($redirect); ?>" class="text-primary fw-semibold text-decoration-none ms-1">Sign In</a>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/footer.php';
?>
