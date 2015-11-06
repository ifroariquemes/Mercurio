<?php
$organization = $data['organization'];
?>    
<header class="row">     
    <div class="col-md-12"><h2 data-i18n="event:organization.label.<?=$data['action']?>_organization"></h2></div>
</header>    
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <form name="FrmEdit" id="FrmEdit" role="form" onsubmit="organization.submit(event);">
                    <fieldset>
                        <div class="form-group">
                            <label for="textName"><span data-i18n="event:organization.label.name"></span>:</label>                            
                            <input type="text" required="required" name="name" id="textName" class="form-control" value="<?= $organization->getName() ?>">                            
                        </div>             
                        <div class="form-group">
                            <label for="textCity"><span data-i18n="event:organization.label.city"></span>:</label>                            
                            <input type="text" required="required" name="city" id="textCity" class="form-control" value="<?= $organization->getCity() ?>">                            
                        </div>             
                        <div class="form-group">
                            <label for="textState"><span data-i18n="event:organization.label.state"></span>:</label>                            
                            <input type="text" required="required" name="state" id="textState" class="form-control" value="<?= $organization->getState() ?>">                            
                        </div>             
                    </fieldset>
                    <input type="hidden" name="id" value="<?= $organization->getId() ?>">            
                    <div class="text-right">            
                        <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> <span data-i18n="mycookie:button.save"></span></button>                        
                    </div>
                </form>                                
            </div>
        </div>
        <?php if ($organization->getId()) : ?>
            <div class="text-right">            
                <a href="#" onclick="organization.delete(event)" data-i18n="event:organization.button.delete"></a>                
            </div>
        <?php endif; ?>
    </div>    
</div>
<script type="text/javascript">
    require(['jquery'], function($) {
        $(function() {
            $('#textName').focus();
        });
    });
</script>