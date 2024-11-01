 <div class="wp_subscription">
             
              <h3 class="box-title wp_subscription_title" id="wp_subscription_title<?php echo $form_id ?>"><?php echo $wp_subscription_title?></h3>
            
           <form name="myform<?php echo $form_id ?>">
         
                  <div class="wp_subscription_sub_title" id="wp_subscription_sub_title<?php echo $form_id ?>"><?php echo $wp_subscription_sub_title?></div> 
                 <div id="subscribeerrordiv<?php echo $form_id ?>" class="has-success">
                  <label class="control-label" id="subscribeerror<?php echo $form_id ?>"></label>                
                </div>
                  <?php if(isset( $wp_subscription_enable_first_name) &&  $wp_subscription_enable_first_name==1){?>                                 
                    <div class="wp_subscription_email_frist_name form-group">
                      <label for="frist_name<?php echo $form_id ?>"><?php echo $wp_subscription_first_name ?></label><br>
                      <input type="text" class="form-control" id="frist_name<?php echo $form_id ?>" name="frist_name"  placeholder="Enter <?php echo $wp_subscription_first_name ?>">
                    </div> 
                     <?php } if(isset( $wp_subscription_enable_last_name) &&  $wp_subscription_enable_last_name==1) {?> 
                     <div class="wp_subscription_email_last_name form-group">
                      <label for="last_name<?php echo $form_id ?>"><?php echo $wp_subscription_last_name ?></label><br>
                      <input type="text" class="form-control" id="last_name<?php echo $form_id ?>" name="last_name"  placeholder="Enter <?php echo $wp_subscription_last_name ?>">
                    </div> 
                    <?php } ?>
                    <div class="wp_subscription_email form-group">
                      <label for="email<?php echo $form_id ?>"><?php echo $wp_subscription_email_label ?> *</label><br>
                      <input type="email" class="form-control" id="email<?php echo $form_id ?>" name="email" ng-model="email" placeholder="Enter <?php echo $wp_subscription_email_label ?>" required>
                    </div> 
                     <input type="hidden" id="list_id<?php echo $form_id ?>" name="list_id" value="<?php echo  $list_id ?>">
                      <input type="hidden" id="form<?php echo $form_id ?>" name="form" value="<?php echo  $form_id ?>">
                      <input type="hidden" id="wp_subscription_token<?php echo $form_id ?>" name="wp_subscription_token" value="<?php echo  get_option('wp_subscription_token'); ?>">

                      <input type="button" id="submit_product<?php echo $form_id ?>" class="wp_subscription_btn btn btn-primary" name="submit_product" value="<?php echo $wp_subscription_button_label ?>">
                 
                </form>
</div> 