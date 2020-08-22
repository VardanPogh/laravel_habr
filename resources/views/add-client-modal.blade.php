<div class="modal fade" id="exampleModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('site.add') @lang('site.client')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <label for="serviceName" class="h4">@lang('site.services'): </label>
                <span id="serviceName" class="h4"></span>

                <form method="POST">
                    @csrf
                    <input type="hidden" name="service_id" value="">
                    <input type="hidden" name="id" value="">
                    <!-- action="/agent/add-client" enctype="multipart/form-data" -->


                    <div class="card-body">

                        <!-- **********************Privato/Azienda ********************************-->
                        <div class="radio-buttons">
                            <div class="row">
                                <div class="col-6 text-center">
                                    <input type="radio" id="privato" value="1" name="type" checked
                                        onchange="changeType(1)" style="display:none" />
                                    <label for="privato">Privato</label>
                                </div>
                                <div class="col-6 text-center">
                                    <input type="radio" id="azienda" value="2" name="type" style="display:none"
                                        onchange="changeType(2)" />
                                    <label for="azienda">Azienda</label>
                                </div>
                            </div>
                        </div>


                        <!--********************** Mutual Fields ***********************************-->
                        <div class="row">

                            <!--******* form-group col-md-6 **********-->
                            <div class="form-group col-md-6">
                                <label for="taxCodeInput">Codice Fiscale</label>
                                <input name="tax_code" type="text" class="form-control"
                                    placeholder="Codice Fiscale" onblur="fiscalCode()">
                                <span id="tax_code" class="invalid-feedback"></span>
                            </div>

                            <!--******* form-group col-md-6 **********-->
                            <div class="form-group col-md-6">
                                <label for="managerOptions">Gestore</label>
                                <select class="form-control" id="managerOptions" name="manager">
                                    <option value="" selected disabled>Gestore</option>
                                    @foreach ($menegers as $meneger)
                                    <option value="{{$meneger['id']}}">{{$meneger['name']}}</option>
                                    @endforeach
                                </select>
                                <span id="manager" class="invalid-feedback"></span>
                            </div>

                            <!--******* form-group col-md-6 **********-->
                            <div class="form-group col-md-6">
                                <label for="addressInput">Indirizzo</label>
                                <input name="address" type="address" class="form-control" id="addressInput"
                                    placeholder="Indirizzo">
                                <span id="address" class="invalid-feedback"></span>
                            </div>


                            <!--******* form-group col-md-6 **********-->
                            <div class="form-group col-md-6">
                                <label for="capInput">Cap</label>
                                <input name="cap" type="number" class="form-control" id="capInput" placeholder="Cap">
                                <span id="cap" class="invalid-feedback"></span>
                            </div>


                            <!--******* form-group col-md-6 **********-->
                            <div class="form-group col-md-6">
                                <label for="provincia">Provincia di residenza</label>
                                <input name="provincia" type="text" class="form-control" id="provincia"
                                    placeholder="Provincia di residenza">
                                <span id="provincia" class="invalid-feedback"></span>
                            </div>

                            <!--******* form-group col-md-6 **********-->
                            <div class="form-group col-md-6">
                                <label for="city">Comune di residenza</label>
                                <input name="city" type="text" class="form-control" id="city"
                                    placeholder="Comune di residenza">
                                <span id="city" class="invalid-feedback"></span>
                            </div>

                            <!--******* form-group col-md-6 **********-->
                            <div class="form-group col-md-6">
                                <label for="fixed_delivery">Recapito fisso</label>
                                <input name="fixed_delivery" type="text" class="form-control" id="fixed_delivery"
                                    placeholder="Recapito fisso">
                                <span id="fixed_delivery" class="invalid-feedback"></span>
                            </div>

                            <!--******* form-group col-md-6 **********-->
                            <div class="form-group col-md-6">
                                <label for="fixed_manager">Gestore fisso</label>
                                <input name="fixed_manager" type="text" class="form-control" id="fixed_manager"
                                    placeholder="Gestore fisso">
                                <span id="fixed_manager" class="invalid-feedback"></span>
                            </div>
                            <!--******* form-group col-md-6 **********-->
                            <div class="form-group col-md-6">
                                <label for="mobile_delivery">Recapito mobile</label>
                                <input name="mobile_delivery" type="number" class="form-control" id="mobile_delivery"
                                    placeholder="Recapito mobile">
                                <span id="mobile_delivery" class="invalid-feedback"></span>
                            </div>

                            <!--******* form-group col-md-6 **********-->
                            <div class="form-group col-md-6">
                                <label for="alternative_mobile">Recapito telefonico alternativo</label>
                                <input name="alternative_mobile" type="number" class="form-control"
                                    id="alternative_mobile" placeholder="Recapito telefonico alternativo">
                                <span id="alternative_mobile" class="invalid-feedback"></span>
                            </div>

                            <!--******* form-group col-md-6 **********-->
                            <div class="form-group col-md-6">
                                <label for="mobile">Gestore mobile</label>
                                <input name="mobile" type="number" class="form-control" id="mobile"
                                    placeholder="Gestore mobile">
                                <span id="mobile" class="invalid-feedback"></span>
                            </div>

                            <!--******* form-group col-md-6 **********-->
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input name="email" type="text" class="form-control" id="email" placeholder="Email">
                                <span id="email" class="invalid-feedback"></span>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="email">Rappresentante Legale</label>
                                <input name="email" type="text" class="form-control"  id="rappresentante_legale" placeholder="Rappresentante Legale">
                                <span id="rappresentante_legale" class="invalid-feedback"></span>
                            </div>

                        </div>


                        <!--********************** Fields for Privato ****************************** -->
                        <fieldset class="fieldset privato">
                            <legend>Privato:</legend>
                            <div class="row">

                                <!--******* form-group col-md-6 **********-->
                                <div class="form-group col-md-6">
                                    <label for="firstNmaeInput">Nome</label>
                                    <input name="first_name" type="text" class="form-control" id="firstNmaeInput"
                                        placeholder="First Name">
                                    <span id="first_name" class="invalid-feedback"></span>
                                </div>
                                <!--******* form-group col-md-6 **********-->
                                <div class="form-group col-md-6">
                                    <label for="lastNameInput">Cognome</label>
                                    <input name="last_name" type="text" class="form-control" id="lastNameInput"
                                        placeholder="Last Name">
                                    <span id="last_name" class="invalid-feedback"></span>
                                </div>


                                <!--******* form-group col-md-6 **********-->
                                <div class="form-group col-md-6">
                                    <label for="tcivilInput">Numero civico</label>
                                    <input name="civil" type="text" class="form-control" id="civilInput"
                                        placeholder="Numero civico">
                                    <span id="civil" class="invalid-feedback"></span>
                                </div>
                                <!--******* form-group col-md-6 **********-->
                                <div class="form-group col-md-6">
                                    <label for="birthdayInput">Data di nascita</label>
                                    <input name="birthday" type="date" class="form-control" id="birthdayInput"
                                        placeholder="Data di nascita" onblur="changeDate()">
                                    <span id="birthday" class="invalid-feedback"></span>
                                </div>

                                <!--******* form-group col-md-6 **********-->
                                <div class="form-group col-md-6">
                                    <label for="birth_provinciaInput">Provincia (Nascita)</label>
                                    <input name="birth_provincia" type="text" class="form-control"
                                        id="birth_provinciaInput" placeholder="Provincia (Nascita)">
                                    <span id="birth_provincia" class="invalid-feedback"></span>
                                </div>
                                <!--******* form-group col-md-6 **********-->
                                <div class="form-group col-md-6">
                                    <label for="birth_placeInput">Luogo di Nascita</label>
                                    <input name="birth_place" type="text" class="form-control" id="birth_placeInput"
                                        placeholder="Luogo di Nascita">
                                    <span id="birth_place" class="invalid-feedback"></span>
                                </div>

                                <!--******* form-group **********-->
                                <div class="form-group col-md-6">
                                    <label for>Sesso</label>
                                    <div class="row gender">
                                        <div class="d-inline mx-2">
                                            <input type="radio" id="male" name="gender" value="male"  checked />
                                            <label for="male">Male</label>
                                        </div>

                                        <div class="d-inline mx-2">
                                            <input type="radio" id="female" name="gender" value="female"  />
                                            <label for="female">Female</label>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="row mt-4 pt-4 border-top">

                                <!--******* doc1 **********-->
                                <div class="col-md-6">
                                    <div class="border p-2 my-2">
                                        <!--******* form-group **********-->
                                        <div class="form-group">
                                            <label>Tipo di documento</label>
                                            <select name="doc1[type]" class="form-control">
                                                <option value="Carta identità">Carta identità</option>
                                                <option value="Patente">Patente</option>
                                                <option value="Permesso di soggiorno">Permesso di soggiorno
                                                </option>
                                                <option value="Passaporto">Passaporto</option>
                                                <option value="Codice fiscale">Codice fiscale</option>
                                                <option value="Tessera sanitaria">Tessera sanitaria</option>
                                            </select>

                                        </div>

                                        <!--******* form-group **********-->
                                        <div class="form-group">
                                            <label for="doc1_validaty">Data scadenza documento</label>
                                            <input type="date" class="form-control" id="doc1_validaty"
                                                name="doc1[validaty]" placeholder="data scadenza" />
                                        </div>

                                        <!--******* form-group **********-->
                                        <div class="form-group">
                                            <label>Documento Fronte</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="doc1_front"
                                                        name="doc1[front]" ref="doc1[front]"
                                                        accept="image/*;capture=camera" />
                                                    <label class="custom-file-label" for="doc1_front">
                                                        Choose file
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                        <!--******* form-group **********-->
                                        <div class="form-group">
                                            <label>Documento Retro</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="doc1[retro]"
                                                    ref="doc1[retro]" accept="image/*;capture=camera" />
                                                <label class="custom-file-label" for="doc1_retro">
                                                    Choose file
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <!--******* doc2 **********-->
                                <div class="col-md-6">
                                    <div class="border p-2 my-2">
                                        <!--******* form-group **********-->
                                        <div class="form-group">
                                            <label>Tipo di documento</label>
                                            <select name="doc2[type]" class="form-control">
                                                <option value="Carta identità">Carta identità</option>
                                                <option value="Patente">Patente</option>
                                                <option value="Permesso di soggiorno">Permesso di soggiorno
                                                </option>
                                                <option value="Passaporto">Passaporto</option>
                                                <option value="Codice fiscale">Codice fiscale</option>
                                                <option value="Tessera sanitaria">Tessera sanitaria</option>
                                            </select>

                                        </div>

                                        <!--******* form-group **********-->
                                        <div class="form-group">
                                            <label for="doc2_validaty">Data scadenza documento</label>
                                            <input type="date" class="form-control" id="doc2_validaty"
                                                name="doc2[validaty]" placeholder="data scadenza" />
                                        </div>

                                        <!--******* form-group **********-->
                                        <div class="form-group">
                                            <label>Documento Fronte</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="doc2[front]"
                                                        ref="doc2[front]" accept="image/*;capture=camera" />
                                                    <label class="custom-file-label" for="doc2_front">
                                                        Choose file
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                        <!--******* form-group **********-->
                                        <div class="form-group">
                                            <label>Documento Retro</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="doc2_retro"
                                                    name="doc2[retro]" ref="doc2[retro]"
                                                    accept="image/*;capture=camera" />
                                                <label class="custom-file-label" for="doc2_retro">
                                                    Choose file
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </fieldset>

                        <fieldset class="fieldset d-none azienda">
                            <legend>Azienda:</legend>
                            <div class="row">
                                <!--******* form-group col-md-6 **********-->
                                <div class="form-group col-md-6">
                                    <label for="business_nameInput">Ragione sociale</label>
                                    <input name="business_name" type="text" class="form-control" id="business_nameInput"
                                        placeholder="Ragione sociale">
                                    <span id="business_name" class="invalid-feedback"></span>
                                </div>

                                <!--******* form-group col-md-6 **********-->
                                <div class="form-group col-md-6">
                                    <label for="vat_numberInput">Partita IVA</label>
                                    <input name="vat_number" type="text" class="form-control" id="vat_numberInput"
                                        placeholder="Partita IVA">
                                    <span id="vat_number" class="invalid-feedback"></span>
                                </div>
                                <!--******* form-group col-md-6 **********-->
                                <div class="form-group col-md-6">
                                    <label for="alternative_emailInput">Email alternativa</label>
                                    <input name="alternative_email" type="email" class="form-control"
                                        id="alternative_emailInput" placeholder="Email alternativa">
                                    <span id="alternative_email" class="invalid-feedback"></span>
                                </div>


                            </div>

                        </fieldset>
                    </div>

                </form>
                <div class="progress">
                    <span id="progressProcent" class="badge bg-danger">55%</span>
                    <div id="progress" class="progress-bar progress-bar-danger" style="width: 0%"></div>
                </div>
            </div>


            <div class="modal-footer">
                <button type="button" onclick="addEditClients()" class="btn btn-primary">Aggiungi</button>
            </div>

        </div>
    </div>





</div>
