<div class="modal fade" id="fixedService2" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fixedServiceNipLabel">@lang('site.add') @lang('site.client')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <label for="fixedServiceName2" class="h4">@lang('site.services'): </label>
                <span id="fixedServiceName2" class="h4"></span>
                <form method="POST" id="form2" class="nipService">
                    @csrf
                    <input type="hidden" name="service_id" value="">
                    <input type="hidden" name="client_id" value="">
                    <div class="card-body">
                        <div class="row">
                            <div class="h4">Dati Anagrafici</div>
                            <!--********************** Fields for Privato ****************************** -->
                            <fieldset class="fieldset">
                                <div class="row">
                                    <!--******* form-group col-md-6 **********-->
                                    <div class="form-group col-md-6">
                                        <label for="first_name_input">Nome</label>
                                        <input name="first_name" type="text" class="form-control" id=""
                                               placeholder="Nome">
                                        <span id="first_name" class="invalid-feedback"></span>
                                    </div>
                                    <!--******* form-group col-md-6 **********-->
                                    <div class="form-group col-md-6">
                                        <label for="last_name">Cognome</label>
                                        <input name="last_name" type="text" class="form-control" id=""
                                               placeholder="Cognome">
                                        <span id="last_name" class="invalid-feedback"></span>
                                    </div>


                                    <!--******* form-group col-md-6 **********-->
                                    <div class="form-group col-md-6">
                                        <label for="taxCodeInput">Codice Fiscale</label>
                                        <input name="tax_code" type="text" class="form-control" id=""
                                               placeholder="Codice Fiscale" onblur="addFiscalCode()">
                                        <span id="tax_code" class="invalid-feedback"></span>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="birthdayInput">Data di nascita</label>
                                        <input name="birthday" type="date" class="form-control" id=""
                                               placeholder="Data di nascita" onblur="changeFixedServiceClientDate()">
                                        <span id="birthday" class="invalid-feedback"></span>
                                    </div>

                                    <!--******* form-group col-md-6 **********-->
                                    <div class="form-group col-md-6">
                                        <label for="birth_provinciaInput">Comune di nascita</label>
                                        <input name="birth_place" type="text" class="form-control"
                                               placeholder="Comune di nascita">
                                        <span id="birth_place" class="invalid-feedback"></span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input name="email" type="text" class="form-control" id="email"
                                               placeholder="Email">
                                        <span id="email" class="invalid-feedback"></span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="mobile">Recapito Telefonico</label>
                                        <input name="mobile" type="number" class="form-control" id=""
                                               placeholder="Recapito Telefonico">
                                        <span id="mobile" class="invalid-feedback"></span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for>Sesso</label>
                                        <div class="row gender">
                                            <div class="d-inline mx-2">
                                                <input type="radio" id="male" name="gender" value="male" checked/>
                                                <label for="male">Uomo</label>
                                            </div>

                                            <div class="d-inline mx-2">
                                                <input type="radio" id="female" name="gender" value="female"/>
                                                <label for="female">Donna</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="h4">Dati Documento</div>
                            <fieldset class="fieldset">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Tipo di documento</label>
                                        <select name="type_of_document" class="form-control">
                                            <option value="Carta identità">Carta identità</option>
                                            <option value="Patente">Patente</option>
                                            <option value="Permesso di soggiorno">Permesso di soggiorno
                                            </option>
                                            <option value="Passaporto">Passaporto</option>
                                            <option value="Codice fiscale">Codice fiscale</option>
                                            <option value="Tessera sanitaria">Tessera sanitaria</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="document_number">Numero documento</label>
                                        <input name="document_number" type="text" class="form-control" id=""
                                               placeholder="Numero documento">
                                        <span id="document_number" class="invalid-feedback"></span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="document_date">Dati documento</label>
                                        <input type="date" class="form-control" id="doc1_validaty"
                                               name="document_date" placeholder="Dati documento"/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="issue_date">Data emissione</label>
                                        <input name="issue_date" type="date" class="form-control" id=""
                                               placeholder="Data emissione">
                                        <span id="issue_date" class="invalid-feedback"></span>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Documento Retro</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="document_retro"
                                                   placeholder="Carica Documento – Retro"
                                                   ref="document_retro" accept="image/*;capture=camera"/>
                                            <label class="custom-file-label" for="document_retro">
                                                Choose file
                                            </label>
                                            <span id="document_retro" class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Carica Documento – Fronte</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input"
                                                       name="document_front" ref="document_front"
                                                       placeholder="Carica Documento – Fronte"
                                                       accept="image/*;capture=camera"/>
                                                <label class="custom-file-label" for="document_front">
                                                    Choose file
                                                </label>
                                                <span id="document_front" class="invalid-feedback"></span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="expiry_date">Data scadenza</label>
                                        <input name="expiry_date" type="date" class="form-control" id=""
                                               placeholder="Data scadenza" onblur="changeDate()">
                                        <span id="expiry_date" class="invalid-feedback"></span>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="h4">Impianto</div>
                            <fieldset class="fieldset">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="place_of_issue">Luogo Emissione</label>
                                        <input name="place_of_issue" type="text" class="form-control" id=""
                                               placeholder="Luogo Emissione">
                                        <span id="place_of_issue" class="invalid-feedback"></span>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="issuing_body">Ente Emissione</label>
                                        <input name="issuing_body" type="text" class="form-control" id=""
                                               placeholder="Ente Emissione">
                                        <span id="issuing_body" class="invalid-feedback"></span>
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label for="emission_province">Provincia Emissione</label>
                                        <input name="emission_province" type="text" class="form-control" id=""
                                               placeholder="Provincia Emissione">
                                        <span id="emission_province" class="invalid-feedback"></span>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="province">Provincia</label>
                                        <input name="provincia" type="text" class="form-control" id=""
                                               placeholder="Provincia">
                                        <span id="provincia" class="invalid-feedback"></span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="alternative_telephone_number">Recapito telefonico
                                            alternativo</label>
                                        <input name="alternative_telephone_number" type="number" class="form-control"
                                               id=""
                                               placeholder="Numero di telefono fisso attuale">
                                        <span id="alternative_telephone_number" class="invalid-feedback"></span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="plant_location_address">Indirizzo Sede Impianto</label>
                                        <input name="plant_location_address" type="text" class="form-control" id=""
                                               placeholder="Indirizzo Sede Impianto">
                                        <span id="plant_location_address" class="invalid-feedback"></span>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                </form>
                <div class="progress">
                    <span id="progress2" class="badge bg-danger">55%</span>
                    <div id="progressProcent2" class="progress-bar progress-bar-danger" style="width: 0%"></div>
                </div>
            </div>


            <div class="modal-footer">
                <button type="button" onclick="addNipTransaction()" class="btn btn-primary">Aggiungi</button>
            </div>

        </div>
    </div>
</div>
