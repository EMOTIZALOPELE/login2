<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($subject) ?></title>
</head>
<body style="margin: 0; padding: 0; background-color: #0a192f;">
    <center>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" style="table-layout: fixed; background-color: #0a192f; height: 100%;">
            <tr>
                <td align="center" style="padding: 40px 0;"> 

                    <table border="0" cellpadding="0" cellspacing="0" width="500" style="max-width: 500px; width: 100%; background-color: rgba(16, 32, 61, 0.9); border-radius: 15px; border: 1px solid rgba(100, 255, 218, 0.3);">
                        
                        <tr>
                            <td align="center" style="padding: 30px 30px 10px 30px;">
                                <span style="font-family: Arial, sans-serif; font-size: 32px; font-weight: bold; color: #64ffda; text-transform: uppercase;">VECOPO</span>
                            </td>
                        </tr>

                        <tr>
                            <td align="center" style="padding: 10px 40px 40px 40px; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; color: #ccd6f6;">
                                
                                <h1 style="font-size: 24px; margin-top: 0; margin-bottom: 25px; color: #ccd6f6;">Código de Verificación de Cuenta</h1>
                                
                                <p style="margin-bottom: 30px;">¡Hola! Gracias por registrarte en Vecopo. Necesitamos que verifiques tu cuenta.</p>
                                
                                <p style="margin-bottom: 20px;">Tu código de verificación es:</p>
                                
                                <table border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto 35px auto; background-color: #0a192f; border: 1px solid #64ffda; border-radius: 4px;">
                                    <tr>
                                        <td align="center" style="padding: 18px 40px;">
                                            <span style="font-family: Arial, sans-serif; font-size: 36px; font-weight: bold; color: #64ffda; letter-spacing: 5px; display: block;">
                                                <?= esc($code) ?>
                                            </span>
                                        </td>
                                    </tr>
                                </table>

                                <p style="margin-bottom: 35px;">Debes ingresarlo en la pantalla de verificación en la próxima hora para activar tu cuenta. Si no lo haces, tu cuenta será eliminada por seguridad.</p>

                                <table border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                    <tr>
                                        <td align="center" style="border-radius: 25px; background-color: #00f2fe; padding: 2px;"> <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                    <td align="center" style="border-radius: 25px; background-color: #4facfe; padding: 12px 30px;">
                                                        <a href="<?= esc($verification_link) ?>" target="_blank" style="color: #0a192f; text-decoration: none; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold; display: block;">
                                                            Verificar mi cuenta aquí
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                
                                <p style="margin-top: 35px; font-size: 12px; color: #8892b0; word-break: break-all;">
                                    Si el botón no funciona, copia y pega el siguiente enlace:<br><a href="<?= esc($verification_link) ?>" style="color: #64ffda; text-decoration: none;"><?= esc($verification_link) ?></a>
                                </p>

                            </td>
                        </tr>
                    </table>

                    <table border="0" cellpadding="0" cellspacing="0" width="500" style="max-width: 500px;">
                        <tr>
                            <td align="center" style="padding: 25px 20px; font-family: Arial, sans-serif; font-size: 12px; line-height: 18px; color: #8892b0;">
                                Atentamente,<br>El equipo de VECOPO
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>
    </center>
</body>
</html>