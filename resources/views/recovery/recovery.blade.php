<html>

<head>
    <title>Recuperação de Senha</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Raleway|Roboto');

        .white {
            color: white;
        }
        .card {
            width: 485px;
            top: 50%;
            left: 50%;
            color: #444;
            transform: translate(-50%, -50%);
            position: absolute;
            vertical-align: top;
            border-radius: 3px;
            background: #FFFFFF;
            font-family: 'Raleway', sans-serif;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        }

        .card-header {
            padding: 14px;
            background-color: #1194d0 !important;
            color: #000;
        }

        .card-header h2 {
            font-size: 22px;
            text-align: center;
            margin: 6px 0 6px -2px !important;
            padding: 0;
        }

        .card-body {
            padding: 22px;
        }

        .card-body .form-control {
            padding: 10px;
            width: 100%;
            margin-top: 4px;
            margin-bottom: 15px;
            border: 1px solid #D0D0D0;
            font-family: 'Raleway', sans-serif;
        }

        .card-body button {
            padding: 12px;
            width: 100%;
            cursor: pointer;
            margin-top: 4px;
            margin-bottom: 15px;
            border: none;
            border-radius: 2px;
            font-size: 15px;
            background-color: #1194d0 !important;
            font-family: 'Raleway', sans-serif;
        }

        .card-body button:hover {
            background-color: #1194d0;
        }

        .text-center {
            margin: 10px 0 20px -10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header">
            <h2 class='white'>
                Recuperação de Senha
                <i class="fa fa-key"></i>
            </h2>
        </div>

        <div class="card-body">
            @if(!$expired)
            <form method="POST" action="{{ url('api/v1/user/recovery/' . $token) }}">
                {{ csrf_field() }}

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">Senha</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirme a Senha</label>
                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" required>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary white">
                            Trocar a Senha
                        </button>
                    </div>
                </div>
            </form>
            @else
            <p class="text-center" style="margin-top:45px;font-weight:bold;font-size:20px;color:#C44D58;">O token informado já foi utilizado.</p>
            @endif
        </div>
    </div>
</body>

</html>