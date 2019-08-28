<script id="field_template_a" type="text/x-handlebars-template">
    <div class="uk-grid uk-grid-medium form_section" data-uk-grid-match>
        <div class="uk-width-9-10">
            <div class="uk-grid">
                <div class="uk-width-1-2">
                    <div class="parsley-row">
                        <select name="new[exchange_rate_id][]" required>
                        	<?php foreach ($currencies as $currency): ?>
								<option value="<?php echo $currency->id ?>"><?php echo $currency->name ?></option>
                        	<?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="uk-width-1-2">
                    <div class="parsley-row">
                        <input type="text" class="md-input" name="new[exchange_rate_value][]" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-width-1-10 uk-text-center">
            <div class="uk-vertical-align uk-height-1-1">
                <div class="uk-vertical-align-middle">
                    <a href="#" class="btnSectionClone"><i class="fa fa-plus-square fa-15"></i></a>
                </div>
            </div>
        </div>
    </div>
</script>