<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>General Categorie</h1>
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
                                <h3 class="card-title">General Categorie Elenco</h3>
                                <div class="card-title btn btn-primary float-right action-icon" @click="addEditGeneralCategory('open')" data-toggle="modal"
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
                                        <tr v-for="(categorie, i) in categories" :key="i">
                                            <td>{{categorie.name}}</td>
                                            <td>{{dataFormat(categorie.created_at)}}</td>
                                            <td width="150px">
                                                <div class="d-inline-block action-icon">
                                                    <button class="btn btn-danger  btn-sm" @click="removeItem(categorie.id, i)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                        data-target="#exampleModal"
                                                        @click="addEditGeneralCategory('open', categorie)">
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
                        <h5 class="modal-title" id="exampleModalLabel">General Categoria {{id ? 'Modifica' : 'Aggiungi'}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" @submit.prevent="addEditGeneralCategory('save')">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nameInput">General Categoria Nome</label>
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
        name: 'GeneralCategoriesComponent',
        data() {
            return {
                categories: [],
                id: '',
                name: '',
            }
        },
        created() {
            this.getGeneralCategories();
        },
        methods: {
            getGeneralCategories() {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: 'general-categories/get-general-categories',
                    success: resolve => {
                        if (Object.keys(resolve.data).length) {
                            this.categories = resolve.data;
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
                        url: 'general-categories/delete-general-categories',
                        data: { id },
                        success: resolve => {
                            if (resolve.message == 'successful') {
                                this.categories = this.categories.filter(categ => categ.id != id);
                            }
                        },
                        error: reject => {
                            // console.log(reject)
                        }
                    });
                }
            },
            addEditGeneralCategory(type, data) {
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
                        url: 'general-categories/add-edit-general-categories',
                        data: da,
                        success: resolve => {
                            if (Object.keys(resolve).length) {
                                console.log(resolve)
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
    .action-icon {
        cursor: pointer;
    }

    .image>img {
        max-width: 150px !important;
        max-height: 50px !important;
    }
</style>