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

    'accepted' => 'השדה :attribute חייב להיות מסומן.',
    'accepted_if' => 'השדה :attribute חייב להיות מסומן כאשר :other הוא :value.',
    'active_url' => 'השדה :attribute חייב להיות כתובת אתר תקנית.',
    'after' => 'השדה :attribute חייב להיות תאריך אחרי :date.',
    'after_or_equal' => 'השדה :attribute חייב להיות תאריך אחרי או שווה ל :date.',
    'alpha' => 'השדה :attribute יכול להכיל אותיות בלבד.',
    'alpha_dash' => 'השדה :attribute יכול להכיל אותיות, מספרים, מקפים וקווים תחתונים בלבד.',
    'alpha_num' => 'השדה :attribute יכול להכיל אותיות ומספרים בלבד.',
    'array' => 'השדה :attribute חייב להיות מערך.',
    'ascii' => 'השדה :attribute יכול להכיל רק תווים אלפאנומריים בודדים ותווי סימנים.',
    'before' => 'השדה :attribute חייב להיות תאריך לפני :date.',
    'before_or_equal' => 'השדה :attribute חייב להיות תאריך לפני או שווה ל :date.',
    'between' => [
        'array' => 'השדה :attribute חייב להכיל בין :min ל :max פריטים.',
        'file' => 'השדה :attribute חייב להיות בין :min ל :max קילובייטים.',
        'numeric' => 'השדה :attribute חייב להיות בין :min ל :max.',
        'string' => 'השדה :attribute חייב להיות בין :min ל :max תווים.',
    ],
    'boolean' => 'השדה :attribute חייב להיות אמת או שקר.',
    'confirmed' => 'אימות :attribute אינו תואם.',
    'current_password' => 'הסיסמה שגויה.',
    'date' => 'השדה :attribute אינו תאריך תקני.',
    'date_equals' => 'השדה :attribute חייב להיות תאריך שווה ל :date.',
    'date_format' => 'השדה :attribute אינו תואם את הפורמט :format.',
    'decimal' => 'השדה :attribute חייב להיות עם :decimal מקומות עשרוניים.',
    'declined' => 'השדה :attribute חייב להיות מסורב.',
    'declined_if' => 'השדה :attribute חייב להיות מסורב כאשר :other הוא :value.',
    'different' => 'השדה :attribute וה :other חייבים להיות שונים.',
    'digits' => 'השדה :attribute חייב להיות :digits ספרות.',
    'digits_between' => 'השדה :attribute חייב להיות בין :min ל :max ספרות.',
    'dimensions' => 'השדה :attribute מכיל ממדי תמונה לא חוקיים.',
    'distinct' => 'השדה :attribute מכיל ערך כפול.',
    'doesnt_end_with' => 'השדה :attribute אינו יכול להסתיים עם אחד מהבאים: :values.',
    'doesnt_start_with' => 'השדה :attribute אינו יכול להתחיל עם אחד מהבאים: :values.',
    'email' => 'השדה :attribute חייב להיות כתובת דוא"ל תקנית.',
    'ends_with' => 'השדה :attribute חייב להסתיים באחד מהבאים: :values.',
    'enum' => 'ה :attribute שנבחר אינו חוקי.',
    'exists' => 'ה :attribute שנבחר אינו חוקי.',
    'file' => 'השדה :attribute חייב להיות קובץ.',
    'filled' => 'השדה :attribute חייב להכיל ערך.',

    // תוספת שדות ולידציה נוספים בהתאם לצורך

    'attributes' => [
        'email' => 'דוא"ל',
        'password' => 'סיסמה',
        'name' => 'שם',
    ],
];
