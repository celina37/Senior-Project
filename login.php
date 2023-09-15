
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>


<body>
    
     <!-- Login start -->
   

     <form  method="POST" action="login_action.php">
   
<input type="email" id="email" name="email" placeholder=" "  required>
<label class="pb-3" for="email">Email</label>



<input type="password" id="password" name="password" placeholder=" " required>
<label class="pb-3" for="password">Password</label>


            <div class="text-center pt-1 mb-5 pb-1">
            <button class="btn btn-primary align-center mb-3" type="submit" style="width:50%;"  value="login" name="login">Log in</button>
               <br>
              <a class="text-info mt-3" href="forget-password.php">Forgot password?</a>
            </div>
            </div>
        </div>
</div>
          </form>


     <!-- login end -->

</body>
</html>