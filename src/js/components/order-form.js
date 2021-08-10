'use strict';

const {ajax_url, nonce} = window.ajax_systems;

!(function ($) {

    /**
     * @param input
     * @returns {boolean}
     */
    function validateField(input) {
        let valid = true;
        switch (input.type) {
            case 'checkbox':
                if (input.required && !input.checked) {
                    valid = false;
                }
                break;
            case 'text':
            case 'email':
            case 'phone':
                if (input.required && !input.value) {
                    valid = false;
                }
                break;
        }
        if (!valid) {
            input.classList.add('is-invalid');
        } else {
            input.classList.remove('is-invalid');
        }

        return valid;
    }

    $(document).on('submit', '.js-order-form', function (e) {
        e.preventDefault();
        const $form = $(this);
        const $inputs = $form.find('input:not([type=submit])');
        let passedValidation = true;
        let data = {};
        $inputs.each((i, input) => {
            if (!validateField(input)) {
                passedValidation = false;
            }
            data[input.name] = input.value;
        });
        delete data.terms;
        if (passedValidation) {
            $.ajax({
                url: ajax_url,
                type: 'POST',
                data: {
                    action: 'order_form_submit',
                    data,
                    nonce // very important for secure sake
                },
                beforeSend() {
                    $form.attr('disabled', 'disabled');
                },
                complete(resp) {
                    $form.removeAttr('disabled');
                    const response = resp.responseText ? JSON.parse(resp.responseText) : false;
                    if (response) {
                        if (response.notification) {
                            alert(response.notification);
                        }
                    } else {
                        alert('Something went wrong, try again later.')
                    }
                }
            });
        }
    })

})(jQuery);
