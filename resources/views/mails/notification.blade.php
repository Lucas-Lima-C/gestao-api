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
                        @if($data['operation'] == 'Add')
                            <p style="font-family:'Calibri Light', sans-serif !important;font-size:14px;">
                                Um novo cadastro de {{ $data['model'] }} foi realizado!
                            </p>
                            @if($data['model'] == 'usuário')
                            <p>
                                Nome: {{ $data['register']['name' ]}}
                            </p>
                            <p>
                                E-mail: {{ $data['register']['email' ]}}
                            </p>
                            @else
                            <p>
                                Nome: {{ $data['register']['name' ]}}
                            </p>
                            <p>
                                Data de conclusão: {{ $data['register']['date_of_conclusion' ]}}
                            </p>
                            @endif
                        @elseif($data['operation'] == 'Edit')
                            <p style="font-family:'Calibri Light', sans-serif !important;font-size:14px;">
                                Um cadastro de {{$data['model']}} foi editado!
                            </p>
                            <p>
                                ID do cadastro: {{ $data['register']['id']}}
                            </p>
                        @foreach($data['previousData'] as $previousData => $item)
                            @if($previousData != 'changedPhoto')
                            <p>
                                O campo <b>{{ $previousData }}</b> foi alterado de: {{ $item }}, para: {{ $data['register'][$previousData] }} .
                            </p>
                            @else
                            <p style="font-family:'Calibri Light', sans-serif !important;font-size:14px;">
                                A foto do usuário foi atualizada!
                            </p>
                            @endif
                        @endforeach
                        @elseif($data['operation'] == 'Delete')
                            <p style="font-family:'Calibri Light', sans-serif !important;font-size:14px;">
                                Um cadastro de {{ $data['model'] }} foi deletado!
                            </p>
                            @if($data['model'] == 'usuário')
                            <p>
                                Nome: {{ $data['register']['name']}}
                            </p>
                            <p>
                                E-mail: {{ $data['register']['email']}}
                            </p>
                            @else
                            <p>
                                Nome: {{ $data['register']['name']}}
                            </p>
                            @endif
                        @else
                        <p style="font-family:'Calibri Light', sans-serif !important;font-size:14px;">
                            Uma tarefa foi concluída!
                        </p>
                        <p>
                            Nome: {{ $data['register']['name' ]}}
                        </p>
                        @endif
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