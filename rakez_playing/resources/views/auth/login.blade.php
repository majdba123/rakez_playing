@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-6">
    <div class="text-center mb-8">
        <i class="fas fa-sign-in-alt text-4xl text-green-600 mb-4"></i>
        <h2 class="text-2xl font-bold text-gray-800">Welcome Back</h2>
        <p class="text-gray-600 mt-2">Sign in to your account</p>
    </div>

    <form id="loginForm" class="space-y-6">
        @csrf
        
        <!-- Phone Field -->
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-phone mr-2"></i>Phone Number
            </label>
            <input type="tel" id="phone" name="phone" required 
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                   placeholder="Enter your phone number">
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 transform hover:scale-105">
            <i class="fas fa-sign-in-alt mr-2"></i>Sign In
        </button>

        <!-- Register Link -->
        <div class="text-center">
            <p class="text-gray-600">Don't have an account? 
                <a href="{{ route('register') }}" class="text-green-600 hover:text-green-700 font-semibold transition duration-200">
                    <i class="fas fa-user-plus mr-1"></i>Create Account
                </a>
            </p>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Signing In...';
    submitBtn.disabled = true;

    try {
        const formData = new FormData(this);
        const response = await fetch('/api/login', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            showAlert('success', 'Welcome!', data.message);
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 1500);
        } else {
            showAlert('error', 'Error!', data.message);
        }
    } catch (error) {
        showAlert('error', 'Error!', 'Something went wrong. Please try again.');
    } finally {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
});
</script>
@endsection