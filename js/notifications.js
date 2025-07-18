$(document).ready(function () {
    function fetchNotifications(callback = null) {
        $.ajax({
            url: "src/fetch_notifications.php",
            method: "GET",
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    const notifications = response.notifications;
                    const dropdown = $("#notificationsDropdown");
                    dropdown.empty();

                    const unreadCount = notifications.filter(n => n.is_read == 0).length;

                    if (unreadCount > 0) {
                        $("#notificationCount").text(unreadCount).show();
                    } else {
                        $("#notificationCount").hide();
                    }

                    if (notifications.length > 0) {
                        notifications.forEach(n => {
                            const item = `
                                <a href="${n.url}"
                                class="dropdown-item notification-item ${n.is_read == 1 ? 'text-muted' : ''}"
                                data-id="${n.id}">
                                ${n.message}
                                </a>`;
                            dropdown.append(item);
                        });

                    } else {
                        dropdown.append('<a class="dropdown-item text-muted">No new notifications</a>');
                    }

                    if (callback) callback();
                } else {
                    console.error("Error: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: " + error);
            }
        });
    }

    // Fetch every 5s
    setInterval(fetchNotifications, 5000);
    fetchNotifications();

    // Mark one notification as read
    $(document).on("click", ".notification-item", function (event) {
        event.preventDefault();
        const notificationId = $(this).data("id");
        const ticketUrl = $(this).attr("href");

        $.ajax({
            url: "src/mark_notifications_read.php",
            method: "POST",
            data: { id: notificationId },
            dataType: "json",
            success: () => fetchNotifications(() => window.location.href = ticketUrl),
            error: () => window.location.href = ticketUrl
        });
    });

    // Mark all as read on dropdown open
    // ───── dropdown bell click – open on first click, close on second ─────
$("#notificationsToggle").on("click", function (event) {
    event.preventDefault();
    event.stopPropagation();          // stop bubbling to document

    const dropdown = $("#notificationsDropdown");
    const arrow    = $("#notifArrow");

    if (dropdown.hasClass("show")) {
        // ▼ Currently open  →  close it
        dropdown.removeClass("show");
        arrow.removeClass("fa-chevron-up").addClass("fa-chevron-down");
        return;
    }

    // ▲ Currently closed  →  open it
    dropdown.addClass("show");
    arrow.removeClass("fa-chevron-down").addClass("fa-chevron-up");

    // Mark all as read once
    $.ajax({
        url: "src/mark_all_notifications_read.php",
        method: "POST",
        dataType: "json",
        success: function (res) {
            if (res.status === "success") {
                fetchNotifications(); // refresh badge & styles
            }
        }
    });
});

    // Close dropdown on outside click
    $(document).click(function (e) {
        if (!$(e.target).closest("#notificationsToggle, #notificationsDropdown").length) {
            $("#notificationsDropdown").removeClass("show");
        }
    });
});
