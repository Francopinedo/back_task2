<option value="-1" disabled selected hidden>{{ __('header.select_a_customer') }}...</option>
@foreach ($customers as $customer)
	<option  data-customer_name="{{ $customer->name }}"   data-customer_id="{{ $customer->id }}" value="{{ $customer->id }}">{{ $customer->name }}</option>
@endforeach