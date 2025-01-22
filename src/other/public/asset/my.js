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
/**
 * add below script for select2
 * <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
 * <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 */

/**
 * document for use this library
 * a[data-model] => show a href on the modal
 * [data-province] => get province's cities
 * form[data-ajax] => post data with ajax
 * input[data-price] => convert input value to number format
 * [data-error] => any inputs has data-error, the form validation show it
 * [data-slug] => convert input value to slug and show in the other input
 * [data-format] => force user to custom format (number,persian,english)
 * a[data-question] => show confirm dialog, set message for show it, data-prompt is placeholder
 * [data-picker] => date,time,datetime , use data-picker-init for use initialValue for picker
 * .select2 => data-select2-modal for set parent modal, data-select2-tag is tag, data-select2-placeholder is placeholder
 * data-select2-ajax is ajax request contain url for fetch
 * select[data-show] => show tags depend on select tag
 * for parent area, set data-show-child-id to data-show and for special tag in parent, set data-show-child-value to select value
 */
document.addEventListener("DOMContentLoaded", function () {

    $("[data-modal]").click(function (e) {
        e.preventDefault();

        let modal_id = $(this).data('modal');
        if ($(this).data('modal-text') === undefined) {
            $(`#${modal_id}`).find('.modal-body').html('در حال بارگزاری...');
            $(`#${modal_id}`).find('.modal-body').load($(this).attr('href'));
            $(`#${modal_id}`).modal('show');
        } else {
            $(`#${modal_id}`).find('.modal-body').html($(this).data('modal-text'));
            $(`#${modal_id}`).modal('show');
        }

    });

    $("[data-toggle-checkbox],input[data-id][type='checkbox']").change(function () {

        var input_id;

        if ($(this).data('toggle-checkbox') !== undefined) {
            $(`input[data-id][type=checkbox]`).prop('checked', this.checked)
            input_id = $("#"+$(this).data('toggle-checkbox'));
        } else {
            input_id = $("#"+$(this).data('parent-id'));
        }

        let selected_id = $(`[data-id]:checked`).map((index,element) => element.value).get();

        input_id.val(selected_id);

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

    $(document).on('click', '[data-form]', function (e) {
        e.preventDefault();
        $($(this).data('form')).submit();
    });

    $(document).on('submit', 'form[data-ajax]', function (e) {
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
                    if (msg.data.redirect !== undefined) {

                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-success',
                                cancelButton: 'btn btn-danger me-2'
                            },
                            buttonsStyling: false,
                        });

                        let config = {
                            title: '',
                            html: msg.message,
                            icon: 'info',
                            confirmButtonClass: 'me-2',
                            confirmButtonText: 'با تشکر',
                            reverseButtons: true
                        };

                        swalWithBootstrapButtons.fire(config).then((result) => {
                            if (result.value !== "undefined" && result.value !== undefined) {
                                if (msg.data.redirect !== undefined) {
                                    location.href = msg.data.redirect;
                                }
                            }
                        });
                    }
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                notify(textStatus, 'error');
            }
        }).always(function () {
            btn.text('ذخیره تغییرات');
        });
    });

    $(document).on('submit', 'form', function (e) {
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

    $("select[data-show]").change(function () {

        let val = $(this).val();
        let id = $(this).data('show');

        $(`[data-show-child-id=${id}]`).hide();
        $(`[data-show-child-id=${id}][data-show-child-value=${val}]`).show();

    });

    /*
    * force user to enter number or other
    * set data-format attribute
    * format can number (you can set except character with data-except
     */
    $('[data-format]').on('change keyup paste keydown', function (event) {

        var code = (event.keyCode ? event.keyCode : event.which);
        var inputValue = $(this).val(); // Get the current value of the input field
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

        if (format === 'english') {
            const isEnglish = /^[a-zA-Z0-9\s]$/.test(event.key);
            if (!isEnglish) {
                event.preventDefault();  // Prevent the key press
            }
        }

    });

    $(document).on('submit', "form", function (e) {
        // Check if the form has the DELETE method
        if ($(this).find('input[name=_method]').val() !== 'DELETE') {
            return; // Ignore other forms
        }

        e.preventDefault();

        var me = $(this);

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger me-2'
            },
            buttonsStyling: false,
        });

        let message = $(this).data('question');

        let config = {
            title: 'دقت کنید',
            html: message !== '' ? message : "آیا مطمئن به انجام این عملیات هستید؟",
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
                me.off('submit'); // Temporarily remove the submit event handler
                me[0].submit();
            }
        });
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

    const elements = document.querySelectorAll("[data-persian],[data-time-picker],[data-picker]");
    elements.forEach(element => {
        element.addEventListener("focus", function () {
            this.blur(); // Remove focus from the element
        });
    });

    $("[data-persian]").each(function () {
        $(this).pDatepicker({ initialValue:false, format: 'YYYY/MM/DD', autoClose: true})
    });

    $("[data-persian-init]").each(function () {
        $(this).pDatepicker({ initialValue:true, format: 'YYYY/MM/DD', autoClose: true})
    });

    $("[data-picker]").each(function () {

        let picker = $(this).data('picker');
        let initialValue = $(this).data('picker-init') !== undefined;

        if (picker === 'date') {
            $(this).pDatepicker({ initialValue:initialValue, format: 'YYYY/MM/DD', autoClose: true})
        }

        if (picker === 'time') {
            $(this).pDatepicker({onlyTimePicker:true, initialValue:initialValue, format: 'HH:mm', autoClose: true})
        }

        if (picker === 'datetime') {
            $(this).pDatepicker({
                timePicker: true,  // Enable time picker
                format: 'YYYY-MM-DD HH:mm', // Format for both date and time
                altFormat: 'YYYY-MM-DD HH:mm', // Format for the alternative field
                autoClose: true,
                initialValue:initialValue
            });
        }

    });

    $('.select2').each(function () {
        var option = {};

        var selectHeight = $(this).css('height');
        if (selectHeight) {
            option.dropdownCss = {
                height: selectHeight,
                'line-height': selectHeight
            };
        }

        // Set the dropdown parent if data-select2-modal is specified
        if ($(this).data('select2-modal') !== undefined) {
            option.dropdownParent = $("#" + $(this).data('select2-modal'));
        }

        if ($(this).data('select2-tag') !== undefined) {
            option.tags = true;
            option.tokenSeparators = [',', ' '];
        }

        // Set the placeholder if data-select2-placeholder is specified
        if ($(this).data('select2-placeholder') !== undefined) {
            option.placeholder = $(this).data('select2-placeholder');
        }

        // Configure AJAX if data-select2-ajax is specified
        if ($(this).data('select2-ajax') !== undefined) {
            option.ajax = {
                url: $(this).data('select2-ajax'),
                dataType: 'json',
                delay: 250, // Add delay for debounce
                data: function (params) {
                    return {
                        search: params.term, // search term
                    };
                },
                processResults: function (data) {
                    // Transforms the top-level key of the response object to 'results'
                    return {
                        results: data.items // adjust this according to your response structure
                    };
                },
                cache: true
            };
        }

        // Initialize select2 with the configured options
        $(this).select2(option);

        if (selectHeight) {
            $(this).next('.select2-container').find('.select2-selection--single').css({
                'height': selectHeight,
                'line-height': selectHeight,
                'display': 'flex',
                'align-items': 'center'
            });

            // Adjust the arrow container within the Select2 element
            $(this).next('.select2-container').find('.select2-selection__arrow').css({
                'height': selectHeight,
                'display': 'flex',
                'align-items': 'center'
            });
        }

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

function only_persian(str) {
    var p = /^[\u0600-\u06FF\s]+$/;
    if (!p.test(str)) {
        return false
    }
    return true;
}