<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Welcome to {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        @media screen {
            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 400;
                src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format('woff');
            }

            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 700;
                src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format('woff');
            }
        }

        body,
        table,
        td,
        a {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-rspace: 0pt;
            mso-table-lspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        a[x-apple-data-detectors] {
            font-family: inherit !important;
            font-size: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            color: inherit !important;
            text-decoration: none !important;
        }

        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }

        body {
            width: 100% !important;
            height: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        table {
            border-collapse: collapse !important;
        }

        a {
            color: black;
        }

        img {
            height: auto;
            line-height: 100%;
            text-decoration: none;
            border: 0;
            outline: none;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .email-content {
            padding: 24px;
            font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif;
            font-size: 16px;
            line-height: 24px;
            background-color: #ffffff;
        }

        .email-header {
            font-size: 32px;
            font-weight: 400;
            line-height: 48px;
            margin: 0 0 12px;
        }

        .email-footer {
            padding: 24px;
            border-bottom: 3px solid #d4dadf;
            font-size: 16px;
            line-height: 24px;
        }

        .email-button {
            display: inline-block;
            padding: 16px 36px;
            font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif;
            font-size: 16px;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            background-color: #1a82e2;
        }

        .email-footer-text {
            font-size: 14px;
            line-height: 20px;
            color: #666;
        }
    </style>
</head>

<body style="background-color: #e9ecef;">

    <div class="preheader"
        style="display: none; max-width: 0; max-height: 0; overflow: hidden; font-size: 1px; line-height: 1px; color: #fff; opacity: 0;">
        Welcome to {{ config('app.name') }}
    </div>

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" bgcolor="#e9ecef">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="email-container">
                    <tr>
                        <td bgcolor="#ffffff" align="left" class="email-content">
                            <h1 class="email-header">Welcome, {{ $username }}</h1>
                            <p>Thank you for registering with our application. Your email is {{ $email }}.</p>
                        </td>
                    </tr>

                    <tr>
                        <td align="left" bgcolor="#ffffff">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" bgcolor="#ffffff" style="padding: 12px;">
                                        <a href="{{ route('index') }}" target="_blank" class="email-button">Go to
                                            Homepage</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td align="left" bgcolor="#ffffff" class="email-footer">
                            <p style="margin: 0;">Thanks,<br>{{ config('app.name') }}</p>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" bgcolor="#e9ecef" style="padding: 24px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                class="email-container">
                                <tr>
                                    <td align="center" bgcolor="#e9ecef" class="email-footer-text">
                                        <p style="margin: 0;">You received this email because you registered at
                                            {{ config('app.name') }}. If you didn't, please let us know at
                                            {{ config('mail.from.address') }}.</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
