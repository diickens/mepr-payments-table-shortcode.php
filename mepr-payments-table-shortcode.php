<?php
//Adds a new shortcode called [mepr-account-payments]
//This shortcode should work on most pages/posts/cpt's on the site
//Probably will not work in a widget or other locations though because of the script enqueueing

function memberpress_account_payments_display($atts, $content='') {
  if(!class_exists('MeprAccountCtrl')) { return; }

  ob_start();

  $acct_ctrl = new MeprAccountCtrl();
  $action = (isset($_REQUEST['action']))?$_REQUEST['action']:false;

  switch($action) {
	case 'cancel':
	  $acct_ctrl->cancel();
	  break;
	case 'suspend':
	  $acct_ctrl->suspend();
	  break;
	case 'resume':
	  $acct_ctrl->resume();
	  break;
	case 'update':
	  $acct_ctrl->update();
	  break;
	case 'upgrade':
	  $acct_ctrl->upgrade();
	  break;
	default:
	  $acct_ctrl->payments();
  }
  
  $content = ob_get_clean();
  return $content;
}
add_shortcode('mepr-account-payments', 'memberpress_account_payments_display');

function memberpress_account_payments_display_scripts() {
  if(!class_exists('MeprAccountCtrl')) { return; }
  
  global $post;
  
  if(!isset($post->post_content)) { return; }
  
  if(strpos($post->post_content, 'mepr-account-payments') !== false) {
    $acct_ctrl = new MeprAccountCtrl();
    $acct_ctrl->enqueue_scripts(true);
  }
}
add_action('template_redirect', 'memberpress_account_payments_display_scripts');
?>
