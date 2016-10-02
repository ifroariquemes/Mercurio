function User() {

    var self = this;

    this.event_onChangePassword = function () {
        if ($('#textNewPassword').val() !== $('#textPasswordRepeat').val()) {
            document.getElementById('textPasswordRepeat').setCustomValidity($.i18n.t('user:message.not_match_pwd'));
        } else {
            document.getElementById('textPasswordRepeat').setCustomValidity('');
        }
    };

    this.event_onBlurActualPassword = function () {
        var msg = MyCookieJS.execute('user/checkActualPassword', $('#FrmEditPassword').serialize(), false);
        if (msg === 'false') {
            document.getElementById('textActualPassword').setCustomValidity($.i18n.t('user:message.incorrect_pwd'));
        } else {
            document.getElementById('textActualPassword').setCustomValidity('');
        }
    };

    this.deactivate = function (e) {
        e.preventDefault();
        var msg = MyCookieJS.execute('user/deactivate', $('#FrmEdit').serialize(), false);
        if (msg !== '') {
            alert(msg);
        } else {
            MyCookieJS.alert($.i18n.t('user:message.user_deactivated'), function () {
                MyCookieJS.goto('administrator/user');
            });
        }
    };

    this.reactivate = function (e) {
        e.preventDefault();
        var msg = MyCookieJS.execute('user/reactivate', $('#FrmEdit').serialize(), false);
        if (msg !== '') {
            alert(msg);
        } else {
            MyCookieJS.alert($.i18n.t('user:message.user_reactivated'), function () {
                MyCookieJS.goto('administrator/user');
            });
        }
    };

    this.changePassword = function (e) {
        e.preventDefault();
        var msg = MyCookieJS.execute('user/changePassword', $('#FrmEditPassword').serialize(), false);
        if (msg !== '') {
            alert(msg);
        } else {
            MyCookieJS.alert($.i18n.t('user:message.incorrect_pwd'), function () {
                MyCookieJS.goto('administrator/user');
            });
        }
    };

    this.delete = function (e) {
        e.preventDefault();
        MyCookieJS.confirm($.i18n.t('user:message.question_delete'), function () {
            var msg = MyCookieJS.execute('user/delete', $('#FrmEdit').serialize(), false);
            if (msg !== '') {
                alert(msg);
            } else {
                MyCookieJS.alert($.i18n.t('user:message.user_deleted'), function () {
                    MyCookieJS.goto('administrator/user');
                });
            }
        });
    };

    this.submit = function (e) {
        e.preventDefault();
        $('#FrmEdit input, #FrmEdit select').attr('disabled', false);
        var msg = MyCookieJS.execute('user/save', $('#FrmEdit').serialize(), false);
        if (msg !== '') {
            alert(msg);
        } else {
            MyCookieJS.alert($.i18n.t('user:message.user_saved'), function () {
                MyCookieJS.goto('administrator/user');
            });
        }
    };

    this.savePublic = function (e) {
        e.preventDefault();
        var msg = MyCookieJS.execute('user/savePublic', $('#FrmEdit').serialize(), false);
        MyCookieJS.alert(msg, function() {
            MyCookieJS.closeAllPopups();
        });
    };
}

var user = new User();