<?php
// $Id: content-field.tpl.php,v 1.1.2.6 2009/09/11 09:20:37 markuspetrux Exp $

/**
 * @file content-field.tpl.php
 * Default theme implementation to display the value of a field.
 *
 * Available variables:
 * - $node: The node object.
 * - $field: The field array.
 * - $items: An array of values for each item in the field array.
 * - $teaser: Whether this is displayed as a teaser.
 * - $page: Whether this is displayed as a page.
 * - $field_name: The field name.
 * - $field_type: The field type.
 * - $field_name_css: The css-compatible field name.
 * - $field_type_css: The css-compatible field type.
 * - $label: The item label.
 * - $label_display: Position of label display, inline, above, or hidden.
 * - $field_empty: Whether the field has any valid value.
 *
 * Each $item in $items contains:
 * - 'view' - the themed view for that item
 *
 * @see template_preprocess_content_field() copy of content-field.tpl.php
 *  dpm($field,'$field');dpm($items,'$items');
dpm($teaser,'$teaser');dpm($page,'$page');
dpm($field_name,'$field_name');dpm($field_type,'$field_type');
dpm($field_name_css,'$field_name_css');dpm($field_type_css,'$field_type_css');
dpm($label_display,'$label_display');dpm($field_empty,'$field_empty');
 */
?>
<?php if (!$field_empty) : ?>
<div class="field field-type-<?php print $field_type_css ?> field-<?php print $field_name_css ?>">
  <?php if ($label_display == 'above') : ?>
    <div class="field-label"><?php print t($label) ?>:&nbsp;</div>
  <?php endif;?>
  <div class="field-items">
    <?php $count = 1;
    foreach ($items as $delta => $item) :
      if (!$item['empty']) : ?>
        <div class="field-item <?php print ($count % 2 ? 'odd' : 'even') ?>">
          <?php if ($label_display == 'inline') { ?>
            <div class="field-label-inline<?php print($delta ? '' : '-first')?>">
              <?php print t($label) ?>:&nbsp;</div>
          <?php } ?>
          <?php $size_array=getimagesize($item['filepath']);
					if($size_array['0']>$size_array['1']){
						$presetname = 'thumbnail_width';//宽>高
					}else{
						$presetname = 'thumbnail_height';//宽<=高
					}
					$path = $item['filepath']; 
					$attributes = array('class'=>'imgtool','rel'=>file_create_url($path),'style'=>'display:inline;');
					$image_bmiddle=theme_imagecache_imagelink($presetname, $path, $alt = '查看大图', $title = '', $attributes , $getsize = TRUE, $absolute = TRUE);
					//$error_img = drupal_get_path('module', 'sina_vp_imagetool').'/images/loading0.gif';
					$lazy_image = drupal_get_path('module', 'sina_vp_imagetool').'/images/grey.gif';
					$replace = 'src="'.$lazy_image.'" original="';//onerror="this.src=\''.$error_img.'\';"
					$image_bmiddle = str_replace('src="', $replace, $image_bmiddle);
					// more。。有点不完美？？？？不是最新的lazyload？修改版的。
					//http://www.popo4j.com/qianduan/transformation_jquery_lazyload_plug.html 
          $output = '<div class="picBox">';
					$output .= $image_bmiddle ;
					$output .= '</div>';
          print $output //$item['view'] ?>
        </div>
      <?php $count++;
      endif;
    endforeach;?>
  </div>
</div>
<?php endif; ?>
