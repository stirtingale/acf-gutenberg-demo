<?php  
if( isset( $block['data']['preview_image_help'] )  ) :    
    $image = get_template_directory_uri().'/blocks/previews/'.basename(__FILE__, '.php').'.jpg';
    echo '<img src="'. $image .'" style="width:100%; height:auto;">';
else:
?>

    <?php 
    // vars 
    $block2 = get_field('block_2');
    ?>

    <h2>
        <?php echo $block2; ?>
    </h2>


<?php endif; // preview_image_help ?>