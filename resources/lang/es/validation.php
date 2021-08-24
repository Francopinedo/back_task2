<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'El :attribute debe ser aceptado.',
    'active_url'           => 'El :attribute no es una URL Valida.',
    'after'                => 'El :attribute debe ser una fecha despues de :date.',
    'after_or_equal'       => 'El :attribute debe ser una fecha despues o igual a :date.',
    'alpha'                => 'El :attribute puede contner solo letras.',
    'alpha_dash'           => 'El :attribute puede contener solo letras, numeros, y guiones.',
    'alpha_num'            => 'El :attribute puede contener solo letras y numeros.',
    'array'                => 'El :attribute debe ser un arreglo.',
    'before'               => 'El :attribute debe ser una fecha anterior a :date.',
    'before_or_equal'      => 'El :attribute debe ser una fecha anterior o igual a :date.',
    'between'              => [
    'numeric'              => 'El :attribute debe estar entre :min y :max.',
    'file'                 => 'El :attribute debe estar entre :min y :max kilobytes.',
    'string'               => 'El :attribute debe estar entre :min y :max caracteres.',
    'array'                => 'El :attribute debe estar entre :min y :max items.',   ],
    'boolean'              => 'El campo :attribute debe ser verdadero o falso.',
    'confirmed'            => 'La confirmacion del :attribute no coincide.',
    'date'                 => 'El :attribute no es una fecha valida.',
    'date_format'          => 'El :attribute no coincide con el formato :format.',
    'different'            => 'El :attribute y :other deben ser diferentes.',
    'digits'               => 'El :attribute debe ser :digits digitos.',
    'digits_between'       => 'El :attribute debe estar entre :min y :max digitos.',
    'dimensions'           => 'El :attribute tiene dimensiones de imagenes invalidas.',
    'distinct'             => 'El  campo :attribute tiene un valor duplicado.',
    'email'                => 'El :attribute debe ser un correo electronico valido.',
    'exists'               => 'El :attribute seleccionado es invalido.',
    'file'                 => 'El :attribute debe ser un archivo.',
    'filled'               => 'El campo :attribute debe tener un valor.',
    'image'                => 'El :attribute debe ser una imagen.',
    'in'                   => 'El :attribute seleccionado es invalido.',
    'in_array'             => 'El campo :attribute no existe en :other.',
    'integer'              => 'El :attribute debe ser un entero.',
    'ip'                   => 'El :attribute debe ser una direccion IP valida.',
    'json'                 => 'El :attribute debe ser una cadena JSON valida.',
    'max'                  => [
        'numeric' => 'El :attribute no puede ser mas grande que :max.',
        'file'    => 'El :attribute no puede ser mas grande que :max kilobytes.',
        'string'  => 'El :attribute no puede ser mas grande que :max caracteres.',
        'array'   => 'El :attribute no puede tener mas de :max items.',
    ],
    'mimes'                => 'El :attribute debe ser un archivo de tipo: :values.',
    'mimetypes'            => 'El :attribute debe ser un archivo de tipo: :values.',
    'min'                  => [
        'numeric' => 'El :attribute debe tener como minimo :min.',
        'file'    => 'El :attribute debe tener como minimo :min kilobytes.',
        'string'  => 'El :attribute debe tener como minimo :min caracteres.',
        'array'   => 'El :attribute debe tener como minimo :min items.',
    ],
    'not_in'               => 'El :attribute no es valido.',
    'numeric'              => 'El :attribute debe ser un numero.',
    'present'              => 'El campo :attribute debe estar presente.',
    'regex'                => 'El formato :attribute no es valido.',
    'required'             => 'El campo :attribute es requerido',
    'required_if'          => 'El campo :attribute es requerido cuando :other es :value.',
    'required_unless'      => 'El campo :attribute es requirido a menos que :other este en :values.',
    'required_with'        => 'El campo :attribute es requerido cuando :values esta presente.',
    'required_with_all'    => 'El campo :attribute es requerido cuando :values esta presente.',
    'required_without'     => 'El campo :attribute es requerido cuando :values no esta presente.',
    'required_without_all' => 'El campo :attribute es requerido cuando ninguno de los :values estan presentes.',
    'same'                 => 'El :attribute y :other deben coincidir.',
    'size'                 => [
        'numeric' => 'El :attribute debe ser :size.',
        'file'    => 'El :attribute debe ser :size kilobytes.',
        'string'  => 'El :attribute debe ser :size caracteres.',
        'array'   => 'El :attribute debe contener :size items.',
    ],
    'string'               => 'El :attribute debe ser una cadena.',
    'timezone'             => 'El :attribute debe ser una zona valida.',
    'unique'               => 'El :attribute ya esta siendo usado.',
    'uploaded'             => 'El :attribute fallo al cargar.',
    'url'                  => 'El format de :attribute no es valido.',
    'phone'                => 'El formato :attribute no es el correcto',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'days' => 'campo dia',
        'title' => 'titulo',
        'country_id' => 'pais',
        'city_id' => 'ciudad',
        'phone'     => 'Telefono',
    ],

];
