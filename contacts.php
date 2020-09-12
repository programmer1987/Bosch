<?php

  require_once("config.php");
  include("header.php");

  try {
     $sql = "SELECT * FROM tbl_contacts WHERE 1 AND contact_id = :cid";
     $stmt = $DB->prepare($sql);
     //intval — Get the integer value of a variable, in this case the requested id
     $stmt->bindValue(":cid", intval($_GET["cid"]));
     $stmt->execute();
     $results = $stmt->fetchAll();
  } catch (Exception $ex) {
    echo $ex->getMessage();
  }
?>

  <div class="row">
    <ul class="breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li class="active"><?php echo ($_GET["m"] == "update") ? "Edit" : "Add"; ?> Contacts</li>
      </ul>
  </div>

  <div class="row">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo ($_GET["m"] == "update") ? "Edit" : "Add"; ?> New Contact</h3>
      </div>

      <div class="panel-body">
        <form class="form-horizontal" name="contact_form" id="contact_form" enctype="multipart/form-data" method="post" action="process_form.php">
          <input type="hidden" name="mode" value="<?php echo ($_GET["m"] == "update") ? "update_old" : "add_new"; ?>" >
          <input type="hidden" name="cid" value="<?php echo intval($results[0]["contact_id"]); ?>" >
          <input type="hidden" name="pagenum" value="<?php echo $_GET["pagenum"]; ?>" >
          <fieldset>
            <div class="form-group">
              <label class="col-lg-4 control-label" for="first_name"><span class="required">*</span>First Name:</label>
              <div class="col-lg-5">
                <input type="text" value="<?php echo $results[0]["first_name"] ?>" placeholder="First Name" id="first_name" class="form-control" name="first_name"><span id="first_name_err" class="error"></span>
              </div>
            </div>

            <div class="form-group">
              <label class="col-lg-4 control-label" for="last_name"><span class="required">*</span>Last Name:</label>
              <div class="col-lg-5">
                <input type="text" value="<?php echo $results[0]["last_name"] ?>" placeholder="Last Name" id="last_name" class="form-control" name="last_name"><span id="last_name_err" class="error"></span>
              </div>
            </div>

            <div class="form-group">
              <label class="col-lg-4 control-label" for="contact_no1"><span class="required">*</span>Contact No #1:</label>
              <div class="col-lg-5">
                <input type="text" value="<?php echo $results[0]["contact_no1"] ?>" placeholder="Contact Number" id="contact_no1" class="form-control" name="contact_no1"><span id="contact_no1_err" class="error"></span>
                <span class="help-block">Maximum of 10 digits only and only numbers.</span>
              </div>
            </div>

            <div class="form-group">
              <div class="col-lg-5 col-lg-offset-4">
                <button class="btn btn-primary" type="submit">Submit</button>
              </div>
            </div>
          </fieldset>
        </form>

      </div>
    </div>
  </div>

<script type="text/javascript">

$(document).ready(function() {

  // fade in and fate out
  $('.error').hover(function() {
    $(this).fadeOut(200);
  });
  //validation of the contact form
  $("#contact_form").submit(function() {
    $('.error').fadeOut(200);
    if(!validateForm()) {
            // after failed validation the focus is on the top
            $(window).scrollTop($("#contact_form").offset().top);
      return false;
    }
    return true;
    });
});

function validateForm() {
  //errCnt - to change the view to the next after edit and add
   var errCnt = 0;

   var first_name = $.trim( $("#first_name").val());
   var last_name = $.trim( $("#last_name").val());
   var contact_no1 = $.trim( $("#contact_no1").val());

   //validation rules
  if (first_name == "" ) {
    $("#first_name_err").html("Enter your first name.");
    $('#first_name_err').fadeIn("fast");
    errCnt++;
  }  else if (first_name.length <= 2 ) {
    $("#first_name_err").html("Enter atleast 3 letter.");
    $('#first_name_err').fadeIn("fast");
    errCnt++;
  }

    if (last_name == "" ) {
    $("#last_name_err").html("Enter your last name.");
    $('#last_name_err').fadeIn("fast");
    errCnt++;
  }  else if (last_name.length <= 2 ) {
    $("#last_name_err").html("Enter atleast 3 letter.");
    $('#last_name_err').fadeIn("fast");
    errCnt++;
  }

    if (contact_no1 == "" ) {
    $("#contact_no1_err").html("Enter first contact number.");
    $('#contact_no1_err').fadeIn("fast");
    errCnt++;
  }  else if (contact_no1.length <= 9 || contact_no1.length > 10 ) {
    $("#contact_no1_err").html("Enter 10 digits only.");
    $('#contact_no1_err').fadeIn("fast");
    errCnt++;
  } else if ( !$.isNumeric(contact_no1) ) {
    $("#contact_no1_err").html("Must be digits only.");
    $('#contact_no1_err').fadeIn("fast");
    errCnt++;
  }

  if(errCnt > 0) {
      return false;
  } else {
    return true;
  }
}

</script>
<?php
  include("footer.php");
?>
