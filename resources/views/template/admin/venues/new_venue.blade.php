<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
<title>Sign Up Form</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 

<style>
	body {
		color: #999;
		background: #fafafa;
		font-family: 'Roboto', sans-serif;
	}
	.form-control {
        min-height: 41px;
		box-shadow: none;
		border-color: #e6e6e6;
	}
	.form-control:focus {
		border-color: #00c1c0;
	}
    .form-control{        
        border-radius: 3px;
    }
	.signup-form {
		width: 425px;
		margin: 0 auto;
		padding: 30px 0;
	}
	.signup-form h2 {
		color: #333;
		font-weight: bold;
        margin: 0 0 25px;
    }
    .signup-form form {
    	margin-bottom: 15px;
        background: #fafafa;
		border: 1px solid #f4f4f4;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 40px 50px;
    }
	.signup-form .form-group {
		margin-bottom: 20px;
	}
	.signup-form label {
		font-weight: normal;
		font-size: 13px;
	}
	.signup-form input[type="checkbox"] {
		margin-top: 2px;
	}    
    .signup-form .btn {        
        font-size: 16px;
        font-weight: bold;
		background: #f29706;
		border: none;
		min-width: 240px;
        outline: none !important;
        color:black;
        /* text-align: center; */
        /* margin: 0 auto; */
        margin-left: 13%;
        border-radius: 9px;

    }
	.signup-form .btn:hover, .signup-form .btn:focus {
		background: #f29706;
	}
	.signup-form a {
		color: #00c1c0;
		text-decoration: none;
	}	
	.signup-form a:hover {
		text-decoration: underline;
	}
    img{
        height: 50px;
        width: 50px;
    }

	 a.btn{
		background-color: #f29706;
		border: none;
		border-radius: 9px; 
		color:black;
		font-size: 14px;
		/* font-weight: bold; */
		margin-left: 13%;
		min-width: 50px;
        float: right;
	} 
</style>

</head>
<body>
<div class="signup-form">
{{-- Message --}}
@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>Success !</strong> {{ session('success') }}
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>Error !</strong> {{ session('error') }}
    </div>
@endif
    <form action="create-venue" method="post" enctype="multipart/form-data">
    @csrf
        <div><img src="{{'/hope.jpeg'}}" alt=""><span> &nbsp;Hops</span></div><br><br>
        
		<h2>Welcome to Hops NZ</h2>
        <div class="form-group">
        	<input type="text" class="form-control" name="name" placeholder="Name" required>
        </div>
        <div class="form-group">
        	<input type="email" class="form-control" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
        	<input type="text" class="form-control" name="password" placeholder="Password" required>
        </div>
        <div class="form-group">
        	<input type="text" class="form-control" name="description" placeholder="Description" required>
        </div>
		<div class="form-group">
            <input type="text" class="form-control" name="place" placeholder="Place Name" required>
        </div>
		<div class="form-group">
            <input type="text" class="form-control" name="website" placeholder="Website" required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="phone" placeholder="phone" required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="address" placeholder="address" required>
        </div>
        <div class="form-group">
            <input type="file" class="form-control" name="fileName"  required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="lat" placeholder="Latitude" required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="lon" placeholder="Longitude" required>
        </div>
       
		
			
					

		     
			
             <div class="form-group fieldGroup">
                <div class="input-group">
                    <div class="row">
                                    <p ><strong>Timing</strong> <span> 
                                    <a href="javascript:void(0)" class="btn btn-success addMore" style="min-width: 50px; float: right;"><span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span> Add</a>

                                    </span></p> <br>
                                </div>
			             <div class="row">
				              <div class="col-xs-4">
				                    <select name="day[]" id="date" class="form-control">
                                        <option value="sunday">Sunday</option>
                                        <option value="monday">Monday</option>
                                        <option value="tuesday">Tuesday</option>
                                        <option value="wednesday">Wednesday</option>
                                        <option value="thursday">Thursday</option>
                                        <option value="friday">Friday</option>
                                        <option value="saturday">Saturday</option>
                                    </select>
				              </div>
			                	<div class="col-xs-4">
				                     <input type="time" class="form-control" placeholder="Opentime" name="otime[]">
				               </div>
				               <div class="col-xs-4">
				                 	<input type="time" class="form-control" placeholder="Closetime" name="ctime[]">
				              </div>
                              <div class="col-xs-3">
                                <!-- <div class="input-group-addon">  -->
                                <!-- </div> -->
                               </div>
			              </div><br>
		</div>
        </div>
                          <div class="form-group fieldGroupCopy" style="display: none;">
                            <div class="input-group">
                                     <div class="row">
                                          <div class="col-xs-4">
                                                <input type="text" class="form-control"  placeholder="Monday" name="monday">
                                          </div>
                                            <div class="col-xs-4">
                                                 <input type="text" class="form-control" placeholder="Opentime" name="opentime">
                                           </div>
                                           <div class="col-xs-4">
                                                 <input type="text" class="form-control" placeholder="Closetime" name="closetime">
                                          </div>
                                       
                                      </div><br>
		                    </div>
                            </div>
		<div class="form-group">
            <button type="" class="btn btn-primary btn-lg">Sign Up</button>
        </div>
	<div class="text-center">Are you are vendor? <a href="#">Contact Us</a></div>

    </form>

   
</div>
<script>
          
          $(document).ready(function(){
                    //group add limit
                    var maxGroup = 10;

                    //add more fields group
                    $(".addMore").click(function(){
                        if($('body').find('.fieldGroup').length < maxGroup){
                            var fieldHTML = '<div class="form-group fieldGroup">'+$(".fieldGroupCopy").html()+'</div>';
                            $('body').find('.fieldGroup:last').after(fieldHTML);
                        }else{
                            alert('Maximum '+maxGroup+' groups are allowed.');
                        }
                    });
                });
</script>
</body>
</html>