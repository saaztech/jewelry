<?php
//dpm($account);
$account_wrapper = entity_metadata_wrapper('user', $account);


// Account Balance Table Header
$balance_header = array(
  array('data' => 'Your Earnings', 'class' => array('info'), 'colspan' => 2),
);

// Current Account Balance
$current_balance = $account_wrapper->mlm_rep_balance->value();
$current_balance = !empty($current_balance['amount']) ? $current_balance['amount'] : 0;
$current_balance_display = '$' . number_format($current_balance / 100, 2);
$balance_rows[] = array(
  array('data' => 'Current Balance'),
  array('data' => $current_balance_display, 'class' => array('text-right') ),
);

// Withdrawable Account Balance
$pending_balance = $account_wrapper->mlm_rep_payable_balance->value();


$query = db_select('mlm_balance_history', 'h')
    ->condition('h.uid', $account->uid)
    ->condition('h.type', 'payment', '!=');
$query->addExpression('SUM(h.difference)', 'total');
$lifetime_earnings = $query->execute()->fetchField();
$lifetime_earnings = '$' . number_format($lifetime_earnings / 100, 2);
//$pending_balance = !empty($pending_balance['amount']) ? $pending_balance['amount'] : 0;
//;$pending_balance_display = '$' . number_format($pending_balance / 100, 2);
$balance_rows[] = array(
  array('data' => 'Lifetime Earnings'),
  array('data' => $lifetime_earnings, 'class' => array('text-right') ),
);

$balance_table = theme('table', array(
  'header' => $balance_header,
  'rows' => $balance_rows,
  'attributes' => array(
    'class' => array('table-bordered', 'striped'),
  ),
));



// Account Balance Table Header
$customer_header = array(
  array('data' => 'Customer Status', 'class' => array('info')),
  array('data' => 'Tier 1', 'class' => array('info', 'text-center')),
  array('data' => 'Tier 2', 'class' => array('info', 'text-center')),
  array('data' => 'Tier 3', 'class' => array('info', 'text-center')),
  array('data' => 'Total', 'class' => array('info', 'text-center')),
  //array('data' => '', 'class' => array('info')),
);

$customer_rows[] = array(
  array('data' => 'Total Customers'),
  array('data' => 565, 'class' => array('text-center') ),
  array('data' => 1, 'class' => array('text-center') ),
  array('data' => 0, 'class' => array('text-center') ),
  array('data' => 3, 'class' => array('text-center') ),
);

$customer_rows[] = array(
  array('data' => 'New Customers (Last 30 Days)'),
  array('data' => 1, 'class' => array('text-center') ),
  array('data' => 0, 'class' => array('text-center') ),
  array('data' => 0, 'class' => array('text-center') ),
  array('data' => 1, 'class' => array('text-center') ),
);

$customer_table = theme('table', array(
  'header' => $customer_header,
  'rows' => $customer_rows,
  'attributes' => array(
    'class' => array('table-bordered', 'striped'),
  ),
));



//
//$chart = theme('balance_chart', array(
//  'account' => $account, 
//  'id' => 'representative-rolling-balance-chart',
//  'interval' => 'day',
//  'periods' => 30,
//  'class' => array('well', 'info'),
//));




?>


<?php if ( empty($account_wrapper->mlm_rep_slug->value()) ) { ?>
<div class="alert alert-danger">
  <span class="glyphicon glyphicon-exclamation-sign"></span> <strong>Website Status:</strong> You have not entered a valid website url. Please visit your account settings and choose a url for your representative website.
</div>
<?php } elseif ( empty($account_wrapper->mlm_rep_approve_slug->value()) ) { ?>
<div class="alert alert-warning">
  <span class="glyphicon glyphicon-exclamation-sign"></span> <strong>Website Status:</strong> Your website settings are pending administrative approval. Once approved, your new website link will be shown here.
</div>
<?php } else { ?>
<div class="alert alert-success">
  <strong>Website Status:</strong> Your website is live! Use this url to invite customers: 
    <?php 
      $url = 'https://' . $_SERVER['HTTP_HOST'] . '/' . $account_wrapper->mlm_rep_slug->value() . '/';
      echo l($url, $url, array('external' => true));
      
      $template_path = drupal_get_path('theme', 'jewelrycandles');
      
    ?>
</div>

<div class="rep-share-buttons text-right">
  Share your website!
  <a target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>"><img width="32" src="/store/<?php echo $template_path;?>/fb-art.jpg"></a> 
  <a target="_blank" href="https://twitter.com/intent/tweet?text=Jewelry Candles!&url=<?php echo $url; ?>"><img width="32" src="/store/<?php echo $template_path;?>/tw-art.png"></a>
  <br><br>
</div>
<?php } ?>





