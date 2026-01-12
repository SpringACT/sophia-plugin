/**
 * Sophia Chat Widget Script
 *
 * Handles chat bubble click interaction with CSP-compatible event listener.
 */
(function() {
    'use strict';

    var button = document.getElementById('sophia-chat-bubble');
    if (!button) {
        return;
    }

    var chatUrl = button.getAttribute('data-chat-url');
    if (!chatUrl) {
        return;
    }

    function openChat() {
        // On mobile, open in new tab to preserve user's place on site
        if (window.innerWidth < 768) {
            window.open(chatUrl, '_blank');
            return;
        }

        // Calculate responsive popup size
        var width = Math.min(400, window.innerWidth - 40);
        var height = Math.min(600, window.innerHeight - 40);
        var left = (window.innerWidth - width) / 2;
        var top = (window.innerHeight - height) / 2;

        var popup = window.open(
            chatUrl,
            'SophiaChat',
            'width=' + width + ',height=' + height + ',left=' + left + ',top=' + top + ',scrollbars=yes,resizable=yes'
        );

        // Fallback: if popup blocked, navigate directly
        if (!popup || popup.closed) {
            window.location.href = chatUrl;
        }
    }

    button.addEventListener('click', openChat);
})();
