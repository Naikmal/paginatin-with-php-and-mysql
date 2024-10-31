<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagination With PHP and MySQL</title>

  <!-- bootsratp css link -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  <?php 

  // connection to database 
  $con = mysqli_connect('localhost', 'root'); 
  if (!$con){
    die("Qury Failed".mysqli_connect_error($con));
  }else{
    mysqli_select_db($con, 'world');
  }
  ?>

  <div class='container'>

    <p class='text-center h1 mt-4'>Hello! we are Learning Pagination Wiht PHP and MYSQL</p>
    <table class='table table-bordered w-75 m-auto mt-3 table-striped'>
      <thead class='table-primary'>
        <th>No.</th>
        <th>Code</th>
        <th>Name</th>
        <th>Continent</th>
      </thead>
    
    <?php

      // pagination handling
      //find all number of records
      $allRecords = mysqli_num_rows(mysqli_query($con, 'SELECT * FROM country'));
      //Records perpage 
      $recordPerPage = 9;
      // number of pages 
      if ($allRecords > $recordPerPage) {
        $pages = ceil($allRecords / $recordPerPage);
        
      }else{
        $pages = 1;
      }
      
      //get the page which user wants
      if (isset($_GET['page'])) {
        $page = $_GET['page'];
      }else{
        $page = 1;
      }

      $start = ($page - 1) * $recordPerPage;


      $select_query = "SELECT   ROW_NUMBER() OVER (ORDER BY name ) AS seq_num, code, name, continent FROM country LIMIT $start, $recordPerPage";
      $select_query_run = mysqli_query($con, $select_query);
      $sn = 0;
      if (mysqli_num_rows($select_query_run) > 0) {
        while($row = mysqli_fetch_assoc($select_query_run)) {
          $sn = $row['seq_num'];
          $code = $row['code'];
          $name = $row['name'];
          $continent = $row['continent'];
        

        echo "<tbody><tr>";
        echo "<td>$sn</td>";
        echo "<td>$code</td>";
        echo "<td>$name</td>";
        echo "<td>$continent</td>";
        echo "</tbody></tr>";
      }
      }
    ?>
  </table>


    <ul class='pagination mt-4'>
      <?php
        if ($page >= 2){
          echo "<li class='page-item'><a class='page-link' href='pagination1.php?page=".($page - 1)."'>Prev</a></li>";
        }
        for ($i = 1;   $i <= $pages;   $i++) {
          if ($i == $page){
            echo "<li class='page-item'><a class='page-link active' href='pagination1.php?page=$i'>$i</a></li>";
          }else{
            echo "<li class='page-item'><a class='page-link' href='pagination1.php?page=$i'>$i</a></li>";
          }
          
        }

        if ($page != $pages){
          echo "<li class='page-item'><a class='page-link' href='pagination1.php?page=".($page + 1)."'>Next</a></li>";
        }

      ?>

    </ul>
  </div>

</body>
</html>