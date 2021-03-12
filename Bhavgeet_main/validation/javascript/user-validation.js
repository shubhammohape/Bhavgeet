console.log("Hello");
$(document).ready(function(){
    $("sign-up-btn").click(function(){
      alert("test");
      
      var username = document.getElementById("sign-up-username");
      var password = document.getElementById("sign-up-password");
      var repeatPassword = document.getElementById("sign-up-rp-password");
      var email = document.getElementById("sign-up-email");
      if (password == repeatPassword){
        $.post('test.php', { username: username.value, email: email.value }, function(result) { 
          if(result=="Email already exists"){
            alert("Email already exists")
          }
          else if(result=="Username already exists"){
            alert("Passwords do not match");
          }
          else if(result=="Conditions Valid"){
            alert("Sugoii");
          }
          else{
            alert("Something went wrong");
          }
      });
      }
      else{
          alert("Passwords do not match");
      }
    });
});