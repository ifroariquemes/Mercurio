<nav>
    <ul class="pagination">                
        <li <?php if ($data['currentPage'] - 1 <= 0) : ?>class="disabled"<?php endif; ?>>
            <a href="<?php if ($data['currentPage'] - 1 > 0) : ?>?page=<?= $data['currentPage'] - 1 ?><?php endif; ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>                
        <?php
        for ($i = 1, $max = $data['pages']; $i <= $max; $i++) :
            ?>
            <li class="<?php if ($i == $data['currentPage']) echo "active" ?>">
                <a href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>                
        <li <?php if ($data['currentPage'] + 1 > $data['pages']) : ?>class="disabled"<?php endif; ?>>
            <a href="<?php if ($data['currentPage'] + 1 <= $data['pages']) : ?>?page=<?= $data['currentPage'] + 1 ?><?php endif; ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>                
    </ul>
</nav>