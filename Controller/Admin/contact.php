<?php 
   $act = 'contact';
   if(isset($_GET['act'])) {
      $act = $_GET['act'];
   }

   switch($act) {
      case 'contact':
         include_once './View/Admin/Contact.php';
         break;
      case 'read_contact':
         include_once ('../../Model/DBConfig.php');
         include_once ('../../Model/API.php');
         include_once ('../../Model/contact.php');
         $connect = new connect();
         $API = new API();
         $contact = new contact();
         $contact_id = $_POST['contact_id'];
         $result = $contact->update_status($contact_id);
         echo json_encode($result);
         break;
   }