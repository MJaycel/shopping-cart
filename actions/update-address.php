<?php require_once '../config.php'; ?>
<?php

use BookWorms\Model\User;
use BookWorms\Model\Role;

$email = $request->session()->get("email");
$user = User::findByEmail($email);

try {
  $countries = [
    "Germany", "France", "Italy", "United Kingdom", "Netherlands", "Sweden", "Switzerland",
    "Greece", "Poland", "Austria", "Czechia", "Denmark", "Ireland", "Norway", "Finland",
    "Luxemberg", "Belgium", "Bulgaria", "Spain", "Portugal"
  ];    

  $postcode_regex = "/\A(?:^[AC-FHKNPRTV-Y][0-9]{2})[ -]?[0-9AC-FHKNPRTV-Y]{4}\Z/";

  $rules = [
    "address_1" => "present|minlength:4|maxlength:255",
    "address_2" => "present|minlength:4|maxlength:255",
    "city" => "present|minlength:4|maxlength:255",
    "country" => "present|in:" . implode(',', $countries),
    "postcode" => "present|match:" . $postcode_regex,
    "phone" => "present|match:/\A[0-9]{2,3}[-][0-9]{5,7}\Z/"
  ];
  $request->validate($rules);
  echo $request->input('address_1');

  if (!$request->is_valid()) {
    throw new Exception("Please fill in the form correctly");
  }

  $user->address_1 = $request->input("address_1");
  $user->address_2 = $request->input("address_2");
  $user->city = $request->input("city");
  $user->country = $request->input("country");
  $user->postcode = $request->input("postcode");
  $user->phone = $request->input("phone");

  $user->saveAdd();

  $request->session()->set('address_1', $user->address_1);
  $request->session()->set('address_2', $user->address_2);
  $request->session()->set('city', $user->city);
  $request->session()->set('country', $user->country);
  $request->session()->set('postcode', $user->postcode);
  $request->session()->set('phone', $user->phone);
//   $request->session()->set('role', $role->title);
  $request->session()->forget("flash_data");
  $request->session()->forget("flash_errors");

  // $request->redirect("views/cart-checkout.php");
  // $request->redirect( 'Location:' . $_SERVER['HTTP_REFERER']);
  $referer = $_SERVER['HTTP_REFERER'];
  header("Location: $referer");

}
catch(Exception $ex) {
  $request->session()->set("flash_message", $ex->getMessage());
  $request->session()->set("flash_message_class", "alert-warning");
  $request->session()->set("flash_data", $request->all());
  $request->session()->set("flash_errors", $request->errors());

  // $request->redirect("views/cart-checkout.php");
  // $request->redirect( $_SERVER['HTTP_REFERER']);
  $referer = $_SERVER['HTTP_REFERER'];
  header("Location: $referer");

}
?>