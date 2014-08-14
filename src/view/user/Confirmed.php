<div class="modal" id="mdConfirmed">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php _e('User confirmed!', 'user') ?></h4>
            </div>            
            <div class="modal-body">                                                        
                <p>Congratulations! Now your are ready to use Mercurio services.<br>Please, proceed with login to continue.</p>                                                                                                    
            </div>                
            <div class="modal-footer">                
                <button type="button" class="btn btn-success" onclick="location.href = '<?php echo $data ?>'"><i class="fa fa-sign-in"></i> <?php _e('Go to login', 'user') ?></button>
            </div>            
        </div>
    </div>
</div>
<script type="text/javascript">
    require(['jquery'], function($) {
        $(function() {
            $('#mdConfirmed').modal({
                'show': true,
                'keyboard': false,
                'backdrop': false
            });
        });
    });
</script>