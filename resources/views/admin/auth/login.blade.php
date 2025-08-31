<x-guest-layout>
	<!-- Admin Login Heading -->
	<div class="mb-6 text-center">
		<h2 class="text-2xl font-bold text-gray-900">{{ __('Admin Login') }}</h2>
	</div>

	<!-- Session Status -->
	<x-auth-session-status class="mb-4" :status="session('status')" />

	<!-- Error Message -->
	@if(session('error'))
		<div class="mb-4 font-medium text-sm text-red-600">
			{{ session('error') }}
		</div>
	@endif

	<form method="POST" action="{{ route('admin.login.submit') }}">
		@csrf

		<!-- Email Address -->
		<div>
			<x-input-label for="email" :value="__('Email')" />
			<x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
			<x-input-error :messages="$errors->get('email')" class="mt-2" />
		</div>

		<!-- Password -->
		<div class="mt-4">
			<x-input-label for="password" :value="__('Password')" />
			<x-text-input id="password" class="block mt-1 w-full"
						  type="password"
						  name="password"
						  required autocomplete="current-password" />
			<x-input-error :messages="$errors->get('password')" class="mt-2" />
		</div>

		<!-- Remember Me -->
		<div class="block mt-4">
			<label for="remember_me" class="inline-flex items-center">
				<input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
				<span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
			</label>
		</div>

		<!-- Submit Button -->
		<div class="flex items-center justify-end mt-4">
			<x-primary-button class="ms-3">
				{{ __('Log in') }}
			</x-primary-button>
		</div>
	</form>
</x-guest-layout>