function Organization() {

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
        var msg = MyCookieJS.execute('organization/search', $('#FrmSearch').serialize(), false);
        $('#lstData').hide();
        $('#lstSearch, #searchClean').show();
        $('#lstSearchData').html(msg);
        $('#FrmSearch')[0].reset();
    };

    this.delete = function(e) {
        e.preventDefault();
        MyCookieJS.confirm(MyCookieJS.execute('organization/deleteMsg'), function() {
            var msg = MyCookieJS.execute('organization/delete', $('#FrmEdit').serialize(), false);
            MyCookieJS.alert(msg, function() {
                MyCookieJS.goto('administrator/organization');
            });
        });
    };

    this.submit = function(e) {
        e.preventDefault();
        var msg = MyCookieJS.execute('organization/save', $('#FrmEdit').serialize(), false);
        MyCookieJS.alert(msg, function() {
            MyCookieJS.goto('administrator/organization');
        });
    };
}

var organization = new Organization();