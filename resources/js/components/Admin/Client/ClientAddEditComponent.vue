<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Clients {{id ? 'Modifica' : 'Aggiungi'}}</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="container-fluid">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{id ? 'Modifica' : 'Aggiungi'}}</h3>
                        </div>

                        <div class="card-body">
                            <form role="form" @submit.prevent="addEditClients()">
                                <!-- **********************Privato/Azienda **************************************-->
                                <div class="radio-buttons">
                                    <div class="row">
                                        <div class="col-6 text-center">
                                            <input @change="changeType(1)" type="radio" id="privato" value="1"
                                                name="type" checked style="display:none" />
                                            <label for="privato">Privato</label>
                                        </div>
                                        <div class="col-6 text-center">
                                            <input type="radio" id="azienda" value="2" name="type" style="display:none"
                                                @change="changeType(2)" />
                                            <label for="azienda">Azienda</label>
                                        </div>
                                    </div>
                                </div>

                                <!--********************** Mutual Fields ******************************************-->
                                <div class="row">
                                    <!--******* form-group **********-->
                                    <div class="form-group col-md-6">
                                        <label for="taxCodeInput">Codice Fiscale</label>
                                        <input v-model="tax_code" type="text" class="form-control" id="taxCodeInput"
                                            @change="errorMessageEdit('tax_code')"
                                            :class="errorMessage && errorMessage['tax_code'] ? 'is-invalid' : ''"
                                            placeholder="Codice Fiscale" @blur="fiscalCode()" />
                                        <span v-if="errorMessage && errorMessage['tax_code']"
                                            class="invalid-feedback error">{{errorMessage['tax_code'][0]}}</span>
                                    </div>

                                    <!--******* form-group **********-->
                                    <div class="form-group col-md-6">
                                        <label for="managerOptions">Gestore</label>
                                        <select class="form-control" id="managerOptions" v-model="manager_id"
                                            @change="errorMessageEdit('manager')"
                                            :class="errorMessage && errorMessage['manager'] ? 'is-invalid' : ''">
                                            <option value selected disabled>Gestore</option>
                                            <option v-for="(man, i) in managers" :key="i" :value="man.id">{{man.name}}
                                            </option>
                                        </select>
                                        <span v-if="errorMessage && errorMessage['manager']"
                                            class="invalid-feedback error">{{errorMessage['manager'][0]}}</span>
                                    </div>

                                    <!--******* form-group **********-->
                                    <div class="form-group col-md-6">
                                        <label for="sectionsOptions">Services</label>
                                        <select class="form-control" id="servicesOptions" v-model="service_id"
                                            @change="errorMessageEdit('service_id')"
                                            :class="errorMessage && errorMessage['service_id'] ? 'is-invalid' : ''">
                                            <option value selected disabled>Services</option>
                                            <option v-for="(ser, i) in services" :key="i" :value="ser.id">{{ser.title}}
                                            </option>
                                        </select>
                                        <span v-if="errorMessage && errorMessage['service_id']"
                                            class="invalid-feedback error">{{errorMessage['service_id'][0]}}</span>
                                    </div>

                                    <!--******* form-group **********-->
                                    <div class="form-group col-md-6">
                                        <label for="addressInput">Indirizzo</label>
                                        <input v-model="address" type="text" class="form-control" id="addressInput"
                                            @change="errorMessageEdit('address')"
                                            :class="errorMessage && errorMessage['address'] ? 'is-invalid' : ''"
                                            placeholder="Indirizzo" />
                                        <span v-if="errorMessage && errorMessage['address']"
                                            class="invalid-feedback error">{{errorMessage['address'][0]}}</span>
                                    </div>

                                    <!--******* form-group **********-->
                                    <div class="form-group col-md-6">
                                        <label for="cap">Cap</label>
                                        <input v-model="cap" type="number" class="form-control" id="cap"
                                            @change="errorMessageEdit('cap')"
                                            :class="errorMessage && errorMessage['cap'] ? 'is-invalid' : ''"
                                            placeholder="Cap" />
                                        <span v-if="errorMessage && errorMessage['cap']"
                                            class="invalid-feedback error">{{errorMessage['cap'][0]}}</span>
                                    </div>

                                    <!--******* form-group **********-->
                                    <div class="form-group col-md-6">
                                        <label for="provincia">Provincia di residenza</label>
                                        <input v-model="provincia" type="text" class="form-control" id="provincia"
                                            @change="errorMessageEdit('provincia')"
                                            :class="errorMessage && errorMessage['provincia'] ? 'is-invalid' : ''"
                                            placeholder="Provincia di residenza" />
                                        <span v-if="errorMessage && errorMessage['provincia']"
                                            class="invalid-feedback error">{{errorMessage['provincia'][0]}}</span>
                                    </div>

                                    <!--******* form-group **********-->
                                    <div class="form-group col-md-6">
                                        <label for="city">Comune di residenza</label>
                                        <input v-model="city" type="text" class="form-control" id="city"
                                            @change="errorMessageEdit('city')"
                                            :class="errorMessage && errorMessage['city'] ? 'is-invalid' : ''"
                                            placeholder="Comune di residenza" />
                                        <span v-if="errorMessage && errorMessage['city']"
                                            class="invalid-feedback error">{{errorMessage['city'][0]}}</span>
                                    </div>

                                    <!--******* form-group **********-->
                                    <div class="form-group col-md-6">
                                        <label for="fixed_delivery">Recapito fisso</label>
                                        <input v-model="fixed_delivery" type="text" class="form-control"
                                            id="fixed_delivery" @change="errorMessageEdit('fixed_delivery')"
                                            :class="errorMessage && errorMessage['fixed_delivery'] ? 'is-invalid' : ''"
                                            placeholder="Recapito fisso" />
                                        <span v-if="errorMessage && errorMessage['fixed_delivery']"
                                            class="invalid-feedback error">{{errorMessage['fixed_delivery'][0]}}</span>
                                    </div>

                                    <!--******* form-group **********-->
                                    <div class="form-group col-md-6">
                                        <label for="fixed_manager">Gestore fisso</label>
                                        <input v-model="fixed_manager" type="text" class="form-control"
                                            id="fixed_manager" @change="errorMessageEdit('fixed_manager')"
                                            :class="errorMessage && errorMessage['fixed_manager'] ? 'is-invalid' : ''"
                                            placeholder="Gestore fisso" />
                                        <span v-if="errorMessage && errorMessage['fixed_manager']"
                                            class="invalid-feedback error">{{errorMessage['fixed_manager'][0]}}</span>
                                    </div>

                                    <!--******* form-group **********-->
                                    <div class="form-group col-md-6">
                                        <label for="mobile_delivery">Recapito mobile</label>
                                        <input v-model="mobile_delivery" type="number" class="form-control"
                                            id="mobile_delivery" @change="errorMessageEdit('mobile_delivery')"
                                            :class="errorMessage && errorMessage['mobile_delivery'] ? 'is-invalid' : ''"
                                            placeholder="Recapito mobile" />
                                        <span v-if="errorMessage && errorMessage['mobile_delivery']"
                                            class="invalid-feedback error">{{errorMessage['mobile_delivery'][0]}}</span>
                                    </div>

                                    <!--******* form-group **********-->
                                    <div class="form-group col-md-6">
                                        <label for="alternative_mobile">Recapito telefonico alternativo</label>
                                        <input v-model="alternative_mobile" type="number" class="form-control"
                                            id="alternative_mobile" @change="errorMessageEdit('alternative_mobile')"
                                            :class="errorMessage && errorMessage['alternative_mobile'] ? 'is-invalid' : ''"
                                            placeholder="Recapito telefonico alternativo" />
                                        <span v-if="errorMessage && errorMessage['alternative_mobile']"
                                            class="invalid-feedback error">{{errorMessage['alternative_mobile'][0]}}</span>
                                    </div>

                                    <!--******* form-group **********-->
                                    <div class="form-group col-md-6">
                                        <label for="mobile">Gestore mobile</label>
                                        <input v-model="mobile" type="number" class="form-control" id="mobile"
                                            @change="errorMessageEdit('mobile')"
                                            :class="errorMessage && errorMessage['mobile'] ? 'is-invalid' : ''"
                                            placeholder="Gestore mobile" />
                                        <span v-if="errorMessage && errorMessage['mobile']"
                                            class="invalid-feedback error">{{errorMessage['mobile'][0]}}</span>
                                    </div>

                                    <!--******* form-group **********-->
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input v-model="email" type="email" class="form-control" id="email"
                                            @change="errorMessageEdit('email')"
                                            :class="errorMessage && errorMessage['email'] ? 'is-invalid' : ''"
                                            placeholder="Email" />
                                        <span v-if="errorMessage && errorMessage['email']"
                                            class="invalid-feedback error">{{errorMessage['email'][0]}}</span>
                                    </div>
                                </div>

                                <!--********************** Fields for Privato **************************************** -->
                                <fieldset v-if="type == '1'">
                                    <legend>Privato:</legend>
                                    <div class="row">
                                        <!--******* form-group **********-->
                                        <div class="form-group col-md-6">
                                            <label for="firstNmaeInput">Nome</label>
                                            <input v-model="first_name" type="text" class="form-control"
                                                id="firstNmaeInput" @change="errorMessageEdit('first_name')"
                                                :class="errorMessage && errorMessage['first_name'] ? 'is-invalid' : ''"
                                                placeholder="Nome" />
                                            <span v-if="errorMessage && errorMessage['first_name']"
                                                class="invalid-feedback error">{{errorMessage['first_name'][0]}}</span>
                                        </div>

                                        <!--******* form-group **********-->
                                        <div class="form-group col-md-6">
                                            <label for="lastNameInput">Cognome</label>
                                            <input v-model="last_name" type="text" class="form-control"
                                                id="lastNameInput" @change="errorMessageEdit('last_name')"
                                                :class="errorMessage && errorMessage['last_name'] ? 'is-invalid' : ''"
                                                placeholder="Cognome" />
                                            <span v-if="errorMessage && errorMessage['last_name']"
                                                class="invalid-feedback error">{{errorMessage['last_name'][0]}}</span>
                                        </div>

                                        <!--******* form-group **********-->
                                        <div class="form-group col-md-6">
                                            <label for="house_numberInput">Numero civico</label>
                                            <input v-model="house_number" type="text" class="form-control"
                                                id="house_numberInput" @change="errorMessageEdit('house_number')"
                                                :class="errorMessage && errorMessage['house_number'] ? 'is-invalid' : ''"
                                                placeholder="Numero civico" />
                                            <span v-if="errorMessage && errorMessage['house_number']"
                                                class="invalid-feedback error">{{errorMessage['house_number'][0]}}</span>
                                        </div>

                                        <!--******* form-group **********-->
                                        <div class="form-group col-md-6">
                                            <label for="birthdayInput">Data di nascita</label>
                                            <input v-model="birthday" type="date" class="form-control"
                                                id="birthdayInput" @change="errorMessageEdit('birthday')"
                                                :class="errorMessage && errorMessage['birthday'] ? 'is-invalid' : ''"
                                                placeholder="Data di nascita" @blur="changeDate()" />
                                            <span v-if="errorMessage && errorMessage['birthday']"
                                                class="invalid-feedback error">{{errorMessage['birthday'][0]}}</span>
                                        </div>

                                        <!--******* form-group **********-->
                                        <div class="form-group col-md-6">
                                            <label for="birth_provincia">Provincia (Nascita)</label>
                                            <input v-model="birth_provincia" type="text" class="form-control"
                                                id="birth_provincia" @change="errorMessageEdit('birth_provincia')"
                                                :class="errorMessage && errorMessage['birth_provincia'] ? 'is-invalid' : ''"
                                                placeholder="Provincia (Nascita)" />
                                            <span v-if="errorMessage && errorMessage['birth_provincia']"
                                                class="invalid-feedback error">{{errorMessage['birth_provincia'][0]}}</span>
                                        </div>

                                        <!--******* form-group **********-->
                                        <div class="form-group col-md-6">
                                            <label for="birth_place">Luogo di Nascita</label>
                                            <input v-model="birth_place" type="text" class="form-control"
                                                id="birth_place" @change="errorMessageEdit('birth_place')"
                                                :class="errorMessage && errorMessage['birth_place'] ? 'is-invalid' : ''"
                                                placeholder="Luogo di Nascita" />
                                            <span v-if="errorMessage && errorMessage['birth_place']"
                                                class="invalid-feedback error">{{errorMessage['birth_place'][0]}}</span>
                                        </div>

                                        <!--******* form-group **********-->
                                        <div class="form-group col-md-6">
                                            <label for>Sesso</label>
                                            <div class="row">
                                                <div class="d-inline mx-2">
                                                    <input type="radio" id="male" name="gender" value="male"
                                                        v-model="gender" />
                                                    <label for="male">Male</label>
                                                </div>

                                                <div class="d-inline mx-2">
                                                    <input type="radio" id="female" name="gender" value="female"
                                                        v-model="gender" />
                                                    <label for="female">Female</label>
                                                </div>
                                            </div>
                                            <span v-if="errorMessage && errorMessage['gender']"
                                                class="invalid-feedback error">{{errorMessage['gender'][0]}}</span>
                                        </div>
                                    </div>

                                    <div class="row mt-4 pt-4 border-top">
                                        <!--******* doc1 **********-->
                                        <div class="col-md-6">
                                            <div class="border p-2 my-2   ">
                                                <!--******* form-group **********-->
                                                <div class="form-group">
                                                    <label>Tipo di documento</label>
                                                    <select v-model="doc1.type" class="form-control">
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
                                                    <label for="doc1.validaty">Data scadenza documento</label>
                                                    <input type="date" class="form-control" id="doc1.validaty"
                                                        v-model="doc1.validaty"
                                                        @change="errorMessageEdit('doc1.validaty')"
                                                        :class="errorMessage && errorMessage['doc1.validaty'] ? 'is-invalid' : ''"
                                                        placeholder="data scadenza" />

                                                </div>

                                                <!--******* form-group **********-->
                                                <div class="form-group">
                                                    <label>Documento Fronte</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input @change="changeFileLabel($event)" type="file"
                                                                class="custom-file-input"
                                                                :class="errorMessage && errorMessage['doc1[front]'] ? 'is-invalid' : ''"
                                                                id="doc1[front]" ref="doc1[front]"
                                                                accept="image/*;capture=camera" />
                                                            <label class="custom-file-label" for="doc1[front]">
                                                                Choose
                                                                file
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>

                                                <!--******* form-group **********-->
                                                <div class="form-group">
                                                    <label>Documento Retro</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input @change="changeFileLabel( $event)" type="file"
                                                                class="custom-file-input"
                                                                :class="errorMessage && errorMessage['doc1[retro]'] ? 'is-invalid' : ''"
                                                                id="doc1[retro]" ref="doc1[retro]"
                                                                accept="image/*;capture=camera" />
                                                            <label class="custom-file-label" for="doc1[retro]">
                                                                Choose
                                                                file
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <!--******* doc2 **********-->
                                        <div class="col-md-6">
                                            <div class="border p-2 my-2   ">
                                                <!--******* form-group **********-->
                                                <div class="form-group">
                                                    <label>Tipo di documento</label>
                                                    <select v-model="doc2.type" class="form-control">
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
                                                    <label id="doc2.validaty">Data scadenza documento</label>
                                                    <input type="date" class="form-control" id="doc2.validaty"
                                                        v-model="doc2.validaty"
                                                        @change="errorMessageEdit('doc2.validaty')"
                                                        :class="errorMessage && errorMessage['doc2.validaty'] ? 'is-invalid' : ''"
                                                        placeholder="data scadenza" />

                                                </div>

                                                <!--******* form-group **********-->
                                                <div class="form-group">
                                                    <label>Documento Fronte</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input @change="changeFileLabel($event)" type="file"
                                                                class="custom-file-input"
                                                                :class="errorMessage && errorMessage['doc2[front]'] ? 'is-invalid' : ''"
                                                                id="doc2[front]" ref="doc2[front]"
                                                                accept="image/*;capture=camera" />
                                                            <label class="custom-file-label" for="doc2[front]">
                                                                Choose
                                                                file
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>

                                                <!--******* form-group **********-->
                                                <div class="form-group">
                                                    <label>Documento Retro</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input @change="changeFileLabel( $event)" type="file"
                                                                class="custom-file-input"
                                                                :class="errorMessage && errorMessage['doc2[retro]'] ? 'is-invalid' : ''"
                                                                id="doc2[retro]" ref="doc2[retro]"
                                                                accept="image/*;capture=camera" />
                                                            <label class="custom-file-label" for="doc2[retro]">
                                                                Choose
                                                                file
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                        <!--******* doc3 **********-->
                                        <div class="col-md-6">
                                            <div class="border p-2 my-2   ">
                                                <!--******* form-group **********-->
                                                <div class="form-group">
                                                    <label>Tipo di documento</label>
                                                    <select v-model="doc3.type" class="form-control">
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
                                                    <label id="doc3.validaty">Data scadenza documento</label>
                                                    <input type="date" class="form-control" id="doc3.validaty"
                                                        v-model="doc3.validaty"
                                                        @change="errorMessageEdit('doc3.validaty')"
                                                        :class="errorMessage && errorMessage['doc3.validaty'] ? 'is-invalid' : ''"
                                                        placeholder="data scadenza" />

                                                </div>

                                                <!--******* form-group **********-->
                                                <div class="form-group">
                                                    <label>Documento Fronte</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input @change="changeFileLabel($event)" type="file"
                                                                class="custom-file-input"
                                                                :class="errorMessage && errorMessage['doc3[front]'] ? 'is-invalid' : ''"
                                                                id="doc3[front]" ref="doc3[front]"
                                                                accept="image/*;capture=camera" />
                                                            <label class="custom-file-label" for="doc3[front]">
                                                                Choose
                                                                file
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>

                                                <!--******* form-group **********-->
                                                <div class="form-group">
                                                    <label>Documento Retro</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input @change="changeFileLabel( $event)" type="file"
                                                                class="custom-file-input"
                                                                :class="errorMessage && errorMessage['doc3[retro]'] ? 'is-invalid' : ''"
                                                                id="doc3[retro]" ref="doc3[retro]"
                                                                accept="image/*;capture=camera" />
                                                            <label class="custom-file-label" for="doc3[retro]">
                                                                Choose
                                                                file
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <!--******* doc4 **********-->
                                        <div class="col-md-6">
                                            <div class="border p-2 my-2   ">
                                                <!--******* form-group **********-->
                                                <div class="form-group">
                                                    <label>Tipo di documento</label>
                                                    <select v-model="doc4.type" class="form-control">
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
                                                    <label id="doc4.validaty">Data scadenza documento</label>
                                                    <input type="date" class="form-control" id="doc4.validaty"
                                                        v-model="doc4.validaty"
                                                        @change="errorMessageEdit('doc4.validaty')"
                                                        :class="errorMessage && errorMessage['doc4.validaty'] ? 'is-invalid' : ''"
                                                        placeholder="data scadenza" />

                                                </div>

                                                <!--******* form-group **********-->
                                                <div class="form-group">
                                                    <label>Documento Fronte</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input @change="changeFileLabel($event)" type="file"
                                                                class="custom-file-input"
                                                                :class="errorMessage && errorMessage['doc4[front]'] ? 'is-invalid' : ''"
                                                                id="doc4[front]" ref="doc4[front]"
                                                                accept="image/*;capture=camera" />
                                                            <label class="custom-file-label" for="doc4[front]">
                                                                Choose
                                                                file
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>

                                                <!--******* form-group **********-->
                                                <div class="form-group">
                                                    <label>Documento Retro</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input @change="changeFileLabel( $event)" type="file"
                                                                class="custom-file-input"
                                                                :class="errorMessage && errorMessage['doc4[retro]'] ? 'is-invalid' : ''"
                                                                id="doc4[retro]" ref="doc4[retro]"
                                                                accept="image/*;capture=camera" />
                                                            <label class="custom-file-label" for="doc4[retro]">
                                                                Choose
                                                                file
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <!--******* doc5 **********-->
                                        <div class="col-md-6">
                                            <div class="border p-2 my-2   ">
                                                <!--******* form-group **********-->
                                                <div class="form-group">
                                                    <label>Tipo di documento</label>
                                                    <select v-model="doc5.type" class="form-control">
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
                                                    <label id="doc5.validaty">Data scadenza documento</label>
                                                    <input type="date" class="form-control" id="doc5.validaty"
                                                        v-model="doc5.validaty"
                                                        @change="errorMessageEdit('doc5.validaty')"
                                                        :class="errorMessage && errorMessage['doc5.validaty'] ? 'is-invalid' : ''"
                                                        placeholder="data scadenza" />

                                                </div>

                                                <!--******* form-group **********-->
                                                <div class="form-group">
                                                    <label>Documento Fronte</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input @change="changeFileLabel($event)" type="file"
                                                                class="custom-file-input"
                                                                :class="errorMessage && errorMessage['doc5[front]'] ? 'is-invalid' : ''"
                                                                id="doc5[front]" ref="doc5[front]"
                                                                accept="image/*;capture=camera" />
                                                            <label class="custom-file-label" for="doc5[front]">
                                                                Choose
                                                                file
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>

                                                <!--******* form-group **********-->
                                                <div class="form-group">
                                                    <label>Documento Retro</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input @change="changeFileLabel( $event)" type="file"
                                                                class="custom-file-input"
                                                                :class="errorMessage && errorMessage['doc5[retro]'] ? 'is-invalid' : ''"
                                                                id="doc5[retro]" ref="doc5[retro]"
                                                                accept="image/*;capture=camera" />
                                                            <label class="custom-file-label" for="doc5[retro]">
                                                                Choose
                                                                file
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <!--******* doc6 **********-->
                                        <div class="col-md-6">
                                            <div class="border p-2 my-2   ">
                                                <!--******* form-group **********-->
                                                <div class="form-group">
                                                    <label>Tipo di documento</label>
                                                    <select v-model="doc6.type" class="form-control">
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
                                                    <label id="doc6.validaty">Data scadenza documento</label>
                                                    <input type="date" class="form-control" id="doc6.validaty"
                                                        v-model="doc6.validaty"
                                                        @change="errorMessageEdit('doc6.validaty')"
                                                        :class="errorMessage && errorMessage['doc6.validaty'] ? 'is-invalid' : ''"
                                                        placeholder="data scadenza" />

                                                </div>

                                                <!--******* form-group **********-->
                                                <div class="form-group">
                                                    <label>Documento Fronte</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input @change="changeFileLabel($event)" type="file"
                                                                class="custom-file-input"
                                                                :class="errorMessage && errorMessage['doc6[front]'] ? 'is-invalid' : ''"
                                                                id="doc6[front]" ref="doc6[front]"
                                                                accept="image/*;capture=camera" />
                                                            <label class="custom-file-label" for="doc6[front]">
                                                                Choose
                                                                file
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>

                                                <!--******* form-group **********-->
                                                <div class="form-group">
                                                    <label>Documento Retro</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input @change="changeFileLabel( $event)" type="file"
                                                                class="custom-file-input"
                                                                :class="errorMessage && errorMessage['doc6[retro]'] ? 'is-invalid' : ''"
                                                                id="doc6[retro]" ref="doc6[retro]"
                                                                accept="image/*;capture=camera" />
                                                            <label class="custom-file-label" for="doc6[retro]">
                                                                Choose
                                                                file
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </fieldset>

                                <!--********************** Fields for Azienda ************************************* -->
                                <fieldset v-if="type == 2">
                                    <legend>Azienda:</legend>
                                    <div class="row">
                                        <!--******* form-group **********-->
                                        <div class="form-group col-md-6">
                                            <label for="business_name">Ragione sociale</label>
                                            <input v-model="business_name" type="text" class="form-control"
                                                id="business_name" @change="errorMessageEdit('business_name')"
                                                :class="errorMessage && errorMessage['business_name'] ? 'is-invalid' : ''"
                                                placeholder="Data di nascita" />
                                            <span v-if="errorMessage && errorMessage['business_name']"
                                                class="invalid-feedback error">{{errorMessage['business_name'][0]}}</span>
                                        </div>

                                        <!--******* form-group **********-->
                                        <div class="form-group col-md-6">
                                            <label for="vat_number">Partita IVA</label>
                                            <input v-model="vat_number" type="text" class="form-control" id="vat_number"
                                                @change="errorMessageEdit('vat_number')"
                                                :class="errorMessage && errorMessage['vat_number'] ? 'is-invalid' : ''"
                                                placeholder="Partita IVA" />
                                            <span v-if="errorMessage && errorMessage['vat_number']"
                                                class="invalid-feedback error">{{errorMessage['vat_number'][0]}}</span>
                                        </div>

                                        <!--******* form-group **********-->
                                        <div class="form-group col-md-6">
                                            <label for="alternative_email">Email alternativa</label>
                                            <input v-model="alternative_email" type="email" class="form-control"
                                                id="alternative_email" @change="errorMessageEdit('alternative_email')"
                                                :class="errorMessage && errorMessage['alternative_email'] ? 'is-invalid' : ''"
                                                placeholder="Email alternativa" />
                                            <span v-if="errorMessage && errorMessage['alternative_email']"
                                                class="invalid-feedback error">{{errorMessage['alternative_email'][0]}}</span>
                                        </div>

                                       
                                    </div>
                                </fieldset>

                                <div class="form-group col-md-12" v-if="progress">
                                    <div class="progress">
                                        <span id="progressProcent" class="badge bg-danger">55%</span>
                                        <div id="progress" class="progress-bar progress-bar-danger" style="width: 0%">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit"
                                        class="btn btn-primary">{{id ? 'Modifica' : 'Aggiungi'}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Swal from "sweetalert2";
    import moment from "moment";
    import axios from "axios";
    export default {
        name: "ClientsAddEditComponent",
        data() {
            return {
                id: "",
                first_name: "",
                last_name: "",
                address: "",
                cap: "",
                tax_code: "",
                house_number: "",
                birthday: "",
                manager_id: "",
                service_id: "",
                //   documentSrc1: "",
                //   documentSrc2: "",
                //   documentSrc3: "",
                //   documentSrc4: "",

                progress: false,
                services: [],
                managers: [],
                errorMessage: {},
                type: 1,

                provincia: "",
                city: "",
                fixed_delivery: "",
                fixed_manager: "",
                mobile_delivery: "",
                alternative_mobile: "",
                mobile: "",
                email: "",
                birth_place: "",
                birth_provincia: "",
                gender: "",
                vat_number: "",
                business_name: "",
                alternative_email: "",

                doc1: [],
                doc2: [],
                doc3: [],
                doc3: [],
                doc4: [],
                doc5: [],
                doc6: []
            };
        },
        created() {
            var url = window.location.href.split("/");
            if (
                url[url.length - 1] != "add" &&
                parseInt(url[url.length - 1]) &&
                typeof parseInt(url[url.length - 1]) == "number"
            ) {
                this.id = parseInt(url[url.length - 1]);
                this.getClients();
            }
            this.getServices();
            this.getManagers();
        },
        methods: {
            changeType(value) {
                this.type = value;
            },

            getClients() {
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    type: "POST",
                    url: "get-clients/" + this.id,
                    success: resolve => {
                        if (Object.keys(resolve.data).length) {
                           
                            this.id = resolve.data.id;
                            this.first_name = resolve.data.first_name;
                            this.last_name = resolve.data.last_name;
                            this.price = resolve.data.price;
                            this.address = resolve.data.address;
                            this.cap = resolve.data.cap;
                            this.tax_code = resolve.data.tax_code;
                            this.house_number = resolve.data.house_number;
                            this.birthday = resolve.data.birthday;
                            this.manager_id = resolve.data.manager.id;
                            this.service_id = resolve.data.service_id;
                            this.type = resolve.data.type ?? 1;

                            this.provincia = resolve.data.provincia;
                            this.city = resolve.data.city;
                            this.fixed_delivery = resolve.data.fixed_delivery;
                            this.fixed_manager = resolve.data.fixed_manager;
                            this.mobile_delivery = resolve.data.mobile_delivery;
                            this.alternative_mobile = resolve.data.alternative_mobile;
                            this.mobile = resolve.data.mobile;
                            this.email = resolve.data.email;
                            this.birth_place = resolve.data.birth_place;
                            this.birth_provincia = resolve.data.birth_provincia;
                            this.gender = resolve.data.gender;
                            this.vat_number = resolve.data.vat_number;
                            this.business_name = resolve.data.business_name;
                            this.alternative_email = resolve.data.alternative_email;
                            this.doc1 = resolve.data.documents[0] ?? [];
                            this.doc2 = resolve.data.documents[1] ?? [];
                            this.doc3 = resolve.data.documents[2] ?? [];
                            this.doc4 = resolve.data.documents[4] ?? [];
                            this.doc5 = resolve.data.documents[3] ?? [];
                            this.doc6 = resolve.data.documents[5] ?? [];

                        
                        }
                    },
                    error: error => {
                        this.notify("danger", error.response.data.message);
                    }
                });
            },

            getManagers() {
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    type: "POST",
                    url: "/admin/managers/get-managers",
                    success: resolve => {
                        if (Object.keys(resolve.data).length) {
                            this.managers = resolve.data;
                        }
                    },
                    error: reject => { }
                });
            },

            getServices() {
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    type: "POST",
                    url: "/admin/services/get-services",
                    success: resolve => {
                        if (Object.keys(resolve.data).length) {
                            this.services = [];
                            for (let cat in resolve.data) {
                                let data = {};
                                data.id = resolve.data[cat].id;
                                data.title = resolve.data[cat].title;
                                this.services.push(data);
                            }
                        }
                    },
                    error: error => {
                        this.notify("danger", error.response.data.message);
                    }
                });
            },

            addEditClients() {
                const form = new FormData();
                const header = {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "Content-Type": "multipart/form-data"
                };

                if (this.id) {
                    form.append("id", this.id);
                }

                if (this.type == 1) {
                    let refs = this.$refs;
                    for (var property in refs) {
                        if (refs.hasOwnProperty(property)) {
                            form.append(property, refs[property].files[0] ?? '');
                        }
                    }
                }

                form.append("first_name", this.first_name ?? "");
                form.append("last_name", this.last_name ?? "");
                form.append("service_id", this.service_id ?? "");
                form.append("address", this.address ?? "");
                form.append("cap", this.cap ?? "");
                form.append("tax_code", this.tax_code ?? "");
                form.append("house_number", this.house_number ?? "");
                form.append("birthday", this.birthday ?? "");
                form.append("manager", this.manager_id ?? "");


                form.append("type", this.type);
                form.append("provincia", this.provincia ?? "");
                form.append("city", this.city ?? "");
                form.append("fixed_delivery", this.fixed_delivery ?? "");
                form.append("fixed_manager", this.fixed_manager ?? "");
                form.append("mobile_delivery", this.mobile_delivery ?? "");
                form.append("alternative_mobile", this.alternative_mobile ?? "");
                form.append("mobile", this.mobile ?? "");
                form.append("email", this.email ?? "");
                form.append("birth_place", this.birth_place ?? "");
                form.append("birth_provincia", this.birth_provincia ?? "");
                form.append("gender", this.gender ?? "");
                form.append("vat_number", this.vat_number ?? "");
                form.append("business_name", this.business_name ?? "");
                form.append("alternative_email", this.alternative_email ?? "");

                form.append("doc1[date]", this.doc1.validaty ?? "");
                form.append("doc1[type]", this.doc1.type ?? "");

                form.append("doc3[type]", this.doc3.type ?? "");
                form.append("doc3[date]", this.doc3.validaty ?? "");

                form.append("doc3[type]", this.doc3.type ?? "");
                form.append("doc3[date]", this.doc3.validaty ?? "");

                form.append("doc4[type]", this.doc4.type ?? "");
                form.append("doc4[date]", this.doc4.validaty ?? "");

                form.append("doc5[type]", this.doc5.type ?? "");
                form.append("doc5[date]", this.doc5.validaty ?? "");

                form.append("doc6[type]", this.doc6.type ?? "");
                form.append("doc6[date]", this.doc6.validaty ?? "");

                const config = {
                    onUploadProgress: function (progressEvent) {
                        var percentCompleted = Math.round(
                            (progressEvent.loaded * 100) / progressEvent.total
                        );
                        $("#progress")
                            .parent()
                            .removeAttr("style");
                        $("#progress").attr("style", "width: " + percentCompleted + "%");
                        $("#progressProcent").html(percentCompleted + "%");
                    },
                    headers: header
                };

                this.progress = true;

                axios
                    .post("add-edit-clients", form, config)
                    .then(resolve => {
                         window.location.replace("/admin/clients");
                        
                        this.notify("success", "Successful");
                    })
                    .catch(error => {
                        this.errorMessage = error.response.data.errors;
                        this.notify("danger", error.response.data.message);
                    });
            },

            changeDate() {
                if (this.birthday) {
                    let thbrt = moment(this.birthday);
                    let nowdy = moment();
                    let t = thbrt.from(nowdy).split(" ")[0];

                    if (t < 18 || t == "in") {
                        this.notifyWar("warning");
                    }
                }
            },

            changeFileLabel(event) {
                $(event.target)
                    .next("label")
                    .html(event.target.files[0].name);
                //   this.errorMessageEdit(param);
            },

            errorMessageEdit(key) {
                this.errorMessage[key] = "";
            },

            fiscalCode() {
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    type: "POST",
                    url: "tax-code",
                    data: { tax_code: this.tax_code },
                    success: resolve => {
                        this.notifyWarFiscal(resolve);
                    },
                    error: error => {
                        this.notify("danger", error.response.data.message);
                    }
                });
            },

            notifyWarFiscal(resolve) {
                console.log(resolve);
                Swal.fire({
                    background: "#ffc107",
                    confirmButtonText: "Load client data",
                    showCancelButton: true,
                    cancelButtonText: "Create New",
                    preConfirm: () => {
                        if (Object.keys(resolve.data).length) {
                            this.id = resolve.data.id;
                             this.service_id = resolve.data.service_id ?? '';
                            this.first_name = resolve.data.first_name ?? '';
                            this.last_name = resolve.data.last_name ?? '';
                            this.tax_code = resolve.data.tax_code ?? '';
                            this.address = resolve.data.address ?? '';
                            this.cap = resolve.data.cap ?? '';
                          
                            this.house_number = resolve.data.house_number ?? '';
                            this.birthday = resolve.data.birthday;
                            this.manager_id = resolve.data.manager ? resolve.data.manager.id : '';
                            this.city = resolve.data.city ?? '';
                            this.provincia = resolve.data.provincia ?? '';
                            this.birth_place = resolve.data.birth_place ?? '';
                            this.birth_provincia = resolve.data.birth_provincia ?? '';
                            this.gender = resolve.data.gender ?? '';
                            this.fixed_delivery = resolve.data.fixed_delivery ?? '';
                            this.fixed_manager = resolve.data.fixed_manager ?? '';
                            this.mobile = resolve.data.mobile    ?? '';
                            this.mobile_delivery = resolve.data.mobile_delivery    ?? '';
                            this.alternative_mobile = resolve.data.alternative_mobile    ?? '';
                            this.email = resolve.data.email    ?? '';
                            this.alternative_email = resolve.data.alternative_email    ?? '';
                            this.type = resolve.data.type    ?? '';
                            this.business_name = resolve.data.business_name    ?? '';
                            this.vat_number = resolve.data.vat_number    ?? '';
                           
                        }
                    }
                });
            },

            notifyWar(type, text) {
                Swal.fire({
                    text: "The client is less than 18 years old",
                    background: "#ffc107",
                    icon: type,
                    confirmButtonText: "close"
                });
            },

            notify(type, text) {
                var icon, bg_color;
                if (type == "success") {
                    icon = `<i class="far fa-check-circle float-left"></i>`;
                    bg_color = "#28a74580";
                } else if (type == "danger") {
                    icon = `<i class="fas fa-times float-left"></i>`;
                    bg_color = "#dc354580";
                }

                Swal.fire({
                    html: `<div class="h4 text-dark m-0">` + icon + text + `</div>`,
                    position: "top-end",
                    background: bg_color,
                    width: "30%",
                    timer: "2000",
                    showConfirmButton: false
                });
            }
        }
    };
</script>