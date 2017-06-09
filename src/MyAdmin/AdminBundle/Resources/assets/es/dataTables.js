'use strict';

import dt from 'datatables';
$.fn.DataTable = dt;

export default class DataTableInit {

    constructor() {
    
        $('.dataTables').DataTable({
            responsive: true
        });

    
    }

}
