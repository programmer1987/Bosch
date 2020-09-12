<?php
  require("config.php");

  $mode = $_REQUEST["mode"];
  if ($mode == "add_new" ) {

    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $contact_no1 = trim($_POST['contact_no1']);
    $error = FALSE;

  if (!$error) {
    $sql = "INSERT INTO `tbl_contacts` (`first_name`, `last_name`, `contact_no1`) VALUES "
            . "( :fname, :lname, :contact1)";
    try {
      $stmt = $DB->prepare($sql);
      // bind the values
      $stmt->bindValue(":fname", $first_name);
      $stmt->bindValue(":lname", $last_name);
      $stmt->bindValue(":contact1", $contact_no1);

      // execute Query
      $stmt->execute();
      $result = $stmt->rowCount();
      if ($result > 0) {
        $_SESSION["errorType"] = "success";
        $_SESSION["errorMsg"] = "Contact added successfully.";
      } else {
        $_SESSION["errorType"] = "danger";
        $_SESSION["errorMsg"] = "Failed to add contact.";
      }
    } catch (Exception $ex) {

      $_SESSION["errorType"] = "danger";
      $_SESSION["errorMsg"] = $ex->getMessage();
    }
  } else {
    $_SESSION["errorType"] = "danger";
    $_SESSION["errorMsg"] = "failed to upload image.";
  }
  header("location:index.php");
} elseif ( $mode == "update_old" ) {

    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $contact_no1 = trim($_POST['contact_no1']);
    $cid = trim($_POST['cid']);
    $error = FALSE;

  if (!$error) {
    $sql = "UPDATE `tbl_contacts` SET `first_name` = :fname, `last_name` = :lname, `contact_no1` = :contact1 "
              . "WHERE contact_id = :cid ";
    try {
      $stmt = $DB->prepare($sql);

      // bind the values
      $stmt->bindValue(":fname", $first_name);
      $stmt->bindValue(":lname", $last_name);
      $stmt->bindValue(":contact1", $contact_no1);
      $stmt->bindValue(":cid", $cid);

      // execute Query
      $stmt->execute();
      $result = $stmt->rowCount();
      if ($result > 0) {
        $_SESSION["errorType"] = "success";
        $_SESSION["errorMsg"] = "Contact updated successfully.";
      } else {
        $_SESSION["errorType"] = "info";
        $_SESSION["errorMsg"] = "No changes made to contact.";
      }
    } catch (Exception $ex) {
      $_SESSION["errorType"] = "danger";
      $_SESSION["errorMsg"] = $ex->getMessage();
    }
  }
  //comment page number possible error
  header("location:index.php?pagenum=".$_POST['pagenum']);
} elseif ( $mode == "delete" ) {
   $cid = intval($_GET['cid']);
   $sql = "DELETE FROM `tbl_contacts` WHERE contact_id = :cid";

   try {
      $stmt = $DB->prepare($sql);
      $stmt->bindValue(":cid", $cid);
      $stmt->execute();
      $res = $stmt->rowCount();

      if ($res > 0) {
        $_SESSION["errorType"] = "success";
        $_SESSION["errorMsg"] = "Contact deleted successfully.";
      } else {
        $_SESSION["errorType"] = "info";
        $_SESSION["errorMsg"] = "Failed to delete contact.";
      }

   } catch (Exception $ex) {
      $_SESSION["errorType"] = "danger";
      $_SESSION["errorMsg"] = $ex->getMessage();
   }
   header("location:index.php?pagenum=".$_GET['pagenum']);
}
?>
