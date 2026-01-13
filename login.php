<?php
session_start();
include('db.php');

$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Basic validation
    if (empty($username) || empty($password)) {
        $error_message = 'Both fields are required!';
    } else {

        // Fetch user by username only
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $row = $result->fetch_assoc();

            // Verify hashed password
            if (password_verify($password, $row['password'])) {
                
                // Store session data
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];

                $success_message = "Login successful! Redirecting...";

                echo "<script>
                    setTimeout(function() {
                        window.location.href = 'quiz.html';
                    }, 1500);
                </script>";

            } else {
                $error_message = "Invalid username or password!";
            }

        } else {
            $error_message = "Invalid username or password!";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>🎭 Welcome Back - Login</title>
    <link rel="stylesheet" href="./css/login.css" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="background">
        <div class="floating-orb orb-1"></div>
        <div class="floating-orb orb-2"></div>
        <div class="floating-orb orb-3"></div>
        <div class="floating-orb orb-4"></div>
        
        <div class="particle-container">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>
    </div>

    <div class="container">
        <div class="login-box">
            <div class="login-header">
                <div class="character-container">
                    <div class="character" id="character">
                        <div class="character-face">
                            <div class="character-eyes">
                                <div class="eye left-eye">
                                    <div class="pupil"></div>
                                </div>
                                <div class="eye right-eye">
                                    <div class="pupil"></div>
                                </div>
                            </div>
                            <div class="character-hands" id="character-hands">
                                <div class="hand left-hand"></div>
                                <div class="hand right-hand"></div>
                            </div>
                            <div class="character-mouth"></div>
                        </div>
                    </div>
                </div>
                <h1>Welcome Back!</h1>
                <p>Sign in to continue your journey</p>
            </div>

            <form action="login.php" method="post" class="login-form" onsubmit="return handleSubmit(event)">
                <?php if ($error_message): ?>
                    <div class="alert alert-error">
                        <div class="alert-icon">⚠️</div>
                        <span><?php echo htmlspecialchars($error_message); ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($success_message): ?>
                    <div class="alert alert-success">
                        <div class="alert-icon">✅</div>
                        <span><?php echo htmlspecialchars($success_message); ?></span>
                    </div>
                <?php endif; ?>

                <div class="input-group">
                    <div class="input-field">
                        <div class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <input type="text" id="username" name="username" required placeholder=" ">
                        <label for="username">Username</label>
                        <div class="input-highlight"></div>
                    </div>
                    <div class="error-message" id="username-error"></div>
                </div>

                <div class="input-group">
                    <div class="input-field">
                        <div class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <circle cx="12" cy="16" r="1"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" required placeholder=" ">
                        <label for="password">Password</label>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <svg id="show-password" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="hide-password" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                        <div class="input-highlight"></div>
                    </div>
                    <div class="error-message" id="password-error"></div>
                </div>

                <button type="submit" class="login-button" name="submit">
                    <span class="button-text">
                        <span class="button-icon">🚀</span>
                        Sign In
                    </span>
                    <div class="loading-spinner" style="display: none;">
                        <div class="spinner"></div>
                    </div>
                </button>

                <div class="divider">
                    <span>or</span>
                </div>

                <div class="signup-link">
                    <p>New here? <a href="signup.php">Create Account</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        let isSubmitting = false;
        let isPasswordVisible = false;

        function validateLoginForm() {
            const username = document.getElementById("username").value.trim();
            const password = document.getElementById("password").value;
            let isValid = true;

            // Clear previous errors
            document.getElementById("username-error").textContent = "";
            document.getElementById("password-error").textContent = "";

            if (username === "") {
                document.getElementById("username-error").textContent = "Username is required";
                isValid = false;
            } else if (username.length < 3) {
                document.getElementById("username-error").textContent = "Username must be at least 3 characters";
                isValid = false;
            }

            if (password === "") {
                document.getElementById("password-error").textContent = "Password is required";
                isValid = false;
            } else if (password.length < 6) {
                document.getElementById("password-error").textContent = "Password must be at least 6 characters";
                isValid = false;
            }

            return isValid;
        }

        function handleSubmit(event) {
            if (isSubmitting) {
                event.preventDefault();
                return false;
            }

            if (!validateLoginForm()) {
                event.preventDefault();
                return false;
            }

            isSubmitting = true;
            const button = document.querySelector('.login-button');
            const buttonText = button.querySelector('.button-text');
            const spinner = button.querySelector('.loading-spinner');

            button.disabled = true;
            button.classList.add('loading');
            buttonText.style.display = 'none';
            spinner.style.display = 'flex';

            return true;
        }

        function togglePassword() {
            const passwordField = document.getElementById('password');
            const showIcon = document.getElementById('show-password');
            const hideIcon = document.getElementById('hide-password');
            const characterHands = document.getElementById('character-hands');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                showIcon.style.display = 'none';
                hideIcon.style.display = 'block';
                characterHands.classList.remove('covering-eyes');
                isPasswordVisible = true;
            } else {
                passwordField.type = 'password';
                showIcon.style.display = 'block';
                hideIcon.style.display = 'none';
                characterHands.classList.add('covering-eyes');
                isPasswordVisible = false;
            }
        }

        // Real-time validation
        document.getElementById('username').addEventListener('input', function() {
            const username = this.value.trim();
            const errorElement = document.getElementById('username-error');
            
            if (username === '') {
                errorElement.textContent = 'Username is required';
            } else if (username.length < 3) {
                errorElement.textContent = 'Username must be at least 3 characters';
            } else {
                errorElement.textContent = '';
            }
        });

        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const errorElement = document.getElementById('password-error');
            
            if (password === '') {
                errorElement.textContent = 'Password is required';
            } else if (password.length < 6) {
                errorElement.textContent = 'Password must be at least 6 characters';
            } else {
                errorElement.textContent = '';
            }
        });

        // Character eye tracking
        document.addEventListener('mousemove', function(e) {
            if (isPasswordVisible) return;
            
            const eyes = document.querySelectorAll('.pupil');
            const character = document.getElementById('character');
            const rect = character.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;
            
            const angle = Math.atan2(e.clientY - centerY, e.clientX - centerX);
            const distance = Math.min(3, Math.sqrt(Math.pow(e.clientX - centerX, 2) + Math.pow(e.clientY - centerY, 2)) / 50);
            
            eyes.forEach(eye => {
                const x = Math.cos(angle) * distance;
                const y = Math.sin(angle) * distance;
                eye.style.transform = `translate(${x}px, ${y}px)`;
            });
        });

        // Initialize character hands covering eyes when password field is focused
        document.getElementById('password').addEventListener('focus', function() {
            if (!isPasswordVisible) {
                document.getElementById('character-hands').classList.add('covering-eyes');
            }
        });

        document.getElementById('password').addEventListener('blur', function() {
            if (!isPasswordVisible) {
                document.getElementById('character-hands').classList.remove('covering-eyes');
            }
        });
    </script>
</body>
</html>