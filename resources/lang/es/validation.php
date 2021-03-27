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

    'accepted' => ':attribute tiene que ser aceptado.',
    'active_url' => ':attribute no es un URL válido.',
    'after' => ':attribute tiene que ser una fecha posterior a :date.',
    'after_or_equal' => ':attribute tiene que ser una fecha posterior o igual a :date.',
    'alpha' => ':attribute solo puede contener letras.',
    'alpha_dash' => ':attribute solo puede contener letras, numeros, dashes y underscores.',
    'alpha_num' => ':attribute solo puede contener letras y numeros.',
    'array' => ':attribute tiene que ser un array.',
    'before' => ':attribute tiene que ser una fecha anterior a :date.',
    'before_or_equal' => ':attribute tiene que ser anterior o igual a :date.',
    'between' => [
        'numeric' => ':attribute tiene que estar entre :min y :max.',
        'file' => ':attribute tiene que estar entre :min y :max kilobytes.',
        'string' => ':attribute tiene que estar entre :min y :max caracteres.',
        'array' => ':attribute tiene que estaer entre :min y :max items.',
    ],
    'boolean' => 'El atributo :attribute tiene que ser true o false .',
    'confirmed' => ':attribute la confirmación no es igual.',
    'date' => ':attribute no es una fecha válida.',
    'date_equals' => ':attribute tiene que ser una fecha igual a :date.',
    'date_format' => ':attribute no encaja con el formato de fecha :format.',
    'different' => ':attribute y :other tienen que ser diferentes.',
    'digits' => ':attribute tiene que ser los digitos :digits.',
    'digits_between' => ':attribute tiene que estar entre los digitos :min y :max.',
    'dimensions' => ':attribute tiene dimensiones de imagen no válidas.',
    'distinct' => 'El atributo :attribute tiene un valor duplicado.',
    'email' => ':attribute tiene que ser una dirección de correo válida.',
    'ends_with' => ':attribute tiene que terminar con uno de los siguientes: :values.',
    'exists' => 'El atributo seleccionado :attribute no es válido.',
    'file' => ':attribute tiene que ser un fichero.',
    'filled' => 'El atributo :attribute tiene que tener un valor.',
    'gt' => [
        'numeric' => ':attribute tiene que ser mayor que :value.',
        'file' => ':attribute tiene que ser mayor que :value kilobytes.',
        'string' => ':attribute tiene que ser mayor que :value characters.',
        'array' => ':attribute tiene que tener más de :value items.',
    ],
    'gte' => [
        'numeric' => ':attribute tiene que ser mayor o igual que :value.',
        'file' => ':attribute tiene que ser mayor o igual que :value kilobytes.',
        'string' => ':attribute tiene que ser mayor o igual que :value characters.',
        'array' => ':attribute tiene que tener :value o más items.',
    ],
    'image' => ':attribute tiene que ser una imagen.',
    'in' => 'El atributo seleccionado :attribute no es válido.',
    'in_array' => 'El atributo :attribute no existe en :other.',
    'integer' => ':attribute tiene que ser un entero.',
    'ip' => ':attribute tiene que ser una dirección IP válida.',
    'ipv4' => ':attribute tiene que ser una dirección IPv4 válida.',
    'ipv6' => ':attribute tiene que ser una dirección IPv6 válida.',
    'json' => ':attribute tiene que ser un JSON válido.',
    'lt' => [
        'numeric' => ':attribute tiene que ser menor que :value.',
        'file' => ':attribute tiene que ser menor que :value kilobytes.',
        'string' => ':attribute tiene que ser menor que :value characters.',
        'array' => ':attribute tiene que tener menos de :value items.',
    ],
    'lte' => [
        'numeric' => ':attribute tiene que ser menor que or equal :value.',
        'file' => ':attribute tiene que ser menor que or equal :value kilobytes.',
        'string' => ':attribute tiene que ser menor que or equal :value characters.',
        'array' => ':attribute no puede tener mas de :value items.',
    ],
    'max' => [
        'numeric' => ':attribute no puede ser mayor que :max.',
        'file' => ':attribute no puede ser mayor que :max kilobytes.',
        'string' => ':attribute no puede ser mayor que :max characters.',
        'array' => ':attribute no puede tener más de :max items.',
    ],
    'mimes' => ':attribute tiene que ser un fichero de tipo: :values.',
    'mimetypes' => ':attribute tiene que un fichero de tipos: :values.',
    'min' => [
        'numeric' => ':attribute tiene que ser por lo menos :min.',
        'file' => ':attribute tiene que ser por lo menos :min kilobytes.',
        'string' => ':attribute tiene que ser por lo menos :min characters.',
        'array' => ':attribute tiene que tener por lo menos :min items.',
    ],
    'multiple_of' => ':attribute tiene que ser multiplo de :value',
    'not_in' => 'El atributo seleccionado :attribute no es válido.',
    'not_regex' => 'El formato de :attribute no es válido.',
    'numeric' => ':attribute tiene que ser un numero.',
    'password' => 'La contraseña es incorrecta.',
    'present' => 'El atributo :attribute tiene que estar presente.',
    'regex' => 'El formato de :attribute no es válido.',
    'required' => 'El atributo :attribute es obligatorio.',
    'required_if' => 'El atributo :attribute es obligatorio cuando :other es :value.',
    'required_unless' => 'El atributo :attribute es obligatorio a menos que :other esté entre :values.',
    'required_with' => 'El atributo :attribute es obligatorio cuando el valor :values está presente.',
    'required_with_all' => 'El atributo :attribute es obligatorio cuando los valores :values están presentes.',
    'required_without' => 'El atributo :attribute es obligatorio cuando el valor :values no está presente.',
    'required_without_all' => 'El atributo :attribute es obligatorio cuando ninguno de los valores :values están presentes.',
    'same' => 'Los atributos :attribute y :other deben coincidir.',
    'size' => [
        'numeric' => ':attribute tiene que ser de :size.',
        'file' => ':attribute tiene que ser de :size kilobytes.',
        'string' => ':attribute tiene que ser de :size characters.',
        'array' => ':attribute tiene que contener :size items.',
    ],
    'starts_with' => 'El atributo :attribute debe comenzar con uno de los siguientes: :values.',
    'string' => 'El atributo :attribute tiene que ser string.',
    'timezone' => ':El atributo attribute tiene que ser una zona horaria válida.',
    'unique' => 'El atributo :attribute ya ha sido tomado.',
    'uploaded' => 'El atributo :attribute no ha podido ser subido.',
    'url' => 'El formato de :attribute no es válido.',
    'uuid' => 'El atributo :attribute tiene que ser UUID válido.',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'currentPassword' => __('common.current_password'),
        'newPassword' => __('common.new_password'),
        'confirmPassword' => __('common.confirm_password'),
        'phone' => __('common.phone')
    ],

];
