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
        var popup = window.open(
            chatUrl,
            'SophiaChat',
            'width=400,height=600,scrollbars=yes,resizable=yes'
        );

        // Fallback: if popup blocked, navigate directly
        if (!popup || popup.closed) {
            window.location.href = chatUrl;
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
