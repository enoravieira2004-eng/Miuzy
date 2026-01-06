(function ($) {

    console.log('USER PROFILE JS LOADED');

    /* =========================
       TOGGLE EDIT MODE
    ========================= */
    window.toggleEdit = function () {

        $('.profile-display').addClass('hidden');
        $('.profile-edit').removeClass('hidden');

        $('.btn-edit').addClass('hidden');
        $('.btn-save').removeClass('hidden');
    };

    /* =========================
       SAVE PROFILE (NAME + EMAIL)
    ========================= */
    window.saveProfile = function () {

        const name  = $('.edit-name').val().trim();
        const email = $('.edit-email').val().trim();

        if (!name || !email) {
            alert('Veuillez remplir tous les champs');
            return;
        }

        $.ajax({
            url: miuzyAjax.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'update_user_profile',
                nonce: miuzyAjax.nonce_profile,
                name: name,
                email: email
            },
            success: function (response) {

                if (!response.success) {
                    alert(response.data || 'Erreur');
                    return;
                }

                $('.display-name').text(name);
                $('.display-email').text(email);

                $('.profile-display').removeClass('hidden');
                $('.profile-edit').addClass('hidden');

                $('.btn-edit').removeClass('hidden');
                $('.btn-save').addClass('hidden');
            },
            error: function () {
                alert('Erreur serveur');
            }
        });
    };

    /* =========================
       AVATAR UPLOAD
    ========================= */
    window.uploadAvatar = function (input) {

        if (!input.files.length) return;

        const formData = new FormData();
        formData.append('action', 'miuzy_upload_avatar');
        formData.append('avatar', input.files[0]);
        formData.append('nonce', miuzyAjax.nonce_avatar);

        fetch(miuzyAjax.ajax_url, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(res => {

            if (!res.success) {
                alert(res.data || 'Erreur upload');
                return;
            }

            $('.profile-avatar img').attr('src', res.data.url);
        });
    };

    /* =========================
       SEND CLIENT MESSAGE
    ========================= */
    window.sendMessage = function () {

        const message = $('#message').val().trim();

        if (!message) {
            showPopup('Veuillez écrire un message', false);
            return;
        }

        $.ajax({
            url: miuzyAjax.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'send_client_message',
                nonce: miuzyAjax.nonce_message,
                message: message
            },
            success: function (response) {

                if (!response.success) {
                    showPopup(response.data || 'Erreur', false);
                    return;
                }

                $('#message').val('');
                showPopup('Votre message a bien été envoyé ✅', true);
            },
            error: function () {
                showPopup('Erreur serveur', false);
            }
        });
    };

    /* =========================
       POPUP FUNCTION
    ========================= */
    function showPopup(text, success = true) {

        const popup = $(`
            <div class="miuzy-popup ${success ? 'success' : 'error'}">
                ${text}
            </div>
        `);

        $('body').append(popup);

        setTimeout(() => popup.addClass('show'), 50);

        setTimeout(() => {
            popup.removeClass('show');
            setTimeout(() => popup.remove(), 300);
        }, 3000);
    }

})(jQuery);
