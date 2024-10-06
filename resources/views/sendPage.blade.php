<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Send Test</title>
    <link rel="stylesheet" href={{asset('css/notification.css')}}>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 100vh;
            display: grid;
            gap: 15px;
            grid-template-columns: repeat(2, 1fr); /* Two columns */
        }

        #body-container {
            grid-column: span 2; /* Takes full width in a two-column layout */
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        select {
            height: 100px;
        }
        
    </style>
</head>
<body>
    <div style="display: flex;flex-direction:row">
    <form id="myForm" >
        @csrf
        <label for="list_ids">Data List</label>
        <select id='list_ids' name="list_ids[]" multiple>
            @foreach($email_list as $list)
                <option value="{{$list->id}}">{{$list->name}}</option>
            @endforeach
        </select>

        <label for="subject">Subject</label>
        <input id="subject" type='text' name="subject" placeholder="Subject">

        <label for="from_name">From</label>
        <input id='from_name' type="text" name="from_name" placeholder="From Name">

      
        <label for="sender">Sender</label>
        <select id='sender' name="sender[]" multiple>
            @foreach($emails as $email)
                <option value="{{$email->email}}">{{$email->email}}</option>
            @endforeach
        </select>

        <label for="test_after">Test after</label>
        <input id="test_after" type="number" name="test_after" placeholder="Test after">

        <label for="test_email">Test email</label>
        <input id="test_email" type="text" name="test_email" placeholder="Test email">
        
        <label for="message">Body</label>
        <textarea  class='editor' style="height: 17rem;" id="message" name="message" placeholder="Message Body"></textarea>
        <select id='send_option' name="send_option">
            <option value="drop">Drop</option>
            <option value="test">Test</option>
        </select>    
        <input id='submit' type="submit" value="Send">
    </form>

    <iframe id="iframe" style="display: block;background:white;width:100vw;"></iframe>
    </div>
    
    <script>
    // Get the textarea element
    var textarea = document.getElementById('message');

    // Get the iframe element
    var iframe = document.getElementById('iframe');

    // Add an event listener to the textarea for input changes
    textarea.addEventListener('input', function() {
        // Get the content of the textarea
        var htmlContent = textarea.value;

        // Set the content of the iframe to the textarea content
        iframe.contentDocument.body.innerHTML = htmlContent;
    });
</script>

    <script src={{asset('js/notification.js')}}></script>
    <script>
          const popup = Notification({
            position: 'top-right',
            duration: 3500
            });
        $submit = document.getElementById("submit");
        $submit.addEventListener("click", function (event) {
            event.preventDefault();
            const popup = Notification({
                        position: 'top-left',
                        duration: 3500
                        });
            submitForm(popup);
        });

        function submitForm() {
            var formData = new FormData(document.getElementById("myForm"));
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/send-test", true);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        console.log(xhr.responseText);
                        popup.success({
                        title: 'Success',   
                        message: 'Emails sent for proccessing successfully'
                        });

                        
                        
                    } else {
                        console.log(xhr.responseText);
                        popup.error({
                        title: 'Error',
                        message: 'Something went wrong'
                        });
                    }
                }
            };

            xhr.send(formData);
        }
    </script>

  


</body>
</html>
