function Accreditation() {

    this.confirm = function (e) {
        e.preventDefault();
        if ($('input:checked').length < 1) {
            MyCookieJS.alert($.i18n.t('event:accreditation.message.at_least'));
        } else {
            MyCookieJS.showWaitMessage();
            MyCookieJS.execute('event/accreditation/confirm', $('#FrmRegister').serialize(), true, function () {
                MyCookieJS.alert($.i18n.t('event:accreditation.message.confirmed'), function () {
                    MyCookieJS.goto('administrator/event/accreditation/participants/' + $('#eventId').val());
                });
            });
        }
    };

    this.override = function (e) {
        e.preventDefault();
        if ($('input:checked').length < 1) {
            MyCookieJS.alert($.i18n.t('event:accreditation.message.at_least'));
        } else {
            MyCookieJS.showWaitMessage();
            MyCookieJS.execute('event/accreditation/confirmOverride', $('#FrmRegister').serialize(), true, function () {
                MyCookieJS.alert($.i18n.t('event:accreditation.message.confirmed'), function () {
                    MyCookieJS.goto('administrator/event/accreditation/participants/' + $('#eventId').val());
                });
            });
        }
    };

}

var accreditation = new Accreditation();