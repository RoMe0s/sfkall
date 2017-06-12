/**
 * Created by rome0s on 6/9/17.
 */
'use strict';

import { default as swal } from "sweetalert";

export default class Alert {

    remove($form) {

        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            $form.submit();
        });

    }

    constructor() {

        let alert = this;

        $(document).on("click", "[data-alert]", function(e) {

           let type = $(this).attr("data-alert"),
               form = $(this).attr("data-form"),
               $form = form.length ? $(document).find(form) : $(this).closest("form");

           alert[type]($form);

        });

    }

}