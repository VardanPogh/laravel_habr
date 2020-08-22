<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fiscal - Transaction PDF</title>
    <link rel="stylesheet" href="{{asset('public/dist/css/adminlte.min.css')}}">
   
</head>

<body>
    <div class="content">
        <div class="container-fluid">
            <div>
                <p class="my-4">Transazioni</p>
            </div>

            <div class="card">

                <div class="card-body p-0">
                    <table class="table table-bordered" id="transactions">
                        <thead>
                            <tr>
                                {{-- @if (array_key_exists('admin_percent', $transaction['service'])) --}}
                                <th>Nome utente</th>
                                {{-- @endif --}}
                                <th>Servizi Nome</th>
                                <th>Prezzo</th>
                                <th>Guadagno Agente</th>
                                <th>Percentuale Agente</th>
                                {{-- @if (array_key_exists('admin_percent', $transaction['service'])) --}}
                                <th>Guadagno TLM</th>
                                <th>Percentuale TLM</th>
                                {{-- @endif --}}
                                <th>Opzioni</th>
                                <th>Problemi amministrativi</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr onclick="modalShow({{json_encode($transaction['client'])}})" style="cursor: pointer;"
                                data-toggle="modal" data-target="#exampleModal">
                                {{-- @if (array_key_exists('admin_percent', $transaction['service'])) --}}
                                <td>{{$transaction['user']['name']}}</td>
                                {{-- @endif --}}
                                <td>{{$transaction['service']['title']}}</td>
                                <td>{{$transaction['price']}}</td>
                                <td>{{$transaction['agent_percent']}}</td>
                                <td>{{floor($transaction['agent_percent']/$transaction['price']*100)}} %</td>
                                {{-- @if (array_key_exists('admin_percent', $transaction['service'])) --}}
                                <td>{{$transaction['admin_percent']}}</td>
                                <td>{{floor($transaction['admin_percent']/$transaction['price']*100)}} %</td>
                                {{-- @endif --}}
                                <td class="status">
                                    @if($transaction['options'] == 0)
                                    <span>OK</span>
                                    @elseif($transaction['options'] == 1)
                                    <span>In corso</span>
                                    @elseif($transaction['options'] == 2)
                                    <span>Problemi
                                        amministrativi</span>
                                    @endif
                                </td>
                                <td>{{$transaction['motivazione']}}</td>
                                <td>{{date('F, d Y', strtotime($transaction['created_at']))}}</td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>

            @if(is_array($transaction['client']))
            <div>
                <p class="my-4">Clienti</p>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Cognome</th>
                                <th>Services</th>
                                <th>Codice fiscale</th>
                                <th>Address</th>
                                <th>Numero civico</th>
                                <th>Gestore</th>
                                <th>Cap</th>
                                <th>Data di nascita</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$transaction['client']['first_name'] ?? '-'}}</td>
                                <td>{{$transaction['client']['last_name'] ?? '-'}}</td>
                                <td>{{$transaction['client'] && $transaction['service'] ? $transaction['service']['title'] : ''}}
                                </td>
                                <td>{{$transaction['client']['tax_code'] ?? '-'}}</td>
                                <td>{{$transaction['client']['address'] ?? '-'}}</td>
                                <td>{{$transaction['client']['house_number'] ?? '-'}}</td>
                                <td>{{$transaction['client'] && isset($transaction['client']['manager'] )? $transaction['client']['manager']['name'] : ''}}
                                </td>
                                <td>{{$transaction['client']['cap'] ?? '-'}}</td>
                                <td>{{$transaction['client']['birthday'] ?? '-'}}</td>
                                <td>{{date('d M, Y',strtotime( $transaction['client']['created_at'] ?? '-'))}}</td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>

</body>

</html>