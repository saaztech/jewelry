<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * 
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see bootstrap_preprocess_page()
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see bootstrap_process_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup templates
 */
?>

  <!-- HEADER: Above Navbar -->
  <div class="container" id="main-header">
    <div class="row">
      <div class="col-md-6">
        <!-- Logo -->
        <?php if ($logo): ?>
        <a class="logo navbar-btn pull-left" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>">
          <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
        </a>
        <?php endif; ?>
      </div>
      <div class="col-md-6">
        <!-- This is where the Rep's Info is displayed -->
        <div class="rep_header pull-right text-right">
          <?php $rep_header = theme('rep_header', array()); 
        print render($rep_header); ?>
        </div>
      </div>
    </div>
  </div>
  
  <div id="product-search" class="container">
    <div class="row">
      <div class="col-sm-12 col-md-4 col-lg-3 col-md-push-8 col-lg-push-9">
        <form action="/store/collections/search" method="GET">
          <div class="input-group"><input title="Enter the terms you wish to search for." placeholder="Search" class="form-control form-text" type="text" id="edit-search-block-form--2" name="search" value="" size="15" maxlength="128">
            <span class="input-group-btn"><button type="submit" class="btn btn-primary"><span class="icon glyphicon glyphicon-search" aria-hidden="true"></span></button></span></div>
        </form>
      </div>
    </div>
  </div>


  <!-- Main Navigation -->
 <header id="navbar" role="banner" class="<?php print $navbar_classes; ?>">
    <div class="row">
      <div class="navbar-header">
        <?php if (!empty($primary_nav) || !empty($secondary_nav) || !empty($page['navigation'])): ?>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only"><?php print t('Toggle navigation'); ?></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <?php endif; ?>
      </div>

      <?php if (!empty($primary_nav) || !empty($secondary_nav) || !empty($page['navigation'])): ?>
      <div class="navbar-collapse collapse">
        <nav role="navigation">

          <ul class="menu nav navbar-nav navbar-collections">
            <li class="first"><a href="#candle-collections-menu" data-toggle="collapse" class="">Candle Collections <span class="caret"></span></a></li>
            <li class="first"><a href="#tart-collections-menu" data-toggle="collapse" class="">Wax Tarts <span class="caret"></span></a></li>
            <li class="first"><a href="#roses-collections-menu" data-toggle="collapse" class="">Wax Roses <span class="caret"></span></a></li>
            <li class="first"><a href="#soaps-collections-menu" data-toggle="collapse" class="">Bath &amp; Body <span class="caret"></span></a></li>
          </ul>


          <?php if (!empty($primary_nav)): ?>
          <?php print render($primary_nav); ?>
          <?php endif; ?>
          <?php if (!empty($secondary_nav)): ?>
          <?php print render($secondary_nav); ?>
          <?php endif; ?>
          <?php if (!empty($page['navigation'])): ?>
          <?php print render($page['navigation']); ?>
          <?php endif; ?>
        </nav>
      </div>
      <?php endif; ?>
    </div>
  </header>

  <!-- Contains the Collection Menus -->
  <div id="collection-menus" class="container">
    <div class="collection-menu row collapse" id="candle-collections-menu">
      <div class="col-md-6">
        <h2 class="collection-title">Candle Collections</h2>
        <ul class="collection-links">
          <?php
         echo '<li>' . l('All Candles', 'collections/all-candles') . '</li>';
        $terms = taxonomy_get_tree(2, 129, 1);
        foreach($terms as $tid => $term) {
          $uri = taxonomy_term_uri($term);
          $path = drupal_get_path_alias($uri['path']);
          echo '<li>' . l($term->name, $path) . '</li>';
        }
        
      ?>
        </ul>
      </div>
      <div class="col-md-6">
        <?php echo views_embed_view('collection_menu_items', $display_id = 'block_1', array('candle')); ?>
      </div>
    </div>

    <!-- Tarts -->
    <div class="collection-menu row collapse" id="tart-collections-menu">
      <div class="col-md-6">
        <h2 class="collection-title">Wax Tart Collections</h2>
        <ul class="collection-links">
          <?php
        echo '<li>' . l('All Wax Tarts', 'collections/all-tarts') . '</li>';
        $terms = taxonomy_get_tree(2, 130, 1);
        foreach($terms as $tid => $term) {
          $uri = taxonomy_term_uri($term);
          $path = drupal_get_path_alias($uri['path']);
          echo '<li>' . l($term->name, $path) . '</li>';
        }
        
      ?>
            <ul>
      </div>
      <div class="col-md-6">
        <?php echo views_embed_view('collection_menu_items', $display_id = 'block_1', array('wax_melts')); ?>
      </div>
    </div>


    <!-- Roses -->
    <div class="collection-menu row collapse" id="roses-collections-menu">
      <div class="col-md-6">
        <h2 class="collection-title">Wax Roses Collections</h2>
        <ul class="collection-links">
          <?php
        $terms = taxonomy_get_tree(2, 131, 1);
        foreach($terms as $tid => $term) {
          $uri = taxonomy_term_uri($term);
          $path = drupal_get_path_alias($uri['path']);
          echo '<li>' . l($term->name, $path) . '</li>';
        }
        
      ?>
            <ul>
      </div>
      <div class="col-md-6">
        <?php echo views_embed_view('collection_menu_items', $display_id = 'block_1', array('wax_roses')); ?>
      </div>
    </div>

    <!-- Soaps -->
    <div class="collection-menu row collapse" id="soaps-collections-menu">
      <div class="col-md-6">
        <h2 class="collection-title">Soaps Collections</h2>
        <ul class="collection-links">
          <?php
        $terms = taxonomy_get_tree(2, 132, 1);
        foreach($terms as $tid => $term) {
          $uri = taxonomy_term_uri($term);
          $path = drupal_get_path_alias($uri['path']);
          echo '<li>' . l($term->name, $path) . '</li>';
        }
        
      ?>
            <ul>
      </div>
      <div class="col-md-6">
        <?php echo views_embed_view('collection_menu_items', $display_id = 'block_1', array('soaps')); ?>
      </div>
    </div>


  </div>

  <!-- Homepage Slideshow -->  
  <?php if ( drupal_is_front_page() ) : ?>
      <div class="container">
        
      
    <?php echo views_embed_view('slideshow', 'block'); ?>
        </div>
  <?php endif; ?>
      
      
      

  <!-- Main Content -->
  <div class="main-container <?php print $container_class; ?>">

 
    <div class="row">

      <!-- Left Column -->
      <?php if (!empty($page['sidebar_first'])): ?>
        <aside class="col-sm-3" role="complementary">
          <?php print render($page['sidebar_first']); ?>
        </aside>
      <?php endif; ?>

      <!-- Center Column -->
      <section<?php print $content_column_class; ?>>
        
        <!-- Highlighted Information (Currently not Used) -->
        <?php if (!empty($page['highlighted'])): ?>
          <div class="highlighted jumbotron">
            <?php print render($page['highlighted']); ?>
          </div>
        <?php endif; ?>
        
        <!-- Breadcrumbs -->
        <?php //if (!empty($breadcrumb)): print $breadcrumb; endif;?>
        
        <!-- Main Content Anchor Link -->
        <a id="main-content"></a>
        
        <!-- Page Title -->
        <?php print render($title_prefix); ?>
        <?php if (!empty($title)): ?>
          <h1 class="page-header"><?php print $title; ?></h1>
        <?php endif; ?>
        <?php print render($title_suffix); ?>
        
        <!-- Error Messages, Alerts, and Notifications. DO NOT DISABLE -->
        <?php print $messages; ?>
        
        <!-- Page Tabs -->
        <?php if (!empty($tabs)): ?>
        <?php print render($tabs); ?>
        <?php endif; ?>
        
        <!-- Help Information (If it exists) -->
        <?php if (!empty($page['help'])): ?>
          <?php print render($page['help']); ?>
        <?php endif; ?>
        
        <!-- These are action links like Save, Delete, Edit, etc... -->
        <?php if (!empty($action_links)): ?>
        <ul class="action-links">
          <?php print render($action_links); ?>
        </ul>
        <?php endif; ?>
        
        <!-- The Page's Content -->
        <?php print render($page['content']); ?>
      </section>
        
      <!-- Right Column -->
      <?php if (!empty($page['sidebar_second'])): ?>
        <aside class="col-sm-3" role="complementary">
          <?php print render($page['sidebar_second']); ?>
        </aside>
      <?php endif; ?>

    </div>
  </div>
      
  <!-- Footer -->    
  <?php if (!empty($page['footer'])): ?>
  <div class="footer-wrapper">
    <footer class="footer <?php print $container_class; ?>">
      <?php print render($page['footer']); ?>
    </footer>
  </div>
  <?php endif; ?>