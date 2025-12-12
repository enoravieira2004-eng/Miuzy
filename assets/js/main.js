// Main JavaScript file

document.addEventListener('DOMContentLoaded', function() {

    // Sauvegarde des préférences (langue + devise)
    function updatePreferences() {
        jQuery.ajax({
            url: wp_ajax.url,
            type: 'POST',
            data: {
                action: 'update_preferences',
                language: document.getElementById('language').value,
                currency: document.getElementById('currency').value,
                nonce: wp_ajax.nonce
            }
        });
    }

    document.getElementById('language').addEventListener('change', updatePreferences);
    document.getElementById('currency').addEventListener('change', updatePreferences);

});

