<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Agents</h1>
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
                                <h3 class="card-title">Agents Elenco</h3>
                                <div class="card-title btn btn-primary float-right action-icon" @click="addEditRedirect()">Aggiungi</div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Cognome</th>
                                            <th>Usernome</th>
                                            <th>Email</th>
                                            <th>Ragione sociale</th>
                                            <th>Azienda</th>
                                            <th>Comune</th>
                                            <th>Provincia</th>
                                            <th>Address</th>
                                            <th>Tel</th>
                                            <th>Partita iva</th>
                                            <th>Cap</th>
                                            <th>Ruolo</th>
                                            <th>Stato</th>
                                            <th>Data</th>
                                            <th>Azione</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(agent, i) in agents" :key="i">
                                            <td>{{agent.name}}</td>
                                            <td>{{agent.last_name}}</td>
                                            <td>{{agent.username}}</td>
                                            <td>{{agent.email}}</td>
                                            <td>{{agent.business_name ? agent.business_name : ''}}</td>
                                            <td>{{agent.name_of_store ? agent.name_of_store : ''}}</td>
                                            <td>{{agent.common ? agent.common : ''}}</td>
                                            <td>{{agent.province ? agent.province : ''}}</td>
                                            <td>{{agent.address ? agent.address : ''}}</td>
                                            <td>{{agent.tel ? agent.tel : ''}}</td>
                                            <td>{{agent.vat_number ? agent.vat_number : ''}}</td>
                                            <td>{{agent.cap ? agent.cap : ''}}</td>
<!--                                            <td>-->
<!--                                                <button type="button" class="w-50 btn mw-70" :class="agent.role.id == 1 ? 'btn-primary' : 'btn-outline-info'"-->
<!--                                                @click="statusChange(agent.id, agent.role.id, 'role')">-->
<!--                                                    {{agent.role.name}}-->
<!--                                                </button>-->
<!--                                            </td>-->
                                            <td>
                                                <div class="form-group w-50 mw-90">
                                                    <select class="form-control" @click="statusChange(agent.id, agent.role.id, $event,  'role')">
                                                        <option value="2" :selected="agent.role.id == 2 ? true : false">Agent</option>
                                                        <option value="1" :selected="agent.role.id == 1 ? true : false">Admin</option>
                                                        <option value="3" :selected="agent.role.id == 3 ? true : false">Super Admin</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="w-50 btn mw-70" :class="agent.status == 1 ? 'btn-primary' : 'btn-outline-danger'"
                                                @click="statusChange(agent.id, agent.status, 'status')">
                                                    {{agent.status == 1 ? 'Active' : 'Suspended'}}
                                                </button></td>
                                            <td>{{dataFormat(agent.created_at)}}</td>
                                            <td width="150px">
                                                <div class="d-inline-block action-icon">
                                                    <button class="btn btn-danger btn-sm" @click="removeItem(agent.id, i)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button class="btn btn-warning btn-sm" @click="addEditRedirect(agent.id)">
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
    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        name: 'AgentsComponent',
        data() {
            return {
                agents: {}
            }
        },
        created() {
            this.getAgents();
        },
        methods: {
            getAgents() {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: 'agent/get-agent',
                    success: resolve => {
                        if (Object.keys(resolve.data).length) {
                            this.agents = resolve.data;
                        }
                    },
                    error: reject => {
                        // console.log(reject)
                    }
                });
            },
            statusChange(id, change_id, event,  type) {
                var role_id = 0;
                var data = {};
                data.id = id;
                if (type == 'role') {
                        data.role_id = event.target.value;
                } else if (type == 'status') {
                    if(change_id == 1) {
                        data.status = 0;
                    } else {
                        data.status = 1;
                    }
                }
                if (type) {
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'POST',
                        url: 'agent/change-agent-role',
                        data: data,
                        success: resolve => {
                            if (resolve.message == 'successful') {
                                this.agents = this.agents.map(categ => {
                                    if (categ.id == id) {
                                        categ.role = resolve.data.role;
                                        categ.status = resolve.data.status;
                                    }
                                    return categ;
                                });
                            }
                        },
                        error: reject => {
                            // console.log(reject)
                        }
                    });
                }
            },
            removeItem(id) {
                if (confirm('Delete Agent?')) {
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'POST',
                        url: 'agent/delete-agent',
                        data: { id },
                        success: resolve => {
                            if (resolve.message == 'successful') {
                                this.agents = this.agents.filter(categ => categ.id != id);
                            }
                        },
                        error: reject => {
                            // console.log(reject)
                        }
                    });
                }
            },
            addEditRedirect(id) {
                let url = 'agent/';
                if (id) {
                    url += id;
                } else {
                    url += 'add';
                }

                window.location.href = url;
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

    .mw-70 {
        min-width: 70px!important;
    }

    .mw-90 {
        min-width: 90px;
    }
</style>
