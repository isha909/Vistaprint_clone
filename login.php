<?php
require_once __DIR__ . '/functions.php';

// Handle Sign Out Action
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_email']);
    session_destroy();
    header("Location: index.php");
    exit;
}

// Redirect if already logged in
if (is_logged_in()) {
    header("Location: index.php");
    exit;
}

$error = '';
$redirect = isset($_GET['redirect']) ? sanitize($_GET['redirect']) : 'index.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? sanitize($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($email) || empty($password)) {
        $error = 'Please enter both your email address and password.';
    } else {
        if (login_user($email, $password)) {
            header("Location: " . $redirect);
            exit;
        } else {
            $error = 'Invalid email address or password. Please try again.';
        }
    }
}

$page_title = "Sign In";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> | Vistaprint</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            color: #1a1a1a;
        }
        .font-outfit { font-family: 'Outfit', sans-serif; }

        .auth-header {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }
        .logo-text-vista { font-weight: 900; font-size: 26px; color: #111; }
        .logo-text-print { font-weight: 500; font-size: 26px; color: #111; }

        .auth-wrap {padding: 0 16px; margin-top: 30px; margin-bottom: 30px; margin-left: 300px; margin-right: 300px;}

        .btn-passcode {
            background: #7dd3f5;
            border: none;
            color: #062b3a;
            font-weight: 600;
        }
        .btn-passcode:hover { background: #63c9f0; color: #062b3a; }

        .btn-social {
            border: 1px solid #d9d9d9;
            background: #fff;
            font-weight: 600;
            color: #111;
        }
        .btn-social:hover { background: #f7f7f7; }

        .divider-line {
            display: flex;
            align-items: center;
            text-align: center;
            color: #888;
            font-size: 13px;
            margin: 22px 0;
        }
        .divider-line::before, .divider-line::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #e0e0e0;
        }
        .divider-line span { padding: 0 12px; }

        .form-control-vp {
            border-radius: 6px;
            font-size: 14px;
            padding: 10px 14px;
            border: 1px solid #c9c9c9;
        }

        .password-wrap { position: relative; }
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
        }

        .forgot-link {
            display: block;
            text-align: center;
            font-size: 13px;
            font-weight: 600;
            color: #111;
            text-decoration: underline;
            margin: 14px 0 20px;
        }

        .terms-text {
            font-size: 12px;
            color: #555;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .terms-text a { color: #111; text-decoration: underline; }

        .btn-vp-dark {
            background: #111;
            border: none;
            color: #fff;
            font-weight: 600;
        }
        .btn-vp-dark:disabled {
            background: #e2e2e2;
            color: #a3a3a3;
        }
        .btn-vp-dark:not(:disabled):hover { background: #000; }

        .or-text { text-align: center; font-size: 13px; color: #888; margin: 16px 0; }

        .btn-outline-create {
            border: 1px solid #111;
            background: #fff;
            color: #111;
            font-weight: 600;
        }
        .btn-outline-create:hover { background: #f5f5f5; }
    </style>
</head>
<body>

    <header class="auth-header text-center">
        <div class="d-flex align-items-center justify-content-center">
                <a href="index.php" class="d-flex align-items-center text-decoration-none">
                    <img src="assets/images/vista_logo.jpg"
                        alt=""
                        width="50"
                        height="50"
                        class="me-2">
                    <span class="logo-text-vista">vista</span><span class="logo-text-print">print</span>
                </a>
            </div>
    </header>

    <div class="auth-wrap">
        <h1 class="text-center fw-bold font-outfit mb-4" style="font-size: 34px;">Welcome</h1>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger py-2 px-3 mb-3 rounded-3" style="font-size: 13px;" role="alert">
                <i class="fa-solid fa-circle-exclamation me-1"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <button type="button" class="btn btn-passcode w-100 py-2 mb-3" style="border-radius: 6px;">
            Sign in with passcode
        </button>

        <button type="button" class="btn btn-social w-100 py-2 mb-3 d-flex align-items-center justify-content-center gap-2" style="border-radius: 6px;">
            <i class="fa-brands fa-google" style="color:#4285F4;"></i> Continue with Google
        </button>

        <div class="d-flex gap-2 mb-3">
            <button type="button" class="btn btn-social w-100 py-2 d-flex align-items-center justify-content-center gap-2" style="border-radius: 6px;">
                <i class="fa-brands fa-apple"></i> Apple
            </button>
            <button type="button" class="btn btn-social w-100 py-2 d-flex align-items-center justify-content-center gap-2" style="border-radius: 6px;">
                <i class="fa-brands fa-facebook" style="color:#1877F2;"></i> Facebook
            </button>
        </div>

        <div class="divider-line"><span style="font-size: 16px; font-weight: 600; color: black;">Or, sign in with email.</span></div>
        
        <form action="login.php?redirect=<?php echo urlencode($redirect); ?>" method="POST" id="loginForm">
            <div class="mb-3">
                <input type="email" class="form-control form-control-vp" id="email" name="email"
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                       placeholder="Email address" required>
            </div>

            <div class="mb-1 password-wrap">
                <input type="password" class="form-control form-control-vp" id="password" name="password"
                       placeholder="Password" required>
                <button type="button" class="password-toggle" id="togglePassword" tabindex="-1">
                    <i class="fa-solid fa-eye" id="toggleIcon"></i>
                </button>
            </div>

            <a href="#" class="forgot-link">Forgot password?</a>

            <p class="terms-text">
                By signing in, you have read and agree to our <a href="#">Vista Account Terms</a> and
                <a href="#">Privacy and Cookie Policy</a>. By clicking on the 'Sign in' button, you authorize us
                (Cimpress India Pvt Ltd) and its representatives to contact you through Call, Email, SMS, or WhatsApp
                for transactional, promotional and/or commercial purposes. This consent overrides your registration
                under DNC/NDNC.
            </p>

            <button type="submit" class="btn btn-vp-dark w-100 py-2 mb-3" id="signInBtn" style="border-radius: 6px;" disabled>
                Sign in
            </button>
        </form>

        <div class="or-text">or</div>

        <a href="register.php?redirect=<?php echo urlencode($redirect); ?>" class="btn btn-outline-create w-100 py-2" style="border-radius: 6px;">
            Create an account
        </a>

        <!-- Quick Demo Credentials Display -->
        <!-- <div class="alert alert-info py-2 px-3 mt-4 rounded-3 text-start" style="font-size: 11px; line-height: 1.4;">
            <h6 class="fw-bold mb-1 text-dark" style="font-size: 12px;"><i class="fa-solid fa-info-circle me-1"></i> Developer Account Credentials:</h6>
            Email: <strong>customer@vistaprint.in</strong><br>
            Password: <strong>password123</strong>
        </div> -->
    </div>

    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        togglePassword.addEventListener('click', function () {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            toggleIcon.classList.toggle('fa-eye');
            toggleIcon.classList.toggle('fa-eye-slash');
        });

        // Enable Sign in button only when both fields are filled
        const emailInput = document.getElementById('email');
        const signInBtn = document.getElementById('signInBtn');
        function checkFormFilled() {
            signInBtn.disabled = !(emailInput.value.trim() && passwordInput.value.trim());
        }
        emailInput.addEventListener('input', checkFormFilled);
        passwordInput.addEventListener('input', checkFormFilled);
        checkFormFilled();
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
