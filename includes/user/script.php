<script>
var $ = jQuery.noConflict();
$("#submit_product<?php echo $form_id ?>").click(function(){
       var frist_name_ip = $("#frist_name<?php echo $form_id ?>").val();
       var last_name_ip = $("#last_name<?php echo $form_id ?>").val();
       var email_ip = $("#email<?php echo $form_id ?>").val();
       var list_id_ip = $("#list_id<?php echo $form_id ?>").val();    
       var form_ip = $("#form<?php echo $form_id ?>").val();     
       var wp_subscription_token = $("#wp_subscription_token<?php echo $form_id ?>").val();        
   $.ajax({
      url: '<?php echo admin_url('admin-ajax.php')?>?action=wpuser_addsubscriber',
      data: {
        frist_name: frist_name_ip,
        last_name: last_name_ip,
        email :email_ip,
        list_id :list_id_ip,
        form :form_ip,
        wp_subscription_token :wp_subscription_token
      },
       error: function(data) {       
         alert(data['message']);       
      },     
      success: function(data) {
        var parsed = $.parseJSON(data);
        $('#subscribeerror<?php echo $form_id ?>').html(parsed.message);
        $('#subscribeerrordiv<?php echo $form_id ?>').removeClass().addClass('has-'+parsed.status);    
        
       $("#frist_name<?php echo $form_id ?>").val('');
       $("#last_name<?php echo $form_id ?>").val('');
       $("#email<?php echo $form_id ?>").val('');      
      },
      type: 'POST'
   });
});
</script>