@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <div class="content">
        <div class="container">
            <div class="row" id="general">

                @foreach ($datas['general'] as $data)

                <div class="col-lg-4 mt-3">
                    <div class="card bg-info">
                        <a href="/agent/general/{{$data['id']}}"
                            class="{{ array_key_exists('general_id', $datas) && $data['id'] == $datas['general_id'] ? 'click-border' : ''}}">
                            <div class="card-body">
                                <h5 class="card-title">{{$data['name']}}</h5>
                            </div>
                        </a>
                    </div>
                </div>

                @endforeach

            </div>

            <div class="row" id="categories">

                @foreach ($datas['categories'] as $data)

                <div class="col-lg-3 mt-3">
                    <div class="border shadow">
                        <div class="image">
                            <img src="{{$data['image']}}" class="img-fluid">
                        </div>

                        <div class="card bg-danger m-0">
                            <a href="/agent/general/{{$data['general_category_id']}}/category/{{$data['id']}}"
                                title="{{$data['desc']}}"
                                class="{{array_key_exists('category_id', $datas) && $data['id'] == $datas['category_id'] ? 'click-border' : ''}}"
                                alt="{{$data['desc']}}">
                                <div class="card-body">
                                    <h5 class="card-title">{{$data['name']}}</h5>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>

                @endforeach

            </div>

            <div class="row" id="services">

                @foreach ($datas['services'] as $service)

                <div class="col-lg-2 mt-3 ">
                    <div class="border shadow">
                        <div class="image">
                            <img src="{{$service['image']}}" class="img-fluid">
                        </div>
                        @if($service->with_protocol)
                        <button type="button" class="btn btn-warning btn-block" onclick="modalOpen({{$service}}, event)"
                            title="{{$service['description']}}" alt="{{$service['description']}}">
                            {{$service['title']}}
                            @if($service['form_type'] == 6)
                                {{$service['price']}}
                            @endif
                            @if( $service['form_type'] == 6 && $service['course'] == 1)
                                $
                            @elseif($service['form_type'] == 6 && $service['course'] == 0)
                                €
                            @endif
                        </button>

                        @else
                        <form action="{{url('agent/add-client')}}" method="post">
                            @csrf
                            <input type="hidden" name="service_id" value="{{$service->id}}">
                            <input type="hidden" name="form">
                            <button type="submit" class="btn btn-warning btn-block" title="{{$service['description']}}"
                                alt="{{$service['description']}}">
                                {{$service['title']}}
                            </button>
                        </form>
                        @endif
                    </div>

                </div>

                @endforeach

            </div>
        </div>
    </div>

    @include('add-client-modal')
    @include('add-ull-service-modal')
    @include('add-acq-service-modal')
    @include('add-mnp-service-modal')
    @include('add-conversion-service-modal')
    @include('add-nip-service-modal')
    @include('confirm-reload-service-modal')
</div>
@endsection

@section('script')
<script src="{{asset('dist/js/home.js')}}"></script>
<script src="{{asset('dist/js/services.js')}}"></script>
<script>
    var form_types = {
        default: '0',
        ricarica: '6',
    }
    function modalOpen(data, event) {
        if (data.form_type == form_types.ricarica){
            confirmReloadModalOpen(data, event)

        }
        if (data.form_type !== form_types.default) {
            fixedServicesModalOpen(data, event)
        }
        if (data.form_type == form_types.default){
            $('#progress').parent().css('display', 'none');
            $('#services a').attr('class', '');
            $(event.target).addClass("click-border");
            $("[name=service_id]").attr('value', data.id);
            $("#serviceName").html(data.title);
            $('#exampleModal').modal('show');
        }
}
    function fixedServicesModalOpen(data, event) {
        $('#progress' + data.form_type).parent().css('display', 'none');
        $('#services a').attr('class', '');
        $(event.target).addClass("click-border");
        $("[name=service_id]").attr('value', data.id);
        $("#fixedServiceName"+ data.form_type).html(data.title);
        $('#fixedService'+ data.form_type).modal('show');
        openUsedServiceForm(data.form_type)
    }
    function confirmReloadModalOpen(data, event) {
        $('#progressRelaod').parent().css('display', 'none');
        $('#services a').attr('class', '');
        $(event.target).addClass("click-border");
        $("[name=services_id]").attr('value', data.id);
        if (data.course == 0){
            var course = '€'
        }else {
           course = '$'
        }
        $("#reloadServiceName").html(data.title +' Da '+ data.price + ' ' + course);
        $('#confirmReload').modal('show');
    }
</script>
@endsection


@section('css')
<style>
    .error {
        display: block;
    }

    .click-border {
        border: 3px solid #6c757d !important;
    }
</style>
@endsection
