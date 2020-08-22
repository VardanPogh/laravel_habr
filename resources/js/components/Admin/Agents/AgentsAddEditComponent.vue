<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Agent {{id ? 'Modifica' : 'Aggiungi'}}</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-6">

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{id ? 'Modifica' : 'Aggiungi'}}</h3>
                            </div>

                            <form role="form" @submit.prevent="addEditAgent()">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="nameInput">Nome</label>
                                        <input v-model="name" type="text" class="form-control" id="nameInput"
                                            placeholder="Nome">
                                    </div>
                                    <div class="form-group">
                                        <label for="nameLastInput">Cognome</label>
                                        <input v-model="last_name" type="text" class="form-control" id="nameLastInput"
                                            placeholder="Cognome">
                                    </div>
                                    <div class="form-group">
                                        <label for="addressInput">Indirizzo</label>
                                        <input v-model="address" type="address" class="form-control" id="addressInput"
                                            placeholder="Indirizzo">
                                    </div>
                                    <div class="form-group">
                                        <label for="telInput">Numero di Tel.</label>
                                        <input v-model="tel" type="number" class="form-control" id="telInput"
                                            placeholder="Numero di Tel.">
                                    </div>
                                    <div class="form-group">
                                        <label for="emailInput">Email</label>
                                        <input v-model="email" type="email" class="form-control" id="emailInput"
                                            placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <label for="businessNameInput">Ragione sociale</label>
                                        <input v-model="business_name" type="text" class="form-control" id="businessNameInput"
                                            placeholder="Ragione sociale">
                                    </div>
                                    <div class="form-group">
                                        <label for="storeNameInput">Azienda</label>
                                        <input v-model="name_of_store" type="text" class="form-control" id="storeNameInput"
                                            placeholder="Azienda">
                                    </div>
                                    <div class="form-group">
                                        <label for="commonInput">Comune</label>
                                        <input v-model="common" type="text" class="form-control" id="commonInput"
                                            placeholder="Comune">
                                    </div>
                                    <div class="form-group">
                                        <label for="provinceInput">Provincia</label>
                                        <input v-model="province" type="text" class="form-control" id="provinceInput"
                                            placeholder="Provincia">
                                    </div>
                                    <div class="form-group">
                                        <label for="partitaIvaInput">Partita Iva</label>
                                        <input v-model="vat_number" type="text" class="form-control" id="partitaIvaInput"
                                            placeholder="Partita Iva">
                                    </div>
                                    <div class="form-group">
                                        <label for="capInput">Cap</label>
                                        <input v-model="cap" type="number" class="form-control" id="capInput"
                                            placeholder="Cap">
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control"  @click="statusChange($event)">
                                            <option value="2" :selected="this.role_id == 2 ? true : false">Agent</option>
                                            <option value="1" :selected="this.role_id == 1 ? true : false">Admin</option>
                                            <option value="3" :selected="this.role_id == 3 ? true : false">Super Admin</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="passwordInput">Password</label>
                                        <input v-model="password" type="password" class="form-control"
                                            id="passwordInput" placeholder="Password">
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">{{id ? 'Modifica' : 'Aggiungi'}}</button>
                                    </div>
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
    import Swal from 'sweetalert2';
    import axios from 'axios';
    export default {
        name: 'AgentAddEditComponent',
        data() {
            return {
                id: '',
                name: '',
                last_name: '',
                address: '',
                tel: '',
                business_name: '',
                name_of_store: '',
                province: '',
                vat_number: '',
                cap: '',
                common: '',
                email: '',
                password: '',
                role_id: '',
            }
        },
        created() {
            var url = window.location.href.split('/');
            if (url[url.length - 1] != 'add' && parseInt(url[url.length - 1]) && typeof parseInt(url[url.length - 1]) == 'number') {
                this.id = parseInt(url[url.length - 1]);
                this.getAgent();
            }
        },
        methods: {
            getAgent() {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: 'get-agent/' + this.id,
                    success: resolve => {
                        if (Object.keys(resolve.data).length) {
                            this.id = resolve.data.id;
                            this.name = resolve.data.name;
                            this.email = resolve.data.email;
                            this.last_name = resolve.data.last_name;
                            this.address = resolve.data.address;
                            this.tel = resolve.data.tel;
                            this.business_name = resolve.data.business_name;
                            this.name_of_store = resolve.data.name_of_store;
                            this.province = resolve.data.province;
                            this.vat_number = resolve.data.vat_number;
                            this.cap = resolve.data.cap;
                            this.common = resolve.data.common;
                            this.role_id = resolve.data.role_id;
                        }
                    },
                    error: reject => {
                        // console.log(reject)
                    }
                });
            },
            addEditAgent() {
                const form = new FormData();
                const header = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'multipart/form-data',
                };


                if (this.id) {
                    form.append('id', this.id);
                }
                if (this.password) {
                    form.append('password', this.password);
                }
                form.append('name', this.name);
                form.append('last_name', this.last_name);
                form.append('address', this.address);
                form.append('tel', this.tel);
                form.append('business_name', this.business_name);
                form.append('name_of_store', this.name_of_store);
                form.append('province', this.province);
                form.append('vat_number', this.vat_number);
                form.append('cap', this.cap);
                form.append('common', this.common);
                form.append('email', this.email);
                form.append('role_id', this.role_id);

                axios.post(
                    'add-edit-agent',
                    form, { headers: header }
                ).then((resolve) => {
                    if (!this.id) {
                        this.id = '';
                        this.name = '';
                        this.last_name = '';
                        this.address = '';
                        this.tel = '';
                        this.business_name = '';
                        this.name_of_store = '';
                        this.province = '';
                        this.vat_number = '';
                        this.cap = '';
                        this.common = '';
                        this.email = '';
                        this.password = '';
                        this.role_id = '';
                    }
                    this.notify('success', 'Successful')

                }).catch((error) => {
                    this.notify('danger', error.response.data.message)
                });
            },
            notify(type, text){
                var icon, bg_color;
                if (type == 'success') {
                    icon = `<i class="far fa-check-circle float-left"></i>`;
                    bg_color = '#28a74580';
                } else if(type == 'danger') {
                    icon = `<i class="fas fa-times float-left"></i>`;
                    bg_color = '#dc354580';
                }

                Swal.fire({
                    html: `<div class="h4 text-dark m-0">`+icon + text + `</div>`,
                    position: 'top-end',
                    background: bg_color,
                    width: '30%',
                    timer: '2000',
                    showConfirmButton: false
                })

            },
            statusChange(event){
                console.log(event.target.value)
                this.role_id = event.target.value;
            }

        }
    }
</script>

<style lang="scss">
    .action-icon {
        cursor: pointer;
    }

    .form-group>.img-fluid {
        max-height: 500px;
    }
</style>
