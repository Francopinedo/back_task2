<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('absence_types_template') }}" id="data-form"
              data-redirect-on-success="{{ url('absence_types_template') }}">
    	    {{ csrf_field() }}
    		<div class="uk-width-medium-1-1 uk-row-first">
                <div class="md-input-wrapper">
                	<label>{{ __('absence_types.title') }}</label>
                	<input type="text" class="md-input" name="title" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required title-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('absence_types.days') }}</label>
                	<input type="number" class="md-input" name="days" min="0"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required days-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('absence_types.country') }}</label>
                	<select name="country_id"  id="country_id" data-md-selectize>
                	    <option value="">{{ __('absence_types.country') }}...</option>
                	    @foreach ($countries as $country)
                	        <option value="{{ $country->id }}">{{ $country->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>


                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('users.city') }}</label>
                    <select name="city_id" id="city_id" data-md-selectize>
                        <option value="">{{ __('users.city') }}...</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span>
                </div>


				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('absence_types.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>


<script type="text/javascript">

    $(function(){
        
        $("#country_id").on('change', function () {
            // console.log('chage....');
            $.ajax({
                url: API_PATH + '/cities',
                type: 'GET',
                data: {country_id: $(this).val()},
                dataType: 'json'
            }).done(function (data) {
                    var html = '<option value="">Country...</option>';

                    $('#city_id').selectize()[0].selectize.destroy();

                    $.each(data.data, function (i, value) {
                        // console.log(value);
                        html += '<option value="' + value.id + '">' + value.name + '</option>';
                    });

                    $('#city_id').html(html);
                    $('#city_id').selectize();



                }
            );
        });
    });

</script>
