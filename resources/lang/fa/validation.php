<?php

return array(

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

    'recaptcha' => 'تصویر امنیتی مورد تایید نیست',
    'persian_alpha' => 'از حروف فارسی استفاده کنید.',
    'persian_num' => 'از اعداد فارسی استفاده کنید.',
    'persian_alpha_num' => 'از حروف و اعداد فارسی استفاده کنید.',
    'is_not_persian' => '',
    'iran_mobile' => 'شماره همراه معتبر نمی‌باشد.' . '\r\n' . 'مثال: 09xxxxxxxxx',
    'iran_sheba' => 'شبا معتبر نمی باشد.',
    'iran_phone' => 'شماره تلفن معتبر نمی‌باشد.',
    'iran_phone_with_area_code' => '',
    'iran_postal_code' => 'کد پستی معتبر نمی‌باشد',
    'melli_code' => 'کد ملی 10 رقمی معتبر نمی‌باشد.',
    'card_number' => 'شماره کارت معتبر نمی‌باشد.',
    'limited_array' => '',
    'un_signed_num' => '',

    'more' => '',
    'less' => '',
    'address' => 'آدرس معتبر نمی‌باشد',
    'package_name' => '',
    'alpha_space' => 'در :attribute فقط اجازه وارد کردن حروف دارید.',
    "accepted" => ":attribute باید پذیرفته شده باشد.",
    "active_url" => "آدرس :attribute معتبر نیست",
    "after" => ":attribute باید تاریخی بعد از :date باشد.",
    "alpha" => ":attribute باید شامل حروف الفبا باشد.",
    "alpha_dash" => ":attribute باید شامل حروف الفبا و عدد و خظ تیره(-) باشد.",
    "alpha_num" => ":attribute باید شامل حروف الفبا و عدد باشد.",
    "array" => ":attribute باید شامل آرایه باشد.",
    "before" => ":attribute باید تاریخی قبل از :date باشد.",
    "between" => array(
        "numeric" => ":attribute باید بین :min و :max باشد.",
        "file" => ":attribute باید بین :min و :max کیلوبایت باشد.",
        "string" => ":attribute باید بین :min و :max کاراکتر باشد.",
        "array" => ":attribute باید بین :min و :max آیتم باشد.",
    ),
    "boolean" => "The :attribute field must be true or false",
    "confirmed" => ":attribute با تاییدیه مطابقت ندارد.",
    "date" => ":attribute یک تاریخ معتبر نیست.",
    "date_format" => ":attribute با الگوی :format مطاقبت ندارد.",
    "different" => ":attribute و :other باید متفاوت باشند.",

    "digits" => ":attribute باید :digits رقم باشد.",
    "digits_between" => ":attribute باید بین :min و :max رقم باشد.",
    "email" => "فرمت :attribute معتبر نیست.",
    "exists" => ":attribute انتخاب شده، معتبر نیست.",
    "image" => ":attribute باید تصویر باشد.",

    "in" => ":attribute انتخاب شده، معتبر نیست.",
    "integer" => ":attribute باید نوع داده ای عددی (integer) باشد.",
    "ip" => ":attribute باید IP آدرس معتبر باشد.",
    "max" => array(
        "numeric" => ":attribute نباید بزرگتر از :max باشد.",
        "file" => ":attribute نباید بزرگتر از :max کیلوبایت باشد.",
        "string" => ":attribute نباید بیشتر از :max کاراکتر باشد.",
        "array" => ":attribute نباید بیشتر از :max آیتم باشد.",
    ),
    "mimes" => ":attribute باید یکی از فرمت های :values باشد.",
    "min" => array(
        "numeric" => ":attribute نباید کوچکتر از :min باشد.",
        "file" => ":attribute نباید کوچکتر از :min کیلوبایت باشد.",
        "string" => ":attribute نباید کمتر از :min کاراکتر باشد.",
        "array" => ":attribute نباید کمتر از :min آیتم باشد.",
    ),
    "not_in" => ":attribute انتخاب شده، معتبر نیست.",
    "verify_code" => ":attribute کد را وارد کنید",
    "numeric" => ":attribute باید شامل عدد باشد.",
    "regex" => ":attribute یک فرمت معتبر نیست",
    "required" => "فیلد :attribute الزامی است",
    "required_if" => "فیلد :attribute هنگامی که :other برابر با :value است، الزامیست.",
    "required_with" => ":attribute الزامی است زمانی که :values موجود است.",
    "required_with_all" => ":attribute الزامی است زمانی که :values موجود است.",
    "required_without" => ":attribute الزامی است زمانی که :values موجود نیست.",
    "required_without_all" => ":attribute الزامی است زمانی که :values موجود نیست.",
    "same" => ":attribute و :other باید مانند هم باشند.",
    "size" => array(
        "numeric" => ":attribute باید برابر با :size باشد.",
        "file" => ":attribute باید برابر با :size کیلوبایت باشد.",
        "string" => ":attribute باید برابر با :size کاراکتر باشد.",
        "array" => ":attribute باسد شامل :size آیتم باشد.",
    ),

    "timezone" => "The :attribute must be a valid zone.",
    "unique" => ":attribute قبلا انتخاب شده است.",
    "url" => "فرمت آدرس :attribute اشتباه است.",

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

    'custom' => array(),

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
    'attributes' => array(
        "name" => "نام",
        "body" => "محتوا",
        "reply" => "پاسخ",
        "username" => "نام کاربری",
        "email" => "پست الکترونیکی",
        "subject" => "موضوع",

        "first_name" => "نام",
        "last_name" => "نام خانوادگی",
        "message" => "پیام",
        'natural_name' => 'نام و نام خانوادگی',
        'natural_mobile' => 'شماره همراه',
        'natural_email' => 'ایمیل',
        'legal_name' => "نام خانوادگی",
        'legal_mobile' => 'شماره همراه',
        'legal_email' => 'ایمیل',
        'legal_tel' => 'شماره ثابت',
        'legal_fax' => 'فکس',
        'legal_company' => 'نام شرکت',
        'legal_job' => 'سمت در شرکت',
        'user_type' => 'نوع شخص',

        "password" => "رمز عبور",
        "password_confirmation" => "تاییدیه ی رمز عبور",
        "city" => "شهر",
        "country" => "کشور",
        "address" => "نشانی",
        "postal_code" => "کدپستی",
        "phone" => "تلفن",
        "mobile" => "تلفن همراه",
        "age" => "سن",
        "sex" => "جنسیت",
        "gender" => "جنسیت",
        "day" => "روز",
        "month" => "ماه",
        "year" => "سال",
        "hour" => "ساعت",
        "minute" => "دقیقه",
        "second" => "ثانیه",
        "title" => "عنوان",
        "text" => "متن",
        "content" => "محتوا",
        "description" => "توضیحات",
        "excerpt" => "گلچین کردن",
        "date" => "تاریخ",
        "time" => "زمان",
        "available" => "موجود",
        "size" => "اندازه",
        "num_rides" => "مبلغ",
        "new_password" => "فیلد رمز عبور",
        "image" => "تصویر",
        "job" => "شغل",
        "avatar" => "تصویر نمایه",
        "order" => "ترتیب",
        "slug" => "نامک",
        "img" => "تصویر",
        "categories" => 'دسته بندی',
        "file" => 'فایل',
        "pic" => 'تصویر',


    ),


);
