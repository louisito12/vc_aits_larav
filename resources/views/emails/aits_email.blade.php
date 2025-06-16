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
            <b>
                <p>Email Notification from Admin Information Tracking System</p>
            </b>
            <br>

            @if($mail_data['trans_process'] == 1)
                <table>
                    <tbody>
                        <tr>
                            <th>Request Number</th>
                            <td>{{ $mail_data['request_no'] }}</td>
                        </tr>
                        <tr>
                            <th>Requestor</th>
                            <td>{{ $mail_data['requestor'] }}</td>
                        </tr>
                        <tr>
                            <th>Room</th>
                            <td>{{ $mail_data['room_name'] }}</td>
                        </tr>
                        <tr>
                            <th>Schedule From</th>
                            <td>{{ $mail_data['schedule_from'] }}</td>
                        </tr>
                        <tr>
                            <th>Schedule To</th>
                            <td>{{ $mail_data['schedule_to'] }}</td>
                        </tr>
                        <tr>
                            <th>Request Status</th>
                            <td>{{ $mail_data['process'] }}</td>
                        </tr>
                    </tbody>
                </table>
            @endif

            @if($mail_data['trans_process'] == 2)
                <table>
                    <tbody>
                        <tr>
                            <th>Request Number</th>
                            <td>{{ $mail_data['request_number'] }}</td>
                        </tr>
                        <tr>
                            <th>Requestor</th>
                            <td>{{ $mail_data['requestor'] }}</td>
                        </tr>
                        <tr>
                            <th>Destination</th>
                            <td>{{ $mail_data['destination'] }}</td>
                        </tr>
                        <tr>
                            <th>Appointment Date</th>
                            <td>{{ $mail_data['appointment_date'] }}</td>
                        </tr>
                        <tr>
                            <th>Date Requested</th>
                            <td>{{ $mail_data['date_requested'] }}</td>
                        </tr>
                        <tr>
                            <th>Client Name</th>
                            <td>{{ $mail_data['client_name'] }}</td>
                        </tr>
                        <tr>
                            <th>Request for</th>
                            <td>{{ $mail_data['status'] }}</td>
                        </tr>
                    </tbody>
                </table>

            @endif

            @if($mail_data['trans_process'] == 3)
                <table>
                    <tbody>
                        <tr>
                            <th>Request Number</th>
                            <td>{{ $mail_data['request_number'] }}</td>
                        </tr>
                        <tr>
                            <th>Requestor</th>
                            <td>{{ $mail_data['requestor'] }}</td>
                        </tr>
                        <tr>
                            <th>Type</th>
                            <td>{{ $mail_data['type'] }}</td>
                        </tr>
                        <tr>
                            <th>Area</th>
                            <td>{{ $mail_data['area'] }}</td>
                        </tr>
                        <tr>
                            <th>Date Requested</th>
                            <td>{{ $mail_data['date_requested'] }}</td>
                        </tr>
                        <tr>
                            <th>Company Name</th>
                            <td>{{ $mail_data['company_name'] }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $mail_data['address'] }}</td>
                        </tr>

                        <tr>
                            <th>Logistic Type</th>
                            <td>{{ $mail_data['request_for'] }}</td>
                        </tr>
                        <tr>
                            <th>Request for</th>
                            <td>{{ $mail_data['process'] }}</td>
                        </tr>
                    </tbody>
                </table>

            @endif
            <br><br><br>

            <p>If you have any questions, feel free to reach out to our support team.</p>


        </div>






        <div class="email-footer">
            <p>&copy; 2025 Valucare. All rights reserved.</p>

        </div>
    </div>

</body>

</html>