<!-- Created on March 7th, 2019. --> 
<!--By: Tiffany C-->
<!--howTo.php: webpage that provides a step-by-step guide for user on how to use the ticketing system-->
<!DOCTYPE html>
<html lang="en">

<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Queen's Chemistry Department's Repair Ticketing System">
    <meta name="author" content="">

    <title>QU Chemistry Repair</title>

    <!--Bootstrap core CSS-->
    <link rel="stylesheet" type="text/css" href="./public/bootstrap-4.0.0-dist/css/bootstrap.min.css"> 
      
    <!--Bootstrap core JavaScript-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="./public/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
    
     <!--FontAwesome stylesheet(s)-->
    <link rel="stylesheet" href="public/font/fontawesome-5.7.1/css/all.css">
      
    <!--Open Sans font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
      
    <!--Custom stylesheet(s)-->
    <link href="public/css/style.css" rel="stylesheet">
    <link href="public/css/howTo.css" rel="stylesheet">
    
    <!--Custom javascript(s)-->
    <script src="public/js/main.js"></script>

    <!--favicon image-->
    <link rel="shortcut icon" href="public/images/favicon.ico">
  </head>

  <body>

    <!-- Loads the user's version of the header -->
    <!-- howTo page is only available on user's version -->
    <?php include("headerUser.php");?>
    
    <div class="container">
        <h2>How to Get Started...</h2>
    </div>  
      
    <!-- Boxes listing getting started steps -->
    <div class="container">
        <!-- 1st step in process of repair ticketing system -->
          <div class="row justify-content-center">
            <div class="square">
                <div class="col">
                    <h1>1</h1>                  
                    <h3 id="heading">Submit a Repair Ticket</h3>
                    <p>Fill out the required details outlined in the <a href="createTicketPage.php">Create Ticket tab</a> in regards to the machine or product that needs repair(s). </p>
                </div>
            </div>
          </div> 
        <!-- 2nd step in process of repair ticketing system -->
         <div class="row justify-content-center">
            <div class="square">
                <div class="col">
                    <h1>2</h1>
                    <h3 id="heading">Wait for Technician Email Response</h3>
                    <p>A technician will be assigned to your submitted ticket and once received, they will be contact with you via. email with a repairs estimate.</p>
                </div>
            </div>
         </div>
        <!-- 3rd step in process of repair ticketing system -->
         <div class="row justify-content-center">
            <div class="square">
                <div class="col">
                    <h1>3</h1>
                    <h3 id="heading">Confirm Repair Costs</h3>
                    <p>In order for the repairs to begin, you must confirm with the repairs estimate to be charged. Once the repairs are complete, an invoice will be charged and sent to Dept. of Chemistry's Finances.</p>
                </div>
            </div>
         </div>
        <!-- 4th step in process of repair ticketing system -->
         <div class="row justify-content-center">
            <div class="square">
                <div class="col">
                    <h1>4</h1>
                    <h3 id="heading">Wait for Completion of Repairs</h3>
                    <p>A technician will begin the requested repairs and once the fix is complete, an email will be sent indicating the completion.</p>
                </div>
            </div>
         </div>
      </div>
      
    <!-- Loads the footer -->
    <?php include("footer.php");?>    
  </body> 
    
</html>
