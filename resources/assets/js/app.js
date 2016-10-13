
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});

$(document).on('click', '#close-preview', function(){
    $('.image-preview').popover('hide');
    // Hover before close the preview
    $('.image-preview').hover(
        function () {
            $('.image-preview').popover('show');
        },
        function () {
            $('.image-preview').popover('hide');
        }
    );
});

$(document).on('change', '.avatar_register input:file', function() {
    var file = this.files[0];+
    $(".btn-txt").html(file.name);
});

$(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.form-toggle').click(function () {
        $('.post-form').slideToggle(300);
        var link = $(this).find('a');
        if (link.html() == 'Add Post')
            link.html('Hide');
        else
            link.html('Add Post');
    });

    // EDIT PAGE FILE INPUT JS  ------------------------------------

    // Create the close button
    var closebtn = $('<button/>', {
        type:"button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class","close pull-right");
    // Set the popover default content
    $('.image-preview').popover({
        trigger:'manual',
        html:true,
        title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
        content: "There's no image",
        placement:'right'
    });
    // Clear event
    $('.image-preview-clear').click(function(){
        $('.image-preview').attr("data-content","").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("Browse");
    });
    // Create the preview image
    $(".image-preview-input input:file").change(function (){
        var img = $('<img/>', {
            id: 'dynamic',
            width:250
        });
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".image-preview-input-title").text("Change");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);
            img.attr('src', e.target.result);
            $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
        }
        reader.readAsDataURL(file);
    });
    // EDIT PAGE FILE INPUT JS THE END --------------------------------

    // ajax post create request
    $('#post_form').on('submit', function(e) {
        e.preventDefault();
        var $content = $('#content').val();
        var $image = $('#image').prop('files');

        var $form_data = new FormData();
        $form_data.append("content", $content);
        if ($image.length > 0) {
            var $file_data = $('#image').prop('files')[0]; // Getting the properties of file from file field
            $form_data.append("image", $file_data);
        }

        $.ajax({
            type: "POST",
            url: '/posts',
            data: $form_data,
            contentType: false,
            processData: false,
            success: function( data ) {
                console.log(data);
                $(".posts").prepend(data);
                clear_post_form();
            },
            error: function(data) {
                //TODO: display error messages using flash or smth idk m8, idc - it is now problem of future me.
                console.log(data);
                clear_post_form();
            }
        });
    });

});

function clear_post_form() {
    $('#content').val("");
    $('.image-preview').attr("data-content","").popover('hide');
    $('.image-preview-filename').val("");
    $('.image-preview-clear').hide();
    $('.image-preview-input input:file').val("");
    $(".image-preview-input-title").text("Browse");
}