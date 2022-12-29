			
        </div>
		<!-- /Main Wrapper -->
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script>
// 			var email = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
var email = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

			$(document).ready(function() {

				var dateToday = new Date(); 

				$("#name").keypress(function(event) {
					var inputValue = event.which;
					// allow letters and whitespaces only.
					if (!(inputValue >= 65 && inputValue <= 123) && (inputValue != 32 && inputValue != 0)) {
						event.preventDefault();
					}
				});

				$('#phone').keypress(function(event) {

					if (event.which != 8 && isNaN(String.fromCharCode(event.which))) {
						event.preventDefault(); //stop character from entering input
					}

				});

				
			});
			
			$("#email").change(function() {
				// console.log($(this).val());
				if ($(this).val().match(email)) {} else {
					alert("Email address you entered is Incorrect!");
					$("#email").focus();
				}
			});

			$("#email1").change(function() {
				if ($(this).val().match(email)) {} else {
					alert("Email address you entered is Incorrect!");
					$("#email1").focus();
				}
			});
		</script>
		
		<!-- jQuery -->
        <script src="{{ URL::to('/') }}{{ MYHOST }}/public/js/jquery-3.6.0.min.js"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="{{ URL::to('/') }}{{ MYHOST }}/public/js/bootstrap.bundle.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
		
		<!-- Slimscroll JS -->
		<script src="{{ URL::to('/') }}{{ MYHOST }}/public/js/jquery.slimscroll.min.js"></script>
		
		<!-- Select2 JS -->
		<script src="{{ URL::to('/') }}{{ MYHOST }}/public/js/select2.min.js"></script>
		
		<!-- Datetimepicker JS -->
		<script src="{{ URL::to('/') }}{{ MYHOST }}/public/js/moment.min.js"></script>
		<script src="{{ URL::to('/') }}{{ MYHOST }}/public/js/bootstrap-datetimepicker.min.js"></script>
		
		<!-- Ck Editor JS -->
		<script src="{{ URL::to('/') }}{{ MYHOST }}/public/js/ckeditor.js"></script>

		<!-- Custom JS -->
		<script src="{{ URL::to('/') }}{{ MYHOST }}/public/js/app.js"></script>
		

		<script>
			$(document).ready(function()
			{
				var date = new Date();
              	date.setDate(date.getDate() - 7);
				
				$('#dueDate').datetimepicker().on('dp.show', function () {
					return $(this).data('DateTimePicker').minDate(new Date());
				});

				$('#dueDate1').datetimepicker().on('dp.show', function () {
					return $(this).data('DateTimePicker').minDate(new Date());
				});
			});
		</script>
    </body>
</html>