function Accreditation() {

    this.clear = function(e) {
        e.preventDefault();
        $('#lstDataParticipant').show();
        $('#lstSearchParticipant, #searchCleanP').hide();
        $('#textNameParticipant').focus();
    };

    this.searchEvent = function(e) {
        e.preventDefault();
        $('#searchTerm').html($('#textName').val());
        var msg = MyCookieJS.execute('accreditation/searchEvent', $('#FrmSearch').serialize(), false);
        $('#lstData').hide();
        $('#lstSearch, #searchClean').show();
        $('#lstSearchData').html(msg);
        $('#FrmSearch')[0].reset();
    }

    this.search = function(e) {
        e.preventDefault();
        $('#searchTermParticipant').html($('#textNameParticipant').val());
        var msg = MyCookieJS.execute('accreditation/search', $('#FrmSearchAccreditation').serialize(), false);
        $('#lstDataParticipant').hide();
        $('#lstSearchParticipant, #searchCleanP').show();
        $('#lstSearchDataParticipant').html(msg);
        $('#FrmSearchAccreditation')[0].reset();
    };

    this.confirm = function(e) {
        e.preventDefault();
        MyCookieJS.showWaitMessage();
        MyCookieJS.execute('accreditation/confirm', $('#FrmRegister').serialize(), true, function(msg) {
            MyCookieJS.alert(msg, function() {
                MyCookieJS.goto('administrator/accreditation/participants/' + $('#eventId').val());
            });
        });
    };

}

var accreditation = new Accreditation();