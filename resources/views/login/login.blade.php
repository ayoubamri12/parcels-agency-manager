<style>
    /* Login Form Container */
    .login-form {
        background-color: #fff;
        width: 100%;
        max-width: 400px;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    /* Lock Icon Animation */
    .login-form .lock-icon {
        font-size: 2.5rem;
        color: orange;
        margin-bottom: 10px;
        animation: bounce 1.5s infinite;
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    /* Title Styling */
    .login-form h2 {
        font-size: 1.5rem;
        margin-bottom: 20px;
        color: #333;
    }

    /* Input Styling */
    .login-form .input-group {
        position: relative;
        margin-bottom: 20px;
    }

    .login-form input {
        width: 100%;
        padding: 12px;
        padding-left: 40px;
        font-size: 1rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        transition: border 0.3s ease;
    }

    .login-form input:focus {
        border-color: orange;
        outline: none;
    }

    /* Input Icon */
    .input-icon {
        position: absolute;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        color: #aaa;
        transition: color 0.3s ease;
    }

    .login-form input:focus~.input-icon {
        color: orange;
    }

    /* Button Styling */
    .login-form button {
        width: 100%;
        padding: 12px;
        font-size: 1rem;
        color: #fff;
        background-color: orange;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .login-form button:hover {
        background-color: orang;
    }

    /* Subtle Shadow on Focus */
    .login-form input:focus,
    .login-form button:focus {
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    /* Toast Styling */
    .toast {
        display: flex;
        align-items: center;
        background: rgba(242, 220, 76, 0.9);
        /* Foggy Color */
        color: #fff;
        padding: 15px 20px;
        border-radius: 8px;
        width: 350px;
        box-shadow: 0 4px 15px rgba(209, 160, 62, 0.8);
        opacity: 0;
        transform: translateX(100%);
        animation: slideIn 0.5s forwards, fadeOut 0.5s 3.5s forwards;
        position: relative;
    }

    /* Slide In and Fade Out Animations */
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }

        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }

    /* Timer Bar */
    .toast::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background-color: #ff0000;
        /* Yellow color for timer */
        animation: timer 3.5s linear forwards;
    }

    @keyframes timer {
        from {
            width: 100%;
        }

        to {
            width: 0;
        }
    }

    /* Icon Styling */
    .toast .icon {
        font-size: 1.5rem;
        margin-right: 15px;
    }

    /* Close Button Styling */
    .toast .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: none;
        border: none;
        color: #fff;
        font-size: 1.2rem;
        cursor: pointer;
    }

    /* Message Styling */
    .toast .message {
        flex: 1;
        font-size: 1rem;
        line-height: 1.4;
    }
    @media (max-width: 768px) {
        .login-form {
            width: 94%;
            padding: 1.5rem;
        }

        .login-btn {
            padding: 0.65rem;
        }

        .input-group label, .input-group input {
            font-size: 0.85rem;
        }
    }
     /* Responsive Styles */
    
</style>
<x-layout>
    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>
    @if(session('error'))
    <script>
        // Function to Show Toast Notification
    
            const toastContainer = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.classList.add('toast');
    
            toast.innerHTML = `
                <span class="icon" style='color:red;'><i class="fas fa-exclamation-circle"></i></span>
                <div class="message">
                    <strong style='color:red;'>Login error</strong><br>
                    error
                </div>
                <button class="close-btn" onclick="this.parentElement.remove()">×</button>
            `;
    
            // Append Toast to Container
            toastContainer.appendChild(toast);
    
            // Remove Toast After 3.5 Seconds
            setTimeout(() => {
                toast.remove();
            }, 3500);
        
    </script>
    @endif
    <!-- Button to Trigger Toast -->
    <div class="d-flex justify-content-center align-items-center h-100">
        <div class="login-form">
            <!-- Lock Icon -->
            <i class="fas fa-lock lock-icon"></i>

            <!-- Form Title -->
            <h2>Login to Your Account</h2>

            <!-- Username Input Group -->
            <form action="{{route("auth")}}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="email"  placeholder="Username">
                    <i class="fas fa-user input-icon"></i>
                </div>

                <!-- Password Input Group -->
                <div class="input-group">
                    <input type="password" name="password"  placeholder="Password">
                    <i class="fas fa-key input-icon"></i>
                </div>
                <button type="submit">Login</button>
            </form>

            <!-- Login Button -->
        </div>
    </div>
</x-layout>

