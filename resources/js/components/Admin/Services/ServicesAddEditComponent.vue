<template>

    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Services {{id ? 'Modifica' : 'Aggiungi'}}</h1>
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
                            <form role="form" @submit.prevent="addEditServices()">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="titleInput">Section Title</label>
                                        <input v-model="title" type="text" class="form-control" id="titleInput"
                                            placeholder="Title">
                                    </div>
                                    <div class="form-group">
                                        <label for="descriptionInput">Section description</label>
                                        <input v-model="description" type="text" class="form-control" id="descriptionInput"
                                            placeholder="Description">
                                    </div>
                                    <div class="form-group">
                                        <label for="priceInput">Section price</label>
                                        <input v-model="price" type="number" class="form-control" id="priceInput"
                                            placeholder="Price">
                                    </div>
                                    <div class="form-group">
                                        <label for="agentPercentInput">Percentuale agente</label>
                                        <input v-model="agent_percent" type="number" class="form-control" id="agentPercentInput"
                                            placeholder="Percentuale agente">
                                    </div>
                                    <div class="form-group">
                                        <label for="adminPercentInput">Percentuale TLM</label>
                                        <input v-model="admin_percent" type="number" class="form-control" id="adminPercentInput"
                                            placeholder="Percentuale agente">
                                    </div>


                                    <div class="form-group">
                                        <label for="adminPercentInput">IVA</label>
                                        <input v-model="iva" type="number" class="form-control" id="iva"
                                               placeholder="IVA">
                                    </div>

                                    <div class="form-group">
                                        <label for="adminPercentInput">Durata</label>
                                        <input v-model="durata" type="number" min="0" class="form-control" id="durata"
                                               placeholder="Durata">
                                    </div>




                                    <div class="form-group">
                                        <label for="sectionsOptions">Categoria</label>
                                        <select class="form-control" id="sectionsOptions" v-model="category_id">
                                            <option value="" selected disabled>Categoria</option>
                                            <option v-for="(cat, i) in categories" :key="i" :value="cat.id">{{cat.name}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="sectionsOptions">Form type</label>
                                        <select class="form-control" id="formType" v-model="form_type">
                                            <option value="" selected disabled>Form type</option>
                                            <option :selected="form_type == 0" value="0">Default</option>
                                            <option :selected="form_type == 1" value="1">Ull</option>
                                            <option :selected="form_type == 2" value="2">Nip</option>
                                            <option :selected="form_type == 3" value="3">Conversion</option>
                                            <option :selected="form_type == 4" value="4">Mnp</option>
                                            <option :selected="form_type == 5" value="5">Acq</option>
                                            <option :selected="form_type == 6" value="6">Ricarica</option>
                                        </select>
                                    </div>
                                    <div class="form-group" v-show="form_type == 6">
                                        <label for="course">Course</label>
                                        <select class="form-control" id="course" v-model="course">
                                            <option value="" selected disabled>Course</option>
                                            <option :selected="course === 1" value="1">$</option>
                                                <option :selected="course === 0" value="0">€</option>
                                        </select>
                                    </div>

<!--                                    <div class="form-group" v-if="id">-->
<!--                                        <label for="status">Stato</label>-->
<!--                                        <select class="form-control" id="status" v-model="status">-->
<!--                                            <option value="" selected disabled>Stato</option>-->
<!--                                            <option value="0">Active</option>-->
<!--                                            <option value="1">Inactive</option>-->
<!--                                        </select>-->
<!--                                    </div>-->

                                    <!--Test-->
                                    <div class="form-group" v-if="id">
                                        <label for="status">Stato</label>
                                        <select class="form-control" id="status" v-model="status">
                                            <option value="" selected disabled>Stato</option>
                                            <option :selected="status === 1" value="1">Active</option>
                                            <option :selected="status === 0" value="0">Inactive</option>
                                        </select>
                                    </div>
                                    <!--Test end-->

<!--

                                    <div class="form-group">
                                        <label for="with_protocol">Servizio con protocollazione</label>
                                        <select class="form-control" id="with_protocol" v-model="with_protocol">
                                            <option value="1">Sì</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
-->

                                    <div class="form-group">
                                        <label for="with_protocol">Servizio con protocollazione</label>
                                        <select class="form-control" id="with_protocol" v-model="with_protocol">
                                            <option :selected="with_protocol === 1" value="1">Sì</option>
                                            <option :selected="with_protocol === 0" value="0">No</option>

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputFile">Services Image</label>
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
import Swal from 'sweetalert2';
    import axios from 'axios';
    export default {
        name: 'ServicesAddEditComponent',
        data() {
            return {
                id: '',
                title: '',
                description: '',
                price: '',
                agent_percent: '',
                admin_percent: '',
                status: '',
                course: '',
                // options: '',
                image: '',
                imageSrc: '',
                category_id: '',
                categories: [],
                with_protocol : '',
                form_type: '',
                iva : 22,
                durata: '',
            }
        },
        created() {
            var url = window.location.href.split('/');
            if (url[url.length - 1] != 'add' && parseInt(url[url.length - 1]) && typeof parseInt(url[url.length - 1]) == 'number') {
                this.id = parseInt(url[url.length - 1]);
                this.getServices();
            }
            this.getCategory();

        },
        methods: {
            getServices() {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: 'get-services/' + this.id,
                    success: resolve => {
                        if (Object.keys(resolve.data).length) {
                            this.id = resolve.data.id;
                            this.title = resolve.data.title;
                            this.description = resolve.data.description;
                            this.price = resolve.data.price;
                            this.agent_percent = resolve.data.agent_percent;
                            this.admin_percent = resolve.data.admin_percent;
                            this.status = resolve.data.status;
                            this.with_protocol = resolve.data.with_protocol;
                            this.form_type = resolve.data.form_type
                            this.course = resolve.data.course
                            // this.options = resolve.data.options;
                            this.category_id = resolve.data.category_id;
                            this.imageSrc = resolve.data.image;
                            this.iva = resolve.data.iva;
                            this.durata = resolve.data.durata;
                        }
                    },
                    error: reject => {
                        // console.log(reject)
                    }
                });
            },
            getCategory() {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '/admin/categories/get-categories',
                    success: resolve => {
                        if (Object.keys(resolve.data).length) {
                            this.categories = [];
                            for (let cat in resolve.data) {
                                let data = {};
                                data.id = resolve.data[cat].id;
                                data.name = resolve.data[cat].name;
                                this.categories.push(data);
                            }
                        }
                    },
                    error: reject => {
                        // console.log(reject)
                    }
                });
            },
            addEditServices() {
                const form = new FormData();
                const header = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'multipart/form-data',
                };


                if (this.id) {
                    form.append('id', this.id);
                    form.append('image_old', this.imageSrc);
                    form.append('status', this.status);
                    // form.append('options', this.options);
                }
                if (this.$refs.file.files[0]) {
                    form.append('image', this.$refs.file.files[0]);
                }
                form.append('title', this.title);
                form.append('description', this.description);
                form.append('category_id', this.category_id);
                form.append('price', this.price);
                form.append('agent_percent', this.agent_percent);
                form.append('admin_percent', this.admin_percent);
                form.append('with_protocol', this.with_protocol);
                form.append('iva', this.iva);
                form.append('durata', this.durata);
                form.append('form_type', this.form_type);
                form.append('course', this.course ? this.course : 0);

                console.log(this.status);
                axios.post(
                    'add-edit-services',
                    form, { headers: header }
                ).then((resolve) => {
                    if (this.id) {
                        setTimeout(() => {
                            this.imageSrc = resolve.data.image;
                        }, 10)
                    } else {
                        this.id = '';
                        this.title = '';
                        this.description = '';
                        this.price = '';
                        this.agent_percent = '';
                        this.admin_percent = '';
                        this.status = '';
                        // this.options = '';
                        this.category_id = '';
                        this.image = '';
                        this.imageSrc = '';
                        this.iva = '';
                        this.durata = '';
                        this.form_type = '';
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

            }
        }

    }
</script>

<style lang="scss">
    .action-icon {
        cursor: pointer;
    }
</style>
