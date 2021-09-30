<style>
    #create_div.switcher_active {
        width: 50%;
    }
    #phone_1, #phone_2, #phone_3, #swiftcode, #aba {
        padding-top: 30px;
    }
</style>

<form role="form" method="POST" files=true  action="{{ url('providers') }}" id="data-form" data-redirect-on-success="{{ url('providers') }}" enctype="multipart/form-data">
 
    <div class="uk-grid" data-uk-grid-margin>
    	<li class="uk-width-medium-1-1 uk-row-first">
            <div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>
        </li>
   	    {{ csrf_field() }}
	    <input type="hidden" name="company_id" value="{{ $company->id }}">
		<li class="uk-width-medium-1-4 uk-row-first">
            <div class="md-input-wrapper">
            	<label>{{ __('providers.name') }}</label>
            	<input type="text" class="md-input" name="name" id="name" required><span class="md-input-bar"></span>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>

            <div class="md-input-wrapper">
            	<label>{{ __('providers.address') }}</label>
            	<input type="text" class="md-input" name="address"><span class="md-input-bar"></span>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required address-error"></span></div>

            <div class="md-input-wrapper md-input-filled md-input-select">
            	<label>{{ __('providers.country') }}</label>
            	<select name="country_id" id="country_id" data-md-selectize>
            	    <option value="">{{ __('providers.country') }}...</option>
            	    @foreach ($countries as $country)
            	        <option value="{{ $country->id }}">{{ $country->name }} </option>
            	    @endforeach
            	</select>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>

            <div class="md-input-wrapper md-input-select">
            	<label>{{ __('providers.city') }}</label>
            	<select name="city_id" id="city_id" data-md-selectize>
            	    <option value="">{{ __('providers.city') }}...</option>
            	    @foreach ($cities as $city)
            	        <option value="{{ $city->id }}">{{ $city->name }}</option>
            	    @endforeach
            	</select>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>

            <div class="md-input-wrapper">
            	<label>{{ __('providers.email_1') }}</label>
            	<input type="text" class="md-input" name="email_1"><span class="md-input-bar"></span>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required email_1-error"></span></div>

            <div class="md-input-wrapper">
            	<label>{{ __('providers.email_2') }}</label>
            	<input type="text" class="md-input" name="email_2"><span class="md-input-bar"></span>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required email_2-error"></span></div>

            <div class="md-input-wrapper">
            	<label>{{ __('providers.email_3') }}</label>
            	<input type="text" class="md-input" name="email_3"><span class="md-input-bar"></span>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required email_3-error"></span></div>
        </li>

        <li class="uk-width-medium-1-4 uk-row-first">

            <div class="md-input-wrapper">
            	<label for="phone_1">{{ __('providers.phone_1') }}</label>
            	<input type="tel" id="phone_1" class="md-input" name="phone_1"><span class="md-input-bar"></span>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required phone_1-error"></span></div>

            <div class="md-input-wrapper">
            	<label for="phone_2">{{ __('providers.phone_2') }}</label>
            	<input type="text" class="md-input" id="phone_2" name="phone_2"><span class="md-input-bar"></span>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required phone_2-error"></span></div>

            <div class="md-input-wrapper">
            	<label for="phone_3">{{ __('providers.phone_3') }}</label>
            	<input type="text" class="md-input" id="phone_3" name="phone_3"><span class="md-input-bar"></span>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required phone_3-error"></span></div>

            <div class="md-input-wrapper">
            	<label>{{ __('providers.billing_name') }}</label>
            	<input type="text" class="md-input" name="billing_name" id="billing_name"><span class="md-input-bar"></span>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required billing_name-error"></span></div>

            <div class="md-input-wrapper">
            	<label>{{ __('providers.billing_address') }}</label>
            	<input type="text" class="md-input" name="billing_address" id="billing_address"><span class="md-input-bar"></span>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required billing_address-error"></span></div>

            <div class="md-input-wrapper">
            	<label>{{ __('providers.tax_number') }}</label>
            	<input type="text" class="md-input" name="tax_number"><span class="md-input-bar"></span>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required tax_number-error"></span></div>
        </li>

        <li class="uk-width-medium-1-4 uk-row-first">

            <div class="md-input-wrapper">
            	<label>{{ __('providers.bank_name') }}</label>
            	<input type="text" class="md-input" name="bank_name"><span class="md-input-bar"></span>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required bank_name-error"></span></div>

            <div class="md-input-wrapper">
            	<label>{{ __('providers.account_number') }}</label>
            	<input type="text" class="md-input" name="account_number"><span class="md-input-bar"></span>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required account_number-error"></span></div>

            <div class="md-input-wrapper">
            	<label>{{ __('providers.swiftcode') }}</label>
            	<input type="text" class="md-input" name="swiftcode" id="swiftcode" placeholder="ej. BFRPARBAXXX" maxlength="11"><span class="md-input-bar"></span>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required swiftcode-error"></span></div>

            <div class="md-input-wrapper">
            	<label>{{ __('providers.aba') }}</label>
            	<input type="text" class="md-input" name="aba" id="aba" placeholder="ej. 122234445" minlength="9"><span class="md-input-bar"></span>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required aba-error"></span></div>

            <div class="md-input-wrapper md-input-select">
            	<label>{{ __('providers.currency') }}</label>
            	<select name="currency_id" data-md-selectize>
            	    <option value="">{{ __('providers.currency') }}...</option>
            	    @foreach ($currencies as $currency)
            	        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
            	    @endforeach
            	</select>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

            <div class="md-input-wrapper md-input-select">
            	<label>{{ __('providers.industry') }}</label>
            	<select name="industry_id" data-md-selectize>
            	    <option value="">{{ __('providers.industry') }}...</option>
            	    @foreach ($industries as $industry)
            	        <option value="{{ $industry->id }}">{{ $industry->name }}</option>
            	    @endforeach
            	</select>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required industry_id-error"></span></div>
        </li>

        <li class="uk-width-medium-1-4 uk-row-first">
            <div class="md-input-wrapper md-input-select">
                <label>{{ __('providers.logo_path') }}</label>      
                <br/>
                <div class="thumbnail">
                    <img alt="logo" id="logo_path_img" src="{{ URL::to('/') }}/assets/img/avatardefault.png">
                </div>  
                               
                <a class="uk-form-file md-btn" id="upload_widget_opener">Upload image
                    <input 
                        type="file" 
                        id="logo_path" 
                        name="logo_path" 
                        accept="image/*" 
                        onchange="document.getElementById('logo_path_img').src = window.URL.createObjectURL(this.files[0])"
                    >
                </a>
            </div>  
            <div class="parsley-errors-list filled"><span class="parsley-required logo_path-error"></span></div>
        </li>

        <li class="uk-width-medium-1-1 uk-row-first">
			<div class="uk-margin-medium-top">
                <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('cities.add_new') }}</a>
                <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
            </div>
        </li>

    </div>
