<!-- Auth Modal -->
<div id="auth-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity duration-300" onclick="document.getElementById('auth-modal').classList.add('hidden')"></div>

    <!-- Modal Content -->
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-100 opacity-100">
            <!-- Close Button -->
            <button onclick="document.getElementById('auth-modal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Modal Header -->
            <div class="p-8 pb-6">
                <div class="text-center mb-6">
                    <img src="{{ asset('assets/logo/dark-green-logo.png') }}" alt="BALANGAY" class="h-10 mx-auto mb-4">
                    <h2 class="text-2xl mb-2" style="font-family: 'Elinga', serif;">Welcome to BALANGAY</h2>
                    <p class="text-gray-600 text-sm">Join our community of conscious consumers</p>
                </div>

                <!-- Tab Navigation -->
                <div class="flex border-b border-gray-200 mb-6">
                    <button onclick="switchTab('signin')" id="signin-tab" class="flex-1 py-3 text-center border-b-2 border-[#5B5843] text-[#5B5843] font-medium transition-colors duration-300">
                        Sign In
                    </button>
                    <button onclick="switchTab('signup')" id="signup-tab" class="flex-1 py-3 text-center border-b-2 border-transparent text-gray-500 font-medium hover:text-gray-700 transition-colors duration-300">
                        Sign Up
                    </button>
                </div>

                <!-- Sign In Form -->
                <form id="signin-form" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent transition-all duration-300" placeholder="your@email.com">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent transition-all duration-300" placeholder="••••••••">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">I am a:</label>
                        <div class="grid grid-cols-2 gap-2">
                            <button type="button" class="role-signin-btn py-2 px-3 text-sm border-2 border-[#5B5843] bg-[#5B5843] text-white rounded-lg transition-all duration-300" data-role="user">
                                User
                            </button>
                            <button type="button" class="role-signin-btn py-2 px-3 text-sm border-2 border-gray-300 rounded-lg hover:border-[#5B5843] transition-all duration-300" data-role="seller">
                                Seller
                            </button>
                        </div>
                        <input type="hidden" name="role" id="signin-role" value="user" required>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-[#5B5843] focus:ring-[#5B5843]">
                            <span class="ml-2 text-gray-600">Remember me</span>
                        </label>
                        <a href="#" class="text-[#5B5843] hover:text-[#252525]">Forgot password?</a>
                    </div>
                    <button type="submit" class="w-full bg-[#5B5843] text-white py-3 rounded-full hover:bg-[#252525] transition-all duration-300 tracking-wide">
                        Sign In
                    </button>
                    <div id="signin-error" class="hidden text-red-600 text-sm text-center"></div>
                </form>

                <!-- Sign Up Form -->
                <form id="signup-form" class="space-y-4 hidden">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">I want to join as:</label>
                        <div class="grid grid-cols-2 gap-2">
                            <button type="button" class="role-signup-btn py-2 px-3 text-sm border-2 border-[#5B5843] bg-[#5B5843] text-white rounded-lg transition-all duration-300" data-role="user">
                                User
                            </button>
                            <button type="button" class="role-signup-btn py-2 px-3 text-sm border-2 border-gray-300 rounded-lg hover:border-[#5B5843] transition-all duration-300" data-role="seller">
                                Seller
                            </button>
                        </div>
                        <input type="hidden" name="role" id="signup-role" value="user" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input type="text" name="full_name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent transition-all duration-300" placeholder="Juan Dela Cruz">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent transition-all duration-300" placeholder="your@email.com">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" name="phone_number" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent transition-all duration-300" placeholder="+63 912 345 6789">
                    </div>
                    <!-- Seller-specific fields -->
                    <div id="seller-fields" class="hidden space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Indigenous Tribe *</label>
                            <select name="indigenous_tribe" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent transition-all duration-300">
                                <option value="">Select your tribe</option>
                                <option value="Ati">Ati</option>
                                <option value="Igorot">Igorot</option>
                                <option value="Lumad">Lumad</option>
                                <option value="Mangyan">Mangyan</option>
                                <option value="T'boli">T'boli</option>
                                <option value="Kalinga">Kalinga</option>
                                <option value="Ifugao">Ifugao</option>
                                <option value="Maguindanao">Maguindanao</option>
                                <option value="Bagobo">Bagobo</option>
                                <option value="Yakan">Yakan</option>
                                <option value="Isnag">Isnag</option>
                                <option value="Manobo">Manobo</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Seller Type *</label>
                            <div class="grid grid-cols-2 gap-2">
                                <button type="button" class="seller-type-btn py-2 px-3 text-sm border-2 border-[#5B5843] bg-[#5B5843] text-white rounded-lg transition-all duration-300" data-type="solo">
                                    Solo Seller
                                </button>
                                <button type="button" class="seller-type-btn py-2 px-3 text-sm border-2 border-gray-300 rounded-lg hover:border-[#5B5843] transition-all duration-300" data-type="enterprise">
                                    Enterprise
                                </button>
                            </div>
                            <input type="hidden" name="seller_type" id="seller-type-input" value="solo">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Shop Name (Optional)</label>
                            <input type="text" name="shop_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent transition-all duration-300" placeholder="Your Shop Name">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent transition-all duration-300" placeholder="••••••••">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                        <input type="password" name="password_confirmation" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent transition-all duration-300" placeholder="••••••••">
                    </div>
                    <div class="text-xs text-gray-600">
                        <label class="flex items-start">
                            <input type="checkbox" required class="mt-1 rounded border-gray-300 text-[#5B5843] focus:ring-[#5B5843]">
                            <span class="ml-2">I agree to the Terms of Service and Privacy Policy</span>
                        </label>
                    </div>
                    <button type="submit" class="w-full bg-[#5B5843] text-white py-3 rounded-full hover:bg-[#252525] transition-all duration-300 tracking-wide">
                        Create Account
                    </button>
                    <div id="signup-error" class="hidden text-red-600 text-sm text-center"></div>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">Or continue with</span>
                    </div>
                </div>

                <!-- Social Login -->
                <div class="grid grid-cols-2 gap-3">
                    <button class="flex items-center justify-center gap-2 py-3 px-4 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-300">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span class="text-sm">Google</span>
                    </button>
                    <button class="flex items-center justify-center gap-2 py-3 px-4 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-300">
                        <svg class="w-5 h-5" fill="#1877F2" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span class="text-sm">Facebook</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Tab switching
function switchTab(tab) {
    const signinForm = document.getElementById('signin-form');
    const signupForm = document.getElementById('signup-form');
    const signinTab = document.getElementById('signin-tab');
    const signupTab = document.getElementById('signup-tab');

    if (tab === 'signin') {
        signinForm.classList.remove('hidden');
        signupForm.classList.add('hidden');
        signinTab.classList.add('border-[#5B5843]', 'text-[#5B5843]');
        signinTab.classList.remove('border-transparent', 'text-gray-500');
        signupTab.classList.remove('border-[#5B5843]', 'text-[#5B5843]');
        signupTab.classList.add('border-transparent', 'text-gray-500');
    } else {
        signupForm.classList.remove('hidden');
        signinForm.classList.add('hidden');
        signupTab.classList.add('border-[#5B5843]', 'text-[#5B5843]');
        signupTab.classList.remove('border-transparent', 'text-gray-500');
        signinTab.classList.remove('border-[#5B5843]', 'text-[#5B5843]');
        signinTab.classList.add('border-transparent', 'text-gray-500');
    }
}

// Role selection for sign in
document.querySelectorAll('.role-signin-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.role-signin-btn').forEach(b => {
            b.classList.remove('border-[#5B5843]', 'bg-[#5B5843]', 'text-white');
            b.classList.add('border-gray-300', 'text-gray-700');
        });
        this.classList.add('border-[#5B5843]', 'bg-[#5B5843]', 'text-white');
        this.classList.remove('border-gray-300', 'text-gray-700');
        document.getElementById('signin-role').value = this.dataset.role;
    });
});

