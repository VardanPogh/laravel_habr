<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Categorie</h1>
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
                                <h3 class="card-title">Categorie Elenco</h3>
                                <div class="card-title btn btn-primary float-right action-icon" @click="addEditRedirect()">Aggiungi</div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Desc</th>
                                            <th>Immagine</th>
                                            <th>Data</th>
                                            <th>Azione</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(categorie, i) in categories" :key="i">
                                            <td>{{categorie.name}}</td>
                                            <td>{{categorie.desc}}</td>
                                            <td>
                                                <div class="form-group image">
                                                    <img :src="categorie.image" class="img-fluid">
                                                </div>
                                            </td>
                                            <td>{{dataFormat(categorie.created_at)}}</td>
                                            <td width="150px">
                                                <div class="d-inline-block action-icon">
                                                    <button class="btn btn-danger btn-sm" @click="removeItem(categorie.id, i)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button class="btn btn-warning btn-sm"
                                                        @click="addEditRedirect(categorie.id)">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-info btn-sm" data-toggle="modal"
                                                        data-target="#exampleModal"
                                                        @click="services = categorie.services">
                                                        <i class="fas fa-eye"></i>
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
                        <h5 class="modal-title" id="exampleModalLabel">Services</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table>
                            <tbody>
                                <tr v-for="(service, i) in services" :key="i">
                                    <td>{{service.title}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        name: 'CategoriesComponent',
        data() {
            return {
                categories: [],
                services: [],
            }
        },
        created() {
            this.getCategories();
        },
        methods: {
            getCategories() {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: 'categories/get-categories',
                    success: resolve => {
                        if (Object.keys(resolve.data).length) {
                            for (let ind in resolve.data) {
                                var data = {};
                                data.id = resolve.data[ind].id;
                                data.name = resolve.data[ind].name;
                                data.desc = resolve.data[ind].desc;
                                data.services = this.servicesSort(resolve.data[ind].services);
                                data.image = resolve.data[ind].image;
                                data.created_at = resolve.data[ind].created_at;
                                this.categories.push(data);
                            }
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
                        url: 'categories/delete-categories',
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
            addEditRedirect(id) {
                let url = 'categories/';
                if (id) {
                    url += id;
                } else {
                    url += 'add';
                }

                window.location.href = url;
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