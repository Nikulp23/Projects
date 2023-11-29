function validate(formObj) {
  
    if (formObj.username.value == "") {
      alert("Please enter the username");
      formObj.username.focus();
      return false;
    }
    
    if (formObj.password.value == "") {
      alert("Please enter a password");
      formObj.password.focus();
      return false;
    }
      
    return true;
  }
  
  $(document).ready(function() {
    
});