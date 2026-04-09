<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reset Password - ResuMate</title>
    
    <style>
        body, table, td, a { 
            -webkit-text-size-adjust: 100%; 
            -ms-text-size-adjust: 100%; 
        }
        table, td { 
            mso-table-lspace: 0pt; 
            mso-table-rspace: 0pt; 
        }
        img { 
            -ms-interpolation-mode: bicubic; 
            border: 0; 
            height: auto; 
            line-height: 100%; 
            outline: none; 
            text-decoration: none; 
        }
        
        body { 
            margin: 0 !important; 
            padding: 0 !important; 
            width: 100% !important; 
            height: 100% !important;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        @media screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                margin: auto !important;
            }
            .fluid {
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }
            .stack-column {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }
            .mobile-padding {
                padding: 20px !important;
            }
        }
    </style>
</head>

<body style="margin: 0; padding: 0; background-color: #f7f7f7;">
    <!-- Preview Text -->
    <div style="display: none; max-height: 0px; overflow: hidden;">
        Kami menerima permintaan reset password untuk akun ResuMate Anda.
    </div>

    <!-- Email Container -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 0; padding: 0; background-color: #f7f7f7;">
        <tr>
            <td style="padding: 40px 20px;">
                
                <!-- Main Email Container -->
                <table role="presentation" class="email-container" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%); padding: 40px 40px 30px; text-align: center;">
                            <!-- Logo -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center">
                                <tr>
                                    <td style="background-color: #ffffff; width: 70px; height: 70px; border-radius: 16px; text-align: center; vertical-align: middle; box-shadow: 0 6px 20px rgba(0,0,0,0.15);">
                                        <div style="font-size: 36px; color: #4CAF50; line-height: 70px;">📄</div>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Header Title -->
                            <h1 style="margin: 25px 0 0; padding: 0; color: #ffffff; font-size: 28px; font-weight: 700; line-height: 1.3;">
                                Reset Password Anda
                            </h1>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td class="mobile-padding" style="padding: 40px 40px 30px;">
                            
                            <!-- Greeting -->
                            <p style="margin: 0 0 20px; color: #333333; font-size: 16px; line-height: 1.6;">
                                Halo, <strong>{{ $username ?? 'Pengguna' }}</strong>
                            </p>
                            
                            <!-- Message -->
                                <p style="margin: 0 0 30px; color: #666666; font-size: 15px; line-height: 1.6;">
                                    Kami menerima permintaan untuk mereset password akun ResuMate Anda. 
                                    Silakan klik link di bawah ini untuk membuat password baru. Jika Anda tidak merasa meminta reset password, abaikan saja email ini.
                                </p>

                            <p style="margin: 0 0 30px; text-align: center;">
                                <a href="{{ $resetUrl ?? '#' }}" style="color: #4CAF50; font-size: 13px; word-break: break-all; text-decoration: underline;">
                                    {{ $resetUrl ?? 'https://resumate.com/reset-password/token-xxxxxxxxxx' }}
                                </a>
                            </p>

                            <!-- Expiry Warning -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 0 0 30px;">
                                <tr>
                                    <td style="background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 16px 20px; border-radius: 8px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td>
                                                    <p style="margin: 0; color: #856404; font-size: 14px; line-height: 1.5;">
                                                        <strong>Penting:</strong> Link ini hanya berlaku selama <strong>60 menit</strong>. 
                                                        Setelah itu, Anda perlu meminta link reset password baru.
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Divider -->
                            <div style="border-top: 1px solid #e5e5e5; margin: 30px 0;"></div>

                            <!-- Security Tips -->
                            <h3 style="margin: 0 0 15px; color: #333333; font-size: 16px; font-weight: 600;">
                                Tips Keamanan
                            </h3>
                            
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td style="padding: 0 0 12px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td style="padding-right: 10px; vertical-align: top;">
                                                    <div style="color: #4CAF50; font-size: 16px;">✓</div>
                                                </td>
                                                <td>
                                                    <p style="margin: 0; color: #666666; font-size: 14px; line-height: 1.5;">
                                                        Jangan bagikan link ini kepada siapa pun, termasuk staff ResuMate
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 0 0 12px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td style="padding-right: 10px; vertical-align: top;">
                                                    <div style="color: #4CAF50; font-size: 16px;">✓</div>
                                                </td>
                                                <td>
                                                    <p style="margin: 0; color: #666666; font-size: 14px; line-height: 1.5;">
                                                        Pastikan Anda mengakses situs resmi ResuMate
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 0;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td style="padding-right: 10px; vertical-align: top;">
                                                    <div style="color: #4CAF50; font-size: 16px;">✓</div>
                                                </td>
                                                <td>
                                                    <p style="margin: 0; color: #666666; font-size: 14px; line-height: 1.5;">
                                                        Abaikan email ini jika Anda tidak meminta reset password
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Divider -->
                            <div style="border-top: 1px solid #e5e5e5; margin: 30px 0;"></div>

                            <!-- Not You? -->
                            <p style="margin: 0; color: #666666; font-size: 14px; line-height: 1.6; text-align: center;">
                                Tidak meminta reset password? Abaikan email ini atau 
                                <a href="#" style="color: #4CAF50; text-decoration: none; font-weight: 600;">hubungi support kami</a> 
                                jika Anda khawatir tentang keamanan akun Anda.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9f9f9; padding: 30px 40px; border-top: 1px solid #e5e5e5;">
                            
                            <!-- Company Info -->
                            <p style="margin: 0 0 10px; color: #999999; font-size: 13px; line-height: 1.6; text-align: center;">
                                <strong style="color: #666666;">ResuMate</strong><br>
                                Jl. Contoh No. 123, Jakarta Selatan 12345<br>
                                Indonesia
                            </p>

                            <!-- Copyright & Links -->
                            <p style="margin: 0; color: #999999; font-size: 12px; line-height: 1.6; text-align: center;">
                                © {{ date('Y') }} ResuMate. All rights reserved.<br>
                                <a href="#" style="color: #4CAF50; text-decoration: none;">Privacy Policy</a> | 
                                <a href="#" style="color: #4CAF50; text-decoration: none;">Terms of Service</a> | 
                                <a href="#" style="color: #4CAF50; text-decoration: none;">Unsubscribe</a>
                            </p>

                        </td>
                    </tr>

                </table>
                
            </td>
        </tr>
    </table>

</body>
</html>