<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Check Duplicate Emails</title>
	<meta name="author" content="James Boullion">

	<link 
		rel="stylesheet" 
		href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
		integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" 
		crossorigin="anonymous">

	<script src="https://kit.fontawesome.com/247f876d94.js" crossorigin="anonymous"></script>

	<style>
		.form-control {
			height: auto;
		}
		.entry{
			margin-top: 10px;
		}

		#check-emails {
			margin: 20px 0;
		}
		
	</style>
</head>
<body>
	<div class="container">
		<h3 class="control-label" for="ourField">Add Emails to check</h3>
		<form id="email-form" role="form" method="post" target="_blank" action="unique-emails.php">
			<div id="email-list" class="form-row">
				<div class="entry input-group col-12">
					<input class="form-control" name="emails[]" type="email" placeholder="Email Address" />
					<span class="input-group-btn">
						<button type="button" class="btn btn-success btn-lg btn-add">
							<i class="fas fa-plus"></i>
						</button>
					</span>
				</div>
			</div>
			<button type="submit" class="btn btn-primary" id="check-emails">Check</button>
		</form>
		<div id="alert-target"></div>
	</div>

	<script
		src="https://code.jquery.com/jquery-3.4.1.min.js"
		integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
		crossorigin="anonymous"></script>
	<script>
		$(function(){
			// Control the add / removal of emails
			$(document).on('click', '.btn-add', function(e) {
				e.preventDefault();
				var controlForm = $('#email-list:first'),
					currentEntry = $(this).parents('.entry:first'),
					newEntry = $(currentEntry.clone()).appendTo(controlForm);

				newEntry.find('input').val('');

				controlForm.find('.entry:not(:last) .btn-add')
					.removeClass('btn-add').addClass('btn-remove')
					.removeClass('btn-success').addClass('btn-danger')
					.html('<i class="fas fa-minus"></i>');
			}).on('click', '.btn-remove', function(e) {
				e.preventDefault();
				$(this).parents('.entry:first').remove();
				return false;
			});

			// Handle the submissions
			
			$('#email-form').submit(function(e){
				e.preventDefault();
				
				$.post('unique-emails.php', $(this).serializeObject(), function(results){
					//console.log(results);

					if(results){
						if(results.success){
							$('#alert-target').html('<div class="alert alert-success" role="alert">We found "'+results.unique_count+'" Unique Emails!</div>');
						}else{
							$('#alert-target').html('<div class="alert alert-danger" role="alert">An error occured! Sorry!</div>');
						}
					}
				});

				return false;
			});

			/**
			* Take a form and convert it into a Object for easy manipulation
			* 
			* @link https://stackoverflow.com/a/23315254
			* @link http://jsfiddle.net/akhildave/sxGtM/5002/
			*/
			$.fn.serializeObject = function() {
				var o = {};
				var a = this.serializeArray();
				$.each(a, function() {
					if (o[this.name] !== undefined) {
						if (!o[this.name].push) {
							o[this.name] = [o[this.name]];
						}
						o[this.name].push(this.value || '');
					} else {
						o[this.name] = this.value || '';
					}
				});
				return o;
			};
		});
	</script>
</body>
</html>