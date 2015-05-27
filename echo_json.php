<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>JSON TEST</title>
</head>
<body>
            <style type="text/css">
        

            #msg {
            width: 500px; 
            margin: 0px auto; 
            }
            .classifieds {
            width: 500px ; 
            background: rgba(225,225,220,.3);
            padding:20px;
            }
        </style>
 
        <div id="msg"> </div>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js">
        </script>
        <script type="text/javascript">

            $(document).ready(function(){
                var url="http://isobellennox.com/MILK/insert_json.php";
                $.getJSON(url,function(json){
                    // loop through the classifieds here
                    $.each(json.classifieds,function(i,dat){
                        $("#msg").append(
                            '<div class="classifieds">'+
//                            '<h1> <a href="http://columbian.com/Classifieds/classifieds/view/'+dat.id+'">View This Post</a></h1>'+
                            '<h1> <a href="http://dev.classifieds.columbian.com/Classifieds/classifieds/view/'+dat.id+'">View This Post</a></h1>'+ 
                            '<p>Name : <strong>'+dat.name+'</strong></p>'+
//                             '<p>Posted : <em>'+dat.start+'</em></p>'+
//                             '<p>Updated : <em>'+dat.updated+'</em></p>'+
//                             '<p>Ends : <em>'+dat.end+'</em></p>'+
                            '<hr>'+
                            '</div>'
                        );
                    });
                });
            });

        </script>
</body>
</html>