<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

        <div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

        <form role="form" method="POST" action="{{ url('kpis/update') }}" id="data-form-edit"
              data-redirect-on-success="{{ url('kpis') }}">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $kpi->id }}">
            <div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('kpis.kpi') }}</label>
                    <input readonly type="text" class="md-input" name="kpi" value="{{ $kpi->kpi }}" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required kpi-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('kpis.nombre') }}</label>
                    <input type="text" class="md-input" name="nombre" value="{{ $kpi->nombre }}" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required nombre-error"></span></div>



                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('kpis.description') }}</label>
                    <input type="text" class="md-input" name="description" value="{{ $kpi->description }}"
                           required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required description-error"></span></div>

                <label>{{ __('kpis.category') }}</label>
                <div class="md-input-wrapper">

                    <select  class="md-input" name="category" required data-md-selectize>
                        <option  value="">Category</option>
                        @foreach($categories as $category)
                            <option <?php if($category->id==$kpi->category) echo 'selected'?>  value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    <span class="md-input-bar"></span>

                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required category-error"></span></div>



               <!-- <label>{{ __('kpis.type_of_result') }}</label>
                <div class="md-input-wrapper">


                    <select  class="md-input" name="type_of_result" required data-md-selectize>
                        <option <?php if($kpi->type_of_result=='NUMERIC') echo 'selected'?>  value="NUMERIC">Numeric</option>
                        <option  <?php if($kpi->type_of_result=='PERCENT') echo 'selected'?> value="PERCENT">Percent</option>
                        <option  <?php if($kpi->type_of_result=='GRAPHIC') echo 'selected'?> value="GRAPHIC">Graphic</option>
                    </select>
                    <span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required graphic_type-error"></span></div>

                <label>{{ __('kpis.graphic_type') }}</label>

                <div class="md-input-wrapper">


                    <select  class="md-input" name="graphic_type" required data-md-selectize>
                        <option  value="">{{ __('kpis.graphic_type') }}</option>
                        <option <?php if($kpi->graphic_type=='VELOCIMETRO') echo 'selected'?> value="VELOCIMETRO">Velocímetro</option>
                        <option <?php if($kpi->graphic_type=='BAR') echo 'selected'?> value="BAR">Bar</option>
                        <option <?php if($kpi->graphic_type=='DONUT') echo 'selected'?> value="DONUT">Donut</option>
                    </select>
                    <span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required graphic_type-error"></span></div>




                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('kpis.query') }}</label>
                    <input type="text" class="md-input" name="query" value="{{ $kpi->query }}" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required query-error"></span></div>
-->
                <label>{{ __('kpis.show') }}</label>
                <div class="md-input-wrapper">

                    <input type="checkbox"  <?php if($kpi->showkpi == '1') echo 'checked'; ?> class="md-input" name="showkpi" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required query-error"></span></div>


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
