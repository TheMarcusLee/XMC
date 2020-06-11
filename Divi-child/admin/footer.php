<footer>
		<div class="container">
			
			<p class="text-center">Copyright © 2018 XTREME MARKETING CODE. All Right Reserved</p>
		</div>
	</footer>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script src="<?php echo  get_template_directory_uri().'-child'; ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo  get_template_directory_uri().'-child'; ?>/js/jquery.validate.js"></script>
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="<?php echo  get_template_directory_uri().'-child'; ?>/js/customscript.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
	
	<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap.min.js"></script>

	<script src="<?php echo  get_template_directory_uri().'-child'; ?>/js/custom-file.js"></script>
	
	<script>
		var overlay=document.getElementById('overlay');
		window.addEventListener('load',function(){
			overlay.style.display="none";
		})
	</script>

	<script>
		$(document).ready(function(){
			$(".container-fluid").addClass("no-padding-right");
			$(".dashboard-box").addClass("no-padding-right");
			$(".dashboard-box").children().children().next().addClass("pages-bg");
			$('.dropdown-button').click(function(){
				$('.dropdown-options').toggle();
			});			
			$('.earning-btn').click(function(){
				$('.earning-ddown').fadeToggle();
			});
			

			$('.lead-btn').click(function(){
				$('.lead-ddown').fadeToggle();
			});
			$('.referral-btn').click(function(){
				$('.referral-ddown').fadeToggle();
			});
			// $('#phone_name_list').DataTable();
			
			$('#phone_name_list').DataTable({
				responsive: true
			});
			$('#view_phone_list').DataTable({
				responsive: true
			});
			$('#audio_list').DataTable({
				responsive: true
			});			
			$("#compaign_list_table").DataTable({
				responsive: true
			});
			$("#subscription").DataTable({
				responsive: true
			});
			
			$('.phone_name_lists').DataTable({
				responsive: true
			});
		});

	function notishowable() {
		var checkBox = document.getElementById("notificationRadio1");
		var text = document.getElementById("mobilehidden-div");
		if (checkBox.checked == true){
			//alert('Hello');
			text.style.display = "block";
		} else {
		   text.style.display = "none";
		}
	}
	
	function notiunshowable() {
		var checkBox = document.getElementById("notificationRadio2");
		var text = document.getElementById("mobilehidden-div-2");
		if (checkBox.checked == true){
			//alert('Hello');
			text.style.display = "block";
		} else {
		   text.style.display = "none";
		}
	}
	function buy_num_notiunshowable() {
		
		var checkBox = document.getElementById("notificationRadio2");
		var text = document.getElementById("mhidden-div");
		if (checkBox.checked == true){
			//alert('Hello');
			text.style.display = "block";
		} else {
		   text.style.display = "none";
		}
	}
	
	function followshowable() {
		var checkBox = document.getElementById("dayRadio1");
		var text = document.getElementById("dayhidden-div");
		if (checkBox.checked == true){
			//alert('Hello');
			text.style.display = "block";
		} else {
		   text.style.display = "none";
		}
	}
	
	function followunshowable() {
		var checkBox = document.getElementById("dayRadio2");
		var text = document.getElementById("dayhidden-div");
		if (checkBox.checked == true){
			//alert('Hello');
			text.style.display = "none";
		} else {
		   text.style.display = "block";
		}
	}
	
	</script>

  </body>
</html>