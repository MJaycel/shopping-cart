<?php require_once '../config.php'; ?>
<?php

use BookWorms\Model\User;
use BookWorms\Model\Role;

try {
  $countries = [
    "Germany", "France", "Italy", "United Kingdom", "Netherlands", "Sweden", "Switzerland",
    "Greece", "Poland", "Austria", "Czechia", "Denmark", "Ireland", "Norway", "Finland",
    "Luxemberg", "Belgium", "Bulgaria", "Spain", "Portugal"
  ];    

  $postcode_regex = "/\A(?:^[AC-FHKNPRTV-Y][0-9]{2})[ -]?[0-9AC-FHKNPRTV-Y]{4}\Z/";

  $rules = [
    "email" => "present|email|minlength:7|maxlength:64",
    "password" => "present|minlength:8|maxlength:64",
    "name" => "present|minlength:4|maxlength:64",
    "address_1" => "present|minlength:4|maxlength:255",
    "address_2" => "present|minlength:4|maxlength:255",
    "city" => "present|minlength:4|maxlength:255",
    "country" => "present|in:" . implode(',', $countries),
    "postcode" => "present|match:" . $postcode_regex,
    "phone" => "present|match:/\A[0-9]{2,3}[-][0-9]{5,7}\Z/"
  ];
  $request->validate($rules);

  if (!$request->is_valid()) {
    throw new Exception("Please fill in the form correctly");
  }
  $email = $request->input("email");
  $password = $request->input("password");
  $name = $request->input("name");
  $address_1 = $request->input("address_1");
  $address_2 = $request->input("address_2");
  $city = $request->input("city");
  $country = $request->input("country");
  $postcode = $request->input("postcode");
  $phone = $request->input("phone");

  $user = User::findByEmail($email);
  if ($user !== null) {
    throw new Exception("Email address is already registered");
  }
  $role = Role::findByTitle("customer");
  $user = new User();
  $user->email = $email;
  $user->password = password_hash($password, PASSWORD_DEFAULT);
  $user->name = $name;
  $user->address_1 = $address_1;
  $user->address_2 = $address_2;
  $user->city = $city;
  $user->country = $country;
  $user->postcode = $postcode;
  $user->phone = $phone;

  $user->role_id = $role->id;

  $user->save();

  $request->session()->set('email', $user->email);
  $request->session()->set('name', $user->name);
  $request->session()->set('address_1', $user->address_1);
  $request->session()->set('address_2', $user->address_2);
  $request->session()->set('city', $user->city);
  $request->session()->set('country', $user->country);
  $request->session()->set('postcode', $user->postcode);
  $request->session()->set('phone', $user->phone);
  $request->session()->set('role', $role->title);
  $request->session()->forget("flash_data");
  $request->session()->forget("flash_errors");

  $request->redirect("/views"."/".$role->title."/home.php");  

}
catch(Exception $ex) {
  $request->session()->set("flash_message", $ex->getMessage());
  $request->session()->set("flash_message_class", "alert-warning");
  $request->session()->set("flash_data", $request->all());
  $request->session()->set("flash_errors", $request->errors());

  $request->redirect("views/auth/register-form.php");
}
?>