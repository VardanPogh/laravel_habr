<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Clients</h1>
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
                <h3 class="card-title">Clients Elenco</h3>
                <div
                  class="card-title btn btn-primary float-right action-icon"
                  @click="addEditRedirect()"
                >Aggiungi</div>
              </div>

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
                      <th>Azione</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(client, i) in clients" :key="i">
                      <td>{{client.first_name}}</td>
                      <td>{{client.last_name}}</td>
                      <td>{{client.service.title}}</td>
                      <td>{{client.tax_code}}</td>
                      <td>{{client.address}}</td>
                      <td>{{client.civil}}</td>
                      <td>{{client.manager.name}}</td>
                      <td>{{client.cap}}</td>
                      <td>{{client.birthday}}</td>
                      <td>{{dataFormat(client.created_at)}}</td>
                      <td width="150px">
                        <div class="d-inline-block action-icon">
                          <button class="btn btn-sm btn-danger" @click="removeItem(client.id, i)">
                            <i class="fas fa-trash"></i>
                          </button>
                          <button
                            class="btn btn-sm btn-warning"
                            @click="addEditRedirect(client.id)" >
                            <i class="fas fa-edit"></i>
                          </button>

                            <button class="btn btn-sm btn-info"   data-toggle="modal"  data-target="#exampleModal" @click="documents = client.documents">
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

      <div
        class="modal fade"
        id="exampleModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Documento</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <table>
                <tbody>
                  <tr v-for="(document, i) in documents" :key="i">
                    <div class="p-2">
                      <a :href="url + document.document" target="_blank">{{url + document.document}}</a>
                    </div>
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
import moment from "moment";
export default {
  name: "ClientsComponent",
  data() {
    return {
      clients: {},
      documents: [],
      url: window.location.origin
    };
  },
  created() {
    this.getClients();
  },
  methods: {
    getClients() {
      $.ajax({
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        type: "POST",
        url: "clients/get-clients",
        success: resolve => {
          if (Object.keys(resolve.data).length) {
            this.clients = resolve.data;
          }
        },
        error: reject => {
          this.notify("danger", reject.response.data.message);
          // console.log(reject)
        }
      });
    },
    removeItem(id) {
      if (confirm("Delete Client?")) {
        $.ajax({
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          type: "POST",
          url: "clients/delete-clients",
          data: { id },
          success: resolve => {
            if (resolve.message == "successful") {
              this.clients = this.clients.filter(categ => categ.id != id);
            }
          },
          error: reject => {
            // console.log(reject)
          }
        });
      }
    },
    addEditRedirect(id) {
      let url = "clients/";
      if (id) {
        url += id;
      } else {
        url += "add";
      }

      window.location.href = url;
    },
    changeStatusOptions(id, event, type) {
      let data = {};
      data.id = id;
      if (type == "status") {
        data.status = event == 1 ? 0 : 1;
      }
      if (type == "options") {
        data.options = event.target.value;
      }

      $.ajax({
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        type: "POST",
        url: "clients/change-status-options-clients",
        data: data,
        success: resolve => {
          if (resolve.message == "successful") {
            if (resolve.message == "successful") {
              this.clients = this.clients.map(categ => {
                if (categ.id == id) {
                  categ.status = resolve.data.status;
                  categ.options = resolve.data.options;
                }
                return categ;
              });
            }
          }
        },
        error: reject => {
          this.notify("danger", reject.response.data.message);
        }
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
    },
    dataFormat(date) {
      return moment(date).format("MMMM DD YYYY");
    }
  }
};
</script>

<style lang="scss">
.action-icon {
  cursor: pointer;
}

.image > img {
  max-width: 150px !important;
  max-height: 50px !important;
}

.form-group > .img-fluid {
  max-height: 500px;
}
</style>