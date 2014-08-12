function Type() {

    this.manage = function(e) {
        e.preventDefault();
        MyCookieJS.showDynamicPopup('mdTypeManage', 'activity/type/manage');
    };

    this.close = function() {
        activity.refreshTypes();
        MyCookieJS.gotoPopup('mdActivityEdit');
    };

    this.add = function() {
        MyCookieJS.showDynamicPopup('mdTypeEdit', 'activity/type/add');
    };

    this.edit = function(id) {
        MyCookieJS.showDynamicPopup('mdTypeEdit', 'activity/type/edit', String.format('id={0}', id));
    };

    this.submit = function(e) {
        e.preventDefault();
        MyCookieJS.execute('activity/type/save', $('#FrmTypeEdit').serialize(), false, function() {
            MyCookieJS.showDynamicPopup('mdTypeManage', 'activity/type/manage');
        });
    };

    this.delete = function(id) {        
        MyCookieJS.confirm(MyCookieJS.execute('activity/type/deleteMsg'), function() {
            MyCookieJS.execute('activity/type/delete', String.format('id={0}', id));
            MyCookieJS.alert(MyCookieJS.execute('activity/type/deletedMsg'), function() {
                MyCookieJS.showDynamicPopup('mdTypeManage', 'activity/type/manage');
            });
        }, null, false);
    };

}

tpe = new Type();