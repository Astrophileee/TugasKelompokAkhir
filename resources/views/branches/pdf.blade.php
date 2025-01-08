<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>All Branches</h1>
    <table>
        <thead>
            <tr>
                <th scope="col" class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">
                    No
                </th>
                <th scope="col" class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">
                    Name
                </th>
                <th scope="col" class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">
                    Location
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($branches as $branch)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ ucwords(strtolower($branch->name)) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ ucwords(strtolower($branch->location)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
