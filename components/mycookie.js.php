<?php global $_MyCookie; ?>
<script type="text/javascript">
    MYCOOKIEJS_ACTION = '<?php echo $_MyCookie->getAction(); ?>';
    MYCOOKIEJS_MODULE = '<?php echo $_MyCookie->getModule(); ?>';
    MYCOOKIEJS_AUXILIARMODULE = '<?php echo $_MyCookie->getAuxiliarModule(); ?>';
    MYCOOKIEJS_NAMESPACE = '<?php echo str_replace('\\', '\\\\', $_MyCookie->getNamespace()); ?>';
    MYCOOKIEJS_SITE = '<?php echo $_MyCookie->getSite(); ?>';
    MYCOOKIEJS_ALERT = '<?php _e('System message', 'administrator') ?>';
    MYCOOKIEJS_CONFIRMATION = '<?php _e('Confirmation', 'administrator') ?>';
    MYCOOKIEJS_YES = '<?php _e('Yes', 'administrator') ?>';
    MYCOOKIEJS_NO = '<?php _e('No', 'administrator') ?>';
    I18N_LANG = '<?php echo $_MyCookie->getMyCookieConfiguration()->lang; ?>';
    require(['jquery'], function($) {
        i18n.init({
            resGetPath: 'src/lang/__lng__/js/__ns__.json',
            ns: {
                namespaces: ['index', 'administrator', 'build', 'user']
            }
        });
    });
</script>