<?php
include 'session.php';
include 'conn.php';

// Only proceed if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

  // Update status if id is set
  if (isset($_GET['id'])) {
    $que_id = $_GET['id'];
    $sql1 = "UPDATE contact_query SET query_status='1' WHERE query_id={$que_id}";
    mysqli_query($conn, $sql1);
    echo '<div class="alert alert-info alert-dismissible"><b><button type="button" class="close" data-dismiss="alert">&times;</button></b><b>Pending Request "Read".</b></div>';
  }

  $limit = 10;
  if (isset($_GET['page'])) {
    $page = $_GET['page'];
  } else {
    $page = 1;
  }
  $offset = ($page - 1) * $limit;
  $count = $offset + 1;
  $sql = "SELECT * FROM contact_query LIMIT {$offset}, {$limit}";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    #sidebar {
      position: relative;
      margin-top: -20px;
    }
    #content {
      position: relative;
      margin-left: 210px;
    }
    @media screen and (max-width: 600px) {
      #content {
        position: relative;
        margin-left: auto;
        margin-right: auto;
      }
    }
    #he {
      font-size: 14px;
      font-weight: 600;
      text-transform: uppercase;
      padding: 3px 7px;
      color: #fff;
      text-decoration: none;
      border-radius: 3px;
      text-align: center;
    }
  </style>
</head>
<body style="color:black">
  <div id="header">
    <?php include 'header.php'; ?>
  </div>
  <div id="sidebar">
    <?php $active = "query"; include 'sidebar.php'; ?>
  </div>
  <div id="content">
    <div class="content-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 lg-12 sm-12">
            <h1 class="page-title">User Query</h1>
          </div>
        </div>
        <hr>

        <div class="table-responsive">
          <table class="table table-bordered" style="text-align:center">
            <thead style="text-align:center">
              <tr>
                <th style="text-align:center">S.no</th>
                <th style="text-align:center">Name</th>
                <th style="text-align:center">Email Id</th>
                <th style="text-align:center">Mobile Number</th>
                <th style="text-align:center">Message</th>
                <th style="text-align:center">Posting Date</th>
                <th style="text-align:center">Status</th>
                <th style="text-align:center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                  <td><?php echo $count++; ?></td>
                  <td><?php echo $row['query_name']; ?></td>
                  <td><?php echo $row['query_mail']; ?></td>
                  <td><?php echo $row['query_number']; ?></td>
                  <td><?php echo $row['query_message']; ?></td>
                  <td><?php echo $row['query_date']; ?></td>
                  <td>
                    <?php if ($row['query_status'] == 1) { ?>
                      Read<br>
                    <?php } else { ?>
                      <a href="query.php?id=<?php echo $row['query_id']; ?>"><b>Pending</b></a><br>
                    <?php } ?>
                  </td>
                  <td id="he" style="width:100px">
                    <a style="background-color:aqua" href='delete_query.php?id=<?php echo $row['query_id']; ?>'> Delete </a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        
        <!-- Displaying form data from database -->
        <div class="container">
          <h2>Query Form Data</h2>
          <table class="table">
            <thead>
              <tr>
                <th>Query ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile Number</th>
                <th>Message</th>
                <th>Posting Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT * FROM contact_query";
              $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td>" . $row['query_id'] . "</td>";
                  echo "<td>" . $row['query_name'] . "</td>";
                  echo "<td>" . $row['query_mail'] . "</td>";
                  echo "<td>" . $row['query_number'] . "</td>";
                  echo "<td>" . $row['query_message'] . "</td>";
                  echo "<td>" . $row['query_date'] . "</td>";
                  echo "<td>" . ($row['query_status'] == 1 ||2 || 3 ? 'Read' : 'Pending') . "</td>";
                  echo "</tr>";
                }
              } else {
                echo "<tr><td colspan='7'>No query data found.</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>

        <div class="table-responsive" style="text-align:center;">
          <?php
          $sql1 = "SELECT * FROM contact_query";
          $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");
          if (mysqli_num_rows($result1) > 0) {
            $total_records = mysqli_num_rows($result1);
            $total_page = ceil($total_records / $limit);
            echo '<ul class="pagination admin-pagination">';
           
            if ($page > 1) {
              echo '<li><a href="query.php?page=' . ($page - 1) . '">Prev</a></li>';
            }
            for ($i = 1; $i <= $total_page; $i++) {
              $active = $i == $page ? "active" : "";
              echo '<li class="' . $active . '"><a href="query.php?page=' . $i . '">' . $i . '</a></li>';
            }
            if ($total_page > $page) {
              echo '<li><a href="query.php?page=' . ($page + 1) . '">Next</a></li>';
            }
            echo '</ul>';
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

<?php
  } else {
    echo '<div class="alert alert-danger"><b> Please Login First To Access Admin Portal.</b></div>';
?>
  <form method="post" action="login.php" class="form-horizontal">
    <div class="form-group">
      <div class="col-sm-8 col-sm-offset-4" style="float:left">
        <button class="btn btn-primary" name="submit" type="submit">Go to Login Page</button>
      </div>
    </div>
  </form>
<?php
  }
} else {
  echo '<div class="alert alert-danger"><b> Please Login First To Access Admin Portal.</b></div>';
?>
  <form method="post" action="login.php" class="form-horizontal">
    <div class="form-group">
      <div class="col-sm-8 col-sm-offset-4" style="float:left">
        <button class="btn btn-primary" name="submit" type="submit">Go to Login Page</button>
      </div>
    </div>
  </form>
<?php
}
?>
