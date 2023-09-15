
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>


<body>
    
                 <!-- register start -->
       
      
                 <form method="POST" action="register_action.php">

<div class="row">
 <div class="col-6">
 <input type="text" id="fname" name="fname" placeholder=" " required>
<label class="pb-3" for="fname">First Name</label>

   </div>
   <div class="col-6">
   <input type="text" id="lname" name="lname" placeholder=" " required>
<label class="pb-3" for="lname">Last Name</label>
   </div>

   </div>
   <input type="tel" id="phone" name="phone" pattern="[+]{1}[0-9]{3}[0-9]{2}[0-9]{3}[0-9]{3}" placeholder=" " required>
<label class="pb-3" for="phone">Phone Number</label>


<input type="email" id="remail" name="remail" placeholder=" " required>
<label class="pb-3" for="remail">Email</label>



<input type="password" id="rpassword" name="rpassword" placeholder=" " required>
<label class="pb-3" for="rpassword">Password</label>



<div class="text-center pt-1 mb-5 pb-1">
             <button class="btn btn-primary align-center mb-3" type="submit" style="width:50%;" value="register" name="register">Create Account</button>
              <br>
           
           </div>

   </form>

</div>
 </div>
</div>
<!-- register end -->   

</body>
</html>