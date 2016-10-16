
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

    // Change looks if user is not logged in.
    if (window.location.pathname == "/" || window.location.pathname == "/login" || window.location.pathname == '/register') {
        $('.navbar').addClass('login-navbar');
        $('#app').addClass('login-app');
    }

    //alert('height: ' + $(window).height() + 'width: ' + $(window).width());   // returns height and width of browser viewport

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
        };
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
                console.log("success");
                $("#posts").prepend(data);
                clear_post_form();
            },
            error: function(data) {
                console.log("error");
                showFlash(data.responseJSON.content);
            }
        });
    });

    // ajax comment submit
    $('.comment-form').on('submit', function(e) {
        e.preventDefault();
        var $form = $(this);
        var $comment_input = $form.find('input.comment-content');
        var token = $form.find('input#token').val();
        var $content = $comment_input.val();
        var $post_id = $form.data('post-id');
        var $form_data = new FormData();
        $form_data.append('_token', token);
        $form_data.append('content', $content);

        $.ajax({
            type: "POST",
            url: "/posts/"+$post_id+"/comments",
            data: $form_data,
            contentType: false,
            processData: false,
            success: function (data) {
                console.log("comment creation was succesful");
                $("[data-comments-post-id="+$post_id+"]").find('.post-comments').prepend(data['view']);
                $comment_input.val('');
                $("a.more_comments[data-post-id="+$post_id+"]").html('more comments('+data['count']+')');
            },
            error: function (data) {
                console.log('comment creation failed');
                console.log(data);
                showCommentFlash(data.responseJSON.content, $comment_input);
            }
        });
    });
    $('a.more_comments').on('click', function(e) {
        e.preventDefault();
        var $post_id = $(this).data('post-id');

        $.get({
            url: "/posts/"+$post_id+"/more_comments",
            success: function(data) {
                console.log("success more comments");
                console.log(data);
                $("[data-comments-post-id="+$post_id+"]").find('.post-comments').html(data);
                $("a.more_comments[data-post-id="+$post_id+"]").remove();
            },
            error: function (data) {
                console.log("error more comments");
            }
        })
    })

});

function showCommentFlash(message, item) {
    // var pos = item.offset();
    var width = item.outerWidth();
    var pos = item.position();
    var msg_container = $('#msg_container');
    $('body').prepend('<div id="msg_container" class="alert alert-danger" style="display: none"></div>');
    msg_container.html(message);
    msg_container.css({
        position: "absolute",
        top: pos.top - 10 + "px",
        left: (pos.left + width + 50) + "px"
    }).fadeIn(200);
    msg_container.fadeIn(200);
    msg_container.click(function () { msg_container.fadeOut(200) });
    setTimeout(function() {
        msg_container.fadeOut(200);
        msg_container.remove();
    }, 6000);
}
// sets notification message positioned on the right of the given item selector(string)
function showFlash (message) {
    var pos = $('#content').position();
    var width = $('#content').outerWidth();
    var msg_container = $('#msg_container');
    $('body').prepend('<div id="msg_container" class="alert alert-danger" style="display: none"></div>');
    msg_container.html(message);
    msg_container.css({
        position: "absolute",
        top: pos.top + "px",
        left: (pos.left + width + 50) + "px"
    }).fadeIn(200);
    msg_container.click(function () { msg_container.fadeToggle(200) });
    setTimeout(function() {
        msg_container.fadeOut(200);
        msg_container.remove();
    }, 6000);
}

// function clear_comment_form(post_id) {
//     $('[data-post-id='+post_id+'][data-behavior=comment-form]')
// }

function clear_post_form() {
    $('#content').val("");
    $('.image-preview').attr("data-content","").popover('hide');
    $('.image-preview-filename').val("");
    $('.image-preview-clear').hide();
    $('.image-preview-input input:file').val("");
    $(".image-preview-input-title").text("Browse");
}