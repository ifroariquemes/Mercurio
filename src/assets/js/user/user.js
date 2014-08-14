function User() {

    var self = this;

    this.event_onChangePassword = function() {
        if ($('#textNewPassword').val() !== $('#textPasswordRepeat').val()) {
            document.getElementById('textPasswordRepeat').setCustomValidity('Passwords do not match');
        } else {
            document.getElementById('textPasswordRepeat').setCustomValidity('');
        }
    };

    this.event_onBlurActualPassword = function() {
        var msg = MyCookieJS.execute('user/checkActualPassword', $('#FrmEditPassword').serialize(), false);
        if (msg === 'false') {
            document.getElementById('textActualPassword').setCustomValidity('Incorrect password');
        }
        else {
            document.getElementById('textActualPassword').setCustomValidity('');
        }
    };

    this.deactivate = function(e) {
        e.preventDefault();
        var msg = MyCookieJS.execute('user/deactivate', $('#FrmEdit').serialize(), false);
        if (msg !== '') {
            alert(msg);
        }
        else {
            MyCookieJS.alert(t('user:user_deactivated'));
            MyCookieJS.alert('Usuário desativado com sucesso!', function() {
                MyCookieJS.goto('administrator/user');
            });
        }
    };

    this.reactivate = function(e) {
        e.preventDefault();
        var msg = MyCookieJS.execute('user/reactivate', $('#FrmEdit').serialize(), false);
        if (msg !== '') {
            alert(msg);
        }
        else {
            MyCookieJS.alert('Usuário reativado com sucesso!', function() {
                MyCookieJS.goto('administrator/user');
            });
        }
    };

    this.changePassword = function(e) {
        e.preventDefault();
        var msg = MyCookieJS.execute('user/changePassword', $('#FrmEditPassword').serialize(), false);
        if (msg !== '') {
            alert(msg);
        }
        else {
            MyCookieJS.alert('Senha alterada com sucesso!', function() {
                MyCookieJS.goto('administrator/user');
            });
        }
    };

    this.delete = function(e) {
        e.preventDefault();
        MyCookieJS.confirm('Deseja realmente deletar este usuário?', function() {
            var msg = MyCookieJS.execute('user/delete', $('#FrmEdit').serialize(), false);
            if (msg !== '') {
                alert(msg);
            }
            else {
                MyCookieJS.alert('Usuário deletado com sucesso!', function() {
                    MyCookieJS.goto('administrator/user');
                });
            }
        });
    };

    this.submit = function(e) {
        e.preventDefault();
        $('#FrmEdit').find(':disabled').attr('disabled', false);
        var msg = MyCookieJS.execute('user/save', $('#FrmEdit').serialize(), false);
        if (msg !== '') {
            alert(msg);
        }
        else {
            MyCookieJS.alert('Usuário salvo com sucesso!', function() {
                MyCookieJS.goto('administrator/user');
            });
        }
    };

    this.verifyUsername = function() {
        MyCookieJS.showWaitMessage();
        MyCookieJS.execute('user/verifyUsername', $('#FrmEdit').serialize(), true, function(msg) {
            document.getElementById('textEmail').setCustomValidity(msg);
            MyCookieJS.gotoPopup('mdRegister', function(e) {
                $('#FrmEdit input[type=submit]').click();
            });
        });
    };

    this.userSubmit = function(e) {
        e.preventDefault();
        MyCookieJS.showWaitMessage('Salvando seus dados de usuário...');
        MyCookieJS.execute('user/saveAndEmail', $('#FrmEdit').serialize(), true, function(msg) {
            MyCookieJS.alert(msg, function() {
                MyCookieJS.closeWaitMessage();
                MyCookieJS.closeAllPopups();
                $('#FrmEdit')[0].reset();
            });
        });
    };

    this.resend = function(e) {
        e.preventDefault();
        MyCookieJS.showWaitMessage();
        MyCookieJS.execute('user/resend', $('#FrmResend').serialize(), true, function(msg) {
            MyCookieJS.alert(msg, function() {
                MyCookieJS.closeWaitMessage();
                MyCookieJS.closeAllPopups();
                $('#FrmResend')[0].reset();
            });
        });
    };

}

user = new User();