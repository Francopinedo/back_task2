<br>
@foreach ($customers as $customer)
	<a class="md-btn md-btn-large md-btn-block md-btn-wave-light waves-effect waves-button waves-light customer_for_selection"
		  data-customer_name="{{ $customer->name }}" data-csrf="{{ csrf_token() }}" data-customer_id="{{ $customer->id }}" href="#">
		{{ $customer->name }}
	</a>
@endforeach

<script type="text/javascript">
	layout.selectCustomer();
</script>

