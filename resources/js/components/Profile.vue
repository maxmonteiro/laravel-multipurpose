<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 mt-3">
        <div class="card card-widget widget-user">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div class="widget-user-header bg-black">
            <h3 class="widget-user-username">Elizabeth Pierce</h3>
            <h5 class="widget-user-desc">Web Designer</h5>
          </div>
          <div class="widget-user-image">
            <img class="img-circle" :src="getPhoto()" alt="User Avatar">
          </div>
          <div class="card-body mt-2">
            <div class="row">
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">3,200</h5>
                  <span class="description-text">SALES</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">13,000</h5>
                  <span class="description-text">FOLLOWERS</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4">
                <div class="description-block">
                  <h5 class="description-header">35</h5>
                  <span class="description-text">PRODUCTS</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
        </div>
      </div>
      <div class="col-md-12 mt-3">
          <div class="card">
            <div class="nav-tabs">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="#activity" class="nav-link" data-toggle="tab" aria-expanded="false">Activity</a>
                    </li>
                    <li class="nav-item">
                        <a href="#settings" class="nav-link" data-toggle="tab" aria-expanded="false">Settings</a>
                    </li>
                </ul>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane" id="activity">
                            <h4>Activity</h4>
                        </div>
                        <div class="tab-pane" id="settings">
                            <form class="form-horizontal">
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10">
                                  <input type="email" class="form-control" id="inputName" placeholder="Name"
                                  :class="{ 'is-invalid': form.errors.has('name') }"
                                  v-model="form.name"
                                  >
                                  <has-error :form="form" field="name"></has-error>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                  <input type="email" class="form-control" id="inputEmail" placeholder="Email"
                                  :class="{ 'is-invalid': form.errors.has('email') }"
                                  v-model="form.email"
                                  >
                                  <has-error :form="form" field="email"></has-error>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputExperience" class="col-sm-2 control-label">Experience</label>
                                <div class="col-sm-10">
                                  <textarea class="form-control" id="inputExperience" placeholder="Experience"
                                  v-model="form.experience"
                                  >
                                  </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPhoto" class="col-sm-6 control-label">Profile Photo</label>
                                <div class="col-sm-10">
                                  <input type="file" name="" id=""
                                  @change="updateProfile">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword" class="col-sm-6 control-label">Password (leave empty if not changing)</label>
                                <div class="col-sm-10">
                                  <input class="form-control" id="inputExperience" placeholder="Password"
                                  :class="{ 'is-invalid': form.errors.has('password') }"
                                  v-model="form.password"
                                  >
                                  <has-error :form="form" field="password"></has-error>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-success"
                                    @click.prevent="updateInfo">
                                        <i class="fa fa-sync-alt pr-2"></i>Update
                                    </button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    data() {
        return {
            form: new Form({
                id: '',
                name: '',
                email: '',
                password: '',
                type: '',
                bio: '',
                photo: '',
            }),
            photo: ''
        }
    },
    mounted() {
        console.log("Component mounted.");
    },
    created() {
        axios.get('api/profile')
        .then(({data}) => {
            this.form.fill(data);
            this.photo = this.form.photo;
        }).catch((err) => {
            console.err(err);
        });
    },
    methods: {
        getPhoto() {
            return '/img/profile/' + this.photo;
        },
        updateProfile(e) {
            //console.log('upload photo', e);
            // setando arquivo carregado
            let file = e.target.files[0];
            // instanciando novo FileReader - leitor de arquivos
            let reader = new FileReader();
            // checando o tamanho do arquivo
            if (file['size'] < 2111775) { // 2111775 = 2MB
                // setando a foto no formulário
                reader.onloadend = (file) => {
                    this.form.photo = reader.result;
                }
                // lendo arquivo
                reader.readAsDataURL(file);
            } else {
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'You are uploading a large file'
                })
            }

        },
        updateInfo() {
            this.$Progress.start();
            this.form.put('api/profile/')
            .then(({data}) => {
                this.photo = data.data.photo;
                this.$Progress.finish();
            }).catch((err) => {
                this.$Progress.fail();
            });
        }
    }
};
</script>
