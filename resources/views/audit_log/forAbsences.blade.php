<option value="-1" disabled selected hidden>{{ __('absences.select_a_type_of_absence') }}...</option>
@foreach ($absenceTypes as $absenceTypes)
	<option value="{{ $absenceTypes->id }}">{{ $absenceTypes->title }} ({{ $absenceTypes->days }})</option>
@endforeach