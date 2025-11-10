@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-6">
    <div class="text-center mb-8">
        <i class="fas fa-user text-4xl text-blue-600 mb-4"></i>
        <h2 class="text-2xl font-bold text-gray-800">Enter Your Details</h2>
    </div>

    <form id="registerForm" class="space-y-6">
        @csrf
        
        <!-- Name Field -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                Full Name
            </label>
            <input type="text" id="name" name="name" required 
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Enter your full name">
        </div>

        <!-- Phone Field -->
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                Phone Number
            </label>
            <input type="tel" id="phone" name="phone" required 
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Enter your phone number">
        </div>

        <!-- Submit Button -->
        <button type="submit" id="submitBtn"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
            Continue
        </button>
    </form>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Processing...';

    try {
        const formData = new FormData(this);
        const response = await fetch('/users', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            // Redirect to home page
            window.location.href = data.redirect;
        }
    } catch (error) {
        alert('Something went wrong. Please try again.');
        submitBtn.disabled = false;
        submitBtn.textContent = 'Continue';
    }
});
</script>
@endsection