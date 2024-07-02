<?php
$toc_title = $attributes['title'] ?? 'En Este Artículo';
$toc_color = $attributes['borderColor'] ?? '';

$extraAttributes = array(
  'class'=>'toc-wrapper wp-block-wa-blocks-core-toc',
  'data-heading' => $toc_title,
  'syle' => $toc_color ?? '',
);
$toc="";
if(function_exists('WA_Theme')):
$toc =  WA_Theme()->helper('articles')->get_table_of_contents(get_the_content());
endif;
ob_start();

?>

<nav <?php echo get_block_wrapper_attributes($extraAttributes); ?>>

      <?php echo $toc; ?>

      <div class="toc-wrapper-view-all">
        <button class="btn btn-view-all">Ver todo</button>
      </div>
</nav>
<?php

$render = ob_get_clean();


$render = str_replace(array("\r", "\n", "<p></p>"), '', $render);

echo $render;
?>