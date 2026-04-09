<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login Instan - ResuMate</title>
    
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
            .mobile-padding {
                padding: 20px !important;
            }
        }
    </style>
</head>

<body style="margin: 0; padding: 0; background-color: #f7f7f7;">
    <div style="display: none; max-height: 0px; overflow: hidden;">
        Gunakan link ini untuk masuk ke akun ResuMate Anda secara instan tanpa password.
    </div>

    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 0; padding: 0; background-color: #f7f7f7;">
        <tr>
            <td style="padding: 40px 20px;">
                
                <table role="presentation" class="email-container" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                    
                    <tr>
                        <td style="background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%); padding: 40px 40px 30px; text-align: center;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center">
                                <tr>
                                    <td style="background-color: #ffffff; width: 70px; height: 70px; border-radius: 16px; text-align: center; vertical-align: middle; box-shadow: 0 6px 20px rgba(0,0,0,0.15);">
                                        <div style="font-size: 36px; color: #4CAF50; line-height: 70px;">📄</div>
                                    </td>
                                </tr>
                            </table>
                            
                            <h1 style="margin: 25px 0 0; padding: 0; color: #ffffff; font-size: 28px; font-weight: 700; line-height: 1.3;">
                                Akses Aman Akun Anda
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td class="mobile-padding" style="padding: 40px 40px 30px;">
                            
                            <p style="margin: 0 0 20px; color: #333333; font-size: 16px; line-height: 1.6;">
                                Halo, <strong>{{ $user->name }}</strong>
                            </p>
                            
                            <p style="margin: 0 0 30px; color: #666666; font-size: 15px; line-height: 1.6;">
                                Kami menerima permintaan untuk mengakses akun ResuMate Anda. Silakan klik tombol di bawah ini untuk memverifikasi email Anda dan langsung mengakses Dashboard.
                            </p>

                            <p style="margin: 0 0 30px; text-align: center;">
                                <a href="{{ $url }}" style="color: #4CAF50; font-size: 13px; word-break: break-all; text-decoration: underline;">
                                    {{ $url }}
                                </a>
                            </p>

                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 0 0 30px;">
                                <tr>
                                    <td style="background-color: #e8f5e9; border-left: 4px solid #4CAF50; padding: 16px 20px; border-radius: 8px;">
                                        <p style="margin: 0; color: #2e7d32; font-size: 14px; line-height: 1.5;">
                                            <strong>Keamanan:</strong> Link ini hanya berlaku selama <strong>15 menit</strong> dan hanya dapat digunakan <strong>satu kali</strong>. 
                                            Setelah Anda masuk, link ini akan hangus secara otomatis.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <div style="border-top: 1px solid #e5e5e5; margin: 30px 0;"></div>

                            <p style="margin: 0; color: #666666; font-size: 14px; line-height: 1.6; text-align: center;">
                                Tidak merasa meminta link ini? Jangan khawatir, akun Anda tetap aman. Cukup abaikan email ini dan jangan berikan link di atas kepada siapapun.
                            </p>

                        </td>
                    </tr>

                    <tr>
                        <td style="background-color: #f9f9f9; padding: 30px 40px; border-top: 1px solid #e5e5e5;">
                            <p style="margin: 0 0 10px; color: #999999; font-size: 13px; line-height: 1.6; text-align: center;">
                                <strong style="color: #666666;">ResuMate</strong><br>
                                Cara tercepat membuat CV profesional untuk karir impian Anda.
                            </p>

                            <p style="margin: 0; color: #999999; font-size: 12px; line-height: 1.6; text-align: center;">
                                © {{ date('Y') }} ResuMate. All rights reserved.<br>
                                <a href="#" style="color: #4CAF50; text-decoration: none;">Bantuan</a> | 
                                <a href="#" style="color: #4CAF50; text-decoration: none;">Kebijakan Privasi</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>