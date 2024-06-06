<!-- SCRIPT CHAIN DROPDOWNLIST RELATED -->
<script>           
    
    $(function(){                           
        $('#<?php echo $parentId;?>').change(function(){
            var parentId = $('#<?php echo $parentId;?>').val();
            var secondParentId = $('#<?php echo $secondParentId;?>').val();
            var data = {'<?php echo $parentId;?>':parentId};
            if (typeof secondParentId !== 'undefined' && secondParentId !== null && secondParentId !== '') {
                data['<?php echo $secondParentId;?>'] = secondParentId;
            }
  
        $("#<?php echo $childId;?> > option").remove();
            
        $.ajax({
            /*url:"<?php echo Yii::app()->createAbsoluteUrl($url); ?>",*/
            url:"<?php echo Constant::baseUrl() . '/'. $url; ?>",
            data:data,
            type:'post',
            dataType:'json',
            success:function(data){
                $.each(data,function(<?php echo $valueField;?>,<?php echo $textField;?>) 
                {
                    var opt = $('<option />');
                    opt.val(<?php echo $valueField;?>);
                    opt.text(<?php echo $textField;?>);
                    $('#<?php echo $childId;?>').append(opt);                                        
                });
                <?php if (isset($triggerId)): ?>
                    $('#<?php echo $triggerId;?>').trigger('change'); 
                <?php endif; ?>
            }
        })
        })
    })
</script>
