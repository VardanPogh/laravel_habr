<div class="modal fade" id="confirmReload" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmReloadLabel">@lang('site.add') @lang('site.client')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
{{--                <label for="reloadServiceName" class="h4">@lang('site.services'): </label>--}}
                <span id="reloadServiceName" class="h4"></span>

                <form method="POST" id="confirmReloadService">
                    @csrf
                    <input type="hidden" name="service_id" value="">
                    <input type="hidden" name="id" value="">
                    <!-- action="/agent/add-client" enctype="multipart/form-data" -->


                    <div class="card-body">

                        <!--********************** Mutual Fields ***********************************-->
                        <div class="row">
                            <!--******* form-group col-md-6 **********-->
                            <div class="form-group col-md-12">
                                <label for="provincia">Numero da ricarica</label>
                                <input name="reloaded_number" type="number" class="form-control"
                                       placeholder="Numero da ricarica">
                                <span id="reloaded_number" class="invalid-feedback"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="provincia">Conferma numero</label>
                                <input name="confirm_reloaded_number" type="number" id="confirmReloadedNumber" class="form-control"
                                       placeholder="Conferma numero">
                                <span id="confirm_reloaded_number" class="invalid-feedback"></span>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="progress">
                    <span id="progressRelaod" class="badge bg-danger">55%</span>
                    <div id="progressProcentReload" class="progress-bar progress-bar-danger" style="width: 0%"></div>
                </div>
            </div>
            <div class="modal-footer justify-content-between ">
                <button type="button" data-dismiss="modal" class="btn btn-light">ANNULLA</button>
                <button type="button"  onclick="addConfirmReload()" class="btn btn-success">PROCEDI</button>
            </div>
        </div>
    </div>
</div>
