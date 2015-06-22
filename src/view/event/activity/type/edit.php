<form id="FrmTypeEdit" onsubmit="activity_type.submit(event)">
    <div class="modal-header">    
        <h4 class="modal-title">Type</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">                
                <div class="form-group">
                    <label for="textNameType"><span data-i18n="event:activity.type.label.name"></span></label>
                    <input type="text" name="Name" id="textNameType" class="form-control" value="<?= $data->getName() ?>" required="required">                
                </div>
                <input type="hidden" name="id" value="<?= $data->getId() ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">                
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title" data-i18n="event:activity.type.label.translations"></h3>
                    </div>
                    <div class="panel-body">                                
                        <table class="table table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th data-i18n="event:activity.type.label.translation_name"></th>
                                    <th data-i18n="event:activity.type.label.translation_lang"></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="lstTranslations">
                                <?php
                                if (!empty($data->getTranslations())) {
                                    foreach ($data->getTranslations() as $t) {
                                        $_MyCookie->LoadView('event/activity/type', 'translation.line', $t);
                                    }
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><input type="text" name="transName" id="transName" value="" class="form-control"></td>
                                    <td class="col-md-2"><input type="text" name="transLang" id="transLang" value="" class="form-control"></td>
                                    <td class="col-md-1"><button type="button" class="btn btn-success" onclick="activity_type.addTranslation()"><i class="fa fa-plus"></i></button></td>
                                </tr>
                            </tfoot>
                        </table>                                
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">                
        <button type="button" class="btn btn-danger" onclick="MyCookieJS.gotoPopup('mdTypeManage')"><i class="fa fa-times"></i> <span data-i18n="mycookie:button.cancel"></span></button>
        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> <span data-i18n="mycookie:button.save"></span></button>
    </div> 
</form>
<script type="text/javascript">
    require(['jquery'], function ($) {
        $(function () {
            MyCookieJS.maskUpper('#textNameType');
            $('#textNameType').focus();
        });
    });
</script>