<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNIC Verification</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
<?php
$active="home";
include('head.php'); ?>

    <div class="container">
        <h2 class="mt-5 mb-4">CNIC Verification</h2>
        <form id="cnicVerificationForm">
            <div class="form-group">
                <label for="cnic">Enter Your CNIC:</label>
                <input type="text" class="form-control" id="cnic" name="cnic" pattern="[0-9]{5}-[0-9]{7}-[0-9]{1}" required>
                <small class="form-text text-muted">Format: 12345-1234567-1</small>
            </div>
            <button type="submit" class="btn btn-primary">Verify</button>
        </form>
        <div id="verificationResult" class="mt-4"></div>
    </div>
    <?php include('footer.php');?>
    <script>
        $(document).ready(function () {
            $("#cnicVerificationForm").submit(function (event) {
                event.preventDefault();
                var cnic = $("#cnic").val();
                // Simulate loading for 2 seconds
                $("#verificationResult").html('<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>');
                setTimeout(function () {
                    $("#verificationResult").html('<div class="alert alert-success">Your CNIC ' + cnic + ' has been verified.</div>');
                }, 2000);
            });
        });
    </script>

</body>

</html>
