@extends('layouts.app')

@section('content')
<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('site.transaction')</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">

                            <h3 class="card-title">@lang('site.transaction') @lang('site.list')</h3>
                            <div class="col-md-3">
                                <input type="date" class="form-control" id="fromDate">
                                <input type="date" class="form-control" id="toDate">
                                <button class="btn btn-primary  filter" id="filter">Filter</button>

                            </div>
                            <div class="float-right btn-filter">
                                <button class="btn btn-primary  filter">Rapporto</button>
                                <button class="btn btn-primary  d-none reset">Reset</button>
                            </div>
                        </div>
                            <div class="card-body">
                                @if (count($transactions))

                                    <table class="table table-bordered" id="transactions">
                                        <thead>
                                        <tr>
                                            {{-- @if (array_key_exists('admin_percent', $transactions[0]['client']['service'])) --}}
                                            {{-- @endif --}}
                                            <th>Servizi Nome</th>
                                            <th>Guadagno Agente</th>
                                            {{-- @if (array_key_exists('admin_percent', $transactions[0]['client']['service'])) --}}
                                            {{--                                        <th>Guadagno TLM</th>--}}
                                            {{--                                        <th>Percentuale TLM</th>--}}
                                            {{-- @endif --}}
                                            <th>Opzioni</th>
                                            <th>Problemi amministrativi</th>
                                            <th>Stato Pagamento</th>
                                            <th>Data Pagamento</th>
                                            <th>Dettagli Pagamento</th>
                                            <th>Data</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($transactions as $transaction)
                                            <tr onclick="modalShow({{json_encode($transaction['client'])}}, event)"
                                                style="cursor: pointer;" >
                                                {{-- @if (array_key_exists('admin_percent', $transaction['service'])) --}}
                                                {{-- @endif --}}
                                                <td>{{$transaction['service']['title'] ?? '-'}}</td>
                                                <td>{{$transaction['agent_percent'] ?? '-'}}</td>
                                                {{-- @if (array_key_exists('admin_percent', $transaction['service'])) --}}
                                                {{--                                        <td>{{$transaction['admin_percent']}}</td>--}}
                                                {{--                                        <td>{{floor($transaction['admin_percent']/$transaction['price']*100)}} %</td>--}}
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
                                                <td>{{$transaction['motivazione'] ?? '-'}}</td>
                                                @if($transaction['payment_status'] == 0)
                                                    <td>Non Pagato</td>
                                                @elseif($transaction['payment_status'] == 1)
                                                    <td>Pagato</td>
                                                @endif
                                                <td>{{$transaction['payment_date'] ?? ''}}</td>
                                                <td>{{$transaction['payment_details'] ?? ''}}</td>
                                                <td>{{date('F, d Y', strtotime($transaction['created_at']))}}</td>
                                                <td class="text-center">
                                                    <a class="link"
                                                       href="{{url('transaction/downloadPDF/'.$transaction['id'])}}">
                                                        <i class="fa fa-file-pdf"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td></td>
                                            <td><b>Total: {{$agent_percent_sum}}</b></td>
                                            <td colspan="6"></td>
                                        </tr>
                                        </tfoot>
                                    </table>

                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('site.client')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
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
                                    <td id="first_name"></td>
                                    <td id="last_name"></td>
                                    <td id="service"></td>
                                    <td id="tax_code"></td>
                                    <td id="address"></td>
                                    <td id="civil"></td>
                                    <td id="manager"></td>
                                    <td id="cap"></td>
                                    <td id="birthday"></td>
                                    <td id="date"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function modalShow(data, event) {
        if (data && event.toElement.localName == 'td') {
                $("#first_name").html(data['first_name']);
                $("#last_name").html(data['last_name']);
                $("#service").html(data['service']['title']);
                $("#tax_code").html(data['tax_code']);
                $("#address").html(data['address']);
                $("#civil").html(data['house_number']);
                $("#manager").html(data['manager'] ? data['manager']['name'] : '');
                $("#cap").html(data['cap']);
                $("#birthday").html(data['birthday']);
                $("#date").html(moment(data['created_at']).format('MMMM DD YYYY'));
                $('#exampleModal').modal('show');
        }

    }


    $('.btn-filter button').click(function () {
        $this = $(this);

        if ($this.hasClass('filter')) {
            var value = 'ok'
            diFilter(value)
            $('.btn-filter button').toggleClass('d-none')

        } else {
            $('.btn-filter button').toggleClass('d-none')
            diFilter('')
        }
    })


    function diFilter(value) {
        $("#transactions tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    }

    $("#filter").on("click", function() {
        let from = ($("#fromDate").val());
        let to = ($("#toDate").val());
        if (from && to)  window.location =  '/agent/transaction?from='+from+'&to='+to;
    });
</script>
@endsection
