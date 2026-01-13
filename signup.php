<?php
include('db.php');

$admin_password = "secret123";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $locality = trim($_POST['locality']);
    $password_raw = $_POST['password'];        // User input password
    $admin_input = $_POST['admin_password'];

    // Admin password check
    if ($admin_input !== $admin_password) {
        $error_message = "❌ You can't sign up without the correct admin password.";
    } else {

        // Hashing the actual password FIX
        $password = password_hash($password_raw, PASSWORD_BCRYPT);

        // Prepare and execute query
        $stmt = $conn->prepare(
            "INSERT INTO users (username, email, locality, password) VALUES (?, ?, ?, ?)"
        );

        if (!$stmt) {
            die("SQL Error: " . $conn->error);
        }

        $stmt->bind_param("ssss", $username, $email, $locality, $password);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $error_message = "Error: " . $stmt->error;
        }
    }
}
?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="./css/signup.css">
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

    <div class="box"> 
        <div class="form">
            <form action="signup.php" method="post" onsubmit="return validateSignupForm()">
                <h2>REGISTER</h2>
                
                <!-- Character Container -->
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

                <!-- Show error message if set -->
                <?php if (!empty($error_message)): ?>
                    <div class="error-box">
                        <div class="alert-icon">⚠️</div>
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <div class="inputbox">
                    <input type="text" id="username" name="username" required>
                    <span>Name Your Account</span>
                    <i></i>
                </div>

                <div class="inputbox">
                    <input type="email" id="email" name="email" required>
                    <span>Enter Your Email Address</span>
                    <i></i>
                </div>

                <div class="inputbox">
                    <input type="text" id="locality" name="locality" required>
                    <span>Locality</span>
                    <i></i>
                </div>

                <div class="inputbox">
                    <input type="password" id="password" name="password" required>
                    <span>Create a Password</span>
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <svg id="show-password" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg id="hide-password" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                    </button>
                    <i></i>
                </div>

                <!-- Admin Password Field -->
                <div class="inputbox">
                    <input type="password" id="admin_password" name="admin_password" required>
                    <span>Enter Admin Password</span>
                    <button type="button" class="password-toggle" onclick="togglePassword('admin_password')">
                        <svg id="show-admin-password" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg id="hide-admin-password" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                    </button>
                    <i></i>
                </div>

                <div class="links">
                    <a href="login.php">Already have an account? Log in</a>
                </div>
                <input type="submit" value="Create Account" name="submit">
            </form>
        </div>
    </div>

    <script>
        function validateSignupForm() {
            var username = document.getElementById("username").value.trim();
            var email = document.getElementById("email").value.trim();
            var locality = document.getElementById("locality").value.trim();
            var password = document.getElementById("password").value;
            var adminPassword = document.getElementById("admin_password").value;

            if (username === "" || email === "" || locality === "" || password === "" || adminPassword === "") {
                alert("All fields are required, including the Admin Password.");
                return false;
            }

            var emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            if (!email.match(emailPattern)) {
                alert("Please enter a valid email address.");
                return false;
            }

            if (password.length < 6) {
                alert("Password must be at least 6 characters long.");
                return false;
            }

            return true;
        }

        let isPasswordVisible = false;
        let isAdminPasswordVisible = false;

        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const characterHands = document.getElementById('character-hands');
            
            if (fieldId === 'password') {
                const showIcon = document.getElementById('show-password');
                const hideIcon = document.getElementById('hide-password');
                
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    showIcon.style.display = 'none';
                    hideIcon.style.display = 'block';
                    isPasswordVisible = true;
                } else {
                    passwordField.type = 'password';
                    showIcon.style.display = 'block';
                    hideIcon.style.display = 'none';
                    isPasswordVisible = false;
                }
            } else if (fieldId === 'admin_password') {
                const showIcon = document.getElementById('show-admin-password');
                const hideIcon = document.getElementById('hide-admin-password');
                
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    showIcon.style.display = 'none';
                    hideIcon.style.display = 'block';
                    isAdminPasswordVisible = true;
                } else {
                    passwordField.type = 'password';
                    showIcon.style.display = 'block';
                    hideIcon.style.display = 'none';
                    isAdminPasswordVisible = false;
                }
            }
            
            // Update character hands based on any password visibility
            if (isPasswordVisible || isAdminPasswordVisible) {
                characterHands.classList.remove('covering-eyes');
            } else {
                characterHands.classList.add('covering-eyes');
            }
        }

        // Character eye tracking
        document.addEventListener('mousemove', function(e) {
            if (isPasswordVisible || isAdminPasswordVisible) return;
            
            const eyes = document.querySelectorAll('.pupil');
            const character = document.getElementById('character');
            if (!character) return;
            
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

        // Initialize character hands covering eyes when password fields are focused
        document.getElementById('password').addEventListener('focus', function() {
            if (!isPasswordVisible) {
                document.getElementById('character-hands').classList.add('covering-eyes');
            }
        });

        document.getElementById('admin_password').addEventListener('focus', function() {
            if (!isAdminPasswordVisible) {
                document.getElementById('character-hands').classList.add('covering-eyes');
            }
        });

        document.getElementById('password').addEventListener('blur', function() {
            if (!isPasswordVisible && !isAdminPasswordVisible) {
                document.getElementById('character-hands').classList.remove('covering-eyes');
            }
        });

        document.getElementById('admin_password').addEventListener('blur', function() {
            if (!isPasswordVisible && !isAdminPasswordVisible) {
                document.getElementById('character-hands').classList.remove('covering-eyes');
            }
        });
    </script>
</body>
</html>