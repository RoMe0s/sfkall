'use strict';

import 'select2';
import 'icheck';

export default class Inputs {

    constructor() {
   
        this.select2();

        this.datePicker();

        this.icheck();
            
    }


    select2() {
    
        $('select').select2({
            minItemsForSearch: 10
        });

    
    }

    datePicker() {
    
        $('.input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

    }

    icheck() {

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

    }

}
