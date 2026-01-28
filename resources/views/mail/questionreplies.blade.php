<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Novi odgovor</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f8; font-family:Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8; padding:30px 0;">
    <tr>
        <td align="center">

            <!-- Main container -->
            <table width="600" cellpadding="0" cellspacing="0"
                   style="background-color:#ffffff; border-radius:6px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.05);">

                <!-- Header -->
                <tr>
                    <td style="background-color:#111827; padding:20px; text-align:center;">
                        <h1 style="color:#ffffff; margin:0; font-size:22px;">
                            {{ config('app.name') }}
                        </h1>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:30px; color:#333333; font-size:15px; line-height:1.6;">

                        

                        <p>
                            Novi odgovor na vaše pitanje:
                           
                        </p>
                        
                        <!-- Question -->
                        <div style="background-color:#f9fafb; border-left:4px solid #111827; padding:15px; margin:20px 0;">
                            <p style="margin:0; font-style:italic;">
                              
                                “ {{$question->question}}”
                                  
                            </p>
                        </div>

                        <!-- Replies -->
                        <p><strong>Odgovor:</strong></p>

                        <div style="background-color:#f1f5f9; padding:15px; border-radius:4px;">
                             <p style="margin-top:0;">
                            Hi <strong>{{ $userName ?? 'there' }}</strong>,
                        </p>
                            @foreach($questionReply as $reply)
                                <p style="margin:0 0 10px 0; padding-bottom:10px; border-bottom:1px solid #e5e7eb;">
                                    {{ $reply }}
                                </p>
                            @endforeach
                        </div>

                        <p style="color:#6b7280; font-size:13px;">
                            Ovaj mail ste dobili kao odgovor na Vašu poruku koju ste poslali putem kontakt forme.
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background-color:#f9fafb; padding:15px; text-align:center; font-size:12px; color:#6b7280;">
                        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
