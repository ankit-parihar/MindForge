<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contactus_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Ensure all required fields exist
    if (!isset($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message'])) {
        header("Location: contact.php?error=missing");
        exit();
    }

    // Escape user inputs
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = !empty($_POST['phone']) ? $conn->real_escape_string($_POST['phone']) : NULL;
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);

    // Prepared statement
    $stmt = $conn->prepare("INSERT INTO contact (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");

    // Bind parameters
    $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);

    // Execute
    if ($stmt->execute()) {
        header("Location: contact.php?success=1");
        exit();
    } else {
        header("Location: contact.php?error=1");
        exit();
    }
}

$conn->close();
?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #0f0f23;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Animated Background */
        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 25%, #16213e 50%, #0f3460 75%, #533483 100%);
            background-size: 400% 400%;
            animation: gradientShift 20s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating Orbs */
        .floating-orb {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(45deg, rgba(139, 92, 246, 0.1), rgba(59, 130, 246, 0.1));
            backdrop-filter: blur(10px);
            animation: float 25s ease-in-out infinite;
            box-shadow: 0 0 30px rgba(139, 92, 246, 0.2);
        }

        .orb-1 {
            width: 120px;
            height: 120px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 80px;
            height: 80px;
            top: 70%;
            right: 15%;
            animation-delay: 8s;
        }

        .orb-3 {
            width: 60px;
            height: 60px;
            bottom: 30%;
            left: 70%;
            animation-delay: 16s;
        }

        .orb-4 {
            width: 100px;
            height: 100px;
            top: 40%;
            right: 60%;
            animation-delay: 12s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg) scale(1); }
            25% { transform: translateY(-30px) rotate(90deg) scale(1.1); }
            50% { transform: translateY(20px) rotate(180deg) scale(0.9); }
            75% { transform: translateY(-20px) rotate(270deg) scale(1.05); }
        }

        /* Particle System */
        .particle-container {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: rgba(139, 92, 246, 0.6);
            border-radius: 50%;
            animation: particleFloat 30s linear infinite;
            box-shadow: 0 0 10px rgba(139, 92, 246, 0.3);
        }

        .particle:nth-child(1) { left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { left: 25%; animation-delay: 5s; }
        .particle:nth-child(3) { left: 40%; animation-delay: 10s; }
        .particle:nth-child(4) { left: 60%; animation-delay: 15s; }
        .particle:nth-child(5) { left: 75%; animation-delay: 20s; }
        .particle:nth-child(6) { left: 90%; animation-delay: 25s; }

        @keyframes particleFloat {
            0% { transform: translateY(100vh) scale(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100vh) scale(1); opacity: 0; }
        }

        /* Container */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* Contact Box */
        .contact-box {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 800px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow:
                0 25px 50px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.05),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            animation: slideUp 0.8s ease-out;
            position: relative;
        }

        .contact-box::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #8b5cf6, #3b82f6, #06b6d4, #8b5cf6);
            border-radius: 26px;
            z-index: -1;
            opacity: 0.3;
            animation: borderGlow 4s ease-in-out infinite;
        }

        @keyframes borderGlow {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.6; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Contact Header */
        .contact-header {
            text-align: center;
            margin-bottom: 40px;
        }

        /* Character */
        .character-container {
            margin-bottom: 30px;
        }

        .character {
            width: 100px;
            height: 100px;
            margin: 0 auto;
            position: relative;
        }

        .character-face {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 50%;
            position: relative;
            box-shadow:
                0 10px 30px rgba(16, 185, 129, 0.3),
                inset 0 -10px 20px rgba(0, 0, 0, 0.1);
            animation: characterBreathe 4s ease-in-out infinite;
        }

        @keyframes characterBreathe {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .character-eyes {
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 20px;
        }

        .eye {
            width: 16px;
            height: 16px;
            background: white;
            border-radius: 50%;
            position: relative;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .pupil {
            width: 8px;
            height: 8px;
            background: #1f2937;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            transition: transform 0.1s ease;
        }

        .character-mouth {
            position: absolute;
            bottom: 25%;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 10px;
            background: #dc2626;
            border-radius: 20px 20px 0 0;
            box-shadow: inset 0 -2px 4px rgba(0, 0, 0, 0.2);
        }

        .contact-header h1 {
            font-size: 2.2rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 12px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            line-height: 1.2;
        }

        .contact-header p {
            color: #e2e8f0;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
        }

        /* Form Styles */
        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* Two-column layout for desktop */
        @media (min-width: 768px) {
            .form-row {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }
            
            .form-row .input-group {
                margin: 0;
            }
        }

        /* Alert Messages */
        .alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 20px;
            border-radius: 16px;
            font-size: 0.95rem;
            font-weight: 500;
            animation: slideIn 0.5s ease-out;
            backdrop-filter: blur(10px);
            line-height: 1.4;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-icon {
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            color: #ffffff;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.15);
            color: #ffffff;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        /* Input Groups */
        .input-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            position: relative;
        }

        .input-field {
            position: relative;
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            width: 20px;
            height: 20px;
            color: #94a3b8;
            z-index: 2;
            transition: color 0.3s ease;
        }

        .input-field input,
        .input-field textarea {
            width: 100%;
            padding: 18px 18px 18px 54px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 16px;
            color: #ffffff;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            line-height: 1.4;
            font-family: inherit;
            resize: vertical;
        }

        .input-field textarea {
            min-height: 120px;
            max-height: 200px;
            padding-top: 18px;
        }

        .input-field input:focus,
        .input-field textarea:focus {
            outline: none;
            border-color: #8b5cf6;
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15);
            transform: translateY(-1px);
        }

        .input-field input:focus + label,
        .input-field textarea:focus + label {
            transform: translateY(-38px) scale(0.85);
            color: #a78bfa;
            font-weight: 600;
        }

        .input-field input:not(:placeholder-shown) + label,
        .input-field textarea:not(:placeholder-shown) + label {
            transform: translateY(-38px) scale(0.85);
            color: #a78bfa;
            font-weight: 600;
        }

        .input-field input:focus ~ .input-icon,
        .input-field textarea:focus ~ .input-icon {
            color: #8b5cf6;
            transform: scale(1.1);
        }

        .input-field label {
            position: absolute;
            left: 54px;
            top: 18px;
            color: #cbd5e1;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            pointer-events: none;
            transform-origin: left top;
            line-height: 1.2;
            z-index: 1;
        }

        .input-highlight {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #8b5cf6, #3b82f6);
            border-radius: 0 0 16px 16px;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .input-field input:focus ~ .input-highlight,
        .input-field textarea:focus ~ .input-highlight {
            transform: scaleX(1);
        }

        /* Error Messages */
        .error-message {
            color: #fca5a5;
            font-size: 0.875rem;
            font-weight: 500;
            margin-left: 8px;
            margin-top: 4px;
            min-height: 24px;
            transition: opacity 0.3s ease;
            line-height: 1.4;
            display: block;
        }

        .error-message:empty {
            opacity: 0;
        }

        /* Submit Button */
        .submit-button {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            padding: 18px 24px;
            border-radius: 16px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 56px;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
            margin-top: 8px;
            line-height: 1.2;
        }

        .submit-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .submit-button:hover::before {
            left: 100%;
        }

        .submit-button:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 15px 40px rgba(16, 185, 129, 0.4);
        }

        .submit-button:active {
            transform: translateY(0) scale(0.98);
        }

        .submit-button:disabled {
            cursor: not-allowed;
            opacity: 0.7;
        }

        .button-text {
            display: flex;
            align-items: center;
            gap: 8px;
            line-height: 1.2;
        }

        .button-icon {
            font-size: 1.2rem;
            animation: paperPlane 2s ease-in-out infinite;
        }

        @keyframes paperPlane {
            0%, 100% { transform: translateX(0) rotate(0deg); }
            50% { transform: translateX(3px) rotate(5deg); }
        }

        /* Loading Spinner */
        .loading-spinner {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Contact Info */
        .contact-info {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .contact-info h3 {
            color: #ffffff;
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 16px;
            text-align: center;
        }

        .contact-methods {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .contact-method {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .contact-method:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .contact-method-icon {
            width: 24px;
            height: 24px;
            color: #10b981;
            flex-shrink: 0;
        }

        .contact-method-text {
            color: #e2e8f0;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Success Message */
        .success-message {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 2rem 3rem;
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            z-index: 10000;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(20px);
        }

        .success-message.show {
            transform: translate(-50%, -50%) scale(1);
        }

        .success-message h3 {
            margin-bottom: 1rem;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .success-message p {
            font-size: 1rem;
            opacity: 0.9;
        }

        /* Overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* Responsive Design */
        @media (min-width: 1200px) {
            .contact-box {
                max-width: 900px;
                padding: 40px 60px;
            }
        }
        
        @media (min-width: 1200px) {
            .contact-box {
                max-width: 800px;
                padding: 50px 60px;
            }
            
            .contact-header h1 {
                font-size: 2.5rem;
            }
            
            .input-field input,
            .input-field textarea {
                padding: 20px 20px 20px 60px;
                font-size: 1.1rem;
            }
            
            .input-field textarea {
                padding-top: 20px;
                min-height: 140px;
            }
            
            .input-field label {
                left: 60px;
                top: 20px;
                font-size: 1.1rem;
            }
            
            .input-field input:focus + label,
            .input-field input:not(:placeholder-shown) + label,
            .input-field textarea:focus + label,
            .input-field textarea:not(:placeholder-shown) + label {
                transform: translateY(-42px) scale(0.85);
            }
            
            .input-icon {
                left: 20px;
                width: 22px;
                height: 22px;
            }
            
            .submit-button {
                padding: 20px 28px;
                font-size: 1.2rem;
                min-height: 60px;
            }
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            .form-row {
                display: flex !important;
                flex-direction: column !important;
                gap: 24px !important;
            }

            .contact-box {
                padding: 35px 30px;
                border-radius: 20px;
                max-width: 100%;
            }

            .contact-header h1 {
                font-size: 1.9rem;
            }

            .character {
                width: 80px;
                height: 80px;
            }

            .character-eyes {
                gap: 16px;
            }

            .eye {
                width: 14px;
                height: 14px;
            }

            .pupil {
                width: 7px;
                height: 7px;
            }

            .input-field input,
            .input-field textarea {
                padding: 16px 16px 16px 50px;
                font-size: 0.95rem;
            }

            .input-field textarea {
                padding-top: 16px;
            }

            .input-field label {
                left: 50px;
                top: 16px;
                font-size: 0.95rem;
            }

            .input-field input:focus + label,
            .input-field input:not(:placeholder-shown) + label,
            .input-field textarea:focus + label,
            .input-field textarea:not(:placeholder-shown) + label {
                transform: translateY(-36px) scale(0.85);
            }

            .input-icon {
                left: 16px;
                width: 18px;
                height: 18px;
            }

            .submit-button {
                padding: 16px 20px;
                font-size: 1rem;
                min-height: 52px;
            }

            .error-message {
                font-size: 0.8rem;
                min-height: 22px;
            }

            .contact-methods {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 15px;
            }

            .contact-box {
                padding: 30px 25px;
                border-radius: 18px;
                margin: 15px;
            }

            .contact-header h1 {
                font-size: 1.7rem;
            }

            .contact-header p {
                font-size: 0.9rem;
            }

            .character {
                width: 70px;
                height: 70px;
            }

            .character-eyes {
                gap: 14px;
            }

            .eye {
                width: 12px;
                height: 12px;
            }

            .pupil {
                width: 6px;
                height: 6px;
            }

            .input-field input,
            .input-field textarea {
                padding: 15px 15px 15px 48px;
                font-size: 0.9rem;
            }

            .input-field textarea {
                padding-top: 15px;
            }

            .input-field label {
                left: 48px;
                top: 15px;
                font-size: 0.9rem;
            }

            .input-field input:focus + label,
            .input-field input:not(:placeholder-shown) + label,
            .input-field textarea:focus + label,
            .input-field textarea:not(:placeholder-shown) + label {
                transform: translateY(-34px) scale(0.85);
            }

            .input-icon {
                left: 15px;
                width: 17px;
                height: 17px;
            }

            .submit-button {
                padding: 15px 18px;
                font-size: 0.95rem;
                min-height: 50px;
            }

            .floating-orb {
                transform: scale(0.8);
            }

            .error-message {
                font-size: 0.75rem;
                min-height: 20px;
            }

            .success-message {
                padding: 1.5rem 2rem;
                margin: 20px;
                max-width: calc(100vw - 40px);
            }
        }

        @media (max-width: 360px) {
            .container {
                padding: 10px;
            }

            .contact-box {
                padding: 25px 20px;
                margin: 10px;
            }

            .contact-header h1 {
                font-size: 1.5rem;
            }

            .character {
                width: 60px;
                height: 60px;
            }

            .input-field input,
            .input-field textarea {
                padding: 14px 14px 14px 45px;
                font-size: 0.85rem;
            }

            .input-field textarea {
                padding-top: 14px;
            }

            .input-field label {
                left: 45px;
                top: 14px;
                font-size: 0.85rem;
            }

            .input-field input:focus + label,
            .input-field input:not(:placeholder-shown) + label,
            .input-field textarea:focus + label,
            .input-field textarea:not(:placeholder-shown) + label {
                transform: translateY(-32px) scale(0.85);
            }

            .input-icon {
                left: 14px;
                width: 16px;
                height: 16px;
            }

            .error-message {
                font-size: 0.7rem;
                min-height: 18px;
            }
        }

        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* Focus styles for keyboard navigation */
        .submit-button:focus,
        .input-field input:focus,
        .input-field textarea:focus {
            outline: 2px solid #10b981;
            outline-offset: 2px;
        }

        /* Print styles */
        @media print {
            .background,
            .floating-orb,
            .particle-container {
                display: none;
            }

            .contact-box {
                background: white;
                box-shadow: none;
                border: 1px solid #ccc;
            }

            .contact-header h1,
            .input-field input,
            .input-field textarea,
            .input-field label,
            .submit-button {
                color: #000;
            }
        }
    </style>
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

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <div class="container">
        <div class="contact-box">
            <div class="contact-header">
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
                            <div class="character-mouth"></div>
                        </div>
                    </div>
                </div>
                <h1>Get In Touch!</h1>
                <p>We'd love to hear from you. Send us a message!</p>
            </div>

            <form class="contact-form" id="contactForm" action="contact.php" method="POST">

                <div class="alert alert-success" id="success-alert" style="display: none;">
                    <div class="alert-icon">✅</div>
                    <span>Message sent successfully! We'll get back to you soon.</span>
                </div>

                <!-- First row: Name and Email -->
                <div class="form-row">
                    <div class="input-group">
                        <div class="input-field">
                            <div class="input-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </div>
                           <input type="text" id="name" name="name" required placeholder=" ">
                            <label for="name">Full Name</label>
                            <div class="input-highlight"></div>
                        </div>
                        <div class="error-message" id="name-error"></div>
                    </div>

                    <div class="input-group">
                        <div class="input-field">
                            <div class="input-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                            </div>
                            <input type="email" id="email" name="email" required placeholder=" ">
                            <label for="email">Email Address</label>
                            <div class="input-highlight"></div>
                        </div>
                        <div class="error-message" id="email-error"></div>
                    </div>
                </div>

                <!-- Second row: Phone and Subject -->
                <div class="form-row">
                    <div class="input-group">
                        <div class="input-field">
                            <div class="input-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                            </div>
                            <input type="tel" id="phone" name="phone" placeholder=" ">
                            <label for="phone">Phone Number (Optional)</label>
                            <div class="input-highlight"></div>
                        </div>
                        <div class="error-message" id="phone-error"></div>
                    </div>

                    <div class="input-group">
                        <div class="input-field">
                            <div class="input-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                </svg>
                            </div>
                            <input type="text" id="subject" name="subject" required placeholder=" ">
                            <label for="subject">Subject</label>
                            <div class="input-highlight"></div>
                        </div>
                        <div class="error-message" id="subject-error"></div>
                    </div>
                </div>

                <!-- Third row: Message (full width) -->
                <div class="input-group">
                    <div class="input-field">
                        <div class="input-icon" style="top: 18px;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14,2 14,8 20,8"/>
                                <line x1="16" y1="13" x2="8" y2="13"/>
                                <line x1="16" y1="17" x2="8" y2="17"/>
                                <polyline points="10,9 9,9 8,9"/>
                            </svg>
                        </div>
                        <textarea id="message" name="message" required placeholder=" "></textarea>
                        <label for="message">Your Message</label>
                        <div class="input-highlight"></div>
                    </div>
                    <div class="error-message" id="message-error"></div>
                </div>

                <button type="submit" class="submit-button" id="submit-btn">
                    <span class="button-text" id="button-text">
                        Send Message
                    </span>
                    <div class="loading-spinner" id="loading-spinner" style="display: none;">
                        <div class="spinner"></div>
                    </div>
                </button>
            </form>
        </div>
    </div>

    <!-- Success Message -->
    <div class="success-message" id="success-message">
        <h3>🎉 Message Sent!</h3>
        <p>Thank you for reaching out. We'll get back to you soon!</p>
    </div>

    <script>
        let isSubmitting = false;

        // Check for success parameter in URL
        window.addEventListener('load', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('success') === '1') {
                showSuccessMessage();
                // Remove the parameter from URL
                const newUrl = window.location.pathname;
                window.history.replaceState({}, document.title, newUrl);
            }
        });

        function validateContactForm() {
            const name = document.getElementById("name").value.trim();
            const email = document.getElementById("email").value.trim();
            const subject = document.getElementById("subject").value.trim();
            const message = document.getElementById("message").value.trim();
            let isValid = true;

            // Clear previous errors
            document.getElementById("name-error").textContent = "";
            document.getElementById("email-error").textContent = "";
            document.getElementById("subject-error").textContent = "";
            document.getElementById("message-error").textContent = "";

            // Validate full name
            if (name === "") {
                document.getElementById("name-error").textContent = "Full name is required";
                isValid = false;
            } else if (name.length < 2) {
                document.getElementById("name-error").textContent = "Full name must be at least 2 characters";
                isValid = false;
            }

            // Validate email
            if (email === "") {
                document.getElementById("email-error").textContent = "Email is required";
                isValid = false;
            } else if (!isValidEmail(email)) {
                document.getElementById("email-error").textContent = "Please enter a valid email address";
                isValid = false;
            }

            // Validate subject
            if (subject === "") {
                document.getElementById("subject-error").textContent = "Subject is required";
                isValid = false;
            } else if (subject.length < 3) {
                document.getElementById("subject-error").textContent = "Subject must be at least 3 characters";
                isValid = false;
            }

            // Validate message
            if (message === "") {
                document.getElementById("message-error").textContent = "Message is required";
                isValid = false;
            } else if (message.length < 10) {
                document.getElementById("message-error").textContent = "Message must be at least 10 characters";
                isValid = false;
            }

            return isValid;
        }

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function showSuccessMessage() {
            const overlay = document.getElementById('overlay');
            const successMessage = document.getElementById('success-message');
            
            overlay.classList.add('show');
            successMessage.classList.add('show');
            
            // Hide the message after 4 seconds
            setTimeout(function() {
                hideSuccessMessage();
            }, 4000);
        }

        function hideSuccessMessage() {
            const overlay = document.getElementById('overlay');
            const successMessage = document.getElementById('success-message');
            
            overlay.classList.remove('show');
            successMessage.classList.remove('show');
        }

        // Form submission with loading state
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            if (!validateContactForm()) {
                e.preventDefault();
                return;
            }

            if (isSubmitting) {
                e.preventDefault();
                return;
            }

            isSubmitting = true;
            const submitBtn = document.getElementById('submit-btn');
            const buttonText = document.getElementById('button-text');
            const loadingSpinner = document.getElementById('loading-spinner');

            // Show loading state
            buttonText.style.display = 'none';
            loadingSpinner.style.display = 'flex';
            submitBtn.disabled = true;
        });

        // Click overlay to close success message
        document.getElementById('overlay').addEventListener('click', function() {
            hideSuccessMessage();
        });

        // Real-time validation
        document.getElementById('name').addEventListener('input', function() {
            const name = this.value.trim();
            const errorElement = document.getElementById('name-error');
            
            if (name === '') {
                errorElement.textContent = 'Full name is required';
            } else if (name.length < 2) {
                errorElement.textContent = 'Full name must be at least 2 characters';
            } else {
                errorElement.textContent = '';
            }
        });

        document.getElementById('email').addEventListener('input', function() {
            const email = this.value.trim();
            const errorElement = document.getElementById('email-error');
            
            if (email === '') {
                errorElement.textContent = 'Email is required';
            } else if (!isValidEmail(email)) {
                errorElement.textContent = 'Please enter a valid email address';
            } else {
                errorElement.textContent = '';
            }
        });

        document.getElementById('subject').addEventListener('input', function() {
            const subject = this.value.trim();
            const errorElement = document.getElementById('subject-error');
            
            if (subject === '') {
                errorElement.textContent = 'Subject is required';
            } else if (subject.length < 3) {
                errorElement.textContent = 'Subject must be at least 3 characters';
            } else {
                errorElement.textContent = '';
            }
        });

        document.getElementById('message').addEventListener('input', function() {
            const message = this.value.trim();
            const errorElement = document.getElementById('message-error');
            
            if (message === '') {
                errorElement.textContent = 'Message is required';
            } else if (message.length < 10) {
                errorElement.textContent = 'Message must be at least 10 characters';
            } else {
                errorElement.textContent = '';
            }
        });

        // Character eye tracking
        document.addEventListener('mousemove', function(e) {
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

        // Enhanced console message
        console.log(`
        📞 Welcome to our Contact Page!
        ===============================
        
        Features:
        ✨ Beautiful animated form with validation
        📱 Fully responsive design
        🎯 Real-time form validation
        📧 Email format validation
        🎨 Stunning visual effects
        
        Built with modern web technologies! 🚀
        `);
    </script>
</body>
</html>