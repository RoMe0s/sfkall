'use strict';

export default class AjaxSubmit {

    constructor() {

        /**
         * Created by rome0s on 15.05.17.
         */
        $(document).on("submit", 'form[ajax]', function(event) {

            let $form = $(this),
                formData = new FormData($form[0]),
                $submit_button = $form.find('[type="submit"]');

            if($submit_button.html() !== undefined && $submit_button.length) {

                $submit_button.attr('disabled', 'disabled');

                let timeout = setTimeout(function() {

                    $submit_button.removeAttr('disabled');

                    clearTimeout(timeout);

                },1000);

            }

            $.ajax({

                beforeSend: function() {

                    if($form.attr('preAjax') !== undefined) {

                        $(document).trigger($form.attr('preAjax'), [event, $form]);

                    }

                },
                url: $form.attr("action"),
                type: $form.attr("method"),
                data: formData,
                contentType: false,
                processData: false

            }).done(function(response) {

                if(response.status === "success") {

                    if(response.redirect !== undefined &&
                        response.redirect !== null &&
                        response.redirect.length) {

                        window.location.href = response.redirect;

                    }

                    if(response.refresh !== undefined &&
                        response.refresh !== null &&
                        response.refresh.length) {

                        window.location.reload();

                    }

                }

                if(response.message !== undefined &&
                    response.message !== null &&
                    response.message.length) {

                    // window.messages.show(response.status, response.message);

                }

                if($form.attr('postAjax') !== undefined) {

                    $(document).trigger($form.attr('postAjax'), [response, $form]);

                }

            }).fail(function(response) {

                response = response !== undefined ? response.responseJSON : {};

                if($form.attr('errorAjax') !== undefined) {

                    $(document).trigger($form.attr('errorAjax'), [response, $form]);

                }

                var passed_errors = [];

                for(var field in response) {

                    var error = response[field].constructor === Array ? response[field].pop() : response[field];

                    if(passed_errors.indexOf(error) === -1) {

                        // messages.show('error', error);

                        passed_errors.push(error);

                    }

                    $form.find('[name="' + field + '"]').addClass('invalid');

                }

                if(!passed_errors.length) {

                    // messages.show('error', 'Произошла ошибка, попробуйте пожалуйста позже');

                }

                passed_errors = [];

            });

            return event.preventDefault();

        });

        $(document).on("focus", "input.invalid", function() {

            $(this).removeClass('invalid');

        });

        $(document).on("row-deleted", function (event, response, $element) {

            let $row = $element.closest("tr");

/*            if($element[0].hasAttribute("data-table")) {

                let $table = $element.closest("table.dataTables").DataTable({
                    "bServerSide": false
                });

                if($table !== undefined &&
                $table !== null &&
                $table.html().length) {

                    // $table.row($row).delete();

                }

            }*/

            $row.fadeOut("fast");

            swal("Уделно", "Заспись успешно удалена", "success");

        });

    }

}