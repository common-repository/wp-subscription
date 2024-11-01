<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

final class WPSubscriptionShortcode {

    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'loadScripts'));
        add_shortcode('wp_subscription', array($this, 'wp_subscription'));
    }

    function loadScripts() {

     }

    function wp_subscription($atts) {
         include('formSetting.php');
         include('assets.php');
         
        ob_start();
       echo '<style>' . $wp_subscription_appearance_custom_css . '</style>';
        echo '<div class="bootstrap-wrapper support_bs">';
              if($atts['type']=='angular'){
                 include('views/angular/defualt.php');
               } else  if($atts['type']=='popup'){
                $wpsp_form_popup_count='';
                if(!empty(get_option('wpsp_form_popup_count'))){
                  $wpsp_form_popup_count=get_option('wpsp_form_popup_count');
                  $wpsp_form_popup_time = (!empty(get_option('wpsp_form_popup_time'))) ? get_option('wpsp_form_popup_time') : 1 ;
                
                              ?><script type="text/javascript">    
                              var $ = jQuery.noConflict();                          
                $(document).ready(function(){
                   if ($.cookie('wpspform<?php echo $form_id ?>') == null  
                    <?php echo (!empty($wpsp_form_popup_count)) ? " || $.cookie('wpspform".$form_id."') < ".$wpsp_form_popup_count : ''?>
                   ) {
                      $("#wpspModal<?php echo $form_id ?>").modal('show');
                       if ($.cookie('wpspform<?php echo $form_id ?>') == null || $.cookie('wpspform<?php echo $form_id ?>') == 'NaN'){
                          var wpspformcount=0;
                       }else{
                      var wpspformcount=$.cookie('wpspform<?php echo $form_id ?>');
                    }
                      wpspformcount=parseInt(wpspformcount)+1;
                      $.cookie('wpspform<?php echo $form_id ?>', wpspformcount,{ expires : <?php echo $wpsp_form_popup_time ?> });
                }
                });
              </script>
           <?php }else { ?>
<script type="text/javascript">                              
                $(document).ready(function(){                  
                      $("#wpspModal<?php echo $form_id ?>").modal('show');                
                });
              </script>

          <?php } ?>
                      <div class="modal fade bs-example-modal-sm" id="wpspModal<?php echo $form_id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">                          
                          <div class="modal-body">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>    
                             <?php include('views/ajax/defualt.php'); ?>
                          </div>
                          
                        </div>
                      </div>
                    </div>

               <?php
                  include('script.php');    
               }
               else{
                  include('views/ajax/defualt.php');
                  include('script.php');                
              }
        echo '</div>';
        return ob_get_clean();
    }

}

$GLOBALS['WPSubscriptionShortcode'] = new WPSubscriptionShortcode();
