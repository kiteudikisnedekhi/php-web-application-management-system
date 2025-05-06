<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary to-secondary py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg">
        <!-- Logo and Title -->
        <div class="text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">HAVMORICE</h1>
            <p class="text-sm text-gray-600">
                <?php if ($isApp): ?>
                    Enter your mobile number to continue
                <?php else: ?>
                    Download our app for a better experience with Truecaller login
                <?php endif; ?>
            </p>
        </div>

        <?php if (!$isApp): ?>
        <!-- App Download Banner -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-mobile-alt text-blue-500 text-2xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Use our Android app</h3>
                    <p class="text-sm text-blue-600">Get quick access with Truecaller 1-tap sign in</p>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form id="loginForm" class="mt-8 space-y-6">
            <div class="rounded-md shadow-sm -space-y-px">
                <div class="flex">
                    <span class="inline-flex items-center px-4 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        +91
                    </span>
                    <input type="tel" id="mobile" name="mobile" required
                        class="appearance-none rounded-r-md relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-primary focus:border-primary focus:z-10 text-lg"
                        placeholder="Enter mobile number"
                        pattern="[0-9]{10}"
                        maxlength="10">
                </div>
            </div>

            <!-- OTP Input (Hidden initially) -->
            <div id="otpContainer" class="hidden space-y-4">
                <div class="flex justify-between items-center">
                    <label class="block text-sm font-medium text-gray-700">Enter OTP</label>
                    <button type="button" id="resendOtp" class="text-sm text-primary hover:text-primary-dark hidden">
                        Resend OTP
                    </button>
                </div>
                <div class="flex space-x-2 justify-center">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl border-2 rounded-lg focus:border-primary focus:outline-none">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl border-2 rounded-lg focus:border-primary focus:outline-none">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl border-2 rounded-lg focus:border-primary focus:outline-none">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl border-2 rounded-lg focus:border-primary focus:outline-none">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl border-2 rounded-lg focus:border-primary focus:outline-none">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl border-2 rounded-lg focus:border-primary focus:outline-none">
                </div>
            </div>

            <div>
                <button type="submit" id="submitButton"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-arrow-right text-primary-dark group-hover:text-primary-light"></i>
                    </span>
                    Get OTP
                </button>
            </div>
        </form>

        <!-- Error Message -->
        <div id="errorMessage" class="hidden mt-4 text-center text-sm text-red-600"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const mobileInput = document.getElementById('mobile');
    const otpContainer = document.getElementById('otpContainer');
    const submitButton = document.getElementById('submitButton');
    const resendOtp = document.getElementById('resendOtp');
    const errorMessage = document.getElementById('errorMessage');
    const otpInputs = document.querySelectorAll('.otp-input');
    let otpRequestSent = false;

    // Handle OTP input behavior
    otpInputs.forEach((input, index) => {
        input.addEventListener('keyup', (e) => {
            if (e.key !== 'Backspace' && input.value) {
                const next = otpInputs[index + 1];
                if (next) next.focus();
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !input.value) {
                const prev = otpInputs[index - 1];
                if (prev) prev.focus();
            }
        });
    });

    // Form submission handler
    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        errorMessage.classList.add('hidden');

        if (!otpRequestSent) {
            // Send OTP
            if (!validateMobile()) return;
            
            try {
                showLoading();
                const response = await fetch('/login/otp/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        mobile: mobileInput.value
                    })
                });

                const data = await response.json();
                
                if (response.ok) {
                    otpRequestSent = true;
                    otpContainer.classList.remove('hidden');
                    submitButton.textContent = 'Verify OTP';
                    mobileInput.disabled = true;
                    
                    // Show resend button after 30 seconds
                    setTimeout(() => {
                        resendOtp.classList.remove('hidden');
                    }, 30000);

                    // If in development, auto-fill OTP
                    if (data.otp) {
                        const otpDigits = data.otp.split('');
                        otpInputs.forEach((input, index) => {
                            input.value = otpDigits[index] || '';
                        });
                    }
                } else {
                    showError(data.error || 'Failed to send OTP');
                }
            } catch (error) {
                showError('An error occurred. Please try again.');
            } finally {
                hideLoading();
            }
        } else {
            // Verify OTP
            const otp = Array.from(otpInputs).map(input => input.value).join('');
            if (!otp || otp.length !== 6) {
                showError('Please enter a valid OTP');
                return;
            }

            try {
                showLoading();
                const response = await fetch('/login/otp/verify', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        mobile: mobileInput.value,
                        otp: otp
                    })
                });

                const data = await response.json();
                
                if (response.ok) {
                    window.location.href = data.redirect;
                } else {
                    showError(data.error || 'Invalid OTP');
                }
            } catch (error) {
                showError('An error occurred. Please try again.');
            } finally {
                hideLoading();
            }
        }
    });

    // Resend OTP handler
    resendOtp.addEventListener('click', async () => {
        resendOtp.classList.add('hidden');
        otpInputs.forEach(input => input.value = '');
        otpRequestSent = false;
        loginForm.dispatchEvent(new Event('submit'));
    });

    function validateMobile() {
        const mobile = mobileInput.value;
        if (!mobile || !/^[0-9]{10}$/.test(mobile)) {
            showError('Please enter a valid 10-digit mobile number');
            return false;
        }
        return true;
    }

    function showError(message) {
        errorMessage.textContent = message;
        errorMessage.classList.remove('hidden');
    }
});
</script>
