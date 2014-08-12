function Activity() {

    this.submit = function(e) {
        e.preventDefault();
        if ($('#activityEditId').val() > 0) {
            $(String.format('#lstActivities tr[data-id={0}]', $('#activityEditId').val())).replaceWith(MyCookieJS.execute('activity/updateLine', $('#FrmActivityEdit').serialize()));
        }
        else if ($('#activityEditSession').val() == 'true') {
            $(String.format('#lstActivities tr[data-id={0}]', $('#activityEditAct').val())).replaceWith(MyCookieJS.execute('activity/updateLine', $('#FrmActivityEdit').serialize()));
        }
        else {
            $('#lstActivities').prepend(MyCookieJS.execute('activity/createLine', $('#FrmActivityEdit').serialize()));
        }
        MyCookieJS.closeAllPopups();
    };

    this.add = function() {
        MyCookieJS.showDynamicPopup('mdActivityEdit', 'activity/add');
    };

    this.edit = function(id, onSession) {
        MyCookieJS.showDynamicPopup('mdActivityEdit', 'activity/edit', String.format('id={0}&onSession={1}', id, onSession));
    };

    this.addSpeaker = function() {
        if ($('#spkName').val() !== '') {
            $('#lstSpeakers').prepend(MyCookieJS.execute('activity/createSpeakerLine', 'spkName=' + $('#spkName').val().toUpperCase()));
            $('#spkName').val('').focus();
        }
    };

    this.refreshTypes = function() {
        $('#typeSelectView').html(MyCookieJS.execute('activity/type/select', null));
    };

}

activity = new Activity();
