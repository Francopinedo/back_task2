@extends('layouts.app')

@section('section_title', __('catalog.repository'))

@section('content')


    @if(!session()->has('project_id'))
        <div class="uk-alert uk-alert-danger" data-uk-alert>
            <a href="#" class="uk-alert-close uk-close"></a>
            {{ __('projects.you_need_a_project') }}
        </div>
    @endif
    @if(session()->has('project_id'))
        @include('repository.form', array('project'=>$project))
    @endif
@endsection



