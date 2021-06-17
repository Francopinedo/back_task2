@extends('layouts.app')
@section('scripts')
@section('content')

   <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">

                	@if(session()->has('message'))
                		<div class="uk-alert uk-alert-{{ session('alert-class', 'close') }}" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ session('message') }}
                        </div>
                	@endif
                    @if(app()->getLocale()== 'en')
                        <object width="100%" height="700px" type="application/pdf" data="{{ asset('/storage/app/public/help/English/TASKCONTROL-BASIC-KPIs-GUIDE.pdf')}}?#zoom=100&scrollbar=0&toolbar=0&navpanes=0">
                            <p>{{__('errors.500')}}</p>
                        </object>
                    @else
                        <object width="100%" height="700px" type="application/pdf" data="{{ asset('/storage/app/public/help/Spanish/TASKCONTROL-GUIA-DE-KPIs.pdf')}}?#zoom=100&scrollbar=0&toolbar=0&navpanes=0">
                            <p>{{__('errors.500')}}</p>
                        </object>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
