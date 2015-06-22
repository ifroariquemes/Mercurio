function ActivityType() {

    this.manage = function (e) {
        e.preventDefault();
        MyCookieJS.showDynamicPopup('mdTypeManage', 'event/activity/type/manage');
    };

    this.close = function () {
        activity.refreshTypes();
        MyCookieJS.gotoPopup('mdActivityEdit');
    };

    this.add = function () {
        MyCookieJS.showDynamicPopup('mdTypeEdit', 'event/activity/type/add');
    };

    this.edit = function (id) {
        MyCookieJS.showDynamicPopup('mdTypeEdit', 'event/activity/type/edit', String.format('id={0}', id));
    };

    this.submit = function (e) {
        e.preventDefault();
        MyCookieJS.execute('event/activity/type/save', $('#FrmTypeEdit').serialize(), true, function () {            
            MyCookieJS.showDynamicPopup('mdTypeManage', 'event/activity/type/manage');
        });
    };

    this.delete = function (id) {
        MyCookieJS.confirm($.i18n.t('event:activity.type.message.delete'), function () {
            MyCookieJS.execute('event/activity/type/delete', String.format('id={0}', id));
            MyCookieJS.alert($.i18n.t('event:activity.type.message.deleted'), function () {
                MyCookieJS.showDynamicPopup('mdTypeManage', 'event/activity/type/manage');
            });
        }, null, false);
    };

    this.addTranslation = function () {
        if ($('#transName').val() !== '' && $('#transLang').val() !== '') {
            var data = String.format('Name={0}&Lang={1}', $('#transName').val(), $('#transLang').val());
            MyCookieJS.execute('event/activity/type/createTranslationLine', data, true, addTranslationLine);            
        }
    };

    var addTranslationLine = function (line) {
        $('#lstTranslations').prepend(line);
        $('#transName').val('').focus();
        $('#transLang').val('');
    }

}

activity_type = new ActivityType();