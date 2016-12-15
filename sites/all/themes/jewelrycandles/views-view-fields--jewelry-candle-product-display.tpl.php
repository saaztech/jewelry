<?php

/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */


$yotpo = $fields['field_yotpo_id']->content;

?>

<div class="row">
  <div class="col-lg-5 col-md-6">
    <?php print $fields['field_product_image']->content; ?>
    <!--<img src="//cdn.shopify.com/s/files/1/0172/4672/products/alaskan-adventures_large.jpg?v=1452285470" alt="Alaskan Adventures Jewelry Candles - The Official Website of Jewelry Candles - Find Jewelry In Candles!" id="ProductPhotoImg">-->
    <em><small>* The jewel shown in the picture is just an example of what you could get in your Jewelry Candle! We offer thousands of different styles and designs of jewelry in our Jewelry Candles so you never know what you are going to get! It is always a surprise!</small></em>
  </div>
  <div class="col-lg-7 col-md-6">
<!--     <h3><?php print $fields['title']->content; ?></h3> -->
    <h4 class="commerce-product-price">
      <?php print $fields['commerce_price']->wrapper_prefix; ?>
      <?php print $fields['commerce_price']->content; ?>
      <?php print $fields['commerce_price']->wrapper_suffix; ?>
    </h4>
    
    <div class="product-cart-box clearfix">
      <?php print $fields['add_to_cart_form']->wrapper_prefix; ?>
      <?php print $fields['add_to_cart_form']->content; ?>
      <?php print $fields['add_to_cart_form']->wrapper_suffix; ?>
    </div>
    
    <div class="product-yotpo">
       <?php if ( !empty($yotpo) ) : ?>
        <div class="yotpo bottomLine"
          data-appkey="Xbirnz4w9FnYQzZSt3GfVaePo0wIgVT96MvAqwqi"
          data-domain="jewelrycandles.myshopify.com"
          data-product-id="<?php print $yotpo; ?>"
          data-product-models="<?php print $yotpo; ?>"
          data-name="Lavender Wax Dipped Roses"
          data-url="http://www.jewelrycandles.com/products/lavender-wax-dipped-roses"
          data-image-url="//cdn.shopify.com/s/files/1/0172/4672/products/105_watermark_large.jpg%3Fv=1447445299"
          data-description="&lt;p&gt; &lt;/p&gt;
          &lt;p&gt;These are our new , classic lavender wax dipped roses!&lt;/p&gt;
          &lt;p&gt;These are truly perfect for any special occasion!&lt;/p&gt;
          &lt;p&gt;These will look great with your home decor and make your home smell amazing!&lt;/p&gt;
          &lt;p&gt;Remember, the scent lasts up to 6 months and all our wax dipped roses are coated with fresh cut roses scent!&lt;/p&gt;"
          data-bread-crumbs="25-50;pure;rosebundle;shopby-ann;shopby-bridal;shopby-grads;shopby-love;shopby-sorry;shopby-wedd;wax-dipped-roses;wax-roses;waxroses;">
        </div>
        <?php endif; ?>
    </div>
    
    <div class="product-description">
      <?php print $fields['field_description']->content; ?>
    </div>
    
    <?php if ( !empty($fields['description']->content) ) : ?>
    <div class="product-description product-collection-description">
      <?php print $fields['description']->content; ?>
    </div>
    <?php endif; ?>

    <div class="product-specifications">
      <?php print $fields['field_specifications']->content; ?>
    </div>
  </div>
</div>

<hr>

<?php if ( !empty($yotpo) ) : ?>
<div class="yotpo yotpo-main-widget"
    data-product-id="<?php print $yotpo; ?>"
    data-name="Alaskan Adventures Jewelry Candles"
    data-url="http://www.jewelrycandles.com/products/alaskan-adventures-jewelry-candles"
    data-image-url="//cdn.shopify.com/s/files/1/0172/4672/products/alaskan-adventures_large.jpg%3Fv=1452285470"
    data-description="Product Description">
</div>
<script type="text/javascript">
  (function e(){var e=document.createElement("script");e.type="text/javascript",e.async=true,e.src="//staticw2.yotpo.com/Xbirnz4w9FnYQzZSt3GfVaePo0wIgVT96MvAqwqi/widget.js";var t=document.getElementsByTagName("script")[0];t.parentNode.insertBefore(e,t)})();
</script>
<?php endif; ?>

<style>
  .yotpo-main-widget { width: 100% !important;}
</style>