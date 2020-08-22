<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Services</h1>
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
                                <h3 class="card-title">Services Elenco</h3>
                                <div class="card-title btn btn-primary float-right action-icon" @click="addEditRedirect()">Aggiungi</div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Prezzo</th>
                                            <th>Percentuale agente</th>
                                            <th>Percentuale TLM</th>
                                            <th>Immagine</th>
                                            <th>Data</th>
                                            <th>Con protocollazione</th>
                                            <th>Stato</th>
                                            <th>IVA</th>
                                            <th>Durata</th>
                                            <th>Options</th>
                                            <td>Azione</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(service, i) in services" :key="i">
                                            <td>{{service.title}}</td>
                                            <td>{{service.description}}</td>
                                            <td>{{service.price}}</td>
                                            <td>{{service.agent_percent}}</td>
                                            <td>{{service.admin_percent}}</td>
                                            <td>
                                                <div class="form-group image m-0">
                                                    <img :src="service.image" class="img-fluid">
                                                </div>
                                            </td>
                                            <td>{{dataFormat(service.created_at)}}</td>
                                            <td>{{service.with_protocol ? 'Sì' : 'No'}}</td>

                                            <!-- <td>
                                                <button type="button" class="w-100 btn" :class="service.status == 1 ? 'btn-primary' : 'btn-outline-danger'"
                                                @click="changeStatusOptions(service.id, service.status, 'status')">
                                                    {{service.status == 1 ? 'Active' : 'Inactive'}}
                                                </button>
                                            </td> -->

                                            <td>
                                                 <p>{{service.status == 1 ? 'Active' : 'Inactive'}}</p>
                                            </td>

                                            <td>
                                                <p>{{ service.iva }}</p>
                                            </td>
                                            <td>
                                                <p>{{ service.durata }}</p>
                                            </td>


                                            <td>
                                                <div class="form-group">
                                                    <select class="form-control" @change="changeStatusOptions(service.id, $event, 'options')">
                                                        <option value="0" :selected="service.options == 0 ? true : false">Ok</option>
                                                        <option value="1" :selected="service.options == 1 ? true : false">In corso</option>
                                                        <option value="2" :selected="service.options == 2 ? true : false">Problemi amministrativi</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td width="150px">
                                                <div class="d-inline-block action-icon">
                                                    <button class="btn btn-danger btn-sm" @click="removeItem(service.id, i)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button class="btn btn-warning btn-sm"
                                                        @click="addEditRedirect(service.id)">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-warning btn-sm" @click="changeStatusOptions(service.id, service.status, 'status')">
                                                        <i :class="(service.status == 1) ? 'fas fa-lock' : 'fas fa-lock-open'"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-footer clearfix" v-if="false">
                                <ul class="pagination pagination-sm m-0 float-right">
                                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2';

    import moment from 'moment';
    export default {
        name: 'ServicesComponent',
        data() {
            return {
                services: [],
            }
        },
        created() {
            this.getServices();
        },
        methods: {
            getServices() {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: 'services/get-services',
                    success: resolve => {
                        if (Object.keys(resolve.data).length) {
                            for (let ind in resolve.data) {
                                var data = {};
                                data.id = resolve.data[ind].id;
                                data.title = resolve.data[ind].title;
                                data.price = resolve.data[ind].price;
                                data.description = resolve.data[ind].description;
                                data.agent_percent = resolve.data[ind].agent_percent;
                                data.admin_percent = resolve.data[ind].admin_percent;
                                data.status = resolve.data[ind].status;
                                data.with_protocol = resolve.data[ind].with_protocol;
                                // data.options = resolve.data[ind].options;
                                data.image = resolve.data[ind].image;
                                data.created_at = resolve.data[ind].created_at;

                                data.iva = resolve.data[ind].iva ;
                                data.durata = resolve.data[ind].durata ;
                                this.services.push(data);
                            }
                        }
                    },
                    error: reject => {
                        this.notify('danger', reject.response.data.message)
                        // console.log(reject)
                    }
                });
            },
            removeItem(id) {
                if (confirm('Delete Service?')) {
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'POST',
                        url: 'services/delete-services',
                        data: { id },
                        success: resolve => {
                            if (resolve.message == 'successful') {
                                this.services = this.services.filter(categ => categ.id != id);
                            }
                        },
                        error: reject => {
                            // console.log(reject)
                        }
                    });
                }
            },
            addEditRedirect(id) {
                let url = 'services/';
                if (id) {
                    url += id;
                } else {
                    url += 'add';
                }

                window.location.href = url;
            },
            changeStatusOptions(id, event, type){
                let data = {};
                data.id = id;
                if(type == 'status') {
                    data.status = event == 1 ? 0 : 1;
                }
                // if (type == 'options') {
                //     data.options = event.target.value;
                // }

                $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'POST',
                        url: 'services/change-status-options-services',
                        data: data,
                        success: resolve => {
                            if (resolve.message == 'successful') {
                                if (resolve.message == 'successful') {
                                    this.services = this.services.map(categ => {
                                        if (categ.id == id) {
                                            categ.status = resolve.data.status;
                                            // categ.options = resolve.data.options;
                                        }
                                        return categ;
                                    });
                                }
                            }
                        },
                        error: reject => {
                            this.notify('danger', reject.response.data.message)
                        }
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
            dataFormat(date) {
                return moment(date).format('MMMM DD YYYY');
            }
        }
    }
</script>

<style lang="scss">
    .action-icon {
        cursor: pointer;
    }

    .image>img {
        max-width: 150px !important;
        max-height: 50px !important;
    }

    .form-group>.img-fluid {
        max-height: 500px;
    }
</style>
