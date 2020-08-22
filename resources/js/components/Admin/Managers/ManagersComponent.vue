<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Gestore</h1>
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
                                <h3 class="card-title">Gestore Elenco</h3>
                                <div class="card-title btn btn-primary float-right action-icon" @click="addEditManager('open')" data-toggle="modal"
                                                        data-target="#exampleModal">Aggiungi</div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Data</th>
                                            <th>Azione</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(manager, i) in managers" :key="i">
                                            <td>{{manager.name}}</td>
                                            <td>{{dataFormat(manager.created_at)}}</td>
                                            <td width="150px">
                                                <div class="d-inline-block action-icon">
                                                    <button class="btn btn-sm btn-danger" @click="removeItem(manager.id, i)">
                                                                <i class="fas fa-trash"></i>
                                                    </button>
                                                   
                                                   <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal"  @click="addEditManager('open', manager)">
                                                       <i class="fas fa-edit"></i>
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
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Gestore {{id ? 'Modifica' : 'Aggiungi'}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" @submit.prevent="addEditManager('save')">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nameInput">Gestore Nome</label>
                                    <input v-model="name" type="text" class="form-control" id="nameInput"
                                        placeholder="Nome">
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{id ? 'Modifica' : 'Aggiungi'}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        name: 'ManagersComponent',
        data() {
            return {
                managers: [],
                id: '',
                name: '',
            }
        },
        created() {
            this.getManagers();
        },
        methods: {
            getManagers() {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: 'managers/get-managers',
                    success: resolve => {
                        if (Object.keys(resolve.data).length) {
                            this.managers = resolve.data;
                        }
                    },
                    error: reject => {
                        // console.log(reject)
                    }
                });
            },
            removeItem(id) {
                if (confirm('Delete Categoria?')) {
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'POST',
                        url: 'managers/delete-managers',
                        data: { id },
                        success: resolve => {
                            if (resolve.message == 'successful') {
                                this.managers = this.managers.filter(categ => categ.id != id);
                            }
                        },
                        error: reject => {
                            // console.log(reject)
                        }
                    });
                }
            },
            addEditManager(type, data) {
                if(type == 'open') {
                    this.id = '';
                    this.name = '';
                    if (data) {
                        this.id = data.id;
                        this.name = data.name;
                    }
                }
                if (type == 'save') {
                    let da = {};
                    if(this.id){
                        da.id = this.id;
                    }
                    da.name = this.name;
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'POST',
                        url: 'managers/add-edit-managers',
                        data: da,
                        success: resolve => {
                            if (Object.keys(resolve).length) {
                                window.location.reload()
                            }
                        },
                        error: reject => {
                            // console.log(reject)
                        }
                    });
                }

            },
            dataFormat(date) {
                return moment(date).format('MMMM DD YYYY');
            },
            servicesSort(services) {
                var data = [];
                for (let s in services) {
                    data.push(services[s]);
                }
                return data;
            }
        }
    }
</script>

<style lang="scss">
    .image>img {
        max-width: 150px !important;
        max-height: 50px !important;
    }
</style>