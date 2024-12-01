<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Sign In</title>
  <style>
    @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }
    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #ffffff;
    }
    .wrapper {
      position: relative;
      max-width: 430px;
      width: 100%;
      background: rgb(131, 108, 163);
      padding: 34px;
      border-radius: 6px;
      box-shadow: 0 5px 10px rgba(0,0,0,0.2);
    }
    .wrapper h2 {
      position: relative;
      font-size: 22px;
      font-weight: 600;
      color: #333;
    }
    .wrapper h2::before {
      content: '';
      position: absolute;
      left: 0;
      bottom: 0;
      height: 3px;
      width: 78px;
      border-radius: 12px;
      background: #4070f4;
    }
    .wrapper form {
      margin-top: 30px;
    }
    .wrapper form .input-box {
      height: 52px;
      margin: 18px 0;
    }
    form .input-box input, form .input-box select {
      height: 100%;
      width: 100%;
      outline: none;
      padding: 0 15px;
      font-size: 17px;
      font-weight: 400;
      color: #333;
      border: 1.5px solid #C7BEBE;
      border-bottom-width: 2.5px;
      border-radius: 6px;
      transition: all 0.3s ease;
    }
    .input-box input:focus, .input-box input:valid,
    .input-box select:focus, .input-box select:valid {
      border-color: #4070f4;
    }
    .input-box.button input {
      color: #fff;
      letter-spacing: 1px;
      border: none;
      background: #4070f4;
      cursor: pointer;
    }
    .input-box.button input:hover {
      background: #0e4bf1;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <h2>Sign In</h2>
    <form action="config-php-files/verification-signIn.php" method="POST">
      <div class="input-box">
        <select name="userType" required>
          <option value="" disabled selected>Select User Type</option>
          <option value="farmer">Farmers</option>
          <option value="qcOfficer">QC Officer</option>
          <option value="customer">Customer</option>
          <option value="packagingStaff">Packaging Staff</option>
          <option value="driver">Driver</option>
          <option value="admin">Admin</option>
        </select>
      </div>
      <div class="input-box">
        <input type="text" name="id" placeholder="ID" required>
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Password" required>
      </div>
      <div class="input-box button">
        <input type="submit" value="Sign In">
      </div>
    </form>
  </div>
</body>
</html>
