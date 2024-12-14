import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: "25694c5b2d3353008643",
    cluster: "eu",
    forceTLS: true,
    encrypted: true,
});

window.Echo.private("task-created").listen("TaskCreatedEvent", (e) => {
    $('#notificationDropdown').load(' #notificationDropdown > *');
});

window.Echo.private("task-comment").listen("TaskCommentEvent", (e) => {
    var commentsSection = $('#simplebar-content');
    commentsSection.load(" #simplebar-content > *", function () {
        commentsSection.scrollTop(commentsSection[0].scrollHeight);
    });
});

