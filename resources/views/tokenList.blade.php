<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href={{asset('css/notification.css')}}>
    <title>Send Test</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            color: #202124;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            white-space: nowrap; /* Prevent text from wrapping */
            overflow: hidden;
            text-overflow: ellipsis; /* Display ellipsis (...) for overflowed text */
        }

        th {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <div style="text-align: center;">
        <h1>Token List</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Alias</th>
                    <th>Token</th>
                    <th>created at</th>
                    <th>updated at</th>
                </tr>
            </thead>
            <tbody>
                @foreach($email_token as $token)
                <tr>
                    <td>{{$token->id}}</td>
                    <td class="email">{{$token->email}}</td>
                    <td><input type="text" name="alias" value="{{$token->alias}}" id=""></td>
                    <td>{{Str::limit($token->token,50)}}</td>
                    <td>{{$token->created_at}}</td>
                    <td>{{$token->updated_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src={{asset('js/notification.js')}}></script>
<script>
     const popup = Notification({
            position: 'top-right',
            duration: 3500
            });
    // add alias to email ajax if the user click enter
    document.querySelectorAll('input[name="alias"]').forEach(item => {
        item.addEventListener('keyup', event => { 
            if (event.keyCode === 13) {
                let email = item.parentElement.previousElementSibling.innerText;
                let alias = item.value;
                let _token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                fetch('/add-alias', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': _token
                    },
                    body: JSON.stringify({
                        email: email,
                        alias: alias
                    })
                }).then(response => {
                    popup.success({
                        title: 'Success',   
                        message: 'data changed successfully.'
                        });

                }).then(data => {
                    console.log(data);
                });
            }
        })
    });
    

</script>

</body>
</html>
