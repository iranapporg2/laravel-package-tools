/**
 * add below links for persian date
 * <script src="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>
 * <link href="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css" rel="stylesheet">
 */
/**
 * add below scripts
 * <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
 * <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css">
 */

document.addEventListener("DOMContentLoaded", function () {

    $("a[data-modal]").click(function (e) {
        e.preventDefault();

        let modal_id = $(this).data('modal');
        $(`#${modal_id}`).find('.modal-body').html('در حال بارگزاری...');
        $(`#${modal_id}`).find('.modal-body').load($(this).attr('href'));
        $(`#${modal_id}`).modal('show');

    });

    /**
     * load province cities
     * set city select id for data-province
     * use without #
     */
    $("[data-province]").change(function () {

        let province_id = $(this).val();
        let city_tag = $($(this).data('province'));
        city_tag.find('option').empty();
        city_tag.append('<option selected value="">انتخاب کنید</option>');

        $.get(`cities?province_id=${province_id}`, function (data) {
            $.each(data, function (i, item) {
                if (item.id != '')
                    city_tag.append(`<option value="${item.id}">${item.title}</option>`);
            });
        });

    });

    /**
     * add hidden input named _token for csrf
     *
     */
    $('form[data-ajax]').submit(function (e) {
        e.preventDefault();

        let btn = $(this).find('[type=submit]');
        btn.text('در حال پردازش...');

        // Create a new FormData object to handle both files and other input fields
        let formData = new FormData($(this)[0]);

        formData.append('_token', $("[name=_token]").val()); // Manually append the CSRF token if needed

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: formData, // No need to JSON.stringify formData, it's already the right format
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Let the browser set the content type, including boundaries for file uploads
            success: function (msg) {
                if (!msg.status) {
                    notify(msg.message, 'error');
                } else {
                    notify(msg.message, 'success');
                    if (msg.data.redirect !== undefined)
                        setTimeout(function () {
                            location.href = msg.data.redirect;
                        }, 500);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                notify(textStatus, 'error');
            }
        }).always(function () {
            btn.text('ذخیره تغییرات');
        });
    });

    $("form").on('submit', function () {
        $(this).find('[type=submit]').each(function () {
            let message = $(this).data('text') || 'در حال پردازش...';
            $(this).text(message);
        });
    });

    //convert number to currency on input
    $("input[data-price]").on('input keyup', function () {
        $(this).val(toCurrency($(this).val()));
    });

    active_input_errors();

    //add data-error for input for change validation text
    function active_input_errors() {

        var elements = document.getElementsByTagName("INPUT");

        for (var i = 0; i < elements.length; i++) {
            if (!elements[i].hasAttribute('required')) continue;
            elements[i].oninvalid = function (e) {
                e.target.setCustomValidity("");
                let msg = 'لطفا این گزینه را وارد کنید';
                if (e.target.dataset.error !== undefined)
                    msg = e.target.dataset.error;
                if (!e.target.validity.valid) {
                    e.target.setCustomValidity(msg);
                }
            };
            elements[i].oninput = function (e) {
                e.target.setCustomValidity("");
            };
        }

        var elements = document.getElementsByTagName("SELECT");

        for (var i = 0; i < elements.length; i++) {
            if (!elements[i].hasAttribute('required')) continue;
            elements[i].oninvalid = function (e) {
                e.target.setCustomValidity("");
                let msg = 'لطفا این گزینه را وارد کنید';
                if (e.target.dataset.error !== undefined)
                    msg = e.target.dataset.error;
                if (!e.target.validity.valid) {
                    e.target.setCustomValidity(msg);
                }
            };
            elements[i].oninput = function (e) {
                e.target.setCustomValidity("");
            };
        }

    }

    //auto slug for input
    $(`[data-slug]`).on('focusout', function () {
        let id = $(this).data('slug');
        $(`#${id}`).val(toSlug($(this).val()));
    });

    /*
    * force user to enter number or other
    * set data-format attribute
    * format can number (you can set except character with data-except
     */

    $('[data-format]').on('change keyup paste keydown', function (event) {

        var code = (event.keyCode ? event.keyCode : event.which);
        var format = $(this).data('format');

        if (format === 'number') {

            if ($(this).data('except') !== undefined) {
                if (String.fromCharCode(code) === $(this).data('except')) return;
            }

            if (!/^\d+$/.test($(this).val()))
                $(this).val($(this).val().replace(/\D/g, ''));

            if (!(
                    (code >= 48 && code <= 57) //numbers
                    || (code === 46) //period
                )
                || (code === 46 && $(this).val().indexOf('.') !== -1)
            )

                event.preventDefault();

        }

        if (format === 'persian') {
            if(only_persian(e.key) === false)
                e.preventDefault();
        }

    });

    /**
     * add data-prompt for question text
     */
    $("a[data-question]").click(function (e) {

        e.preventDefault();
        let href = $(this).attr('href');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger me-2'
            },
            buttonsStyling: false,
        })

        let message = $(this).data('question');

        let config = {
            title: 'دقت کنید',
            html: message != '' ? message : "آیا مطمئن به انجام این عملیات هستید؟",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'me-2',
            confirmButtonText: 'بله، انجام شود',
            cancelButtonText: 'منصرف شدم',
            reverseButtons: true
        };

        if (typeof $(this).data('prompt') !== 'undefined') {
            config.input = 'text';
            config.inputPlaceholder = $(this).data('prompt');
        }

        swalWithBootstrapButtons.fire(config).then((result) => {
            if (result.value !== "undefined" && result.value !== undefined) {
                location.href = href + "?input=" + result.value;
            }
        });

    });

    $("[data-edit]").css({'cursor':'cell'});

    /**
     * add below dataset for tag
     * data-edit="ROW_ID"
     * data-edit-value="CURRENT_VALUE"
     * data-edit-key="KEY_NANE_FOR_UPDATE"
     * data-edit-title="KEY TITLE"
     * data-edit-model="MODEL_NAME"
     *
     * add route (Route::post('/edit',[CONTROLLER_NANE::class,'ajax_edit'])->name('edit'))
     *
     * add below code in the controller
     *
     * public function ajax_edit(Request $request) {
     *
     *  $id = $request->id;
     *  $key = $request->key;
     *  $val = $request->value;
     *  $model = $request->model;
     *
     *  $model = app('App\\Models\\'.$model);
     *  $model = $model->find($id);
     *  $model->{$key} = $val;
     *  $model->update();
     *
     *  return response()->json(['status' => true]);
     *
     *}
     *
     * blade example:
     * <div data-edit="{{$id}}" data-edit-key="{{$key}}" data-edit-title="{{$title}}" data-edit-value="{{$value}}" data-edit-model="{{$model}}">
     * {{$value}}
     * </div>
     */
    $("[data-edit]").click(async function (e) {

        e.preventDefault();

        var me = $(this);

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger me-2'
            },
            buttonsStyling: false,
        })

        let message = `آیا مطمئن به ویرایش ${$(this).data('edit-title')} هستید؟`;
        let defaultValue = $(this).data('edit-value');
        let input_type = $(this).data('edit-type');

        if (input_type === undefined) {
            input_type = 'text';
        }

        let config = {
            title: 'توجه کنید',
            html: message,
            icon: 'warning',
            inputValue: defaultValue,
            input: input_type,
            showCancelButton: true,
            confirmButtonClass: 'me-2',
            confirmButtonText: 'بله، اعمال کن',
            cancelButtonText: 'انصراف',
            reverseButtons: true
        };

        if (input_type == 'select') {

            let select_model = $(this).data('edit-select-model');
            let relate_id = $(this).data('edit-relate-id');
            let relate_field = $(this).data('edit-relate-field');
            let query = {};

            query.model = select_model;
            if (relate_id !== undefined) {
                query.relate_id = relate_id;
                query.relate_field = relate_field;
            }

            let data = await $.get('fetch',query,function (data) {
                let list = {};
                data.result.forEach(function (item) {
                   list[item.id] = item.title;
                });
                config.inputOptions = list;
            })

        }

        var parameters = {};
        parameters.id = $(this).data('edit');
        parameters.key = $(this).data('edit-key');
        parameters.model = $(this).data('edit-model');
        parameters._token = $('meta[name="csrf-token"]').attr('content');

        swalWithBootstrapButtons.fire(config).then((result) => {

            if (result.value !== undefined) {

                parameters.value = result.value;

                let text = result.value;

                if (config.inputOptions !== undefined) {
                    text = config.inputOptions[result.value];
                }

                $.post('edit', parameters, function (data) {
                    if (data.status) {
                        me.text(text);
                        me.data('edit-value', result.value);
                    }
                });

            }

        });

    });

});

