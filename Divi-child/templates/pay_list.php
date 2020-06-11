<?php  
    global $wpdb;
    global $wp;        
    $table_name = $wpdb->prefix.'plan';
    $rows = $wpdb->get_row("SELECT * FROM $table_name WHERE plan_id = 1",ARRAY_A);  
    if(isset($_POST['submit'])){        
        // if($_POST['plan'] == 0){
                $data = array('selected_plan'=>$_POST['plan'],
                              'basic_amount' =>$_POST['amount']
                              );                
                             
        // }else{
        //     $data = array('selected_plan'=>$_POST['plan'] );            
        // }
            $update = $wpdb->update($table_name,$data,array('plan_id'=>1));
            if($update){                
                flash('msg','<div class="alert alert-success alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Success!</strong> Plan changed successfully.
                            </div>');
                echo "<script>setTimeout(function(){ location.reload(); }, 2000);</script>";
            }
    }
?>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<div class="wrap">
</div>
<div class="container">
	<div class="row top">
      <div class="col-md-6 col-md-offset-3">
        <div class="well well-sm">
          <form class="form-horizontal" method="post" id="myform">
          <fieldset>    
            <legend class="text-center" style="text-transform: uppercase; font-size:22px; font-weight:bold;">
            Choose your current plan
            </legend>
                <?php echo flash('msg');?>
            <!-- Basic input-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="name">Basic plan </label>
              <div class="col-md-9">              
              <input type="radio" value="0" id="basic" name="plan" <?php if($rows['selected_plan'] == 0){ echo "checked"; } ?> > 
              </div>
            </div>
    
            <!-- Advanced input-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="email">Advanced plan</label>              
              <div class="col-md-9">              
              <input type="radio" value="1" name="plan" id="advanced" <?php if($rows['selected_plan'] == 1){ echo "checked"; } ?> >
              </div>
            </div>
                <input type="hidden" name="id" value="<?php echo $row->plan_id; ?>">
            <!-- amount -->
            <div class="form-group show-input-amount <?php if($rows['selected_plan'] == 1){ ?> hidden <?php } ?> " id="amount_input">
              <label class="col-md-3 control-label" for="message">Amount</label>
              <div class="col-md-9">
                <input type="text" name="amount" value="<?php echo $rows['basic_amount'];?>" id="amount" placeholder="Enter basic amount" class="form-control">
              </div>
            </div>
    
            <!-- Form actions -->
            <div class="form-group">
              <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
              </div>
            </div>
          </fieldset>
          </form>
        </div>
      </div>
	</div>
</div>
<script>
    var $ = jQuery;
    $("#basic").click(function(){
        $("#amount_input").removeClass("hidden");
    });
    $("#advanced").click(function(){
        $("#amount_input").addClass("hidden");
    });    
    $( "#myform" ).validate({
    rules: {
        amount: {
        required: true,
        number: true
        },
        plan: {
            required: true,       
        },
        messages:
        {
        plan:
          {
            required:"Please select a Plan<br/>"
          }
        },
       errorPlacement: function(error, element) 
        {
            if ( element.is(":radio") ) 
            {
                error.appendTo( element.parents('.container') );
            }
            else 
            { // This is the default behavior 
                error.insertAfter( element );
            }
         }
        
    }   
    });
    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
        $(".alert").slideUp(500);
    });
</script>
<style>
.row.top {
    margin-top: 6%;
}
html, body {
    max-width: 100%;
    overflow-x: hidden;
}

</style>