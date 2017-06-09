'use strict';

import 'select2';

export default class Inputs {

    constructor() {
   
        this.select2();

        this.datePicker();
            
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

}
