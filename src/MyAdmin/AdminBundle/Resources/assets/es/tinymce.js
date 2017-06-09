'use strict';


// Core - these two are required :-)
import tinymce from 'tinymce/tinymce'
import 'tinymce/themes/modern/theme'

export default class TinyMCEInit {

	constructor(){
	  	// Initialize
     	    tinymce.baseURL = '/bundles/admin/node_modules';
       	    tinymce.init({
                selector: '.tinymce',
            	// skin_url: '/bundles/admin/node_modules',
            	plugins: [
                        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                        'searchreplace wordcount visualblocks visualchars code fullscreen',
                        'insertdatetime media nonbreaking save table contextmenu directionality',
                        'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
                ],
            	toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            	toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
           	image_advtab: true,
          });
      	}

}
