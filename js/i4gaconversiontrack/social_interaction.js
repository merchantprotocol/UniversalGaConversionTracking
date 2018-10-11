window.fbAsyncInit = function() {
    // FaceBook `like` clicked
    if(social_interaction_track_fb_like){
        FB.Event.subscribe('edge.create', function(targetUrl) {
            gtag('event', 'like', {
                event_category : 'social',
                event_label    : 'facebook',
                value          : targetUrl
            });
        });
    }

    // FaceBook `unlike` clicked
    if(social_interaction_track_fb_unlike){
        FB.Event.subscribe('edge.remove', function(targetUrl) {
            gtag('event', 'unlike', {
                event_category : 'social',
                event_label    : 'facebook',
                value          : targetUrl
            });
        });
    }

    /* @TODO: This one needs work! */
    if(social_interaction_track_fb_share){
        FB.Event.subscribe('message.send', function(targetUrl) {
            gtag('event', 'send', {
                event_category : 'social',
                event_label    : 'facebook',
                value          : targetUrl
            });
        });
    }
};
