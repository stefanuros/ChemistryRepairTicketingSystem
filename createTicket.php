<!--By: Meryl Gamboa-->
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
        <script src="public/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>

        <!--FontAwesome stylesheet(s)-->
        <link rel="stylesheet" href="public/font/fontawesome-5.7.1/css/all.css">

        <!--Custom stylesheet(s)-->
        <link href="public/css/style.css" rel="stylesheet">
        <link href="public/css/login.css" rel="stylesheet">

        <!--Custom javascript-->
        <script src="public/js/main.js"></script>

        <!--favicon image-->
        <link rel="shortcut icon" href="public/images/favicon.ico">
    </head>
  
    <body>


        <div class="containter m-5">
            <h3>Create Ticket </h3>
            <form class="create-ticket-form">
                <!--Row 1-->
                <div class="form-row w-50">
                    <div class="form-group col-md-6">
                        <label for="inputMachineName">Machine Name</label>
                        <input type="text" class="form-control" maxlength="256" id="inputMachineName" name="machine_name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputRoom">Room</label>
                        <input type="text" class="form-control" maxlength="256" id="inputRoom" name="room">
                    </div>
                </div>
                <!--Row 2-->
                <!--Row 3-->
                <div class="form-group w-50">
                    <label for="inputComments">Comments</label>
                    <textarea class="form-control" id="inputComments" name="comments" rows="5"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Ticket</button>
            </form>
	   </div>
        
        <!--Bootstrap core JavaScript--> 
        <!-- <script src="./public/css/bootstrap-4.0.0-dist/js/"></script> -->
    </body>
</html>
