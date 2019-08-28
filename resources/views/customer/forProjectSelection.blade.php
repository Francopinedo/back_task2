<option value="-1" disabled selected hidden>{{ __('header.select_a_customer') }}...</option>
@foreach ($customers as $customer)
	<option value="{{ $customer->id }}">{{ $customer->name }}</option>
@endforeach