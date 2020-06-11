<?php 
include( get_template_directory() . '-child/admin/header.php' );
?>
<section class="dashboard">
		<div class="container">
			<div class="dashboard-box">
                <div class="col-md-8">
                <h2 style="border-bottom: 1px solid #e3051c;color: #e3051c; padding-bottom: 15px;margin-bottom:15px;">Settings</h2>
                </div>
                <div class="col-md-8">
               
                <div id="tab" class="btn-group" data-toggle="buttons-radio">
                    <a href="#twilio" class="btn btn-large btn-info active setting_tab_api" data-toggle="tab">Twilio</a>
                    <a href="#pilivo" class="btn btn-large btn-info setting_tab_api" data-toggle="tab">Pilivo</a>
                </div>
                
                <form action="" method="post">


                <!-- Twilio Api Section -->
                <div class="tab-content">
                    <div class="tab-pane active" id="twilio">
                        <div class="form-group">
                            <label for="title">Twilio SID</label>
                            <input type="text" class="form-control" name="twilio_sid" placeholder="Twilio SID">
                        </div>
                        <div class="form-group">
                            <label for="keyword">Twilio Token</span> </label>
                            <input type="text" name="twilio_token" class="form-control" placeholder="Twilio Token">
                        </div>
                    </div>
                
                <!-- END Twilio API Section -->

                <!-- Pilivo Api Section -->
               
                    <div class="tab-pane" id="pilivo">
                        <div class="form-group">
                            <label for="title">Pilivo SID</label>
                            <input type="text" class="form-control" name="pilivo_sid" placeholder="Pilivo SID">
                        </div>
                        <div class="form-group">
                            <label for="">Pilivo Token</span> </label>
                            <input type="text" name="pilivo_token" class="form-control" placeholder="Pilivo Token">
                        </div>
                    </div>
                 </div> 

                <!-- END Twilio API Section -->

                    <div class="form-group">
                            <label for="">From Name For Email</span> </label>
                            <input type="text" name="name_email" class="form-control" placeholder="From Name">
                    </div>
                    <div class="form-group">
                            <label for="">From Name For Email</span> </label>
                            <input type="text" name="name_email" class="form-control" placeholder="From Name">
                    </div>
                    <div class="form-group">
                        <label for="compaign_sms">Email for Outgoing:</label>
                        <input type="text" class="form-control" name="outgoing_email" placeholder="Email" />
                    </div>
                    <div class="form-group">
                        <label for="compaign_sms">Select TimeZone:</label>
                        <select class="form-control" name="timeZone">
                                <option value="">Select One </option>
                                <option value="Africa-Abidjan">Africa-Abidjan</option>
                                <option value="Africa-Accra">Africa-Accra</option>
                                <option value="Africa-Addis_Ababa">Africa-Addis_Ababa</option>
                          </select>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Typo Message : </label>
                        <textarea class="form-control" name="typo_message" rows="5" id="comment"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Resubscriber Message : </label>
                        <textarea class="form-control" name="resubscriber_message" rows="5" id="comment"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Unsubscriber Message : </label>
                        <textarea class="form-control" name="unsubscriber_message" rows="5" id="comment"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Append Text : </label>
                        <textarea class="form-control" name="append_text" rows="5" id="comment"></textarea>
                    </div>
                    <p class="text-danger">Stop,Remove,Cancel,Optout,Unsub,Quit,END,QUIT,
                     Unsubscribe,STOP,STOPALL,UNSUBSCRIBE,CANCEL.</p>
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger"> <i class="fa fa-save"></i> Save</button>
                    </div>
                 </form>
                </div>  
            </div>
        </div>
</section>
<?php
include( get_template_directory() . '-child/admin/footer.php' );
?>