</form>

<script src="{{asset('public/jQuery-Mask/dist/jquery.mask.js')}}"></script>
<script src="{{asset('public/jQuery-Mask/dist/jquery.mask.min.js')}}"></script>

<script src="{{asset('public/Inputmask/dist/inputmask.js')}}"></script>
{{-- <script src="{{asset('public/Inputmask/dist/inputmask.min.js')}}"></script>
<script src="{{asset('public/Inputmask/dist/jquery.inputmask.js')}}"></script>
<script src="{{asset('public/Inputmask/dist/jquery.inputmask.min.js')}}"></script>
<script src="{{asset('public/Inputmask/dist/bindings/inputmask.binding.js')}}"></script> --}}



<script>
    $(function(){
        /* Capturando los datos del nombre de proveedor para agregarselos a el campo nombre de facturacion */
        $('input[name=name]').keyup(function(){
            if($(this).val() !== ''){
                $('#billing_name').parent().addClass('md-input-filled');
                $('input[name=billing_name]').val($('input[name=name]').val());
            }else{
                $('input[name=billing_name]').val(' ');
                $('#billing_name').parent().removeClass('md-input-filled');
            }
        });
        /* Capturando los datos del direccion de proveedor para agregarselos a el campo direccion en la facturcion */
        $('input[name=address]').keyup(function(){
            if($(this).val() !== ''){
                $('#billing_address').parent().addClass('md-input-filled');
                $('input[name=billing_address]').val($('input[name=address]').val());
            }else{
                $('input[name=billing_address]').val('');
                $('#billing_address').parent().removeClass('md-input-filled');
            }
        });
        
        $('#city_id').selectize();
        $("#country_id").on('change', function () {
            $.ajax({
                url: API_PATH + '/cities',
                type: 'GET',
                data: {country_id: $(this).val()},
                dataType: 'json'
            }).done(
                function (data) {
                    var html = '<option value="">City...</option>';

                    $('#city_id').selectize()[0].selectize.destroy();

                    $.each(data.data, function (i, value) {
                        html += '<option value="' + value.id + '">' + value.name + '</option>';
                    });

                    $('#city_id').html(html);
                    $('#city_id').selectize();
                }
            );
            /*Creando mascara de telefono de acuerdo al pais*/
            $.ajax({
                url: API_PATH + '/countries/'+$(this).val(),
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    Inputmask({"mask": data.data['mask_phone']}).mask('#phone_1,#phone_2,#phone_3');
                    $('#phone_1,#phone_2,#phone_3').attr('placeholder', data.data['mask_phone']);
                }
            });
        });
    });
    
    /* Mascara para el campo Codigo Swift */
    $("#swiftcode").mask(
        'PPPPPPNNNNN',
        {translation:
            {
                P: {pattern: /[A-Z]/},
                N: {pattern: /[A-Z, 0-9]/, recursive: true}
            }
        }
    );

    var form = $('#data-form');
    $('#add-btn').on('click', function (e) {
        form.submit();
    });

    $(form).submit(function (event) {
        var formdata = new FormData(form.get(0));
        event.preventDefault();
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formdata,
            dataType: 'json',
            processData: false, //For posting uploaded files we add this
            contentType: false, //For posting uploaded files we add this
            success: function (json) {
                window.location.replace(form.data('redirect-on-success'));
            },
            error: function (json) {
                if (json.status === 422) {
                    var errors = json.responseJSON;
                    $.each(json.responseJSON, function (key, value) {
                        $('#' + key + '-error').html(value);
                    });
                } else {
                    // Error
                }
            }
        });
    });
</script>
