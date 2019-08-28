<br>
<option value="-1" disabled selected hidden>{{ __('contracts.select_a_project') }}...</option>
@foreach ($projects as $project)
	<option value="{{ $project->id }}">{{ $project->name }}</option>
@endforeach