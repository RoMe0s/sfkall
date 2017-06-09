'use strict';

import $ from 'jquery';
import 'bootstrap';
import 'jquery-ui-dist/jquery-ui.min';

//custom
import MyAdmin from './init';
//TinyMCE
import TinyMCEInit from './tinymce.js'; 
//metis menu
import MetisInit from './metis-menu.js';
//inputs
import Inputs from './inputs.js';
//data tables
import DataTableInit from './dataTables.js';
$(()=> {

    new MyAdmin();
    new TinyMCEInit();
    new MetisInit();
    new Inputs();
    new DataTableInit();

});
