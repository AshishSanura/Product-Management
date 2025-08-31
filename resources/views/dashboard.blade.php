<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Dashboard') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6 text-gray-900">
					{{ __("You're logged in!") }}
				</div>
			</div>
		</div>
	</div>

	@if(Auth::check())
		@if(Auth::user()->role === 'admin')

		@elseif(Auth::user()->role === 'customer')
			@section('scripts')
				<script type="text/javascript">
					document.addEventListener('DOMContentLoaded', function () {
						if ('serviceWorker' in navigator && 'PushManager' in window) {
							navigator.serviceWorker.register('/sw.js').then(function(registration) {
								return registration.pushManager.subscribe({
									userVisibleOnly: true,
									applicationServerKey: "{{ env('VAPID_PUBLIC_KEY') }}"
								});
							}).then(function(subscription) {
								return fetch('{{ route('push-subscriptions.store') }}', {
									method: 'POST',
									headers: {
										'Content-Type': 'application/json',
										'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
									},
									body: JSON.stringify(subscription)
								});
							}).then(res => res.json())
							.then(data => console.log('Subscription saved:', data))
							.catch(err => console.error(err));
						}
					});
				</script>
			@endsection
		@endif
	@endif

</x-app-layout>