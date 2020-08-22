<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Categoria {{id ? 'Modifica' : 'Aggiungi'}}</h1>
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

                            <form role="form" @submit.prevent="addEditCategory()">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="nameInput">Categoria Nome</label>
                                        <input v-model="name" type="text" class="form-control" id="nameInput"
                                            placeholder="Nome">
                                    </div>
                                    <div class="form-group">
                                        <label for="descInput">Categoria Desc</label>
                                        <input v-model="desc" type="text" class="form-control" id="descInput"
                                            placeholder="Desc">
                                    </div>
                                    <div class="form-group">
                                        <label for="generalCategories">General Categorie</label>
                                        <select class="form-control" id="generalCategories" v-model="general_category_id">
                                            <option value="" selected disabled>General Categorie</option>
                                            <option v-for="(categ, i) in generalCategories" :key="i" :value="categ.id">{{categ.name}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Categoria Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="imageInput" ref="file">
                                                <label class="custom-file-label" for="imageInput">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" v-if="id">
                                        <img :src="imageSrc" class="img-fluid">
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
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        name: 'CategoriesAddEditComponent',
        data() {
            return {
                id: '',
                name: '',
                desc: '',
                general_category_id: '',
                image: '',
                imageSrc: '',
                generalCategories: [],
            }
        },
        created() {
            var url = window.location.href.split('/');
            if (url[url.length - 1] != 'add' && parseInt(url[url.length - 1]) && typeof parseInt(url[url.length - 1]) == 'number') {
                this.id = parseInt(url[url.length - 1]);
                this.getCategory();
            }
            this.getGeneralCategories();
        },
        methods: {
            getCategory() {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: 'get-categories/' + this.id,
                    success: resolve => {
                        if (Object.keys(resolve.data).length) {
                            this.id = resolve.data.id;
                            this.name = resolve.data.name;
                            this.desc = resolve.data.desc;
                            this.general_category_id = resolve.data.general_category_id;
                            this.imageSrc = resolve.data.image;
                        }
                    },
                    error: reject => {
                        // console.log(reject)
                    }
                });
            },
            getGeneralCategories() {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '/admin/general-categories/get-general-categories',
                    success: resolve => {
                        if (Object.keys(resolve.data).length) {
                            this.generalCategories = resolve.data;
                        }
                    },
                    error: reject => {
                        // console.log(reject)
                    }
                });
            },
            addEditCategory() {
                const form = new FormData();
                const header = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'multipart/form-data',
                };


                if (this.id) {
                    form.append('id', this.id);
                    form.append('image_old', this.imageSrc);
                }
                if (this.$refs.file.files[0]) {
                    form.append('image', this.$refs.file.files[0]);
                }
                form.append('name', this.name);
                form.append('desc', this.desc);
                form.append('general_category_id', this.general_category_id);

                axios.post(
                    'add-edit-categories',
                    form, { headers: header }
                ).then((resolve) => {
                    if (this.id) {
                        this.imageSrc = resolve.data.image;
                    } else {
                        this.id = '';
                        this.name = '';
                        this.desc = '';
                        this.general_category_id = '';
                        this.image = '';
                        this.imageSrc = '';
                    }

                }).catch((error) => {
                    console.log(error)
                });
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