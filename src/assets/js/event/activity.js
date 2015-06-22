function Activity() {

    var self = this;

    this.submit = function (e) {
        e.preventDefault();
        if ($('#activityEditId').val() > 0) {
            MyCookieJS.execute('event/activity/updateLine', $('#FrmActivityEdit, #FrmSpk, #FrmSes').serialize(), true, function (msg) {                
                $(String.format('#lstActivities tr[data-id={0}]', $('#activityEditId').val())).replaceWith(msg);
            });
        }
        else if ($('#activityEditSession').val() == 'true') {
            MyCookieJS.execute('event/activity/updateLine', $('#FrmActivityEdit, #FrmSpk, #FrmSes').serialize(), true, function (msg) {
                $(String.format('#lstActivities tr[data-id={0}]', $('#activityEditAct').val())).replaceWith(msg);
            });
        }
        else {
            MyCookieJS.execute('event/activity/createLine', $('#FrmActivityEdit, #FrmSpk, #FrmSes').serialize(), true, function (msg) {
                $('#lstActivities').prepend(msg);
            });
        }
        MyCookieJS.closeAllPopups();
    };

    this.add = function () {
        MyCookieJS.showDynamicPopup('mdActivityEdit', 'event/activity/add');
    };

    this.edit = function (id, onSession) {
        MyCookieJS.showDynamicPopup('mdActivityEdit', 'event/activity/edit', String.format('id={0}&onSession={1}', id, onSession));
    };

    this.addSpeaker = function (e) {
        e.preventDefault();
        MyCookieJS.execute('event/activity/createSpeakerLine', $('#FrmSpk').serialize(), true, function (msg) {
            $('#lstSpeakers').prepend(msg);
            $('#spkName').val('').focus();
        });
    };

    this.addSession = function (e) {
        e.preventDefault();        
        if ($('#FrmSes')[0].checkValidity()) {
            MyCookieJS.execute('event/activity/createSessionLine', $('#FrmSes').serialize(), true, function (msg) {                
                $('#lstSessions').prepend(msg);
                $('#FrmSes')[0].reset();
                $('#sesDate').focus();
            });
        }
    };

    this.refreshTypes = function () {
        MyCookieJS.execute('event/activity/type/select', null, true, function (msg) {
            $('#typeSelectView').html(msg).i18n();
        });
    };

}

activity = new Activity();
