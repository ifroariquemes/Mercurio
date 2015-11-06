<?php global $_MyCookie; ?>
<div class="row">
    <div class="col-md-12">        
        <div id="admin-tile-section">            
            <?php foreach ($data as $menu) : ?>                    
                <?php $tile_double = (strlen($menu->getName()) <= 7) ? '' : 'tile-double'; ?>                    
                <a class="thumbnail tile fa-links tile-<?= $menu->getColor() ?> <?= $tile_double ?>" href="<?= $_MyCookie->mountLink('administrator', $menu->getDirectory()); ?>">                                                
                    <?php if (!empty($menu->getIcon())) : ?>
                        <h1><?= $menu->getName(); ?></h1>
                        <i class="fa fa-3x <?= $menu->getIcon() ?>"></i>
                    <?php else : ?>
                        <h1 class="tile-text"><?= $menu->getName(); ?></h1>                                
                    <?php endif; ?>
                </a>                                  
            <?php endforeach; ?> 
        </div>    
    </div>
</div>