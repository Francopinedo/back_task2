<br>
@foreach ($projects as $project)
	<a class="md-btn md-btn-large md-btn-block md-btn-wave-light waves-effect waves-button waves-light project_for_selection"
		data-id="{{ $project->id }}" data-name="{{ $project->name }}" data-csrf="{{ csrf_token() }}" href="#">
		{{ $project->name }}
	</a>
@endforeach

<script type="text/javascript">
	layout.selectProject();
</script>