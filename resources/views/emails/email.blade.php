<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Notification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
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
        }

        .email-body {
            font-size: 16px;
            color: #495057;
            line-height: 1.5;
        }

        .email-footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #868e96;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
</head>

<body>

    <div class="email-container">
        <div class="email-header">
            <img src="http://vc_aits.valucarehealth.local/img/vcnew.png" alt="Company Logo">
                <br><br>
            <h1>Notification</h1>
        </div>
    
        <div class="email-body">
            <p>Hello [User],</p>
            <p>We wanted to inform you about an important update regarding your account.</p>

            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td><strong>Request No</strong></td>
                        <td>123</td>
                    </tr>
                    <tr>
                        <td><strong>Date Created</strong></td>
                        <td>05/24/2025</td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>Pending</td>
                    </tr>
                    <tr>
                        <td><strong>Priority</strong></td>
                        <td>High</td>
                    </tr>
                </tbody>
            </table>

            <p>If you have any questions, feel free to reach out to our support team.</p>
            <a href="#" class="btn btn-primary">View Details</a>
        </div>
        <div class="email-footer">
            <p>&copy; 2025 Your Company. All rights reserved.</p>
        </div>
    </div>

</body>

</html>