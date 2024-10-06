<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
      /* Custom Pagination Styles */
      .page-link {
  font-size: 14px;
}
svg.w-5.h-5 {
    width: 15px;
    height: 15px;
}


    </style>
</head>
<body>
    <div style="text-align: center;">
        <h1>drops List</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>email_list_id</th>
                    <th>total_recipients</th>
                    <th>progress</th>
                    <th>status</th>
                    <th>created at</th>
                    <th>updated at</th>
                </tr>
            </thead>
            <tbody>
                @foreach($drop_list as $drop)
                <tr>
                    <td>{{$drop->id}}</td>
                    <td>{{$drop->email_list_id}}</td>
                    <td>{{$drop->total_recipients}}</td>
                    <td>{{$drop->progress}}</td>
                    <td>{{$drop->status}}</td>
                    <td>{{$drop->created_at}}</td>
                    <td>{{$drop->updated_at}}</td>
                </tr>
                @endforeach
            </tbody>
         
                {{ $drop_list->links() }}
          

        </table>
    </div>
    
       
    </script>
</body>
</html>
