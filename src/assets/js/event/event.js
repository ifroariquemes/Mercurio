function Event() {

    var self = this;

    this.delete = function (e) {
        e.preventDefault();
        MyCookieJS.confirm($.i18n.t('event:message.delete'), function () {
            MyCookieJS.showWaitMessage();
            MyCookieJS.execute('event/delete', $('#FrmEventEdit').serialize(), true, function (msg) {
                MyCookieJS.alert($.i18n.t('event:message.deleted'), function () {
                    MyCookieJS.goto('administrator/event');
                });
            });
        });
    };
    this.submitEvent = function (e) {
        e.preventDefault();
        $('#FrmEventEdit input[type="submit"]').click();
    };
    this.next = function (e) {
        e.preventDefault();
        $('#lbEventName').html($('#textName').val());
        $('#scr-1').slideUp(400, function () {
            $('#scr-2').slideDown();
        });
        $('.scr-1').addClass('hidden');
        $('.scr-2').removeClass('hidden');
    };
    this.previous = function (e) {
        e.preventDefault();
        $('#scr-2').slideUp(400, function () {
            $('#scr-1').slideDown();
        });
        $('.scr-2').addClass('hidden');
        $('.scr-1').removeClass('hidden');
    };
    this.submit = function (e) {
        e.preventDefault();
        MyCookieJS.execute('event/save', String.format('{0}&{1}', $('#FrmEventEdit').serialize(), $('#FrmActivities').serialize()), false, function (msg) {
            MyCookieJS.alert($.i18n.t('event:message.success'), function () {
                MyCookieJS.goto('administrator/event');
            });
        });
    };
    this.register = function (e) {
        e.preventDefault();
        if ($('input:checked').length < 1) {
            MyCookieJS.alert($.i18n.t('event:register.message.at_least'));
        } else {
            MyCookieJS.showWaitMessage();
            MyCookieJS.execute('event/saveRegister', $('#FrmRegister').serialize(), true, function (msg) {
                if (msg != '') {
                    MyCookieJS.alert(msg, function () {
                        MyCookieJS.closeAllPopups();
                    });
                } else {
                    MyCookieJS.alert($.i18n.t('event:register.message.registred'), function () {
                        MyCookieJS.goto('administrator/event');
                    });
                }
            });
        }
    };

    this.deleteRegistration = function (e) {
        e.preventDefault();
        MyCookieJS.confirm($.i18n.t('event:register.message.delete'), function () {
            MyCookieJS.showWaitMessage();
            MyCookieJS.execute('event/deleteRegistration', $('#FrmEventInfo').serialize(), true, function () {
                MyCookieJS.alert($.i18n.t('event:register.message.deleted'), function () {
                    MyCookieJS.goto('administrator/event');
                });
            });
        });
    };

    this.actDisable = function (ids) {
        $(ids).each(function () {
            $('input[type="checkbox"][value="' + this + '"]').attr('disabled', true);
        });
    };

    this.actEnable = function (ids) {
        $(ids).each(function () {
            $('input[type="checkbox"][value="' + this + '"]').attr('disabled', false);
        });
        self.updateDisable();
    };

    this.updateDisable = function () {
        $('input[type="checkbox"]').each(function () {
            if ($(this).is(':checked'))
                self.actDisable($.parseJSON($(this).attr('data-disable')));
        });
    };

}
var evt = new Event();