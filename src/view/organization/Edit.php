<?php
$organization = $data['organization'];
?>    
<header class="row">     
    <div class="col-lg-12"><h2><?php _e(sprintf('%s organization', $data['action']), 'organization') ?></h2></div>
</header>    
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <form name="FrmEdit" id="FrmEdit" role="form" onsubmit="organization.submit(event);">
                    <fieldset>
                        <div class="form-group">
                            <label for="textName"><?php _e('Name', 'organization') ?>:</label>                            
                            <input type="text" required="required" name="name" id="textName" class="form-control" value="<?php echo $organization->getName() ?>">                            
                        </div>             
                        <div class="form-group">
                            <label for="textCity"><?php _e('City', 'organization') ?>:</label>                            
                            <input type="text" required="required" name="city" id="textCity" class="form-control" value="<?php echo $organization->getCity() ?>">                            
                        </div>             
                        <div class="form-group">
                            <label for="textState"><?php _e('State', 'organization') ?>:</label>                            
                            <input type="text" required="required" name="state" id="textState" class="form-control" value="<?php echo $organization->getState() ?>">                            
                        </div>             
                    </fieldset>
                    <input type="hidden" name="id" value="<?php echo $organization->getId() ?>">            
                    <div class="text-right">            
                        <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> <?php echo _e('Save', 'organization') ?></button>                        
                    </div>
                </form>                                
            </div>
        </div>
        <?php if ($organization->getId()) : ?>
            <div class="text-right">            
                <a href="#" onclick="organization.delete(event)"><?php _e('Delete organization', 'organization') ?></a>                
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