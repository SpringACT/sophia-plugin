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

    var fallbackUrl = button.getAttribute('data-fallback-url') || chatUrl;

    function openChat() {
        var popup = window.open(
            chatUrl,
            'SophiaChat',
            'width=' + width + ',height=' + height + ',left=' + left + ',top=' + top + ',scrollbars=yes,resizable=yes'
        );

        // Fallback: if popup blocked, navigate to fallback URL (or chat URL if not set)
        if (!popup || popup.closed) {
            window.location.href = fallbackUrl;
        }
    }

    button.addEventListener('click', openChat);

    // Ensure Enter and Space keys work (native button behavior, but explicit for clarity)
    button.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            openChat();
        }
    });
})();