<div class="row">
  <div class="col-md-6">
    <div class="row">
      <div class="col-md-4">
        <?php
          $user_view = user_view($account);
          unset($user_view['mlm_rep_balance']);
          print theme('user_picture', array('account' => $account));
        ?>
      </div>  
      <div class="col-md-8">
        <strong><span class="glyphicon glyphicon-user"></span> <?php echo $account->name; ?></strong><br />
        <?php
          $handlers = array(
            'address' => 'address',
            'phone' => 'phone',
            'organisation' => 'organisation',
          );
          $address_render_array = addressfield_generate($account_wrapper->mlm_rep_info->value(), $handlers, array('mode' => 'render'));
          echo drupal_render($address_render_array); 
        ?>
        <!--#edit-rep-info-->
        
        <div><small><?php echo l('[Edit Details]', 'user/' . $account->uid . '/edit', array('fragment' => 'edit-rep-info')); ?></small></div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <?php if ( empty($account_wrapper->mlm_rep_payment_method->value()) ) { ?>
    <div class="alert alert-danger">
      <span class="glyphicon glyphicon-exclamation-sign"></span> You have not selected a payment method! If you do not select a payment method, you will not receive payments for your earnings. 
      <br>Please visit your <?php echo l('Account Settings', 'user/' . $user->uid . '/edit', array('fragment' => 'edit-rep-info')); ?> page to select a payment method.
    </div>
    <?php } ?>
    <?php echo render($balance_table); ?>
    
    <small class="table text-right"><?php echo l('View Account Balance History', 'user/' . $account->uid . '/balance-history'); ?></small>
    
    <?php //echo render($customer_table); ?>
    <!--<div class="col-md-6">-->
    <h4>30 Day Balance</h4>
    <?php 
      $balance_chart = mlm_rep_balance_chart($account);
      print render($balance_chart);
    ?>
  <!--</div>-->
    
  </div>
</div>

<?php if ( $account_wrapper->mlm_rep_approve_slug->value() ) { ?>
<div class="row">
  <div class="col-md-6">
    <h4>Pages Viewed on your Website</h4>
    <?php 
      $recent_web_activity = mlm_analytics_recent_activity($account);
      print render($recent_web_activity);
    ?>
  </div>
  <div class="col-md-6">
    <h4>Visitors to Your Website</h4>
    <?php 
      //$balance_chart = mlm_rep_balance_chart($account);
      //print render($balance_chart);
      $recent_web_visitors = mlm_analytics_recent_visitors($account);
      print render($recent_web_visitors);
    ?>
  </div>
</div>
<?php } ?>

<h3>Representative Downline</h3>
<div id="downline-table" class="container">
  <div class="downline downline-header row">
    <div class="col-xs-4 cell text-center">Representative</div>
    <div class="col-xs-2 cell text-center">City</div>
    <div class="col-xs-1 cell text-center">State</div>
    <div class="col-xs-2 cell text-center">Created</div>
    <div class="col-xs-1 cell text-center">Orders</div>
    <div class="col-xs-2 cell text-right">Earnings</div>
  </div>
<?php //echo views_embed_view('downline', $display_id = 'block'); ?>
  
<?php
  $data = mlm_rep_draw_tier($account, 1);
  echo $data;
  
?>

  
</div>








<h3>Recent Orders</h3>
<div>
<?php echo views_embed_view('commerce_representative_orders', $display_id = 'block_1', $account->uid); ?>
</div>
