'use strict';

import DataTable from 'datatables';

export default class DataTableInit {

    constructor() {

        DataTable();
    
        $('.dataTables').DataTable({
            responsive: true
        });
    
    }

}
