<?php  
if( isset( $block['data']['preview_image_help'] )  ) :    
    $image = get_template_directory_uri().'/blocks/previews/'.basename(__FILE__, '.php').'.jpg';
    echo '<img src="'. $image .'" style="width:100%; height:auto;">';
else:
?>

    <?php 
    // vars 
    $block1 = get_field('block_1');
    ?>

    <h1>
        <?php echo $block1; ?>
    </h1>


<?php endif; // preview_image_help ?>