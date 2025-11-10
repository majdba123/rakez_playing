@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-6">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Create New Project</h2>
        <p class="text-gray-600 mt-2">Add a new project to the system</p>
    </div>

    <form id="projectForm" action="{{ route('admin.projects.store') }}" method="POST">
        @csrf

        <div class="space-y-6">
            <!-- Name Field -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Project Name *</label>
                <input type="text" id="name" name="name" required 
                       value="{{ old('name') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                       placeholder="Enter project name">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type Field -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Project Type *</label>
                <select id="type" name="type" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    <option value="">Select Project Type</option>
                    <option value="apartment" {{ old('type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                    <option value="floor" {{ old('type') == 'floor' ? 'selected' : '' }}>Floor</option>
                    <option value="unit" {{ old('type') == 'unit' ? 'selected' : '' }}>Unit</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type Discount Field -->
            <div>
                <label for="type_discount" class="block text-sm font-medium text-gray-700 mb-2">Discount Type *</label>
                <select id="type_discount" name="type_discount" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    <option value="">Select Discount Type</option>
                    <option value="percentage" {{ old('type_discount') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                    <option value="fixed" {{ old('type_discount') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                </select>
                @error('type_discount')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Value Discount Field -->
            <div>
                <label for="value_discount" class="block text-sm font-medium text-gray-700 mb-2">Discount Value *</label>
                <input type="number" id="value_discount" name="value_discount" step="0.01" min="0" required
                       value="{{ old('value_discount') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                       placeholder="Enter discount value">
                <p id="discountHelp" class="mt-1 text-sm text-gray-500">
                    @if(old('type_discount') == 'percentage')
                        Enter percentage value (0-100%)
                    @else
                        Enter fixed amount
                    @endif
                </p>
                @error('value_discount')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex space-x-4 pt-4">
                <button type="submit" id="submitBtn"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i>Create Project
                </button>
                <a href="{{ route('admin.projects.index') }}"
                   class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 text-center flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
            </div>
        </div>
    </form>
</div>

<script>
// Dynamic help text for discount type
document.getElementById('type_discount').addEventListener('change', function() {
    const helpText = document.getElementById('discountHelp');
    const valueDiscount = document.getElementById('value_discount');
    
    if (this.value === 'percentage') {
        helpText.textContent = 'Enter percentage value (0-100%)';
        helpText.className = 'mt-1 text-sm text-green-600';
        valueDiscount.max = 100;
        valueDiscount.placeholder = 'Enter percentage (0-100)';
    } else {
        helpText.textContent = 'Enter fixed amount';
        helpText.className = 'mt-1 text-sm text-blue-600';
        valueDiscount.removeAttribute('max');
        valueDiscount.placeholder = 'Enter fixed amount';
    }
});

// Form submission with AJAX
document.getElementById('projectForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating...';

    try {
        const formData = new FormData(this);
        const response = await fetch(this.action, {
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
            // Show success message
            showNotification('success', data.message);
            
            // Redirect after short delay
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 1500);
        } else {
            showNotification('error', data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('error', 'Something went wrong. Please try again.');
    } finally {
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }
});

function showNotification(type, message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg text-white z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check' : 'exclamation-triangle'} mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Remove after 5 seconds
    setTimeout(() => {
        notification.remove();
    }, 5000);
}

// Initialize help text on page load
document.addEventListener('DOMContentLoaded', function() {
    const typeDiscount = document.getElementById('type_discount');
    if (typeDiscount.value) {
        typeDiscount.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection