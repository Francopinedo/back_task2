<option value="-1" disabled selected hidden>{{ __('header.select_a_project') }}...</option>
@foreach ($projects as $project)
	<option data-customer_name="{{ $project->name }}"   data-customer_id="{{ $project->id }}" value="{{ $project->id }}">{{ $project->name }}</option>
@endforeach
