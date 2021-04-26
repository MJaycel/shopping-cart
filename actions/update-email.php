<?php require_once '../config.php'; ?>
<?php

use BookWorms\Model\User;
use BookWorms\Model\Role;

$email = $request->session()->get("email");
$user = User::findByEmail($email);

try {
  $rules = [
    "email" => "present|email|minlength:7|maxlength:64"
  ];
  $request->validate($rules);

  if (!$request->is_valid()) {
    throw new Exception("Please fill in the form correctly");
  }

  $user->email = $request->input("email");

  $user->updateEmail();

  $request->session()->set('email', $user->email);

  $request->session()->forget("flash_data");
  $request->session()->forget("flash_errors");

  $referer = $_SERVER['HTTP_REFERER'];
  header("Location: $referer");

  // $request->redirect("/views/index.php");
}
catch (Exception $ex) {
  $request->session()->set("flash_message", $ex->getMessage());
  $request->session()->set("flash_message_class", "alert-warning");
  $request->session()->set("flash_data", $request->all());
  $request->session()->set("flash_errors", $request->errors());

  $request->redirect("/views/auth/login-form.php");  
}
?>