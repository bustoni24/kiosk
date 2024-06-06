<ul class="nav nav-tabs" id="parent-content">
    <?php
    if (isset($data) && !empty($data)){
        foreach ($data as $key) {
            $Id = $key->accessRules;
            $url = Constant::baseUrl().$key->url;
            $icon = (isset($key->icon) && !empty($key->icon) ? '<i class="fa '.$key->icon.'"></i>' : '');
            $label = $key->label;
            ?>
            <li <?php echo ($this->Id == $Id ? 'class="active"' : ''); ?>>
                <a href="<?php echo $url ?>"><?php echo $icon.' '.$label ?></a>
            </li>
            <?php
        }
    } else {
        ?>
        <li <?php echo ($this->Id == 'front' ? 'class="active"' : ''); ?>>
            <a href="<?php echo Constant::baseUrl().'front/index' ?>"><i class="fa fa-home"></i> Home</a>
        </li>
        <?php
    }
    ?>
</ul>