function Event() {

    var self = this;

    this.clear = function(e) {
        e.preventDefault();
        $('#lstData').show();
        $('#lstSearch, #searchClean').hide();
        $('#textName').focus();
    };

    this.search = function(e) {
        e.preventDefault();
        $('#searchTerm').html($('#textName').val());
        var msg = MyCookieJS.execute('event/search', $('#FrmSearch').serialize(), false);
        $('#lstData').hide();
        $('#lstSearch, #searchClean').show();
        $('#lstSearchData').html(msg);
        $('#FrmSearch')[0].reset();
    };

    this.delete = function(e) {
        e.preventDefault();
        MyCookieJS.confirm(MyCookieJS.execute('event/deleteMsg'), function() {
            var msg = MyCookieJS.execute('event/delete', $('#FrmEdit').serialize(), false);
            MyCookieJS.alert(msg, function() {
                MyCookieJS.goto('administrator/event');
            });
        });
    };

    this.submitEvent = function(e) {
        e.preventDefault();
        $('#FrmEventEdit input[type="submit"]').click();
    };

    this.next = function(e) {
        e.preventDefault();
        MyCookieJS.execute('event/partialSave', $('#FrmEventEdit').serialize());
        $('#lbEventName').html($('#textName').val());
        $('#scr-1').slideUp(400, function() {
            $('#scr-2').slideDown();
        });
        $('.scr-1').addClass('hidden');
        $('.scr-2').removeClass('hidden');
    };

    this.previous = function(e) {
        e.preventDefault();
        $('#scr-2').slideUp(400, function() {
            $('#scr-1').slideDown();
        });
        $('.scr-2').addClass('hidden');
        $('.scr-1').removeClass('hidden');
    };

    this.submit = function(e) {
        e.preventDefault();
        var msg = MyCookieJS.execute('event/save', $('#FrmEdit').serialize(), false);
        MyCookieJS.alert(msg, function() {
            MyCookieJS.goto('administrator/event');
        });
    };
}

var evt = new Event();