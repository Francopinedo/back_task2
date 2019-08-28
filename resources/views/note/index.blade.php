@extends('layouts.app')

@section('scripts')
	<script>
	$(function() {
		tableActions.initEdit();
		tableActions.initDelete('{{ __('general.confirm') }}');
	});
	</script>
@endsection

@section('section_title', __('notes.notes'))

@section('content')
	@if(!session()->has('project_id'))
		<div class="md-card">
	        <div class="md-card-content">
	            <div class="uk-grid" data-uk-grid-margin>
	                <div class="uk-width-1-1">
						<div class="uk-alert uk-alert-danger" data-uk-alert>
				            <a href="#" class="uk-alert-close uk-close"></a>
				            {{ __('projects.you_need_a_project') }}
				        </div>
				    </div>
				</div>
			</div>
		</div>
	@endif

	@if(session()->has('project_id'))
		<div class="uk-width-medium-1-3 uk-push-1-3">
			<div class="md-card">
		        <div class="md-card-content">
		            <div class="uk-grid" data-uk-grid-margin>
		                <div class="uk-width-1-1">
		                	<form role="form" method="POST" action="{{ url('notes') }}" id="data-form">
		                		{{ csrf_field() }}
		                		<input type="hidden" name="project_id" value="{{ session('project_id') }}">
		        	            <div class="uk-form-row">
		        	                <div class="md-input-wrapper">
		        	                	<label>{{ __('notes.title') }}</label>
		        	                	<input type="text" class="md-input" name="title" required>
		        	                	<span class="md-input-bar "></span>
		        	                </div>
		        	            </div>
		        	            <div class="uk-form-row">
		        	                <div class="md-input-wrapper">
		        	                	<label>{{ __('notes.content') }}</label>
		        	                	<textarea required class="md-input selecize_init" placeholder="" name="description" style="overflow-x: hidden; word-wrap: break-word; overflow-y: visible;"></textarea>
		        	                	<span class="md-input-bar "></span>
		        	                </div>
		        	            </div>
		        	            <div class="uk-form-row">
									<div class="uk-width-medium-1-1">
		                                <span class="icheck-inline">
		                                    <input type="radio" name="color" name="white" value="white" data-md-icheck checked/>
		                                    <label class="inline-label">{{ __('notes.white') }}</label>
		                                </span>
		                                <span class="icheck-inline">
		                                    <input type="radio" name="color" name="green" value="green" data-md-icheck />
		                                    <label class="inline-label md-bg-green-100" style="padding: 5px;">{{ __('notes.green') }}</label>
		                                </span>
		                                <span class="icheck-inline">
		                                    <input type="radio" name="color" name="yellow" value="yellow" data-md-icheck />
		                                    <label class="inline-label md-bg-yellow-100" style="padding: 5px;">{{ __('notes.yellow') }}</label>
		                                </span>
		                                <span class="icheck-inline">
		                                    <input type="radio" name="color" name="red" value="red" data-md-icheck />
		                                    <label class="inline-label md-bg-red-100" style="padding: 5px;">{{ __('notes.red') }}</label>
		                                </span>
		                            </div>
		        	            </div>
		        	            <div class="uk-form-row uk-clearfix">
		        	                <div class="uk-float-right">
		        	                    <button type="submit" class="md-btn md-btn-primary" id="note_add">{{ __('notes.add') }}</button>
		        	                </div>
		        	            </div>
		        	        </form>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
		<div class="uk-grid">
		@foreach ($notes as $note)
			<div class="uk-width-1-3 uk-margin-large-top">
				<div class="md-card md-bg-{{ $note->color }}-100">
	                <div class="uk-position-absolute uk-position-top-right uk-margin-small-right uk-margin-small-top">
	                    <a href="/notes/{{ $note->id }}/edit" class="edit-btn" title="{{ __('notes.edit') }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
	                    <a href="/notes/{{ $note->id }}/delete" class="delete-btn" title="{{ __('notes.delete') }}"><i class="fa fa-times" aria-hidden="true"></i></a>
	                </div>
	                <div class="md-card-content">
	                    <h2 class="heading_b uk-margin-large-right">{{ $note->title }}</h2>
	                    <p>{{ $note->description }}</p>
	                   	<span class="uk-margin-top uk-text-italic uk-text-muted uk-display-block uk-text-small">{{ substr($note->created_at->date, 0, 10) }}</span>
	                </div>
	            </div>
			</div>
		@endforeach
		</div>

	@endif

@endsection