<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

        <div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

        <form role="form" method="POST" action="{{ url('kpis_category/update') }}" id="data-form-edit"
              data-redirect-on-success="{{ url('kpis_category') }}">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $kpis_category->id }}">
            <div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('kpicategory.nombre') }}</label>
                    <input type="text" class="md-input" name="name" value="{{ $kpis_category->name }}" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required nombre-error"></span></div>
               <label>{{ __('sidebar.company_roles') }}</label>
                <div class="md-input-wrapper ">


                    <select name="roles[]" multiple data-md-selectize>
                        @foreach($roles as $rol)
                            <option {{in_array($rol->title, $kpis_category->roles)?'selected':''}} value="{{$rol->title}}">{{$rol->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span
                            class="parsley-required roles-error"></span></div>



                <div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light"
                       href="#" id="update-btn">{{ __('kpis.update') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn"
                       href="#">{{ __('general.cancel') }}</a>
                </div>

            </div>

        </form>
    </div>
</div>

<script type="text/javascript">
    $('.cancel-edit-btn').on('click', function (e) {
        e.preventDefault();
        $('#edit_div_toggle').hide();
        $('#edit_div').removeClass('switcher_active');
    });

    tableActions.initEditForm();
</script>