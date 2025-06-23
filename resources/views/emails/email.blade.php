<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Notification</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
        }

        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .email-header img {
            width: 150px;
            height: auto;
        }

        .email-header h1 {
            color: #343a40;
            font-size: 24px;
            margin-top: 10px;
        }

        .email-body {
            font-size: 16px;
            color: #495057;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .email-footer {
            text-align: center;
            font-size: 14px;
            color: #868e96;
            border-top: 1px solid #e9ecef;
            padding-top: 20px;
            margin-top: 20px;
        }

        .email-footer a {
            color: #007bff;
            text-decoration: none;
        }

        .email-footer a:hover {
            text-decoration: underline;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 10px;
            border: 1px solid #dee2e6;
            text-align: left;
        }

        table th {
            background-color: #f8f9fa;
            color: #495057;
        }

        table td {
            background-color: #ffffff;
            color: #495057;
        }

        .btn-primary {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="email-container">

        <div class="email-body">
            <p>Good day!</p>
            <p>We wanted to inform you that there will be a Preventive Maintenance.</p>

            <table>
                <tbody>
                    <tr>
                        <th>PMS</th>
                        <td>{{ $mail_data['pms_name'] }}</td>
                    </tr>
                    <tr>
                        <th>Date Started</th>
                        <td>{{ $mail_data['date_start'] }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $mail_data['pms_description'] }}</td>
                    </tr>
                    <tr>
                        <th>PMS Schedule</th>
                        <td>{{ $mail_data['schedule'] }}</td>
                    </tr>
                </tbody>
            </table>

            <p>If you have any questions, feel free to reach out to our support team.</p>

        </div>

        <div class="email-footer">
            <p>&copy; 2025 Valucare All rights reserved.</p>
        
        </div>
    </div>

</body>

</html>