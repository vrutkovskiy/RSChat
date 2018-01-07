var data = {};
$(document).ready(function() {
  $('#RegisterForm').on('submit', function() {
      resetErrors();
      var url = 'register.php';
      var data = $('#RegisterForm').serialize();
      $.ajax({
          dataType: 'json',
          type: 'POST',
          url: url,
          data: data,
          success: function(resp) {
              if (resp.status == 'Insert succesful') {
				  var msg = '<label style="margin-left: 5px;color:Green" id="RegSuccess">Please confirm your registration through email.</label>';
				  if (resp.ConfirmSuccess){
					  var msg = '<label style="margin-left: 5px;color:Green" id="RegSuccess">Registration successful!</label>';
				  }
                  $('#registerbtn').after(msg);
				  $('#RegisterForm input').each(function(){
					  $( this ).val('');
				  });				  
			  }	  
			  else {
                  $.each(resp, function(i, v) {
					  console.log(i + " => " + v); 
                      var msg = '<label class="error" for="'+i+'">'+v+'</label>';
                      $('label[name="' + i + '"], select[name="' + i + '"]').after(msg);
                      $('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError');
                  });
                  var keys = Object.keys(resp);
                  $('input[name="'+keys[0]+'"]').focus();
              }
              return false;
          },
          error: function() {
              console.log('there was a problem checking the fields');
          }
      });
      return false;
  });

  $('#LoginForm').on('submit', function() {
      resetErrors();
      var url = 'login.php';
      var data = $('#LoginForm').serialize();
      $.ajax({
          dataType: 'json',
          type: 'POST',
          url: url,
          data: data,
          success: function(resp) {
              if (resp.LoginSuccess == 'Successful') {      
                  $("#div1").hide("slow", function(){						  
					$("#div2").show("slow");
				  }); 				      
                  $('#UserLogged').text(resp.UserName); 
				  $('#LoginForm input').each(function(){
					  $( this ).val('');
				  });	
              }
              else{
                 $.each(resp, function(i, v) {
                    var msg = '<label class="error" for="'+i+'">'+v+'</label>';
                    $('label[name="' + i + '"], select[name="' + i + '"]').after(msg);
                    $('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError');
                 });
              }
              return false;
          },
          error: function() {
              console.log('there was a problem checking the fields');
          }
      });
      return false;
  });

   $('#Logoutbtn').on('click', function() {     
      var url = 'logout.php';     
      $.ajax({
          dataType: 'json',
          type: 'POST',
          url: url,
          success: function(resp) {
              if (resp.logout == 'Logout') {      
                $("#div2").hide("slow", function(){             
                  $("#div1").show("slow");
                });  
				$('#UserLogged').remove();
				$('#toPost').val('');
              }
              return false;
          },
          error: function() {
              
          }
      });
      return false;
  });

  $('#PostForm').on('submit', function() {      
      var url = 'post.php';
	  var data = $('#PostForm').serialize();	  
      
      $.ajax({
          dataType: 'json',
          type: 'POST',
          url: url,
          data: data,
          success: function(resp) {
              console.log('ok');
              return false;
          },
          error: function() {
              console.log('there was a problem checking the fields');
          }
      });
      return false;
  });

});
function resetErrors() {
    $('form input').removeClass('inputTxtError');
    $('label.error').remove();
    $('#RegSuccess').remove();
};