<!-- 
1. Form to Post Data 
2. Session to hold Data
3. Function to load data from Chat.php
4. Chat.php to encode php array to js values then post to present on the website 
 -->

  <!-- Model -->
<?php 
session_start();
if( isset ($_POST['reset'])){
    $_SESSION['chats'] = array();
    header('location: index.php');
    return;
}

if(isset($_POST['message'])){
   if( !isset ($_SESSION['chats']) ) $_SESSION['chats'] = array();
//   We want to put the message and time in the array 
// return to the page to render it in view 
    $_SESSION['chats'] []= array($_POST['message'], date(DATE_RFC822));
    header('location: index.php');
    return;
}




?>


<!-- 
    View 
---->



<!-- Form
1. Chat Button 
2. Reset Button 
3. Chat.php Button 
 -->

 <html>
 <head> 
     
    <script src = "jquery.min.js"></script>
    <link href= "style.css" rel="stylesheet"></link>
</head>  
 <!-- ^ We want to generate our own HTML from Server hence in Head (HTML Parses and pauses here to download script) -->

<body>
    <h1 id = "Head" > Chat </h1>
    <form method = "POST"action="index.php" id="form">
        <input id="message" type="text" name="message" size="60" >
        <input id="chat" type="submit" value = "Chat">
        <input id="reset" type="submit" value="Reset" name = "reset">
        <a href="chat.php" id = "chatlist"> ChatList</a>
    </form>

    <div id ="chatcontent">
        <img  src="spinner.gif" alt="Loading...">
    </div>

     <!-- Render our chat.php array 
        1. Function ajax that takes url (recieve the string json obj), and puts into function that would
            desterlize it (Make into jsscript) and parse thru it- -->

            <script>
             function updateMag(){  
                window.console && console.log("Requesting JSON ")
               $.ajax({
                    url: "chat.php",
                    cache: false,
                    success: function(data){
                        window.console && console.log("JSON recieved");
                        window.console && console.log(data);
                        $("#chatcontent").empty();
                        for(i=0; i < data.length; i++){
                            entry = data[i];
                            window.console && console.log(entry);
                            $('#chatcontent').append('<p>'+entry[0]+'<br/>&nbsp;&nbsp;'+entry[1]+"</p>\n");                    
                          }
                    setTimeout('updateMag()', 4000)

                    } 

                })
             }
             
             window.console && console.log("Startup Complete");
             updateMag();
            </script>

</body>
 </html>


