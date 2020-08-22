<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-2">
                        <h1>Transactions</h1>
                    </div>
                    <div class="col">
                        <button :class="filterParam == 'asigned' ? 'btn btn-primary' : 'btn btn-outline-primary'"  @click="filter('asigned')">Home</button>
                        <button :class="filterParam == '' ? 'btn btn-primary' : 'btn btn-outline-primary'" @click="filter('')">Archivo</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row" v-if="isSuperAdmin">
                    <div class="col-12">
                       <div class="card">
                           <div class="card-header">
                             <h3 class="card-title">Admins data</h3>
                             <button type="button" class="btn float-right"  @click="toggleTable()">
                                <i v-if="!showTable" class="fas fa-chevron-down"></i>
                                <i v-if="showTable" class="fas fa-chevron-up"></i>
                             </button>
                           </div>

                           <div class="card-body" v-if="showTable">
                               <table class="table table-bordered" id="admins-table"  >
                                   <thead>
                                      <tr>
                                        <th>Name</th>
                                        <th>Assegnata ad Operatore</th>
                                      </tr>
                                   </thead>
                                   <tbody>
                                       <tr v-for="(admin, index) in admins" :key="index">
                                           <td>{{ admin.name }}</td>
                                           <td>{{ admin.transacrtions ? admin.transacrtions.length : 0  }}</td>
                                       </tr>
                                   </tbody>
                               </table>
                           </div>
                       </div>
                    </div>
                </div>




                <div class="row" v-if="isSuperAdmin">
                    <div class="col-12">
                        <div class="">
                            <div class="px-2 filter-items">
                                <div @click="filter('')">All <span>({{ transactionsCount }})</span></div> |
                                <div @click="filter('asigned')">Asigned <span>({{ asigned }})</span></div>
                                <div @click="filter('notasigned')">Not Asigned <span>({{ transactionsCount - asigned }})</span></div>
                            </div>
                        </div>


                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-2">
                        <div class="form-group d-flex">
                            <select class="form-control mr-2" v-model="admin_id">
                                <option value="">Asign to </option>
                                <option v-for="(admin, index) in admins" :key="'admins_' + index" :value="admin.id">
                                    {{admin.name}}
                                </option>
                            </select>
                            <button type="button" @click="asignTo()"  class="btn btn-outline-primary ">Apply</button>
                        </div>
                    </div>


                    <div class="col-4">
                        <div class="form-group d-flex">
                            <select class="form-control mr-2" v-model="tax_order">
                                <option value="" selected>All</option>
                                <option value="ASC">Fiscal ascending</option>
                                <option value="DESC">Fiscal descending</option>
                            </select>
                            <select name="" id="" class="form-control mr-2" v-model="admin_id">
                                <option value="">All Admins</option>
                                <option v-for="(admin, index) in admins" :key="index" :value="admin.id">
                                    {{admin.name}}
                                </option>
                            </select>
                            <button type="button" @click="getTransactions()"  class="btn btn-outline-primary ">Filter</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Stato" v-model='stato'>
                    </div>
                    <div class="col">
                        <input type="number" class="form-control" placeholder="Numero Pratica" v-model="pratica">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Agente" v-model="agent">
                    </div>

                    <div class="col">
                        <select v-model="option" class="form-control">
                            <option value="">Stato operazione</option>
                            <option :value="i" v-for="(option, i) in options" :key="i">{{option  }}</option>
                        </select>
                    </div>

                    <div class="col">
                        <input type="text" class="form-control" placeholder="Codice Fiscale" v-model="tax_code">
                    </div>

                    <div class="col">
                        <input type="number" class="form-control" placeholder="Giorni allá scadenza" v-model="expire">
                    </div>
                    <div class="col">
                        <button type="button" @click="getTransactions()"  class="btn btn-outline-primary ">Ricerca</button>
                        <button type="button" @click="doReset()"  class="btn btn-outline-primary ">Ripristina</button>
                    </div>



                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card" style="overflow: auto">
                            <div class="card-header">
                                <h3 class="card-title">Transactions Elenco</h3>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered transaction-container">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>User Nome</th>
                                        <th>Servizi Nome</th>
                                        <th>Prezzo</th>
                                        <th>Guadagno Agente</th>
                                        <th>Percentuale Agente</th>
                                        <th>Costo Agente</th>
                                        <th>Guadagno TLM</th>
                                        <th>Percentuale TLM</th>
                                        <th>Stato Operazione</th>
                                        <th>Motivazione</th>
                                        <th>Pratica</th>
                                        <th>Stato Pagamento</th>
                                        <th>Data Pagamento</th>
                                        <th>Dettagli Pagamento</th>
                                        <td>Tax Code</td>
                                        <td>Expire Date</td>
                                        <th>Data</th>
                                        <th>Durata</th>
                                        <th>Data di scadenz</th>
                                        <th>Giorni alla scadenza</th>
                                        <th>Administrator</th>
                                        <th>Azione</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(transaction, i) in transactions" :key="i">
                                        <td>
                                            <input type="checkbox" :value="transaction.id" v-model="checked">
                                        </td>
                                        <td>{{transaction.user.name}}</td>
                                        <td>
                                            {{transaction.client && transaction.client.service &&
                                            transaction.client.service.title ? transaction.client.service.title : ''}}
                                        </td>
                                        <td>{{transaction.price}}</td>
                                        <td>{{transaction.agent_percent}}</td>
                                        <td>{{Math.round(transaction.agent_percent/transaction.price*100)}} %</td>

                                        <td>
                                            <input v-model="transaction.agent_price" type="text" name="agent_price"
                                                   placeholder="Agent Price"
                                                   class="form-control"/>

                                        </td>
                                        <td>{{transaction.admin_percent}}</td>
                                        <td>{{Math.round(transaction.admin_percent/transaction.price*100)}} %</td>
                                        <td>
                                            <select class="form-control" v-model="transaction.options">
                                                <option :value="i" v-for="(option, i) in options" :key="i">{{option  }}</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input v-model="transaction.motivazione" type="text" name="motivazione"
                                                   placeholder="Motivazione" class="form-control"/>
                                        </td>
                                        <td>
                                            <input v-model="transaction.pratica" type="text" name="pratica"
                                                   placeholder="Pratica"
                                                   class="form-control"/>
                                        </td>

                                        <td>
                                            <select class="form-control" v-model="transaction.payment_status">
                                                <option :value="i" v-for="(paymentOption, i) in paymentOptions" :key="i">{{paymentOption}}</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input v-model="transaction.payment_date" type="date" name="payment_date"
                                                   placeholder="Data Pagamento"
                                                   class="form-control"/>
                                        </td>
                                        <td>
                                            <input v-model="transaction.payment_details" type="text" name="payment_details"
                                                   placeholder="Dettagli Pagamento"
                                                   class="form-control"/>
                                        </td>

                                        <td>{{ transaction.client ? transaction.client.tax_code :'No Client' }}</td>

                                        <td>{{ transaction.client && transaction.client.service ? transaction.client.service.dataDiScadenza :'No Sevice' }}</td>

                                        <td>{{dataFormat(transaction.created_at)}}</td>
                                        <td>{{transaction.service.durata}}</td>
                                        <td>{{transaction.data_di_scadenza}}</td>
                                        <td>{{transaction.days_to_maturity}}</td>
                                        <td>
                                            {{ transaction.admin ? transaction.admin.name : '-' }}
                                        </td>

                                        <td width="100px">
                                            <div class="d-inline-block action-icon">
                                                <button class="btn btn-danger "
                                                        @click="removeItem(transaction.id, i)">
                                                    <i class="fas fa-trash"></i>
                                                </button>


                                                <button class="btn btn-warning "
                                                        @click="saveTransaction(transaction)">
                                                    <i class="fa fa-check"></i>
                                                </button>

                                                <button class="btn btn-info " v-if="transaction.client"
                                                        @click="viewClient(transaction.client)">
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
                                    <li class="page-item">
                                        <a class="page-link" href="#">&laquo;</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">&raquo;</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Client</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Cognome</th>
                                    <th>Services</th>
                                    <th>Codice fiscale</th>
                                    <th>Address</th>
                                    <th>Numero civico</th>
                                    <th>Gestore</th>
                                    <th>Cap</th>
                                    <th>Data di nascita</th>
                                    <th>Data</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr v-if="Object.keys(client).length">

                                    <td>{{client.first_name}}</td>
                                    <td>{{client.last_name}}</td>
                                    <td>{{client.service.title}}</td>
                                    <td>{{client.tax_code}}</td>
                                    <td>{{client.address}}</td>
                                    <td>{{client.civil}}</td>
                                    <td>{{client.manager ? client.manager.name : '-'}}</td>
                                    <td>{{client.cap}}</td>
                                    <td>{{client.birthday}}</td>
                                    <td>{{dataFormat(client.created_at)}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Swal from "sweetalert2";

    import axios from 'axios';
    import moment from "moment";

    export default {
        name: "TransactionsComponent",
        data() {
            return {
                isSuperAdmin: '',
                transactions: {},
                client: {},
                admins: [],
                checked: [],
                options: {
                    '0': 'Ok',
                    '1':'In corso',
                    '2':'Problemi amministrativi',
                    '3' :'Assegnata ad operatore'
                },
                paymentOptions: {
                    '0':'Non Pagato',
                    '1': 'Pagato',
                },
                transactionsCount: 0,
                asigned: 0,
                filterParam: 'asigned',
                showTable:false,
                tax_order: '',
                admin_id:'',
                pratica:'',
                agent:'',
                option:'',
                tax_code:'',
                expire:'',
                stato:'',
                reset:false,
            };
        },
        created() {
            this.getTransactions();
        },

        methods: {
            getTransactions() {
                  let   params = {
                    filter:this.filterParam,
                    admin_id:this.admin_id,
                    tax_order:this.tax_order,
                    tax_code:this.tax_code,
                    pratica:this.pratica,
                    agent:this.agent,
                    option:this.option,
                    expire:this.expire,
                    stato:this.stato
                   }


                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    type: "POST",
                    url: "transaction/get-transaction",
                    data:params,
                    success: resolve => {
                        if (Object.keys(resolve).length) {
                            this.transactions = resolve.transactions;
                            this.admins = resolve.admins;
                            this.transactionsCount = resolve.transactionsCount;
                            this.asigned = resolve.asigned;
                            this.isSuperAdmin = resolve.isSuperAdmin;
                        }
                    },
                    error: reject => {
                        this.notify("danger", reject.response.data.message);
                    }
                });
            },
            doReset(){

                this.filterParam = '',
                this.admin_id = '',
                this.tax_order = '',
                this.tax_code = '',
                this.pratica = '',
                this.agent = '',
                this.option = '',
                this.expire = '',
                this.stato = '',
                this.getTransactions();
            },

            toggleTable(){
                this.showTable = ! this.showTable;
            },
            filter(param){
                this.filterParam = param;
                this.getTransactions();
            },

            saveTransaction(transaction) {
                let data = {
                    id: transaction.id,
                    options: transaction.options,
                    agent_price: transaction.agent_price,
                    pratica: transaction.pratica,
                    motivazione: transaction.motivazione,
                    admin_id: transaction.admin_id,
                    payment_status: transaction.payment_status,
                    payment_details: transaction.payment_details,
                    payment_date: transaction.payment_date
                };

                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    type: "POST",
                    url: "transaction/update-transaction",
                    data: data,
                    success: resolve => {
                        if (resolve.message == "successful") {
                            if (resolve.message == "successful") {
                                this.notify("success", 'Success');
                            }
                        }
                    },
                    error: reject => {
                        this.notify("danger", reject.response.data.message);
                    }
                });
            },

            removeItem(id) {
                if (confirm("Delete Transaction?")) {
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        },
                        type: "POST",
                        url: "transaction/delete-transaction",
                        data: {id},
                        success: resolve => {
                            if (resolve.message == "successful") {
                                this.transactions = this.transactions.filter(
                                    categ => categ.id != id
                                );
                            }
                        },
                        error: reject => {
                            // console.log(reject)
                        }
                    });
                }
            },

            viewClient(data) {

                this.client = {};
                this.client = data;
                console.log(this.client)
                $('#exampleModal').modal('show');
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
            },

            dataFormat(date) {
                return moment(date).format("MMMM DD YYYY");
            },



            asignTo(){

                let data = {admin_id:this.admin_id,transaction_ids: JSON.stringify(this.checked)};
                $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        },
                        type: "POST",
                        url: "transaction/asignto-admin",
                        data:data,
                        success: resolve => {
                            if (resolve.message == "successful") {
                                   this.notify('success', 'Successful');
                                   this.getTransactions();
                                   this.checked = [];
                                   this.admin_id = ''
                            }
                            if(resolve.error){
                                this.notify('danger', resolve.error)
                            }
                        },
                        error: reject => {
                            this.notify('danger','Oops')
                        }
                    });
            }
        }
    };
</script>

<style lang="scss">
.transaction-container{
    & th{
        padding: 5px!important;
    }
    & td{
        padding: 8px!important;
    }

}

    .action-icon {
        .btn {
            padding: 2px 3px;
            font-size: 12px;
            width: 25px;
            height: 25px;
        }
    }

    .image > img {
        max-width: 150px !important;
        max-height: 50px !important;
    }

    .form-group > .img-fluid {
        max-height: 500px;
    }
    .filter-items{
        div{
            display: inline-block ;
            color:#007bff;
            cursor:pointer;
            span{
                color:#333;
            }
        }
    }
    #admins-table {
         transition: all .5s linear;
    }
</style>
