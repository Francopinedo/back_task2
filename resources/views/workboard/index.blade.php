@extends('layouts.app', ['favoriteTitle' => __('workboard.workboard'), 'favoriteUrl' => url(Request::path())])
<style>
    div.grouping {
    	display: flex;
    	flex-direction: row;
    	justify-content: space-between;
    	align-items: center;
    }
</style>
@section('scripts')
    <script src="{{ asset('bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <!-- datatables custom integration -->
    <script src="{{ asset('assets/js/custom/datatables/datatables.uikit.min.js') }}"></script>

    <script>

	$(document).ready(function() {
		
		$('#grouping').on('change', function(e){
			e.preventDefault();
			$.ajax({
				url: APP_PATH + '/workboard/'+$('#grouping').val(),
				// type: 'POST',
				data: {project_id: $('#project_id').val()},
				// dataType: 'json',
				success: function(data){
					$('.alert').hide();
					$('.group_active').show();
					$('.group_active').html(data.view);
				}
			});
		});

	});

	</script>
@endsection


@section('section_title', __('workboard.workboard'))

@section('content')

    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid uk-grid-divider" data-uk-grid-margin>
                <div class="uk-width-1-1">

                	@if(session()->has('message'))
                		<div class="uk-alert uk-alert-{{ session('alert-class', 'close') }}" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ session('message') }}
                        </div>
                	@endif

                	@if(!session()->has('project_id'))
                		<div class="uk-alert uk-alert-danger" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ __('projects.you_need_a_project') }}
                        </div>
                	@endif

                    {{-- @if(count($tickets) == 0)
                        <div class="uk-alert uk-alert-danger" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ __('workboard.you_need_tickets') }}
                        </div>
                    @endif --}}

					<!-- Eleccion de Agrupamiento -->
					@if(session()->has('project_id'))
						<div class="grouping">
							<div class="uk-width-medium-2-4 uk-row-first">
								<h2>{{__('workboard.grouping_for')}}</h2>
								<form id="form-group">
									{{ csrf_field() }}
									<input type="hidden" name="creator_id" value="{{ Auth::id() }}">
									<div class="md-input-wrapper md-input-select">
					                	<select name="grouping" id="grouping" data-md-selectize>
					                	    <option value="">{{__('workboard.grouping_field')}}</option>
					                	    <option value="phase">Phase</option>
					                	    <option value="version">Version</option>
					                	    <option value="label">Label</option>
					                	    <option value="release">Release</option>
					                	    <option value="sprint">Sprint</option>
					                	</select>
					                </div>
								</form>
							</div>
						</div>
					@endif
					<!-- ======================== -->
					@if(session()->has('project_id'))

						<div class="uk-alert uk-alert-alert alert" data-uk-alert>
				            {{ __('workboard.grouping') }}
				        </div>

						<div class="group_active">
						</div>
                	@endif
                </div>


            </div>
        </div>
    </div>
@endsection

