<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary to-secondary py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg">
        <!-- Logo and Title -->
        <div class="text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">HAVMORICE</h1>
            <p class="text-sm text-gray-600">Quick login with Truecaller</p>
        </div>

        <!-- Truecaller Login Button -->
        <div class="mt-8">
            <button id="truecallerLoginBtn" 
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#1C97F3] hover:bg-[#1a88db] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1C97F3]">
                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <img src="https://truecaller.com/favicon.ico" alt="Truecaller" class="h-5 w-5">
                </span>
                Login with Truecaller
            </button>
        </div>

        <!-- Alternative Login Option -->
        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Or continue with</span>
                </div>
            </div>

            <div class="mt-6">
                <a href="/login" 
                   class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    <i class="fas fa-mobile-alt mr-2"></i>
                    Login with OTP
                </a>
            </div>
        </div>

        <!-- Privacy Notice -->
        <div class="mt-6">
            <p class="text-xs text-center text-gray-500">
                By continuing, you agree to our 
                <a href="/privacy" class="text-primary hover:text-primary-dark">Privacy Policy</a>
                and
                <a href="/terms" class="text-primary hover:text-primary-dark">Terms of Service</a>
            </p>
        </div>

        <!-- Error Message -->
        <div id="errorMessage" class="hidden mt-4 text-center text-sm text-red-600"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const truecallerLoginBtn = document.getElementById('truecallerLoginBtn');
    const errorMessage = document.getElementById('errorMessage');

    truecallerLoginBtn.addEventListener('click', async () => {
        try {
            showLoading();
            
            // In a real implementation, this would interact with the Android WebView
            // to trigger the Truecaller SDK. Here we'll simulate the response.
            
            // The Android app would inject a JavaScript interface like:
            // window.Android.requestTruecallerLogin()
            // which would then call back to JavaScript with the result
            
            if (window.Android && typeof window.Android.requestTruecallerLogin === 'function') {
                window.Android.requestTruecallerLogin();
            } else {
                // For development/testing, simulate a successful response
                if (window.location.hostname === 'localhost') {
                    await simulateTruecallerLogin();
                } else {
                    throw new Error('Truecaller login is only available in the Android app');
                }
            }
        } catch (error) {
            showError(error.message || 'Failed to login with Truecaller');
            hideLoading();
        }
    });

    // This function would be called by the Android WebView with the Truecaller response
    window.onTruecallerResponse = async function(payload, signature) {
        try {
            const response = await fetch('/login/truecaller', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ payload, signature })
            });

            const data = await response.json();
            
            if (response.ok) {
                window.location.href = data.redirect;
            } else {
                showError(data.error || 'Failed to verify Truecaller login');
            }
        } catch (error) {
            showError('An error occurred. Please try again.');
        } finally {
            hideLoading();
        }
    };

    // For development/testing only
    async function simulateTruecallerLogin() {
        const mockPayload = btoa(JSON.stringify({
            phoneNumber: '9876543210',
            name: 'Test User',
            email: 'test@example.com'
        }));
        const mockSignature = 'mock_signature';
        
        await window.onTruecallerResponse(mockPayload, mockSignature);
    }

    function showError(message) {
        errorMessage.textContent = message;
        errorMessage.classList.remove('hidden');
    }
});
</script>
