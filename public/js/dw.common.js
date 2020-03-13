var selected_state_id = 0;
var selected_city_id = 0;
var list_dt_tbl;

$(document).ready(function(){
    if (typeof tinymce != 'undefined') {
        tinymce.init({
            selector: '.textarea-editor',
            height: 500,
            theme: 'modern',
            //plugins: 'print preview fullpage powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount tinymcespellchecker a11ychecker imagetools mediaembed  linkchecker contextmenu colorpicker textpattern help',
            plugins: 'searchreplace autolink directionality fullscreen image link table advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern',
            toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            image_advtab: true,
            automatic_uploads: true,
            file_picker_types: 'image, media',
            file_picker_callback: function(cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                input.onchange = function() {
                  var file = this.files[0];

                  var reader = new FileReader();
                  reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    // call the callback and populate the Title field with the file name
                    cb(blobInfo.blobUri(), { title: file.name });
                  };
                  reader.readAsDataURL(file);
                };

                input.click();
            },
            templates: [
              { title: 'Test template 1', content: 'Test 1' },
              { title: 'Test template 2', content: 'Test 2' }
            ],
            content_css: [
              '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
              '//www.tinymce.com/css/codepen.min.css'
            ]
        });    
    }
    
    if ($('#newsletter-form').length) {
        $('#newsletter-form').validate({
            rules: {
                newsletter_email: {required: true, email: true},
            },
            message: {
                newsletter_email: {required: 'Please provide your email', email: 'Provide valid email address'}
            }
        });    
    }
});

function generateDatatable(options) {
    list_dt_tbl = $('#'+options.table_id).DataTable({
        keys: true,
        pageLength: 10,
        searching: ((typeof options.searching != 'undefined') ? options.searching : true),
        processing: true,
        serverSide: true,
        ajax: {
            url :options.url, // json datasource
            type: "get",
            data: function(data) {
                data.custom_filter = {};
                if ($('#list_filter_form').length) {
                    $('#list_filter_form input[type="text"]').each(function(){
                        if ($(this).val() != '') {
                            data.custom_filter[$(this).attr('name')] = $(this).val();
                        }
                    });
                    $('#list_filter_form input[type="hidden"]').each(function(){
                        if ($(this).val() != '') {
                            data.custom_filter[$(this).attr('name')] = $(this).val();
                        }
                    });
                    $('#list_filter_form select').each(function(){
                        if ($(this).find('option:selected').val() != '') {
                            data.custom_filter[$(this).attr('name')] = $(this).find('option:selected').val();
                        }
                    });
                }
            },
            error: function () {  // error handling
                $("#"+options.table_id+"-body").html('<tr class="empty_row"><td colspan="'+options.number_of_columns+'" class="text-center"><span class="text-danger"><b>No Record Found</b></span></td></tr>');
                $('#'+options.table_id+'_processing').remove();
            }
        },
        columnDefs: options.columnDefs,
        order: options.order,
    }).on( 'draw.dt', function(){
        if (typeof dtRowCreatedCallback != 'undefined') {
                dtRowCreatedCallback();    
            }
    });
}

function filterList(element)
{
    if (typeof list_dt_tbl != 'undefined') {
        if (!$('table.dataTable').length) {
            $(element).closest('form').submit();
        } else if ($('table.dataTable').length) {
            list_dt_tbl.draw();
        }    
    } else {
        $(element).closest('form').submit();
    }
}

function resetFilters(element)
{
    $(element).closest('form').find('input[type="text"]').val('');
    $(element).closest('form').find('select').each(function(){
        $(this).find('option').removeAttr('selected');
    });
    
    $(element).closest('form').find('.searchbtn').trigger('click');
}

function isImageFile(file) {
    if (file.type) {
        return /^image\/\w+$/.test(file.type);
    } else {
        return /\.(jpg|jpeg|png|gif)$/.test(file);
    }
}