function notify(text, type) {

    let config = {
        html: text,
        icon: type,
        confirmButtonClass: 'me-2',
        confirmButtonText: 'باشه',
        reverseButtons: true
    };

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
        },
        buttonsStyling: false,
    })

    swalWithBootstrapButtons.fire(config).then(function (result) {
        return result;
    });

}

function toSlug(data, separator = "-") {
    return data.toString().replace(/^\s+|\s+$/g, '') // remove all the accents, which happen to be all in the \u03xx UNICODE block.
        .trim() // trim leading or trailing whitespace
        .toLowerCase() // convert to lowercase
        .replace(/[^a-z0-9_\s-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]#u/, '')
        .replace(/\s+/g, separator)
        .replace(/-+/g, separator);
};

function toCurrency(str) {

    str = str.replace(',', '');
    str = str.replace(/\,/g, '');
    var objRegex = new RegExp('(-?[0-9]+)([0-9]{3})');

    while (objRegex.test(str)) {
        str = str.replace(objRegex, '$1,$2');
    }

    return str;

}

$("[data-persian]").each(function () {
    $(this).pDatepicker({ initialValue:false, format: 'YYYY/MM/DD', autoClose: true})
});

$("[data-persian-init]").each(function () {
    $(this).pDatepicker({ initialValue:true, format: 'YYYY/MM/DD', autoClose: true})
});

$("[data-time-picker]").each(function () {
    $(this).pDatepicker({onlyTimePicker:true, initialValue:false, format: 'HH:mm', autoClose: true})
});

function only_persian(str) {
    var p = /^[\u0600-\u06FF\s]+$/;
    if (!p.test(str)) {
        return false
    }
    return true;
}
