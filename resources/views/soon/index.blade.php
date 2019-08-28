@extends('layouts.app')

@section('section_title', __('soon.soon'))

@section('content')

    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">
                	{{ __('soon.unavailable') }}
                </div>
            </div>
        </div>
    </div>
@endsection