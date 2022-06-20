<html>
    <head>
        <title></title>
    </head>
    <body>
        <table style="table-layout:inherit !important;width:525px;margin-right:auto;margin-left:auto;">
            <thead>
                <tr>
                    <th colspan="2" style="height:25px;background-color:#1194d0;"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align:left;padding:14px;border-bottom:1px solid #1194d0">
                        <p style="font-size:16px;font-family:'Calibri Light', sans-serif !important;margin:0;">
                            <b>Olá {{ $data['name'] }}!</b></p>
                        <p style="font-family:'Calibri Light', sans-serif !important;font-size:14px;">
                            Uma solicitação de alteração de senha foi enviada para o seu e-mail. Para trocar a senha, basta <a href="{{ $data['link'] }}">clicar aqui</a>.
                        </p>
                        <p style="font-family:'Calibri Light', sans-serif !important;font-size:14px;">Atenciosamente, <br>
                            <b>{{ env('MAIL_FROM_NAME') }}</b></p>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="height:20px;background-color:#1194d0"></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>