// Role selection for sign up
document.querySelectorAll('.role-signup-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.role-signup-btn').forEach(b => {
            b.classList.remove('border-[#5B5843]', 'bg-[#5B5843]', 'text-white');
            b.classList.add('border-gray-300', 'text-gray-700');
        });
        this.classList.add('border-[#5B5843]', 'bg-[#5B5843]', 'text-white');
        this.classList.remove('border-gray-300', 'text-gray-700');
        document.getElementById('signup-role').value = this.dataset.role;
        
        // Show/hide seller fields
        const sellerFields = document.getElementById('seller-fields');
        const indigenousTribeSelect = document.querySelector('select[name="indigenous_tribe"]');
        
        if (this.dataset.role === 'seller') {
            sellerFields.classList.remove('hidden');
            indigenousTribeSelect.required = true;
        } else {
            sellerFields.classList.add('hidden');
            indigenousTribeSelect.required = false;
        }
    });
});

// Seller type selection
document.querySelectorAll('.seller-type-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.seller-type-btn').forEach(b => {
            b.classList.remove('border-[#5B5843]', 'bg-[#5B5843]', 'text-white');
            b.classList.add('border-gray-300', 'text-gray-700');
        });
        this.classList.add('border-[#5B5843]', 'bg-[#5B5843]', 'text-white');
        this.classList.remove('border-gray-300', 'text-gray-700');
        document.getElementById('seller-type-input').value = this.dataset.type;
    });
});

// Sign In Form Submission
document.getElementById('signin-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const errorDiv = document.getElementById('signin-error');
    
    try {
        const response = await fetch('/auth/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(Object.fromEntries(formData))
        });
        
        const data = await response.json();
        
        if (data.success) {
            window.location.href = data.redirect;
        } else {
            errorDiv.textContent = data.message;
            errorDiv.classList.remove('hidden');
        }
    } catch (error) {
        errorDiv.textContent = 'An error occurred. Please try again.';
        errorDiv.classList.remove('hidden');
    }
});

// Sign Up Form Submission
document.getElementById('signup-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const errorDiv = document.getElementById('signup-error');
    
    try {
        const response = await fetch('/auth/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(Object.fromEntries(formData))
        });
        
        const data = await response.json();
        
        if (data.success) {
            window.location.href = data.redirect;
        } else {
            errorDiv.textContent = data.message || 'Registration failed. Please try again.';
            errorDiv.classList.remove('hidden');
        }
    } catch (error) {
        errorDiv.textContent = 'An error occurred. Please try again.';
        errorDiv.classList.remove('hidden');
    }
});

// Auto-open modal after 20 seconds if not logged in
@guest
setTimeout(() => {
    document.getElementById('auth-modal').classList.remove('hidden');
}, 20000);
@endguest
</script>