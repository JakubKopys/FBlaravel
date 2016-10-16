
(function(){

    var loading_options = {
        finishedMsg: "<div class='end-msg'>Congratulations! You've reached the end of the internet</div>",
        msgText: "<div class='center'>Loading news items...</div>"
    };

    $('#posts').infinitescroll({
        loading : loading_options,
        navSelector : ".posts .pagination",
        nextSelector : ".posts .pagination li.active + li a",
        itemSelector : ".posts li.post"
    });
})();