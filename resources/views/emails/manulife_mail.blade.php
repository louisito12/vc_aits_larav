<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Approval Cancelled Notification</title>
</head>

<body style="margin: 0; padding: 20px; background-color: #f8f9fa; font-family: Arial, sans-serif;">

    <center>
        <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f8f9fa">
            <tr>
                <td align="center">
                    <table width="600" cellpadding="0" cellspacing="0" border="0"
                        style="background-color: #ffffff; border: 2px solid #000; border-radius: 6px;">
                        <tr>
                            <td align="center" style="padding: 20px 30px; text-align: center;">
                                <h2 style="color: #000; margin-bottom: 20px;">Notification For Cancellation</h2>

                                <table width="100%" cellpadding="5" cellspacing="0" border="0"
                                    style="border-collapse: collapse;">
                                    <tr>
                                        <td align="right"
                                            style="font-weight: bold; background-color: #f1f1f1; border: 1px solid #000; width: 40%;">
                                            LOA REQUEST#</td>
                                        <td style="border: 1px solid #000;">{{ $mail_data['loa_id'] }}</td>
                                    </tr>
                                    <tr>
                                        <td align="right"
                                            style="font-weight: bold; background-color: #f1f1f1; border: 1px solid #000;">
                                            Type of Request</td>
                                        <td style="border: 1px solid #000; color: red;">{{ $mail_data['type_request'] }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right"
                                            style="font-weight: bold; background-color: #f1f1f1; border: 1px solid #000;">
                                            Requestor</td>
                                        <td style="border: 1px solid #000;">{{ $mail_data['requestor'] }}</td>
                                    </tr>
                                    <tr>
                                        <td align="right"
                                            style="font-weight: bold; background-color: #f1f1f1; border: 1px solid #000;">
                                            Status</td>
                                        <td style="border: 1px solid #000; color: red;">Cancelled</td>
                                    </tr>
                                    <tr>
                                        <td align="right"
                                            style="font-weight: bold; background-color: #f1f1f1; border: 1px solid #000;">
                                            Reason for Cancellation</td>
                                        <td style="border: 1px solid #000;">{{ $mail_data['reason_cancellation'] }}</td>
                                    </tr>
                                    <tr>
                                        <td align="right"
                                            style="font-weight: bold; background-color: #f1f1f1; border: 1px solid #000;">
                                            Cancellation Date</td>
                                        <td style="border: 1px solid #000;">{{ $mail_data['cancellation_date'] }}</td>
                                    </tr>
                                    <tr>
                                        <td align="right"
                                            style="font-weight: bold; background-color: #f1f1f1; border: 1px solid #000;">
                                            Email Receiver</td>
                                        <td style="border: 1px solid #000;">{{ $mail_data['emailer'] }}</td>
                                    </tr>
                                </table>

                                <p style="margin-top: 20px; font-size: 14px;">If you have questions, don’t hesitate to
                                    call us</p>

                                <div style="margin-top: 15px;">
                                    <img src="{{ $message->embed(public_path('aits_asset/assets/images/manulife_logs.png')) }}"
                                        alt="Company Logo" style="width: 100px; height: auto; margin-bottom: 10px;" />
                                    <p style="margin: 0; font-size: 14px;">+632 8884 7000, Toll-free: 1-800-1-888-6268
                                    </p>
                                    <p style="margin: 0; font-size: 14px;">Main office: 10th Floor NEX Tower, 6786 Ayala
                                        Avenue</p>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </center>

</body>

</html>
